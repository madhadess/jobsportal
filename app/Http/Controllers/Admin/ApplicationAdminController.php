<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ListingApplication;
use Illuminate\Http\Request;

class ApplicationAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = ListingApplication::with(['jobPost', 'applicant'])
            ->orderByDesc('created_at');

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->job_post_id) {
            $query->where('job_post_id', $request->job_post_id);
        }
        if ($request->min_score) {
            $query->where('match_score', '>=', $request->min_score);
        }

        $applications = $query->paginate(25);
        $statusLabels = ListingApplication::getStatusLabels();
        $statusColors = ListingApplication::getStatusColors();

        $stats = [
            'total' => ListingApplication::count(),
            'accepted' => ListingApplication::where('status', 'accepted')->count(),
            'rejected' => ListingApplication::where('status', 'rejected')->count(),
            'avg_score' => round(ListingApplication::whereNotNull('match_score')->avg('match_score'), 1),
        ];

        return view('admin.applications.index', compact('applications', 'statusLabels', 'statusColors', 'stats'));
    }

    public function show($id)
    {
        $application = ListingApplication::with([
            'jobPost.owner',
            'applicant',
            'statusHistory.changedByUser'
        ])->findOrFail($id);

        $statusLabels = ListingApplication::getStatusLabels();

        return view('admin.applications.show', compact('application', 'statusLabels'));
    }
}
