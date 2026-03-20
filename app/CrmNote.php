<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CrmNote extends Model
{
    protected $table = 'crm_notes';

    protected $fillable = [
        'admin_id',
        'creator_id',
        'title',
        'content',
        'event_date',
        'is_completed',
        'priority',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'is_completed' => 'boolean',
    ];

    public function staff()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'creator_id');
    }
}
