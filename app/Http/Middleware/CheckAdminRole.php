<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdminRole
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $admin = Auth::guard('admin')->user();

        if (config('app.debug')) {
            $routeAction = $request->route()->getAction();
            $requiredRoles = isset($routeAction['allowed_roles']) ? $routeAction['allowed_roles'] : 'NONE';
            \Log::debug("CheckAdminRole: Admin ID: " . ($admin ? $admin->id : 'GUEST') . ", route requires: " . json_encode($requiredRoles));
        }

        if (!$admin) {
            \Log::warning("CheckAdminRole: No admin user found.");
            return response()->view('admin.errors.401', [], 401);
        }

        // 1. Super Admin always allowed
        // 2. Managers always allowed (but still restricted by CheckPermission later)
        if ($admin->hasRole('SUPER_ADMIN') || $admin->is_manager) {
            return $next($request);
        }

        // Get the required roles from the route
        $roles = $this->getRequiredRoleForRoute($request->route());

        // 3. If no specific roles required, allow through
        if (!$roles) {
            return $next($request);
        }

        // 4. Check if user has the specific required role
        if ($admin->hasRole($roles)) {
            return $next($request);
        }

        // Fallback for custom active roles on "general" routes (SUB_ADMIN etc)
        $role = $admin->role()->first();
        if ($role && $role->is_active && !$role->is_system) {
            if (is_array($roles) && in_array('SUB_ADMIN', $roles)) {
                return $next($request);
            }
            if ($roles == 'SUB_ADMIN') {
                return $next($request);
            }
        }

        \Log::warning("CheckAdminRole: Access DENIED. Admin ID: " . $admin->id . ", roles: " . json_encode($admin->role()->pluck('role_name')) . ", required: " . json_encode($roles));
        return response()->view('admin.errors.401', [], 401);
    }

    private function getRequiredRoleForRoute($route)
    {
        $actions = $route->getAction();
        return isset($actions['allowed_roles']) ? $actions['allowed_roles'] : null;
    }

}