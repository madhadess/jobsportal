<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    public $timestamps = false; // Disable timestamps since roles table doesn't have created_at/updated_at

    protected $fillable = [
        'role_name',
        'display_name',
        'description',
        'is_active',
        'is_system',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_system' => 'boolean',
    ];

    // İlişkiler
    public function users()
    {
        return $this->hasMany('App\User', 'role_id', 'id');
    }

    public function admins()
    {
        return $this->hasMany('App\Admin', 'role_id', 'id');
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission', 'role_permissions');
    }

    // Scope'lar
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSystem($query)
    {
        return $query->where('is_system', true);
    }

    public function scopeCustom($query)
    {
        return $query->where('is_system', false);
    }

    // Yetki kontrolü
    public function hasPermission($permission)
    {
        if (is_string($permission)) {
            $has = $this->permissions()->where('name', $permission)->exists();
            // \Log::info("Role::hasPermission Check: Role ID: " . $this->id . " Permission: " . $permission . " Result: " . ($has ? 'YES' : 'NO'));
            return $has;
        }

        return $this->permissions()->whereIn('id', $permission)->exists();
    }

    public function givePermissionTo($permission)
    {
        if (is_string($permission)) {
            $permission = \App\Models\Permission::where('name', $permission)->firstOrFail();
        }

        $this->permissions()->syncWithoutDetaching($permission);
    }

    public function revokePermissionTo($permission)
    {
        if (is_string($permission)) {
            $permission = \App\Models\Permission::where('name', $permission)->firstOrFail();
        }

        $this->permissions()->detach($permission);
    }

    public function syncPermissions($permissions)
    {
        $this->permissions()->sync($permissions);
    }
}
