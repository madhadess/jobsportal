<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccupationGroup extends Model
{
    protected $fillable = ['name', 'parent_id', 'is_active'];
    use HasFactory;

    public function parent()
    {
        return $this->belongsTo(OccupationGroup::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(OccupationGroup::class, 'parent_id');
    }
}
