<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceOption extends Model
{
    protected $table = 'service_options';

    protected $fillable = [
        'category_id',
        'option_type',
        'option_name',
        'is_active',
        'sort_order'
    ];

    public function category()
    {
        return $this->belongsTo(\App\ServiceCategory::class, 'category_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
