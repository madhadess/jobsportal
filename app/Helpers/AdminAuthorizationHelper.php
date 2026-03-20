<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AdminAuthorizationHelper
{

    public static function check($allowed_roles = ['SUPER_ADMIN'])
    {
        if (null === Auth::guard('admin')->user()) {
            return false;
        }
        $user = Auth::guard('admin')->user();
        if (!is_array($allowed_roles)) {
            $allowed_roles = [$allowed_roles];
        }
        foreach ($allowed_roles as $role) {
            if ($user->hasRole($role)) {
                return true;
            }
        }
        return false;
    }

    public static function hasPermission($permission)
    {
        if (null === Auth::guard('admin')->user()) {
            return false;
        }
        return Auth::guard('admin')->user()->hasPermission($permission);
    }

}
