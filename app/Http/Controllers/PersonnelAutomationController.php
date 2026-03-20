<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\ServiceRequest;
use App\Service;
use App\ServiceCategory;
use App\State;
use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\DataArrayHelper;

class PersonnelAutomationController extends Controller
{
    private function assignmentsForUser(int $userId)
    {
        return ServiceRequest::where(function ($query) use ($userId) {
            $query->where('matched_personnel_id', $userId)
                ->orWhereHas('assignedPersonnel', function ($subQuery) use ($userId) {
                    $subQuery->where('users.id', $userId);
                });
        });
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function myAssignments()
    {
        $user = Auth::user();
        $assignments = $this->assignmentsForUser((int) $user->id)
            ->with(['service', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.assignments', compact('assignments'));
    }

    public function workPreferences()
    {
        $user = Auth::user();
        $services = ServiceCategory::orderBy('category_name')->get();
        $states = State::whereIn('country_id', [223, 805])->where('lang', 'tr')->orderBy('state')->get();

        return view('user.work_preferences', compact('user', 'services', 'states'));
    }

    public function updatePreferences(Request $request)
    {
        $user = Auth::user();

        $user->is_eligible_for_auto_assignment = $request->has('is_eligible_for_auto_assignment') && $request->input('is_eligible_for_auto_assignment') == '1';
        $user->service_types = $request->input('service_types', []);
        $user->work_locations = $request->input('work_locations', []);
        $user->max_daily_tasks = $request->input('max_daily_tasks', 5);

        // Save availability calendar — form sends availability_calendar[day][active/start/end]
        $rawCalendar = $request->input('availability_calendar', []);
        $calendar = [];
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        foreach ($days as $day) {
            $dayData = $rawCalendar[$day] ?? [];
            $active = !empty($dayData['active']);
            $calendar[$day] = [
                'available' => $active,
                'active' => $active,
                'start' => $dayData['start'] ?? '08:00',
                'end' => $dayData['end'] ?? '18:00',
            ];
        }
        $user->availability_calendar = $calendar;

        $user->save();

        flash(__('Çalışma tercihleriniz başarıyla güncellendi.'))->success();
        return redirect()->route('personnel.preferences');
    }
    public function assignmentDetails($id)
    {
        $user = Auth::user();
        $assignment = $this->assignmentsForUser((int) $user->id)
            ->with(['service', 'user'])
            ->where('id', $id)
            ->firstOrFail();

        return view('user.assignment_details', compact('assignment'));
    }

    public function acceptAssignment($id)
    {
        $user = Auth::user();
        $assignment = $this->assignmentsForUser((int) $user->id)
            ->where('id', $id)
            ->where('automation_status', 'matched')
            ->firstOrFail();

        $assignment->automation_status = 'accepted';
        // Personel kabul ettiğinde admin talepler ekranındaki ana durum da güncellensin.
        if ($assignment->status === 'pending') {
            $assignment->status = 'approved';
            if (empty($assignment->approved_at)) {
                $assignment->approved_at = now();
            }
        }
        $assignment->save();

        flash(__('İşi başarıyla kabul ettiniz. Teşekkürler!'))->success();
        return redirect()->route('personnel.assignment_details', $id);
    }

    public function rejectAssignment($id)
    {
        $user = Auth::user();
        $assignment = $this->assignmentsForUser((int) $user->id)
            ->where('id', $id)
            ->firstOrFail();

        // 1. Add to rejected_ids
        $extraDetails = json_decode($assignment->extra_details, true) ?? [];
        $rejectedIds = $extraDetails['rejected_ids'] ?? [];

        if (!in_array($user->id, $rejectedIds)) {
            $rejectedIds[] = $user->id;
        }

        $extraDetails['rejected_ids'] = $rejectedIds;
        $assignment->extra_details = json_encode($extraDetails);

        // 2. Reset Request (yalnızca eşleşen personel reddediyorsa)
        if ((int) $assignment->matched_personnel_id === (int) $user->id) {
            $assignment->matched_personnel_id = null;
            $assignment->automation_status = 'pending_matching';
            $assignment->status = 'pending';
            // Reset approval (since it's no longer approved)
            $assignment->approved_at = null;
        }

        // Her durumda personel-pivot atamasını kaldır
        $assignment->assignedPersonnel()->detach($user->id);

        $assignment->save();

        flash(__('İş reddedildi ve yeniden eşleşme kuyruğuna alındı.'))->warning();
        return redirect()->route('personnel.assignments');
    }
}
