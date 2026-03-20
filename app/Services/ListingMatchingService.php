<?php

namespace App\Services;

use App\JobPost;
use App\JobPostRequirement;
use App\ListingApplication;
use App\MatchRuleWeight;
use App\MatchScore;
use App\User;
use Illuminate\Support\Carbon;

/**
 * ListingMatchingService — Kural Tabanlı Uygunluk Skoru Motoru
 *
 * Skor 0-100 arası. 7 ağırlıklı kriter.
 * Ağırlıklar `match_rule_weights` tablosundan çekilir (admin değiştirebilir).
 *
 * İleride ML/AI entegrasyonu için engine_version soyutlaması hazır.
 */
class ListingMatchingService
{
    /** @var array */
    private array $weights;

    /** @var string */
    const ENGINE_VERSION = 'v1_rule_based';

    public function __construct()
    {
        $this->weights = MatchRuleWeight::getWeightsMap();

        // Fallback defaults if DB not seeded yet
        $this->weights = array_merge([
            'location' => 20,
            'category' => 20,
            'experience' => 15,
            'work_hours' => 15,
            'salary' => 10,
            'certificate' => 10,
            'profile_completeness' => 10,
        ], $this->weights);
    }

    /**
     * Compute the full eligibility score for an applicant vs a job post.
     *
     * @param User    $applicant
     * @param JobPost $post
     * @return array ['total_score', 'breakdown', 'explanation', 'engine_version']
     */
    public function computeScore(User $applicant, JobPost $post): array
    {
        $weights = $this->weights;
        $breakdown = [];
        $totalScore = 0;

        // 1. Lokasyon Uyumu (max: weight['location'])
        $locationRaw = $this->scoreLocation($applicant, $post);
        $breakdown['location'] = [
            'raw' => $locationRaw,
            'weight' => $weights['location'],
            'points' => round($locationRaw * $weights['location'] / 100, 2),
            'label' => 'Lokasyon Uyumu',
        ];
        $totalScore += $breakdown['location']['points'];

        // 2. Kategori Uyumu
        $categoryRaw = $this->scoreCategory($applicant, $post);
        $breakdown['category'] = [
            'raw' => $categoryRaw,
            'weight' => $weights['category'],
            'points' => round($categoryRaw * $weights['category'] / 100, 2),
            'label' => 'Kategori Uyumu',
        ];
        $totalScore += $breakdown['category']['points'];

        // 3. Deneyim Yılı
        $expRaw = $this->scoreExperience($applicant, $post);
        $breakdown['experience'] = [
            'raw' => $expRaw,
            'weight' => $weights['experience'],
            'points' => round($expRaw * $weights['experience'] / 100, 2),
            'label' => 'Deneyim Yılı',
        ];
        $totalScore += $breakdown['experience']['points'];

        // 4. Çalışma Saati Uyumu
        $hoursRaw = $this->scoreWorkHours($applicant, $post);
        $breakdown['work_hours'] = [
            'raw' => $hoursRaw,
            'weight' => $weights['work_hours'],
            'points' => round($hoursRaw * $weights['work_hours'] / 100, 2),
            'label' => 'Çalışma Saati Uyumu',
        ];
        $totalScore += $breakdown['work_hours']['points'];

        // 5. Ücret Uyumu
        $salaryRaw = $this->scoreSalary($applicant, $post);
        $breakdown['salary'] = [
            'raw' => $salaryRaw,
            'weight' => $weights['salary'],
            'points' => round($salaryRaw * $weights['salary'] / 100, 2),
            'label' => 'Ücret Uyumu',
        ];
        $totalScore += $breakdown['salary']['points'];

        // 6. Sertifika Uyumu
        $certRaw = $this->scoreCertificate($applicant, $post);
        $breakdown['certificate'] = [
            'raw' => $certRaw,
            'weight' => $weights['certificate'],
            'points' => round($certRaw * $weights['certificate'] / 100, 2),
            'label' => 'Sertifika Uyumu',
        ];
        $totalScore += $breakdown['certificate']['points'];

        // 7. Profil Tamlık Oranı
        $profileRaw = $this->scoreProfileCompleteness($applicant);
        $breakdown['profile_completeness'] = [
            'raw' => $profileRaw,
            'weight' => $weights['profile_completeness'],
            'points' => round($profileRaw * $weights['profile_completeness'] / 100, 2),
            'label' => 'Profil Tamlık Oranı',
        ];
        $totalScore += $breakdown['profile_completeness']['points'];

        $total = round(min($totalScore, 100), 1);

        return [
            'total_score' => $total,
            'breakdown' => $breakdown,
            'explanation' => $this->generateExplanation($total, $breakdown),
            'engine_version' => self::ENGINE_VERSION,
        ];
    }

    /**
     * Compute and persist score both in listing_applications table and match_scores log.
     */
    public function computeAndSave(ListingApplication $application): array
    {
        $result = $this->computeScore($application->applicant, $application->jobPost);

        // Update application
        $application->match_score = $result['total_score'];
        $application->match_breakdown = $result['breakdown'];
        $application->match_explanation = $result['explanation'];
        $application->save();

        // Log to match_scores
        MatchScore::create([
            'job_post_id' => $application->job_post_id,
            'user_id' => $application->user_id,
            'total_score' => $result['total_score'],
            'breakdown' => $result['breakdown'],
            'explanation' => $result['explanation'],
            'engine_version' => $result['engine_version'],
            'computed_at' => now(),
        ]);

        return $result;
    }

    // ─── Private Scoring Methods ────────────────────────────────────────────────

    /**
     * Lokasyon: İl eşleşmesi tam puan, yok ise 0.
     * (İlçe eşleşmesi ek bonus olarak gelecekte eklenebilir)
     */
    private function scoreLocation(User $applicant, JobPost $post): float
    {
        if (!$post->state_id) {
            return 0; // İlan lokasyon belirtmemişse skor verilemez
        }
        $workLocations = is_array($applicant->work_locations)
            ? array_map('intval', $applicant->work_locations)
            : [];

        if (empty($workLocations)) {
            return 0; // Personel lokasyon belirtmemişse skor verilemez
        }

        // Direct ID match
        if (in_array((int) $post->state_id, $workLocations)) {
            if ($post->city_id && !empty($applicant->city_id) && (int) $applicant->city_id === (int) $post->city_id) {
                return 100;
            }
            return 80;
        }

        // Fallback: compare by state name (handles dual Turkey country_id issue: 223 vs 805)
        $postState = \App\State::find($post->state_id);
        if ($postState) {
            $matchingNames = \App\State::whereIn('id', $workLocations)
                ->where('state', $postState->state)
                ->exists();
            if ($matchingNames) {
                return 80; // Aynı il ismi, farklı ID
            }
        }

        return 0;
    }

    /**
     * Kategori: personelin service_types arrayinde post'un category_id var mı?
     */
    private function scoreCategory(User $applicant, JobPost $post): float
    {
        if (!$post->category_id) {
            return 0; // İlan kategori belirtmemişse skor verilemez
        }
        $serviceTypes = is_array($applicant->service_types)
            ? array_map('intval', $applicant->service_types)
            : [];

        if (empty($serviceTypes)) {
            return 0; // Personel hizmet türü belirtmemişse skor verilemez
        }

        return in_array((int) $post->category_id, $serviceTypes) ? 100 : 0;
    }

    /**
     * Deneyim: applicant'ın deneyim yılı >= ilanın minimumunu karşılıyor mu?
     */
    private function scoreExperience(User $applicant, JobPost $post): float
    {
        $required = (int) $post->min_experience_years;
        if ($required === 0) {
            return 100; // Deneyim şartı yok
        }

        // Try experience from user's profile
        $userExp = 0;
        if (!empty($applicant->experience_years)) {
            $userExp = (int) $applicant->experience_years;
        } elseif (!empty($applicant->job_experience_id)) {
            // Map job_experience levels to approximate years
            $expMap = [1 => 0, 2 => 1, 3 => 2, 4 => 3, 5 => 5, 6 => 8, 7 => 10];
            $userExp = $expMap[(int) $applicant->job_experience_id] ?? 0;
        }

        if ($userExp >= $required) {
            // Grade: more experience is slightly better
            $excess = min($userExp - $required, $required);
            return min(100, 80 + ($excess / max($required, 1)) * 20);
        }

        // Partial credit if close (e.g., 1 year short = 60)
        $gap = $required - $userExp;
        if ($gap === 1)
            return 60;
        if ($gap === 2)
            return 30;
        return 0;
    }

    /**
     * Çalışma saati uyumu: personelin müsaitlik takvimi ile ilanın saatlerini karşılaştır.
     */
    private function scoreWorkHours(User $applicant, JobPost $post): float
    {
        $calendar = is_array($applicant->availability_calendar)
            ? $applicant->availability_calendar
            : [];

        if (empty($calendar)) {
            return 0; // Takvim yok — skor verilemez
        }

        if (!$post->work_hours_start || !$post->work_hours_end) {
            return 0; // İlan saat belirtmemiş — skor verilemez
        }

        // Count how many days the user covers the required hours
        $coveredDays = 0;
        $checkedDays = 0;

        foreach ($calendar as $day => $dayData) {
            if (empty($dayData['available']) && empty($dayData['active'])) {
                continue;
            }
            $checkedDays++;

            if (!empty($dayData['start']) && !empty($dayData['end'])) {
                // User available start <= post start AND user available end >= post end
                $userStart = Carbon::parse('2000-01-01 ' . $dayData['start']);
                $userEnd = Carbon::parse('2000-01-01 ' . $dayData['end']);
                $postStart = Carbon::parse('2000-01-01 ' . $post->work_hours_start);
                $postEnd = Carbon::parse('2000-01-01 ' . $post->work_hours_end);

                if ($userStart->lte($postStart) && $userEnd->gte($postEnd)) {
                    $coveredDays++;
                }
            } else {
                $coveredDays++; // Day active, no time restriction → assume full coverage
            }
        }

        if ($checkedDays === 0)
            return 50;
        return round(($coveredDays / $checkedDays) * 100);
    }

    /**
     * Ücret uyumu: applicant'ın beklenti aralığı ilanın ücret aralığı ile örtüşüyor mu?
     */
    private function scoreSalary(User $applicant, JobPost $post): float
    {
        if (!$post->salary_min && !$post->salary_max) {
            return 0; // İlan ücret belirtmemişse skor verilemez
        }

        $expectedMin = (float) ($applicant->expected_salary_min ?? $applicant->salary_min ?? 0);
        $expectedMax = (float) ($applicant->expected_salary_max ?? $applicant->salary_max ?? 0);

        if ($expectedMin == 0 && $expectedMax == 0) {
            return 0; // Personel ücret beklentisi belirtmemişse skor verilemez
        }

        $postMin = (float) ($post->salary_min ?? 0);
        $postMax = (float) ($post->salary_max ?? PHP_INT_MAX);

        // Full overlap
        if ($expectedMin <= $postMax && $expectedMax >= $postMin) {
            // Perfect overlap or contained within
            if ($expectedMin >= $postMin && $expectedMax <= $postMax) {
                return 100;
            }
            return 80; // Partial overlap
        }

        // Applicant expects more than max (no match)
        if ($expectedMin > $postMax) {
            $diff = ($expectedMin - $postMax) / max($postMax, 1);
            return $diff > 0.3 ? 0 : 30; // Far or slightly over
        }

        return 30;
    }

    /**
     * Sertifika uyumu: ilan sertifika gerektiriyorsa, applicant'ın profilinde var mı?
     */
    private function scoreCertificate(User $applicant, JobPost $post): float
    {
        if (!$post->requires_certificate) {
            return 0; // Sertifika şartı yok — bu kritere skor verilmez
        }

        $requirements = $post->requirements()
            ->where('requirement_type', JobPostRequirement::TYPE_CERTIFICATE)
            ->where('is_mandatory', true)
            ->pluck('requirement_value')
            ->toArray();

        if (empty($requirements)) {
            return 0;
        }

        $userCerts = is_array($applicant->certificates) ? $applicant->certificates : [];
        if (empty($userCerts)) {
            return 0; // Personelin sertifikası yok
        }

        $matched = 0;
        foreach ($requirements as $req) {
            foreach ($userCerts as $cert) {
                if (stripos((string) $cert, $req) !== false || stripos($req, (string) $cert) !== false) {
                    $matched++;
                    break;
                }
            }
        }
        return count($requirements) > 0
            ? round(($matched / count($requirements)) * 100)
            : 0;
    }

    /**
     * Profil tamlık oranı: kullanıcı profilinin ne kadarı dolu?
     */
    private function scoreProfileCompleteness(User $applicant): float
    {
        $fields = [
            'first_name',
            'last_name',
            'email',
            'phone',
            'image',
            'state_id',
            'city_id',
            'street_address',
            'date_of_birth',
            'gender',
            'job_experience_id',
            'career_level_id',
            'about_me',
        ];

        $filled = 0;
        foreach ($fields as $field) {
            if (!empty($applicant->$field)) {
                $filled++;
            }
        }

        return round(($filled / count($fields)) * 100);
    }

    /**
     * Generate a human-readable Turkish explanation of the score.
     */
    private function generateExplanation(float $total, array $breakdown): string
    {
        $positives = [];
        $negatives = [];

        $checks = [
            'location' => ['label' => 'lokasyon uyumu yüksek', 'threshold' => 70],
            'category' => ['label' => 'kategori uyumu tam', 'threshold' => 90],
            'experience' => ['label' => 'deneyim yeterli', 'threshold' => 70],
            'work_hours' => ['label' => 'çalışma saatleri uyumlu', 'threshold' => 70],
            'salary' => ['label' => 'ücret beklentisi uyumlu', 'threshold' => 70],
            'certificate' => ['label' => 'sertifika şartları karşılanıyor', 'threshold' => 90],
            'profile_completeness' => ['label' => 'profil tamlık oranı yüksek', 'threshold' => 70],
        ];

        $negChecks = [
            'location' => 'lokasyon eşleşmesi yok',
            'category' => 'kategori uyumsuz',
            'experience' => 'deneyim yetersiz',
            'salary' => 'ücret beklentisi yüksek',
        ];

        foreach ($checks as $key => $conf) {
            $raw = $breakdown[$key]['raw'] ?? 0;
            if ($raw >= $conf['threshold']) {
                $positives[] = $conf['label'];
            } elseif (isset($negChecks[$key]) && $raw < 30) {
                $negatives[] = $negChecks[$key];
            }
        }

        $explanation = "Bu aday %{$total} uygun";

        if (!empty($positives)) {
            $explanation .= ': ' . ucfirst(implode(', ', $positives));
        }

        if (!empty($negatives)) {
            $explanation .= '. Dikkat: ' . implode(', ', $negatives);
        }

        $explanation .= '.';
        return $explanation;
    }
}
