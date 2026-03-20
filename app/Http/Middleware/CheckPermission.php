<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * Check if the authenticated admin has the required permission.
     * SUPER_ADMIN bypasses all permission checks (handled in Admin::hasPermission).
     *
     * Usage: ->middleware('check_permission:view_users')
     *        ->middleware('check_permission:delete_users,edit_users') // any of these
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$permissions  One or more permission names (OR logic)
     * @return mixed
     */
    public function handle($request, Closure $next, ...$permissions)
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            \Log::warning("CheckPermission: No admin user found.");
            if ($request->ajax()) {
                return response()->json(['error' => 'Oturum süresi doldu'], 401);
            }
            return redirect()->route('admin.login');
        }

        if (config('app.debug')) {
            \Log::debug("CheckPermission: Admin ID: " . $admin->id . ", required: " . implode(', ', $permissions));
        }

        // Check if admin has ANY of the required permissions (OR logic)
        foreach ($permissions as $permission) {
            if ($admin->hasPermission($permission)) {
                return $next($request);
            }
        }

        \Log::warning("CheckPermission: Access DENIED. Admin ID: " . $admin->id . " does NOT have any of: " . implode(', ', $permissions));

        // No permission matched
        if ($request->ajax()) {
            return response()->json(['error' => 'Bu işlem için yetkiniz bulunmamaktadır.'], 403);
        }

        return response()->view('admin.errors.401', [], 403);
    }
}