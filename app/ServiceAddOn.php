<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceAddOn extends Model
{
    protected $table = 'service_add_ons';
    
    protected $fillable = [
        'service_id',
        'addon_name',
        'addon_description',
        'addon_image',
        'addon_price',
        'is_active',
        'sort_order'
    ];

    public function service()
    {
        return $this->belongsTo('App\Service', 'service_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('addon_name', 'asc');
    }
}
