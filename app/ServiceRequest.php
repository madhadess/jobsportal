<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\State;
use App\City;

class ServiceRequest extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'service_id',
        'request_number',
        'customer_notes',
        'customer_phone',
        'customer_address',
        'customer_city',
        'customer_district',
        'customer_neighborhood',
        'customer_street',
        'preferred_date',
        'preferred_time',
        'status',
        'final_price',
        'admin_notes',
        'approved_at',
        'completed_at',
        'automation_status',
        'matched_personnel_id',
        'matching_attempts',
        'service_duration',
        'home_size',
        'extra_details'
    ];

    /**
     * Find the best matching personnel for this request
     */
    public function findBestMatchingPersonnel()
    {
        $category_id = $this->category_id;
        $city = $this->customer_city;
        $district = $this->customer_district;
        $neighborhood = $this->customer_neighborhood;
        $street = $this->customer_street;

        // 1. Filter personnel eligible for auto-assignment and match category
        $query = User::where('is_eligible_for_auto_assignment', 1)
            ->where(function ($q) use ($category_id) {
                $q->whereJsonContains('service_types', (string) $category_id)
                    ->orWhereJsonContains('service_types', (int) $category_id);
            });

        // 1.1 Match Occupation Group if specified in request
        if ($this->occupation_group_id) {
            $occupationGroups = (array) $this->occupation_group_id;
            $query->where(function ($q) use ($occupationGroups) {
                foreach ($occupationGroups as $groupId) {
                    $q->orWhereJsonContains('occupation_group_id', (string) $groupId)
                        ->orWhereJsonContains('occupation_group_id', (int) $groupId);
                }
            });
        }

        // 2. Location Filtering (Hierarchical)
        // Level A: Direct Street/Neighborhood match (Priority)
        // Level B: Work Locations (JSON) contains the State ID

        $personnel = $query->get();

        if ($personnel->isEmpty()) {
            return null;
        }

        // Scoring and Sorting
        $scoredPersonnel = $personnel->map(function ($p) use ($city, $district, $neighborhood, $street) {
            $score = 0;

            // State match (State name or ID check)
            $state = State::where('state', $city)->first();
            if ($state && in_array($state->id, (array) $p->work_locations)) {
                $score += 10;
            }

            // District match
            if (stripos($p->street_address, $district) !== false) {
                $score += 20;
            }

            // Neighborhood match
            if ($neighborhood && stripos($p->neighborhood, $neighborhood) !== false) {
                $score += 40;
            }

            // Street match (Highest priority)
            if ($street && stripos($p->street, $street) !== false) {
                $score += 100;
            }

            // Availability check (Simple daily limit)
            $todayTasks = ServiceRequest::where('matched_personnel_id', $p->id)
                ->whereDate('preferred_date', $this->preferred_date)
                ->count();

            if ($todayTasks >= ($p->max_daily_tasks ?: 5)) {
                $score = -1; // Disqualify
            }

            $p->matching_score = $score;
            return $p;
        })->filter(function ($p) {
            return $p->matching_score >= 0;
        })->sortByDesc('matching_score');

        return $scoredPersonnel->first();
    }

    protected $dates = ['created_at', 'updated_at', 'preferred_date', 'approved_at', 'completed_at'];

    protected $casts = [
        'occupation_group_id' => 'array',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    public static function getStatusLabels()
    {
        return [
            self::STATUS_PENDING => 'Beklemede',
            self::STATUS_APPROVED => 'Onaylandı',
            self::STATUS_IN_PROGRESS => 'Devam Ediyor',
            self::STATUS_COMPLETED => 'Tamamlandı',
            self::STATUS_CANCELLED => 'İptal Edildi'
        ];
    }

    public static function getStatusColors()
    {
        return [
            self::STATUS_PENDING => 'warning',
            self::STATUS_APPROVED => 'info',
            self::STATUS_IN_PROGRESS => 'primary',
            self::STATUS_COMPLETED => 'success',
            self::STATUS_CANCELLED => 'danger'
        ];
    }

    public function category()
    {
        return $this->belongsTo('App\ServiceCategory', 'category_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function getUser($field = '')
    {
        $user = $this->user()->first();
        if (null !== $user) {
            if (!empty($field)) {
                return $user->$field;
            }
            return $user;
        }
        return null;
    }

    public function service()
    {
        return $this->belongsTo('App\Service', 'service_id', 'id');
    }

    public function assignedPersonnel()
    {
        return $this->belongsToMany('App\User', 'service_request_personnel', 'service_request_id', 'user_id')
            ->withPivot('assigned_at')
            ->withTimestamps();
    }

    public function matchedPersonnel()
    {
        return $this->belongsTo('App\User', 'matched_personnel_id', 'id');
    }

    public function scopePendingMatching($query)
    {
        return $query->where('automation_status', 'pending_matching')->where('status', self::STATUS_PENDING);
    }

    public function getService($field = '')
    {
        $service = $this->service()->first();
        if (null !== $service) {
            if (!empty($field)) {
                return $service->$field;
            }
            return $service;
        }
        return null;
    }

    public function getStatusLabel()
    {
        $labels = self::getStatusLabels();
        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusColor()
    {
        $colors = self::getStatusColors();
        return $colors[$this->status] ?? 'secondary';
    }

    public function getFormattedDate()
    {
        if ($this->preferred_date) {
            return Carbon::parse($this->preferred_date)->format('d.m.Y');
        }
        return 'Belirtilmemiş';
    }

    public function getFormattedTime()
    {
        if ($this->preferred_time) {
            return Carbon::parse($this->preferred_time)->format('H:i');
        }
        return 'Belirtilmemiş';
    }

    public function getFullAddress()
    {
        return $this->customer_address . ', ' . $this->customer_district . '/' . $this->customer_city;
    }

    public function customerState()
    {
        return $this->belongsTo(State::class, 'customer_city', 'state_id');
    }

    public function customerDistrictModel()
    {
        return $this->belongsTo(City::class, 'customer_district', 'city_id');
    }

    public function getCustomerStateNameAttribute()
    {
        return optional($this->customerState)->state ?? $this->customer_city;
    }

    public function getCustomerDistrictNameAttribute()
    {
        return optional($this->customerDistrictModel)->city ?? $this->customer_district;
    }

    public static function generateRequestNumber()
    {
        $prefix = 'HT';
        $date = date('Ymd');
        $random = strtoupper(substr(uniqid(), -4));
        return $prefix . $date . $random;
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function approve()
    {
        $this->status = self::STATUS_APPROVED;
        $this->approved_at = now();
        $this->save();
    }

    public function complete()
    {
        $this->status = self::STATUS_COMPLETED;
        $this->completed_at = now();
        $this->save();
    }

    public function cancel()
    {
        $this->status = self::STATUS_CANCELLED;
        $this->save();
    }
}
