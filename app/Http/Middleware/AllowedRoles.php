<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Auth;
use App\Role;

class AllowedRoles
{
    /**
     * Handle an incoming request.
     *
     * If specific roles are passed, check against those.
     * If no roles specified, allow any admin with an active role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $admin = Auth::guard('admin')->user();

        if (config('app.debug')) {
            Log::debug("AllowedRoles: Checking access for Admin ID: " . ($admin ? $admin->id : 'GUEST') . ", roles: " . json_encode($roles));
        }

        if (!$admin) {
            Log::warning("AllowedRoles: Access DENIED (No admin user found).");
            if ($request->ajax()) {
                return response()->json(['error' => 'Oturum süresi doldu'], 401);
            }
            return redirect()->route('admin.login');
        }

        // Super Admin and Managers always pass this check
        if ($admin->hasRole('SUPER_ADMIN') || $admin->is_manager) {
            return $next($request);
        }

        // If no specific roles required, allow any admin with an active role
        if (empty($roles)) {
            $role = $admin->role()->first();
            if ($role && $role->is_active) {
                return $next($request);
            }
            Log::warning("AllowedRoles: Access DENIED (No specific roles required but admin has no active role). Admin ID: " . $admin->id);
        } else {
            // Check if admin has any of the specified roles
            if ($admin && $admin->hasRole($roles)) {
                return $next($request);
            }
            Log::warning("AllowedRoles: Access DENIED (Admin does not have required role(s): " . json_encode($roles) . "). Admin ID: " . $admin->id);

            // Fallback for custom active roles on "general" routes (SUB_ADMIN etc)
            $role = ($admin) ? $admin->role()->first() : null;
            if ($role && $role->is_active && !$role->is_system) {
                if (is_array($roles) && in_array('SUB_ADMIN', $roles)) {
                    return $next($request);
                }
                if ($roles == 'SUB_ADMIN') {
                    return $next($request);
                }
            }

            // Also check: if the role is active and exists in DB, allow through
            $role = $admin->role()->first();
            if ($role && $role->is_active) {
                $activeRoleNames = Role::where('is_active', 1)->pluck('role_name')->toArray();
                if (in_array($role->role_name, $activeRoleNames)) {
                    return $next($request);
                }
            }
        }

        if ($request->ajax()) {
            return response()->json(['error' => 'Yetkisiz Erişim'], 401);
        }

        return response()->view('admin.errors.401', [], 401);
    }
}