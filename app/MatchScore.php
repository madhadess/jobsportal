<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchScore extends Model
{
    protected $table = 'match_scores';

    public $timestamps = false;

    protected $fillable = [
        'job_post_id',
        'user_id',
        'total_score',
        'breakdown',
        'explanation',
        'engine_version',
        'computed_at',
    ];

    protected $casts = [
        'total_score' => 'decimal:2',
        'breakdown' => 'array',
        'computed_at' => 'datetime',
    ];

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class, 'job_post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
