<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchRuleWeight extends Model
{
    protected $table = 'match_rule_weights';

    protected $fillable = [
        'rule_key',
        'rule_label',
        'weight',
        'is_active',
        'updated_by',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Rule keys
    const RULE_LOCATION = 'location';
    const RULE_CATEGORY = 'category';
    const RULE_EXPERIENCE = 'experience';
    const RULE_WORK_HOURS = 'work_hours';
    const RULE_SALARY = 'salary';
    const RULE_CERTIFICATE = 'certificate';
    const RULE_PROFILE_COMPLETENESS = 'profile_completeness';

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Retrieve all weights as array: ['rule_key' => weight].
     */
    public static function getWeightsMap(): array
    {
        return static::active()->pluck('weight', 'rule_key')->toArray();
    }
}
