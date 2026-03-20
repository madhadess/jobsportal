<?php
// public/fix_crm_columns.php - Path-corrected standalone fix script

// Path correction for public directory
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

echo "<pre>";
echo "<h3>CRM Altyapı Düzeltme Aracı (Public) Başlatıldı...</h3>";

// 1. Admins Tablosu
echo "[1/3] Admins tablosu kontrol ediliyor...\n";
$columnsToAdd = [
    'current_status' => 'string',
    'status_updated_at' => 'timestamp',
    'today_date' => 'date',
    'today_online_seconds' => 'integer',
    'today_break_seconds' => 'integer',
    'today_in_call_seconds' => 'integer',
];

try {
    Schema::table('admins', function (Blueprint $table) use ($columnsToAdd) {
        foreach ($columnsToAdd as $col => $type) {
            if (!Schema::hasColumn('admins', $col)) {
                echo "- '$col' kolonu ekleniyor...\n";
                if ($type == 'string')
                    $table->string($col)->nullable();
                elseif ($type == 'timestamp')
                    $table->timestamp($col)->nullable();
                elseif ($type == 'date')
                    $table->date($col)->nullable();
                elseif ($type == 'integer')
                    $table->integer($col)->default(0);
            } else {
                echo "- '$col' kolonu aktif.\n";
            }
        }
    });
    echo "Admins tablosu hazır.\n";
} catch (\Exception $e) {
    echo "HATA (Admins): " . $e->getMessage() . "\n";
}

// 2. SystemConfig (App\Models\SystemConfig)
echo "\n[2/3] Sistem Ayarları kontrol ediliyor...\n";
try {
    $exists = DB::table('system_configs')->where('key', 'daily_break_limit')->exists();
    if (!$exists) {
        echo "- 'daily_break_limit' ekleniyor...\n";
        DB::table('system_configs')->insert([
            'key' => 'daily_break_limit',
            'value' => '60',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    } else {
        echo "- 'daily_break_limit' aktif.\n";
    }
} catch (\Exception $e) {
    echo "HATA (SystemConfig): " . $e->getMessage() . "\n";
}

// 3. CrmController.php (FORCE UPDATE)
echo "\n[3/3] CrmController.php güncelleniyor...\n";
$controllerPath = base_path('app/Http/Controllers/Admin/CrmController.php');

$controllerCode = <<<'CODE'
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Admin;
use App\AdminActivity;
use App\AdminNotification;
use App\CrmNote;
use App\Services\UrlMapperService;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class CrmController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            $admin = Auth::guard('admin')->user();
            if ($admin && ($admin->hasRole('SUPER_ADMIN') || $admin->is_manager)) {
                return $next($request);
            }
            $criticalMethods = ['sendNotification'];
            if (in_array($request->route()->getActionMethod(), $criticalMethods)) {
                return response()->view('admin.errors.401', [], 401);
            }
            return $next($request);
        })->except([
            'setStatus',
            'getMyNotifications',
            'markNotificationRead',
            'index',
            'show',
            'getStaffActivities',
            'getStaffHistory',
            'storeNote',
            'getNotes',
            'deleteNote',
            'toggleNoteStatus',
            'personnelDashboard'
        ]);
    }

    public function index()
    {
        $admin = Auth::guard('admin')->user();
        if ($admin && !$admin->is_manager && !$admin->hasRole('SUPER_ADMIN')) {
            return redirect()->route('admin.crm.personnel');
        }
        $staffMembers = Admin::whereHas('role', function ($q) {
            $q->where('role_name', '!=', 'SUPER_ADMIN');
        })->where('is_manager', 0)->get();
        return view('admin.crm.index', compact('staffMembers'));
    }

    public function sendNotification(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|exists:admins,id',
            'message' => 'required|string',
            'type' => 'required|in:modal,alert,toast'
        ]);

        AdminNotification::create([
            'admin_id' => $request->admin_id,
            'message' => $request->message,
            'type' => $request->type,
            'is_read' => false
        ]);

        return response()->json(['success' => true, 'message' => 'Bildirim başarıyla gönderildi.']);
    }

    public function getStaffActivities()
    {
        $staffMembers = Admin::with(['role', 'activity'])
            ->whereHas('role', function ($q) {
                $q->where('role_name', '!=', 'SUPER_ADMIN');
            })
            ->where('is_manager', 0)
            ->get()
            ->map(function ($admin) {
                $params = new \stdClass();
                $params->admin = $admin;
                $params->admin_id = $admin->id;
                $lastActivityDate = $admin->activity ? \Carbon\Carbon::parse($admin->activity->last_activity) : null;
                $url = $admin->activity->url ?? '';
                $params->friendly_url = $url ? UrlMapperService::getFriendlyName($url) : 'Henüz işlem yok';
                $params->url = $url;
                $currentStatus = $admin->current_status ?? 'OFFLINE';
                $statusUpdated = $admin->status_updated_at ? \Carbon\Carbon::parse($admin->status_updated_at) : \Carbon\Carbon::now();
                $params->status_details = UrlMapperService::getStatusDetails($currentStatus);
                $now = \Carbon\Carbon::now();
                $today = $now->toDateString();
                $params->page_duration_seconds = $lastActivityDate ? $now->diffInSeconds($lastActivityDate) : 0;
                $params->status_duration_seconds = $now->diffInSeconds($statusUpdated);
                $accumulatedOnline = $admin->today_date == $today ? $admin->today_online_seconds : 0;
                $accumulatedBreak = $admin->today_date == $today ? $admin->today_break_seconds : 0;
                $accumulatedInCall = $admin->today_date == $today ? $admin->today_in_call_seconds : 0;
                $currentDiff = $now->diffInSeconds($statusUpdated);
                if ($currentStatus == 'ONLINE') { $accumulatedOnline += $currentDiff; }
                elseif ($currentStatus == 'BREAK') { $accumulatedBreak += $currentDiff; }
                elseif ($currentStatus == 'IN_CALL') { $accumulatedInCall += $currentDiff; }
                $params->today_online_seconds = $accumulatedOnline;
                $params->today_break_seconds = $accumulatedBreak;
                $params->today_in_call_seconds = $accumulatedInCall;

                // Compliance logic for staff list
                $shiftStart = \App\Models\SystemConfig::where('key', 'work_start_time')->first()->value ?? '09:00';
                $shiftEnd = \App\Models\SystemConfig::where('key', 'work_end_time')->first()->value ?? '18:00';
                $logs = \App\AdminActivityLog::where('admin_id', $admin->id)
                    ->where('url', 'like', '%crm/set-status%')
                    ->whereDate('created_at', $today)
                    ->orderBy('created_at', 'asc')
                    ->get();
                $firstActive = $logs->filter(function ($log) {
                    $payload = json_decode($log->payload, true);
                    return in_array($payload['status'] ?? '', ['ONLINE', 'BREAK', 'IN_CALL']);
                })->first();
                $lastOffline = $logs->filter(function ($log) {
                    $payload = json_decode($log->payload, true);
                    return ($payload['status'] ?? '') == 'OFFLINE';
                })->last();
                $params->arrival_time = $firstActive ? \Carbon\Carbon::parse($firstActive->created_at)->format('H:i') : null;
                $params->departure_time = $lastOffline ? \Carbon\Carbon::parse($lastOffline->created_at)->format('H:i') : null;
                $params->is_late = $params->arrival_time && $params->arrival_time > $shiftStart;
                $params->is_early_leave = ($currentStatus == 'OFFLINE') && $params->departure_time && $params->departure_time < $shiftEnd;
                
                return $params;
            });
        return response()->json($staffMembers);
    }

    public function getMyNotifications()
    {
        $notifications = AdminNotification::where('admin_id', Auth::guard('admin')->id())
            ->where('is_read', false)
            ->get();
        return response()->json($notifications);
    }

    public function markNotificationRead(Request $request)
    {
        $request->validate(['id' => 'required|exists:admin_notifications,id']);
        AdminNotification::where('id', $request->id)
            ->where('admin_id', Auth::guard('admin')->id())
            ->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    public function getStaffHistory($admin_id)
    {
        $history = \App\AdminActivityLog::where('admin_id', $admin_id)
            ->whereIn('method', ['POST', 'PUT', 'PATCH', 'DELETE'])
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get()
            ->map(function ($log) {
                $log->friendly_url = UrlMapperService::getFriendlyName($log->url);
                return $log;
            });
        return response()->json($history);
    }

    public function setStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|in:ONLINE,BREAK,IN_CALL,OFFLINE,SYSTEM_ERROR'
        ]);

        $admin = Auth::guard('admin')->user();
        if ($admin) {
            $now = \Carbon\Carbon::now();
            $today = $now->toDateString();

            if ($admin->today_date != $today) {
                $admin->today_date = $today;
                $admin->today_online_seconds = 0;
                $admin->today_break_seconds = 0;
                $admin->today_in_call_seconds = 0;
            }

            if ($admin->status_updated_at && $admin->current_status) {
                $diff = $now->diffInSeconds(\Carbon\Carbon::parse($admin->status_updated_at));
                if ($admin->current_status == 'ONLINE') { $admin->today_online_seconds += $diff; }
                elseif ($admin->current_status == 'BREAK') { $admin->today_break_seconds += $diff; }
                elseif ($admin->current_status == 'IN_CALL') { $admin->today_in_call_seconds += $diff; }
            }

            $admin->current_status = $request->status;
            $admin->status_updated_at = $now;
            $admin->save();

            return response()->json([
                'success' => true,
                'current_status' => $admin->current_status,
                'today_online_seconds' => $admin->today_online_seconds,
                'today_break_seconds' => $admin->today_break_seconds,
                'today_in_call_seconds' => $admin->today_in_call_seconds,
                'daily_break_limit' => \App\Models\SystemConfig::where('key', 'daily_break_limit')->first()->value ?? 60
            ]);
        }
        return response()->json(['success' => false], 401);
    }

    public function personnelDashboard()
    {
        $admin = Auth::guard('admin')->user();
        if ($admin->is_manager || $admin->hasRole('SUPER_ADMIN')) {
            return redirect()->route('admin.crm.index');
        }

        $now = \Carbon\Carbon::now();
        $today = $now->toDateString();
        $statusUpdated = $admin->status_updated_at ? \Carbon\Carbon::parse($admin->status_updated_at) : $now;
        $statusDuration = $now->diffInSeconds($statusUpdated);

        $accumulatedOnline = $admin->today_date == $today ? $admin->today_online_seconds : 0;
        $accumulatedBreak = $admin->today_date == $today ? $admin->today_break_seconds : 0;
        $accumulatedInCall = $admin->today_date == $today ? $admin->today_in_call_seconds : 0;

        $currentDiff = $now->diffInSeconds($statusUpdated);
        if ($admin->current_status == 'ONLINE') { $accumulatedOnline += $currentDiff; }
        elseif ($admin->current_status == 'BREAK') { $accumulatedBreak += $currentDiff; }
        elseif ($admin->current_status == 'IN_CALL') { $accumulatedInCall += $currentDiff; }

        $dailyStats = [
            'online' => $accumulatedOnline,
            'break' => $accumulatedBreak,
            'in_call' => $accumulatedInCall,
            'break_limit_mins' => \App\Models\SystemConfig::where('key', 'daily_break_limit')->first()->value ?? 60
        ];

        $statusDetails = UrlMapperService::getStatusDetails($admin->current_status ?? 'OFFLINE');
        $history = \App\AdminActivityLog::where('admin_id', $admin->id)
            ->whereIn('method', ['POST', 'PUT', 'PATCH', 'DELETE'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($log) {
                $log->friendly_url = UrlMapperService::getFriendlyName($log->url);
                $log->action_sentence = UrlMapperService::getActivitySentence($log->method, $log->url, $log->payload);
                return $log;
            });

        $shiftStart = \App\Models\SystemConfig::where('key', 'work_start_time')->first()->value ?? '09:00';
        $shiftEnd = \App\Models\SystemConfig::where('key', 'work_end_time')->first()->value ?? '18:00';

        $logs = \App\AdminActivityLog::where('admin_id', $admin->id)
            ->where('url', 'like', '%crm/set-status%')
            ->whereDate('created_at', $today)
            ->orderBy('created_at', 'asc')
            ->get();
        $firstActive = $logs->filter(function ($log) {
            $payload = json_decode($log->payload, true);
            return in_array($payload['status'] ?? '', ['ONLINE', 'BREAK', 'IN_CALL']);
        })->first();
        $lastOffline = $logs->filter(function ($log) {
            $payload = json_decode($log->payload, true);
            return ($payload['status'] ?? '') == 'OFFLINE';
        })->last();
        $departureTime = $lastOffline ? \Carbon\Carbon::parse($lastOffline->created_at) : null;
        if (!$departureTime && ($admin->current_status == 'OFFLINE')) {
            if ($admin->status_updated_at && \Carbon\Carbon::parse($admin->status_updated_at)->toDateString() == $today) {
                $departureTime = \Carbon\Carbon::parse($admin->status_updated_at);
            }
        }
        $compliance = [
            'arrival' => $firstActive ? \Carbon\Carbon::parse($firstActive->created_at)->format('H:i:s') : null,
            'departure' => $departureTime ? $departureTime->format('H:i:s') : null,
            'is_late' => $firstActive && \Carbon\Carbon::parse($firstActive->created_at)->format('H:i') > $shiftStart,
            'is_early' => ($admin->current_status == 'OFFLINE') && $departureTime && $departureTime->format('H:i') < $shiftEnd,
            'shift_start' => $shiftStart,
            'shift_end' => $shiftEnd
        ];

        $notes = CrmNote::where('admin_id', $admin->id)
            ->orderBy('is_completed', 'asc') 
            ->orderBy('event_date', 'asc')   
            ->get();

        return view('admin.crm.personnel_dashboard', compact('admin', 'statusDuration', 'statusDetails', 'history', 'dailyStats', 'compliance', 'notes'));
    }

    public function show($id)
    {
        $admin = Admin::with('role')->findOrFail($id);
        $now = \Carbon\Carbon::now();
        $today = $now->toDateString();
        $statusUpdated = $admin->status_updated_at ? \Carbon\Carbon::parse($admin->status_updated_at) : $now;
        $statusDuration = $now->diffInSeconds($statusUpdated);
        $accumulatedOnline = $admin->today_date == $today ? $admin->today_online_seconds : 0;
        $accumulatedBreak = $admin->today_date == $today ? $admin->today_break_seconds : 0;
        $accumulatedInCall = $admin->today_date == $today ? $admin->today_in_call_seconds : 0;
        $currentDiff = $now->diffInSeconds($statusUpdated);
        if (($admin->current_status ?? 'OFFLINE') == 'ONLINE') { $accumulatedOnline += $currentDiff; }
        elseif (($admin->current_status ?? 'OFFLINE') == 'BREAK') { $accumulatedBreak += $currentDiff; }
        elseif (($admin->current_status ?? 'OFFLINE') == 'IN_CALL') { $accumulatedInCall += $currentDiff; }
        $dailyStats = [
            'online' => $accumulatedOnline,
            'break' => $accumulatedBreak,
            'in_call' => $accumulatedInCall,
            'break_limit_mins' => \App\Models\SystemConfig::where('key', 'daily_break_limit')->first()->value ?? 60
        ];
        $statusDetails = UrlMapperService::getStatusDetails($admin->current_status ?? 'OFFLINE');

        $history = \App\AdminActivityLog::where('admin_id', $id)
            ->whereIn('method', ['POST', 'PUT', 'PATCH', 'DELETE'])
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get()
            ->map(function ($log) {
                $log->friendly_url = UrlMapperService::getFriendlyName($log->url);
                $log->action_sentence = UrlMapperService::getActivitySentence($log->method, $log->url, $log->payload);
                return $log;
            });

        // Compliance logic for profile
        $shiftStart = \App\Models\SystemConfig::where('key', 'work_start_time')->first()->value ?? '09:00';
        $shiftEnd = \App\Models\SystemConfig::where('key', 'work_end_time')->first()->value ?? '18:00';
        $logs = \App\AdminActivityLog::where('admin_id', $id)
            ->where('url', 'like', '%crm/set-status%')
            ->whereDate('created_at', $today)
            ->orderBy('created_at', 'asc')
            ->get();
        $firstActive = $logs->filter(function ($log) {
            $payload = json_decode($log->payload, true);
            return in_array($payload['status'] ?? '', ['ONLINE', 'BREAK', 'IN_CALL']);
        })->first();
        $lastOffline = $logs->filter(function ($log) {
            $payload = json_decode($log->payload, true);
            return ($payload['status'] ?? '') == 'OFFLINE';
        })->last();
        $departureTime = $lastOffline ? \Carbon\Carbon::parse($lastOffline->created_at) : null;
        if (!$departureTime && ($admin->current_status == 'OFFLINE')) {
            if ($admin->status_updated_at && \Carbon\Carbon::parse($admin->status_updated_at)->toDateString() == $today) {
                $departureTime = \Carbon\Carbon::parse($admin->status_updated_at);
            }
        }
        $compliance = [
            'arrival' => $firstActive ? \Carbon\Carbon::parse($firstActive->created_at)->format('H:i:s') : null,
            'departure' => $departureTime ? $departureTime->format('H:i:s') : null,
            'is_late' => $firstActive && \Carbon\Carbon::parse($firstActive->created_at)->format('H:i') > $shiftStart,
            'is_early' => ($admin->current_status == 'OFFLINE') && $departureTime && $departureTime->format('H:i') < $shiftEnd,
            'shift_start' => $shiftStart,
            'shift_end' => $shiftEnd
        ];

        return view('admin.crm.show', compact('admin', 'statusDuration', 'statusDetails', 'dailyStats', 'compliance', 'history'));
    }

    public function storeNote(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|exists:admins,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'event_date' => 'nullable|date',
            'priority' => 'required|in:Low,Medium,High',
        ]);
        CrmNote::create([
            'admin_id' => $request->admin_id,
            'creator_id' => Auth::guard('admin')->id(),
            'title' => $request->title,
            'content' => $request->input('content'),
            'event_date' => $request->event_date,
            'priority' => $request->priority,
        ]);
        return response()->json(['success' => true, 'message' => 'Not başarıyla eklendi.']);
    }

    public function getNotes($admin_id)
    {
        $notes = CrmNote::where('admin_id', $admin_id)->with('creator')->orderBy('created_at', 'desc')->get();
        return response()->json($notes);
    }

    public function toggleNoteStatus($id)
    {
        $note = CrmNote::findOrFail($id);
        $note->is_completed = !$note->is_completed;
        $note->save();
        return response()->json(['success' => true, 'is_completed' => $note->is_completed]);
    }

    public function deleteNote($id)
    {
        $note = CrmNote::findOrFail($id);
        $note->delete();
        return response()->json(['success' => true, 'message' => 'Not silindi.']);
    }
}
CODE;

try {
    file_put_contents($controllerPath, $controllerCode);
    echo "CrmController.php güncellendi.\n";
} catch (\Exception $e) {
    echo "HATA (Controller): " . $e->getMessage() . "\n";
}

echo "\nİŞLEM TAMAMLANDI: Lütfen sayfayı yenileyiniz.\n";
echo "</pre>";
