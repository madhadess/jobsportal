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
use Illuminate\Support\Facades\Schema;

class CrmController extends Controller
{
    private function normalizeStatus(?string $status): string
    {
        $value = trim((string) $status);
        if ($value === '') {
            return 'OFFLINE';
        }

        $upper = mb_strtoupper($value, 'UTF-8');
        if (in_array($upper, ['OFFLINE', 'ÇEVRİMDIŞI', 'ÇEVRIMDIŞI', 'CEVRIMDISI'], true)) {
            return 'OFFLINE';
        }

        return strtoupper($value);
    }

    private function getOfflineTimeoutMinutes(): int
    {
        $minutes = (int) (\App\Models\SystemConfig::where('key', 'crm_offline_timeout_minutes')->first()->value ?? 3);
        return max(1, $minutes);
    }

    private function resolveEffectiveStatus(Admin $admin): array
    {
        $activity = $admin->relationLoaded('activity') ? $admin->activity : $admin->activity()->first();
        $lastActivityDate = ($activity && $activity->last_activity)
            ? Carbon::parse($activity->last_activity)
            : null;

        $now = Carbon::now();
        $isStale = !$lastActivityDate || $lastActivityDate->lt($now->copy()->subMinutes($this->getOfflineTimeoutMinutes()));
        $isOnlineFlag = (bool) ($activity->is_online ?? false);
        $effectiveOffline = $isStale || !$isOnlineFlag;
        $effectiveStatus = $effectiveOffline ? 'OFFLINE' : $this->normalizeStatus($admin->current_status ?? 'OFFLINE');

        return [
            'status' => $effectiveStatus,
            'offline' => $effectiveOffline,
            'last_activity' => $lastActivityDate,
        ];
    }

    public function __construct()
    {
        $this->middleware('auth:admin');
        // checkAdminRoles middleware is ONLY for CRITICAL endpoints (like sendNotification)
        // NOT for setStatus, index, show (which every staff/manager needs)
        $this->middleware(function ($request, $next) {
            $admin = Auth::guard('admin')->user();
            if ($admin && ($admin->hasRole('SUPER_ADMIN') || $admin->is_manager)) {
                return $next($request);
            }

            // Critical methods restricted to Super Admin only if they are not a manager
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

    public function personnelDashboard()
    {
        $admin = Auth::guard('admin')->user();
        if (!$admin) {
            return redirect()->route('admin.login');
        }
        $effective = $this->resolveEffectiveStatus($admin);
        $effectiveStatus = $effective['status'];

        // Reuse the logic from 'show' but for the current user only
        $statusDuration = 0; // Seconds as integer, not formatted string for JS compatibility
        if ($admin->status_updated_at && !in_array($effectiveStatus, ['OFFLINE', 'Çevrimdışı'], true)) {
            $statusDuration = Carbon::now()->diffInSeconds(Carbon::parse($admin->status_updated_at));
        }

        $statusDetails = UrlMapperService::getStatusDetails($effectiveStatus);

        $history = \App\AdminActivityLog::where('admin_id', $admin->id)
            ->whereIn('method', ['POST', 'PUT', 'PATCH', 'DELETE'])
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        // reused logic from show method
        $now = \Carbon\Carbon::now();
        $today = $now->toDateString();
        $statusUpdated = $admin->status_updated_at ? \Carbon\Carbon::parse($admin->status_updated_at) : $now;

        $accumulatedOnline = $admin->today_date == $today ? $admin->today_online_seconds : 0;
        $accumulatedBreak = $admin->today_date == $today ? $admin->today_break_seconds : 0;
        $accumulatedInCall = $admin->today_date == $today ? $admin->today_in_call_seconds : 0;

        $currentDiff = $now->diffInSeconds($statusUpdated);
        if (($effectiveStatus ?? 'OFFLINE') == 'ONLINE') {
            $accumulatedOnline += $currentDiff;
        } elseif (($effectiveStatus ?? 'OFFLINE') == 'BREAK') {
            $accumulatedBreak += $currentDiff;
        } elseif (($effectiveStatus ?? 'OFFLINE') == 'IN_CALL') {
            $accumulatedInCall += $currentDiff;
        }

        $dailyStats = [
            'online' => $accumulatedOnline,
            'break' => $accumulatedBreak,
            'in_call' => $accumulatedInCall,
            'break_limit_mins' => \App\Models\SystemConfig::where('key', 'daily_break_limit')->first()->value ?? 60
        ];

        // Check Compliance
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

        // Fallback: If no OFFLINE log today but current status is OFFLINE, use status_updated_at
        if (!$departureTime && in_array($effectiveStatus, ['OFFLINE', 'Çevrimdışı'], true)) {
            if ($admin->status_updated_at && \Carbon\Carbon::parse($admin->status_updated_at)->toDateString() == $today) {
                $departureTime = \Carbon\Carbon::parse($admin->status_updated_at);
            }
        }

        $compliance = [
            'arrival' => $firstActive ? \Carbon\Carbon::parse($firstActive->created_at)->format('H:i:s') : null,
            'departure' => $departureTime ? $departureTime->format('H:i:s') : null,
            'is_late' => $firstActive && \Carbon\Carbon::parse($firstActive->created_at)->format('H:i') > $shiftStart,
            'is_early' => (($effectiveStatus ?? 'OFFLINE') == 'OFFLINE') && $departureTime && $departureTime->format('H:i') < $shiftEnd,
            'shift_start' => $shiftStart,
            'shift_end' => $shiftEnd
        ];

        // Fetch notes/events
        $notes = CrmNote::where('admin_id', $admin->id)
            ->orderBy('is_completed', 'asc') // Incomplete first
            ->orderBy('event_date', 'asc')   // Soonest first
            ->get();

        return view('admin.crm.personnel_dashboard', compact('admin', 'effectiveStatus', 'statusDuration', 'statusDetails', 'history', 'dailyStats', 'compliance', 'notes'));
    }

    public function index()
    {
        $admin = Auth::guard('admin')->user();
        // Redirect personnel (non-managers and non-superadmins) to their own dashboard
        if ($admin && !$admin->is_manager && !$admin->hasRole('SUPER_ADMIN')) {
            return redirect()->route('admin.crm.personnel');
        }

        $staffMembersQuery = Admin::whereHas('role', function ($q) {
            $q->where('role_name', '!=', 'SUPER_ADMIN');
        })->where('is_manager', 0);

        if (Schema::hasColumn('admins', 'is_active')) {
            $staffMembersQuery->where('is_active', 1);
        }

        $staffMembers = $staffMembersQuery->get();

        return view('admin.crm.index', compact('staffMembers'));
    }

    public function getStaffActivities()
    {
        // Query Admins directly to ensure we get ALL staff, even those without activity logs
        $staffQuery = Admin::with(['role', 'activity'])
            ->whereHas('role', function ($q) {
                $q->where('role_name', '!=', 'SUPER_ADMIN');
            })
            ->where('is_manager', 0);

        // Pasif personelleri canlı takipte göstermeyelim.
        if (Schema::hasColumn('admins', 'is_active')) {
            $staffQuery->where('is_active', 1);
        }

        $staffMembers = $staffQuery->get()
            ->map(function ($admin) {
                // Prepare the "activity" object structure expected by frontend
                $params = new \stdClass();
                $params->admin = $admin;
                $params->admin_id = $admin->id;

                // Get activity data if exists
                $effective = $this->resolveEffectiveStatus($admin);
                $lastActivityDate = $effective['last_activity'];
                $url = $admin->activity->url ?? '';

                // Calculate durations
                $now = \Carbon\Carbon::now();
                $today = $now->toDateString();
                // Status Details
                $effectiveOffline = (bool) $effective['offline'];
                $currentStatus = $this->normalizeStatus($effective['status'] ?? 'OFFLINE');
                $statusUpdated = $admin->status_updated_at ? \Carbon\Carbon::parse($admin->status_updated_at) : \Carbon\Carbon::now();
                $params->status_details = UrlMapperService::getStatusDetails($currentStatus);
                $params->current_status = $currentStatus;

                // Friendly URL
                if ($effectiveOffline) {
                    $params->friendly_url = 'Çevrimdışı';
                    $params->url = '';
                } else {
                    $params->friendly_url = $url ? UrlMapperService::getFriendlyName($url) : 'Henüz işlem yok';
                    $params->url = $url;
                }

                $isOffline = ($currentStatus === 'OFFLINE');

                // Offline durumunda sayaçları dondur.
                $params->page_duration_seconds = (!$isOffline && $lastActivityDate) ? $now->diffInSeconds($lastActivityDate) : 0;
                $params->status_duration_seconds = $isOffline ? 0 : $now->diffInSeconds($statusUpdated);

                // Cumulative Today Stats (Include ongoing time for current status)
                $accumulatedOnline = $admin->today_date == $today ? $admin->today_online_seconds : 0;
                $accumulatedBreak = $admin->today_date == $today ? $admin->today_break_seconds : 0;
                $accumulatedInCall = $admin->today_date == $today ? $admin->today_in_call_seconds : 0;

                $currentDiff = $now->diffInSeconds($statusUpdated);
                if ($currentStatus == 'ONLINE') {
                    $accumulatedOnline += $currentDiff;
                } elseif ($currentStatus == 'BREAK') {
                    $accumulatedBreak += $currentDiff;
                } elseif ($currentStatus == 'IN_CALL') {
                    $accumulatedInCall += $currentDiff;
                }

                $params->today_online_seconds = $accumulatedOnline;
                $params->today_break_seconds = $accumulatedBreak;
                $params->today_in_call_seconds = $accumulatedInCall;

                // Shift Compliance
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
                $params->is_early_leave = ($currentStatus == 'OFFLINE' || $currentStatus == 'Çevrimdışı') && $params->departure_time && $params->departure_time < $shiftEnd;

                return $params;
            });

        return response()->json($staffMembers);
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
            'is_read' => false,
        ]);

        return response()->json(['success' => true, 'message' => 'Bildirim başarıyla gönderildi.']);
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

            // Reset daily stats if date changed
            if ($admin->today_date != $today) {
                $admin->today_date = $today;
                $admin->today_online_seconds = 0;
                $admin->today_break_seconds = 0;
                $admin->today_in_call_seconds = 0;
            }

            // Accumulate time for PREVIOUS status
            if ($admin->status_updated_at && $admin->current_status) {
                $diff = $now->diffInSeconds(\Carbon\Carbon::parse($admin->status_updated_at));
                if ($admin->current_status == 'ONLINE') {
                    $admin->today_online_seconds += $diff;
                } elseif ($admin->current_status == 'BREAK') {
                    $admin->today_break_seconds += $diff;
                } elseif ($admin->current_status == 'IN_CALL') {
                    $admin->today_in_call_seconds += $diff;
                }
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

    public function show($id)
    {
        $admin = Admin::with(['role', 'activity'])->findOrFail($id);
        $effective = $this->resolveEffectiveStatus($admin);
        $effectiveStatus = $effective['status'];

        // Calculate status duration
        $now = \Carbon\Carbon::now();
        $today = $now->toDateString();
        $statusUpdated = $admin->status_updated_at ? \Carbon\Carbon::parse($admin->status_updated_at) : $now;
        $statusDuration = in_array($effectiveStatus, ['OFFLINE', 'Çevrimdışı'], true)
            ? 0
            : $now->diffInSeconds($statusUpdated);

        // Calculate Real-time stats for the profile view
        $accumulatedOnline = $admin->today_date == $today ? $admin->today_online_seconds : 0;
        $accumulatedBreak = $admin->today_date == $today ? $admin->today_break_seconds : 0;
        $accumulatedInCall = $admin->today_date == $today ? $admin->today_in_call_seconds : 0;

        $currentDiff = $now->diffInSeconds($statusUpdated);
        if (($effectiveStatus ?? 'OFFLINE') == 'ONLINE') {
            $accumulatedOnline += $currentDiff;
        } elseif (($effectiveStatus ?? 'OFFLINE') == 'BREAK') {
            $accumulatedBreak += $currentDiff;
        } elseif (($effectiveStatus ?? 'OFFLINE') == 'IN_CALL') {
            $accumulatedInCall += $currentDiff;
        }

        $dailyStats = [
            'online' => $accumulatedOnline,
            'break' => $accumulatedBreak,
            'in_call' => $accumulatedInCall,
            'break_limit_mins' => \App\Models\SystemConfig::where('key', 'daily_break_limit')->first()->value ?? 60
        ];

        $statusDetails = UrlMapperService::getStatusDetails($effectiveStatus ?? 'OFFLINE');

        // Shift Compliance for profile
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

        // Fallback: If no OFFLINE log today but current status is OFFLINE, use status_updated_at
        if (!$departureTime && in_array($effectiveStatus, ['OFFLINE', 'Çevrimdışı'], true)) {
            if ($admin->status_updated_at && \Carbon\Carbon::parse($admin->status_updated_at)->toDateString() == $today) {
                $departureTime = \Carbon\Carbon::parse($admin->status_updated_at);
            }
        }

        $compliance = [
            'arrival' => $firstActive ? \Carbon\Carbon::parse($firstActive->created_at)->format('H:i:s') : null,
            'departure' => $departureTime ? $departureTime->format('H:i:s') : null,
            'is_late' => $firstActive && \Carbon\Carbon::parse($firstActive->created_at)->format('H:i') > $shiftStart,
            'is_early' => (($effectiveStatus ?? 'OFFLINE') == 'OFFLINE') && $departureTime && $departureTime->format('H:i') < $shiftEnd,
            'shift_start' => $shiftStart,
            'shift_end' => $shiftEnd
        ];

        // Fetch simplified history - ONLY state-changing actions (no GET requests)
        $history = \App\AdminActivityLog::where('admin_id', $id)
            ->whereIn('method', ['POST', 'PUT', 'PATCH', 'DELETE'])
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->get()
            ->map(function ($log) {
                // Use sentence generator
                $log->action_sentence = UrlMapperService::getActivitySentence($log->method, $log->url, $log->payload);
                return $log;
            });

        return view('admin.crm.show', compact('admin', 'effectiveStatus', 'statusDuration', 'statusDetails', 'history', 'dailyStats', 'compliance'));
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
        $notes = CrmNote::where('admin_id', $admin_id)
            ->with('creator')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($note) {
                $note->formatted_date = $note->event_date ? $note->event_date->format('d.m.Y H:i') : null;
                $note->created_human = $note->created_at->diffForHumans();
                return $note;
            });

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
