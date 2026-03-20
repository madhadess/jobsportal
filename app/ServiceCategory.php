<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    protected $fillable = [
        'category_name',
        'type',
        'category_slug',
        'category_desc',
        'category_image',
        'is_active',
        'sort_order'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function services()
    {
        return $this->hasMany('App\Service', 'category_id', 'id');
    }

    public function getActiveServices()
    {
        return $this->services()->where('is_active', 1)->orderBy('sort_order', 'asc')->get();
    }

    public function getServicesCount()
    {
        return $this->services()->where('is_active', 1)->count();
    }

    public function getCategoryImage($width = 0, $height = 0)
    {
        $image = (string) $this->category_image;
        $image = (!empty($image)) ? $image : 'no-image.jpg';
        return \ImgUploader::print_image("service_categories/$image", $width, $height, '/admin_assets/no-image.png', $this->category_name);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function options()
    {
        return $this->hasMany('App\ServiceOption', 'category_id', 'id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('category_name', 'asc');
    }
}
