<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\SystemConfig;
use Auth;

class AdminSecurityMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();

            // Süper Admin her zaman her şeyi geçebilir (Güvenli ve yedekli kontrol)
            if ($admin->role_id == 1 || ($admin->role && $admin->role->role_name === 'SUPER_ADMIN')) {
                return $next($request);
            }

            // 1. IP Beyaz Listesi Kontrolü
            $ipWhitelist = SystemConfig::where('key', 'ip_whitelist')->first();
            if ($ipWhitelist && !empty($ipWhitelist->value)) {
                $allowedIps = array_map('trim', explode(',', $ipWhitelist->value));
                if (!in_array($request->ip(), $allowedIps)) {
                    if ($request->ajax()) {
                        return response()->json(['error' => 'IP Yetkilendirme Hatası', 'your_ip' => $request->ip()], 401);
                    }
                    return response()->view('admin.errors.401', ['message' => 'IP adresiniz (' . $request->ip() . ') bu islem için yetkili degil.'], 401);
                }
            }

            // 2. Bakım Modu Kontrolü
            $maintenanceMode = SystemConfig::where('key', 'maintenance_mode')->first();
            if ($maintenanceMode && $maintenanceMode->value == '1') {
                if ($request->ajax()) {
                    return response()->json(['error' => 'Sistem Bakımda'], 401);
                }
                return response()->view('admin.errors.401', ['message' => 'Sistem su an bakımdadır. Lütfen daha sonra tekrar deneyiniz.'], 401);
            }
        }

        return $next($request);
    }
}
