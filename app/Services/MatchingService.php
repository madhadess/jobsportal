<?php

namespace App\Services;

use App\User;
use App\ServiceRequest;
use App\State;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

/**
 * MatchingService — Centralized Auto-Assignment Engine
 *
 * SCORING:
 *   State (il) match             : +10
 *   District (ilçe) match        : +25
 *   Neighborhood (mahalle) match  : +50
 *   Street (sokak) match          : +100
 *   Rating >= 4.5                 : +15
 *   Rating >= 4.0                 : +10
 *   Rating >= 3.5                 : +5
 *   Availability calendar match   : +20
 *   Recently idle (no task ≥7d)   : +10
 *   Daily limit full              : disqualify (score = -1)
 *   Previously rejected           : excluded from set
 */
class MatchingService
{
    /**
     * Find all eligible candidates for a service request, scored and sorted.
     *
     * @param ServiceRequest $sr
     * @return Collection  Collection of User models with ->matching_score attribute
     */
    public function findCandidates(ServiceRequest $sr): Collection
    {
        $categoryId = $sr->category_id;
        $rejectedIds = $this->getRejectedIds($sr);

        // 1. Base filter: eligible + serves this service category
        $query = User::where('is_eligible_for_auto_assignment', 1)
            ->whereIn('user_type', [User::TYPE_PERSONNEL, User::TYPE_CAREGIVER, 'caregiver', 'personnel'])
            ->where('is_active', 1)
            ->where(function ($q) use ($categoryId) {
                $q->whereJsonContains('service_types', (string) $categoryId)
                    ->orWhereJsonContains('service_types', (int) $categoryId);
            });

        // 2. Occupation group filter (if request specifies it)
        if (!empty($sr->occupation_group_id)) {
            $groups = (array) $sr->occupation_group_id;
            $query->where(function ($q) use ($groups) {
                foreach ($groups as $gId) {
                    $q->orWhereJsonContains('occupation_group_id', (string) $gId)
                        ->orWhereJsonContains('occupation_group_id', (int) $gId);
                }
            });
        }

        // 3. Exclude personnel who already rejected this request
        if (!empty($rejectedIds)) {
            $query->whereNotIn('id', $rejectedIds);
        }

        $personnel = $query->get();

        if ($personnel->isEmpty()) {
            return collect([]);
        }

        // 4. Score, filter disqualified, sort
        return $personnel
            ->map(function ($p) use ($sr) {
                $p->matching_score = $this->scorePersonnel($p, $sr);
                return $p;
            })
            ->filter(fn($p) => $p->matching_score >= 0)
            ->sortByDesc('matching_score')
            ->values();
    }

    /**
     * Run matching for a single ServiceRequest: find best, assign, and persist.
     *
     * @param ServiceRequest $sr
     * @return User|null  The matched user, or null if no match found
     */
    public function runMatch(ServiceRequest $sr): ?User
    {
        $sr->matching_attempts = ($sr->matching_attempts ?? 0) + 1;

        try {
            $candidates = $this->findCandidates($sr);
            $best = $candidates->first();

            if ($best) {
                $sr->matched_personnel_id = $best->id;
                $sr->automation_status = 'matched';
                $sr->save();

                Log::info("MatchingService: Matched SR #{$sr->request_number} → User #{$best->id} (score: {$best->matching_score})");
                return $best;
            }

            // No candidates found
            if ($sr->matching_attempts >= 5) {
                $sr->automation_status = 'failed';
                Log::warning("MatchingService: SR #{$sr->request_number} failed after {$sr->matching_attempts} attempts.");
            } else {
                $sr->automation_status = 'pending_matching';
                Log::info("MatchingService: No match for SR #{$sr->request_number}. Attempt {$sr->matching_attempts}/5. Staying in queue.");
            }

            $sr->save();
            return null;

        } catch (\Exception $e) {
            Log::error("MatchingService::runMatch Error for SR #{$sr->id}: " . $e->getMessage());
            $sr->automation_status = 'failed';
            $sr->save();
            return null;
        }
    }

    /**
     * Run matching for ALL service requests currently in pending_matching state.
     *
     * @return array ['matched' => int, 'failed' => int, 'still_pending' => int]
     */
    public function runAllPending(): array
    {
        $pending = ServiceRequest::where('automation_status', 'pending_matching')
            ->where('status', ServiceRequest::STATUS_PENDING)
            ->get();

        $matched = 0;
        $failed = 0;
        $stillPending = 0;

        foreach ($pending as $sr) {
            $result = $this->runMatch($sr);
            // Reload after save
            $sr->refresh();
            if ($result) {
                $matched++;
            } elseif ($sr->automation_status === 'failed') {
                $failed++;
            } else {
                $stillPending++;
            }
        }

        Log::info("MatchingService::runAllPending: matched={$matched}, failed={$failed}, still_pending={$stillPending}");

        return compact('matched', 'failed', 'stillPending');
    }

    /**
     * Calculate the matching score for a given personnel and request.
     *
     * @param User           $p
     * @param ServiceRequest $sr
     * @return int  Score >= 0 means eligible; -1 means disqualify
     */
    public function scorePersonnel(User $p, ServiceRequest $sr): int
    {
        $score = 0;

        // --- Location Scoring ---
        $stateId = $sr->customer_city;        // stored as state_id (numeric)
        $district = $sr->customer_district;    // city_id or name
        $neighborhood = $sr->customer_neighborhood;
        $street = $sr->customer_street;

        // State (il) match via work_locations (array of state IDs)
        $workLocations = is_array($p->work_locations) ? array_map('intval', $p->work_locations) : [];
        if (!empty($stateId) && in_array((int) $stateId, $workLocations)) {
            $score += 10;
        }

        // District match via street_address field (stored text field)
        if (!empty($district) && !empty($p->street_address) && stripos($p->street_address, (string) $district) !== false) {
            $score += 25;
        }

        // Neighborhood match
        if (!empty($neighborhood) && !empty($p->neighborhood) && stripos($p->neighborhood, $neighborhood) !== false) {
            $score += 50;
        }

        // Street match (highest location priority)
        if (!empty($street) && !empty($p->street) && stripos($p->street, $street) !== false) {
            $score += 100;
        }

        // --- Rating Bonus ---
        $rating = (float) ($p->average_rating ?? 0);
        if ($rating >= 4.5) {
            $score += 15;
        } elseif ($rating >= 4.0) {
            $score += 10;
        } elseif ($rating >= 3.5) {
            $score += 5;
        }

        // --- Idle Bonus (Fair Distribution) ---
        if (!$p->last_task_date) {
            $score += 10; // Never had a task
        } else {
            $daysSince = Carbon::parse($p->last_task_date)->diffInDays(now());
            if ($daysSince >= 7) {
                $score += 10;
            }
        }

        // --- Availability Calendar Bonus ---
        if ($sr->preferred_date && $sr->preferred_time) {
            if ($this->isAvailableAt($p, $sr->preferred_date, $sr->preferred_time)) {
                $score += 20;
            }
        }

        // --- Daily Task Limit Check (Disqualify) ---
        if ($sr->preferred_date) {
            $todayTasks = ServiceRequest::where('matched_personnel_id', $p->id)
                ->where('automation_status', '!=', 'failed')
                ->whereDate('preferred_date', Carbon::parse($sr->preferred_date)->toDateString())
                ->count();

            $maxTasks = (int) ($p->max_daily_tasks ?: 5);
            if ($todayTasks >= $maxTasks) {
                return -1; // Disqualify: at daily limit
            }
        }

        return $score;
    }

    /**
     * Check if personnel's availability_calendar covers the given date/time.
     *
     * @param User   $p
     * @param string $date  e.g. "2026-03-15"
     * @param string $time  e.g. "10:00"
     * @return bool
     */
    private function isAvailableAt(User $p, string $date, string $time): bool
    {
        $calendar = is_array($p->availability_calendar) ? $p->availability_calendar : [];

        if (empty($calendar)) {
            return true; // No calendar set → assume always available
        }

        $dayName = strtolower(Carbon::parse($date)->format('l')); // e.g. 'monday'

        if (!isset($calendar[$dayName])) {
            return false;
        }

        $dayConfig = $calendar[$dayName];

        // Check if day is marked as available/active
        if (empty($dayConfig['available']) && empty($dayConfig['active'])) {
            return false;
        }

        // If time windows defined, check if preferred_time is within range
        if (!empty($dayConfig['start']) && !empty($dayConfig['end'])) {
            try {
                $start = Carbon::parse($date . ' ' . $dayConfig['start']);
                $end = Carbon::parse($date . ' ' . $dayConfig['end']);
                $preferred = Carbon::parse($date . ' ' . $time);
                return $preferred->between($start, $end);
            } catch (\Exception $e) {
                return true; // If parsing fails, assume available
            }
        }

        return true; // Day available, no specific time restriction
    }

    /**
     * Get list of user IDs who have already rejected this service request.
     *
     * @param ServiceRequest $sr
     * @return array
     */
    private function getRejectedIds(ServiceRequest $sr): array
    {
        $extra = $sr->extra_details;
        if (is_string($extra)) {
            $extra = json_decode($extra, true) ?? [];
        }
        return is_array($extra) ? ($extra['rejected_ids'] ?? []) : [];
    }
}
