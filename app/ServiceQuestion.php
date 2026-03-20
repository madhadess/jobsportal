<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceQuestion extends Model
{
    protected $fillable = ['category_id', 'question', 'type', 'is_required', 'sort_order'];

    public function options()
    {
        return $this->hasMany(ServiceQuestionOption::class, 'question_id')->orderBy('sort_order');
    }

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }
}
