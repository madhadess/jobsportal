<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceQuestionOption extends Model
{
    protected $fillable = ['question_id', 'option_text', 'price_impact', 'sort_order'];

    public function question()
    {
        return $this->belongsTo(ServiceQuestion::class, 'question_id');
    }
}
