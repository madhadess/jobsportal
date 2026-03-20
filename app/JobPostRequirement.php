<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobPostRequirement extends Model
{
    protected $table = 'job_post_requirements';

    protected $fillable = [
        'job_post_id',
        'requirement_type',
        'requirement_value',
        'is_mandatory',
    ];

    protected $casts = [
        'is_mandatory' => 'boolean',
    ];

    // Requirement types
    const TYPE_CERTIFICATE = 'certificate';
    const TYPE_LANGUAGE = 'language';
    const TYPE_SKILL = 'skill';
    const TYPE_DOCUMENT = 'document';

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class, 'job_post_id');
    }

    public static function getTypeLabels(): array
    {
        return [
            self::TYPE_CERTIFICATE => 'Sertifika',
            self::TYPE_LANGUAGE => 'Dil',
            self::TYPE_SKILL => 'Beceri',
            self::TYPE_DOCUMENT => 'Belge',
        ];
    }
}
