<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceBooking extends Model
{
    protected $table = 'service_bookings';
    
    protected $fillable = [
        'user_id',
        'service_id',
        'category_id',
        'booking_date',
        'booking_time',
        'duration',
        'total_price',
        'status',
        'notes',
        'location'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function getUser($field = '')
    {
        $user = $this->user()->first();
        if (null !== $user) {
            if (!empty($field)) {
                return $user->$field;
            }
            return $user;
        }
        return null;
    }

    public function service()
    {
        return $this->belongsTo('App\Service', 'service_id', 'id');
    }

    public function getService($field = '')
    {
        $service = $this->service()->first();
        if (null !== $service) {
            if (!empty($field)) {
                return $service->$field;
            }
            return $service;
        }
        return null;
    }

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

    public function getStatusLabel()
    {
        $labels = [
            'pending' => 'Beklemede',
            'confirmed' => 'Onaylandı',
            'in_progress' => 'Devam Ediyor',
            'completed' => 'Tamamlandı',
            'cancelled' => 'İptal Edildi'
        ];
        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusBadgeClass()
    {
        $classes = [
            'pending' => 'badge-warning',
            'confirmed' => 'badge-info',
            'in_progress' => 'badge-primary',
            'completed' => 'badge-success',
            'cancelled' => 'badge-danger'
        ];
        return $classes[$this->status] ?? 'badge-secondary';
    }

    public function getFormattedPrice()
    {
        return '₺' . number_format($this->total_price, 2, ',', '.');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByService($query, $serviceId)
    {
        return $query->where('service_id', $serviceId);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }
}
