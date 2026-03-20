<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminActivity extends Model
{
    protected $table = 'admin_activities';

    protected $fillable = [
        'admin_id',
        'url',
        'method',
        'ip_address',
        'user_agent',
        'last_activity',
        'is_online'
    ];

    public function admin()
    {
        return $this->belongsTo('App\Admin', 'admin_id', 'id');
    }
}
