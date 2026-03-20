<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileCertificate extends Model
{
    protected $table = 'profile_certificates';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
