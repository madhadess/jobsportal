<?php

namespace App;
use App\Notifications\AdminResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{

    use Notifiable;


    protected $table = 'admins';
    protected $have_role;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_manager',
        'current_status',
        'status_updated_at',
        'today_date',
        'today_online_seconds',
        'today_break_seconds',
        'today_in_call_seconds',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_manager' => 'boolean',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPassword($token));
    }

    public function role()
    {
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }

    public function activity()
    {
        return $this->hasOne('App\AdminActivity', 'admin_id');
    }

    public function hasRole($roles)
    {
        $this->have_role = $this->getAdminUserRole();
        if (is_array($roles)) {
            foreach ($roles as $need_role) {
                if ($this->checkIfAdminUserHasRole($need_role)) {
                    return true;
                }
            }
        } else {
            return $this->checkIfAdminUserHasRole($roles);
        }
        return false;
    }

    public function getAdminUserRole()
    {
        return $this->role()->getResults();
    }

    private function checkIfAdminUserHasRole($need_role)
    {
        if (null === $this->have_role) {
            return false;
        }
        return (strtolower($need_role) == strtolower($this->have_role->role_name)) ? true : false;
    }

    public function hasPermission($permission)
    {
        $role = $this->role()->first();
        if (!$role) {
            return false;
        }
        // Super Admin has all permissions
        if ($role->role_name == 'SUPER_ADMIN') {
            return true;
        }
        return $role->hasPermission($permission);
    }






}
