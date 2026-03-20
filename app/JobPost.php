<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobPost extends Model
{
    use SoftDeletes;

    protected $table = 'job_posts';

    protected $fillable = [
        'user_id',
        'title',
        'category_type',
        'category_id',
        'state_id',
        'city_id',
        'work_type',
        'work_hours_start',
        'work_hours_end',
        'min_experience_years',
        'salary_min',
        'salary_max',
        'requires_certificate',
        'requires_reference',
        'description',
        'status',
        'published_at',
        'matched_at',
        'matched_user_id',
        'applications_count',
    ];

    protected $casts = [
        'requires_certificate' => 'boolean',
        'requires_reference' => 'boolean',
        'is_active' => 'boolean',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
        'published_at' => 'datetime',
        'matched_at' => 'datetime',
        'min_experience_years' => 'integer',
        'applications_count' => 'integer',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'published_at', 'matched_at'];

    // Status constants
    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';
    const STATUS_MATCHED = 'matched';
    const STATUS_CLOSED = 'closed';
    const STATUS_CANCELLED = 'cancelled';

    // Work type constants
    const WORK_FULL_TIME = 'full_time';
    const WORK_PART_TIME = 'part_time';
    const WORK_DAILY = 'daily';

    // --- Relationships ---

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'state_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }

    public function requirements()
    {
        return $this->hasMany(JobPostRequirement::class, 'job_post_id');
    }

    public function applications()
    {
        return $this->hasMany(ListingApplication::class, 'job_post_id');
    }

    public function matchedUser()
    {
        return $this->belongsTo(User::class, 'matched_user_id');
    }

    // --- Scopes ---

    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    public function scopeDraft($query)
    {
        return $query->where('status', self::STATUS_DRAFT);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('category_type', $type);
    }

    public function scopeForPersonnel($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    // --- Helpers ---

    public static function getStatusLabels(): array
    {
        return [
            self::STATUS_DRAFT => 'Taslak',
            self::STATUS_PUBLISHED => 'Yayında',
            self::STATUS_MATCHED => 'Eşleşti',
            self::STATUS_CLOSED => 'Kapandı',
            self::STATUS_CANCELLED => 'İptal',
        ];
    }

    public static function getWorkTypeLabels(): array
    {
        return [
            self::WORK_FULL_TIME => 'Tam Zamanlı',
            self::WORK_PART_TIME => 'Part-time',
            self::WORK_DAILY => 'Günlük',
        ];
    }

    public function getStatusLabel(): string
    {
        return self::getStatusLabels()[$this->status] ?? $this->status;
    }

    public function getWorkTypeLabel(): string
    {
        return self::getWorkTypeLabels()[$this->work_type] ?? $this->work_type;
    }

    public function getSalaryRange(): string
    {
        if ($this->salary_min && $this->salary_max) {
            return '₺' . number_format($this->salary_min, 0) . ' - ₺' . number_format($this->salary_max, 0);
        }
        if ($this->salary_min) {
            return '₺' . number_format($this->salary_min, 0) . '+';
        }
        return 'Belirtilmemiş';
    }

    public function isOpen(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    public function publish(): void
    {
        $this->status = self::STATUS_PUBLISHED;
        $this->published_at = now();
        $this->save();
    }

    public function close(): void
    {
        $this->status = self::STATUS_CLOSED;
        $this->save();
    }

    public function cancel(): void
    {
        $this->status = self::STATUS_CANCELLED;
        $this->save();
    }

    public function markMatched(int $userId): void
    {
        $this->status = self::STATUS_MATCHED;
        $this->matched_at = now();
        $this->matched_user_id = $userId;
        $this->save();
    }
}
