<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class ListingApplication extends Model
{
    use SoftDeletes;

    protected $table = 'listing_applications';

    protected $fillable = [
        'job_post_id',
        'user_id',
        'cover_note',
        'status',
        'match_score',
        'match_breakdown',
        'match_explanation',
        'is_auto_matched',
    ];

    protected $casts = [
        'match_score' => 'decimal:2',
        'match_breakdown' => 'array',
        'is_auto_matched' => 'boolean',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_SHORTLISTED = 'shortlisted';
    const STATUS_INVITED = 'invited';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_REJECTED = 'rejected';
    const STATUS_WITHDRAWN = 'withdrawn';

    // --- Relationships ---

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class, 'job_post_id');
    }

    public function applicant()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function statusHistory()
    {
        return $this->hasMany(ApplicationStatusHistory::class, 'application_id')
            ->orderBy('created_at', 'desc');
    }

    // --- Scopes ---

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeShortlisted($query)
    {
        return $query->where('status', self::STATUS_SHORTLISTED);
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', self::STATUS_ACCEPTED);
    }

    // --- Helpers ---

    public static function getStatusLabels(): array
    {
        return [
            self::STATUS_PENDING => 'Beklemede',
            self::STATUS_SHORTLISTED => 'Kısa Listede',
            self::STATUS_INVITED => 'Görüşmeye Davet Edildi',
            self::STATUS_ACCEPTED => 'Kabul Edildi',
            self::STATUS_REJECTED => 'Reddedildi',
            self::STATUS_WITHDRAWN => 'Başvuru Geri Çekildi',
        ];
    }

    public static function getStatusColors(): array
    {
        return [
            self::STATUS_PENDING => 'warning',
            self::STATUS_SHORTLISTED => 'info',
            self::STATUS_INVITED => 'primary',
            self::STATUS_ACCEPTED => 'success',
            self::STATUS_REJECTED => 'danger',
            self::STATUS_WITHDRAWN => 'secondary',
        ];
    }

    public function getStatusLabel(): string
    {
        return self::getStatusLabels()[$this->status] ?? $this->status;
    }

    public function getStatusColor(): string
    {
        return self::getStatusColors()[$this->status] ?? 'default';
    }

    public function getMatchScoreBadgeColor(): string
    {
        $score = (float) $this->match_score;
        if ($score >= 80)
            return 'success';
        if ($score >= 60)
            return 'warning';
        return 'danger';
    }

    /**
     * Log a status change to application_status_history.
     */
    public function logStatusChange(string $newStatus, string $notes = '', string $role = 'member'): void
    {
        ApplicationStatusHistory::create([
            'application_id' => $this->id,
            'old_status' => $this->status,
            'new_status' => $newStatus,
            'changed_by' => Auth::id(),
            'changed_by_role' => $role,
            'notes' => $notes,
        ]);
    }

    /**
     * Update status with audit log.
     */
    public function updateStatus(string $newStatus, string $notes = '', string $role = 'member'): void
    {
        $this->logStatusChange($newStatus, $notes, $role);
        $this->status = $newStatus;
        $this->save();
    }
}
