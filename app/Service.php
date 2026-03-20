<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'category_id',
        'service_name',
        'service_slug',
        'service_desc',
        'service_image',
        'price',
        'price_model',
        'duration_minutes',
        'is_active',
        'is_featured',
        'sort_order',
        'views_count',
        'requests_count'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function category()
    {
        return $this->belongsTo('App\ServiceCategory', 'category_id', 'id');
    }

    public function getCategory($field = '')
    {
        $category = $this->category()->first();
        if (null !== $category) {
            if (!empty($field)) {
                return $category->$field;
            }
            return $category;
        }
        return null;
    }

    public function requests()
    {
        return $this->hasMany('App\ServiceRequest', 'service_id', 'id');
    }

    public function addOns()
    {
        return $this->hasMany('App\ServiceAddOn', 'service_id', 'id');
    }

    public function getRequestsCount()
    {
        return $this->requests()->count();
    }

    public function getServiceImage($width = 0, $height = 0)
    {
        $image = (string)$this->service_image;
        $image = (!empty($image)) ? $image : 'no-image.jpg';
        return \ImgUploader::print_image("services/$image", $width, $height, '/admin_assets/no-image.png', $this->service_name);
    }

    public function getFormattedPrice()
    {
        if ($this->price === null) {
            return 'Fiyat için iletişime geçin';
        }
        
        $priceLabels = [
            'fixed' => ' TL',
            'hourly' => ' TL/saat',
            'package' => ' TL (paket)'
        ];
        
        return number_format($this->price, 2, ',', '.') . ($priceLabels[$this->price_model] ?? ' TL');
    }

    public function getFormattedDuration()
    {
        if ($this->duration_minutes === null) {
            return 'Belirtilmemiş';
        }
        
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;
        
        if ($hours > 0 && $minutes > 0) {
            return $hours . ' saat ' . $minutes . ' dakika';
        } elseif ($hours > 0) {
            return $hours . ' saat';
        }
        return $minutes . ' dakika';
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', 1);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('service_name', 'asc');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }
}
