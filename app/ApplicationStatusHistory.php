<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationStatusHistory extends Model
{
    protected $table = 'application_status_history';

    public $timestamps = false; // Only has created_at

    protected $fillable = [
        'application_id',
        'old_status',
        'new_status',
        'changed_by',
        'changed_by_role',
        'notes',
    ];

    protected $dates = ['created_at'];

    public function application()
    {
        return $this->belongsTo(ListingApplication::class, 'application_id');
    }

    public function changedByUser()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
