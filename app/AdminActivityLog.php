<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminActivityLog extends Model
{
    protected $table = 'admin_activity_logs';

    protected $fillable = [
        'admin_id',
        'url',
        'method',
        'payload',
        'ip_address',
        'user_agent'
    ];

    public function admin()
    {
        return $this->belongsTo('App\Admin', 'admin_id', 'id');
    }
}
