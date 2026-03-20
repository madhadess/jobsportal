<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ServiceRequest;
use App\User;
use App\Services\MatchingService;
use Illuminate\Http\Request;

class AutomationController extends Controller
{
    public function index(Request $request)
    {
        $query = ServiceRequest::with(['user', 'service', 'matchedPersonnel'])
            ->whereNotNull('automation_status');

        // Filter by automation_status
        if ($request->has('automation_status') && $request->automation_status != '') {
            $query->where('automation_status', $request->automation_status);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $stats = [
            'total_pending' => ServiceRequest::where('automation_status', 'pending_matching')->count(),
            'total_matched' => ServiceRequest::where('automation_status', 'matched')->count(),
            'total_accepted' => ServiceRequest::where('automation_status', 'accepted')->count(),
            'total_failed' => ServiceRequest::where('automation_status', 'failed')->count(),
        ];

        $recentMatchings = $query->orderBy('updated_at', 'desc')->paginate(20);

        return view('admin.automation.index', compact('stats', 'recentMatchings'));
    }

    public function personnelStats()
    {
        $personnel = User::where('is_eligible_for_auto_assignment', 1)
            ->withCount([
                'matchedRequests as total_matched' => function ($query) {},
                'matchedRequests as completed_matched' => function ($query) {
                    $query->where('status', 'completed');
                }
            ])
            ->orderBy('average_rating', 'desc')
            ->paginate(20);

        return view('admin.automation.personnel', compact('personnel'));
    }

    public function retryMatching($id)
    {
        $serviceRequest = ServiceRequest::findOrFail($id);
        $serviceRequest->automation_status = 'pending_matching';
        $serviceRequest->matching_attempts = 0;
        $serviceRequest->matched_personnel_id = null;
        $serviceRequest->save();

        flash('Talep yeniden eşleştirme kuyruğuna alındı.')->success();
        return back();
    }

    /**
     * Immediately run matching for a specific service request.
     */
    public function triggerMatch($id)
    {
        $serviceRequest = ServiceRequest::findOrFail($id);
        $serviceRequest->automation_status = 'pending_matching';
        $serviceRequest->save();

        $matchingService = new MatchingService();
        $matched = $matchingService->runMatch($serviceRequest);

        if ($matched) {
            flash("Eşleştirme başarılı! Personel: {$matched->getName()} (#{$matched->id})")->success();
        } else {
            flash("Eşleştirme başarısız. Uygun personel bulunamadı. (Deneme: {$serviceRequest->matching_attempts})")->warning();
        }

        return back();
    }

    /**
     * Run matching for ALL pending requests at once.
     */
    public function runAllPending()
    {
        $matchingService = new MatchingService();
        $results = $matchingService->runAllPending();

        $msg = "İşlem tamamlandı: {$results['matched']} eşleşti, {$results['failed']} başarısız, {$results['stillPending']} hâlâ kuyrukta.";
        flash($msg)->success();

        return redirect()->route('admin.automation.index');
    }
}
