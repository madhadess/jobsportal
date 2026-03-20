<?php

namespace App\Http\Middleware;

use Closure;
use App\AdminActivity;
use Auth;

use Illuminate\Support\Str;

class AdminActivityMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();

            // Müdürler aktivite/sayaç takibinden muaftır.
            if ($admin && $admin->is_manager) {
                return $next($request);
            }

            try {
                // Exclude background tasks from logging
                // Using partial strings to match any prefix
                $excludedPaths = [
                    'get-my-notifications',
                    'get-staff-activities',
                    'get-staff-history',
                    'mark-notification-read',
                    'fetch-' // Exclude ALL DataTable fetch routes (fetch-admin-users, fetch-cms, etc.)
                ];

                if (!Str::contains($request->path(), $excludedPaths)) {
                    $isLogout = Str::contains($request->path(), 'logout');
                    $isStatusUpdate = Str::contains($request->path(), 'crm/set-status');
                    $requestedStatus = strtoupper((string) $request->input('status', ''));
                    $isOfflineRequest = $requestedStatus === 'OFFLINE';

                    // Log activity status
                    AdminActivity::updateOrCreate(
                        ['admin_id' => $admin->id],
                        [
                            'url' => $request->fullUrl(),
                            'method' => $request->method(),
                            'ip_address' => $request->ip(),
                            'user_agent' => $request->userAgent(),
                            'last_activity' => now(),
                            // OFFLINE status isteğinde online'a geri çekme yapma.
                            'is_online' => ($isLogout || ($isStatusUpdate && $isOfflineRequest)) ? false : true,
                        ]
                    );

                    // Gelişmiş Log Kaydı
                    if ($admin->id) {
                        \App\AdminActivityLog::create([
                            'admin_id' => $admin->id,
                            'url' => $request->fullUrl(),
                            'method' => $request->method(),
                            'payload' => json_encode($request->except(['_token', 'password', 'password_confirmation'])),
                            'ip_address' => $request->ip(),
                            'user_agent' => $request->userAgent(),
                        ]);
                    }
                }
            } catch (\Exception $e) {
                // Hata durumunda isteği kesme, sadece logla (tn/7 önleyici)
                \Log::warning('Activity Logging Failed: ' . $e->getMessage());
            }
        }

        return $next($request);
    }
}
