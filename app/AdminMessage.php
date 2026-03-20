<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminMessage extends Model
{
    protected $table = 'admin_messages';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'subject',
        'message',
        'is_read'
    ];

    public function sender()
    {
        return $this->belongsTo('App\Admin', 'sender_id', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo('App\Admin', 'receiver_id', 'id');
    }
}
