<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\JobPost;
use App\ListingApplication;
use App\MatchScore;
use Illuminate\Http\Request;

class JobPostAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = JobPost::with(['owner', 'category'])
            ->withCount('applications');

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->category_type) {
            $query->where('category_type', $request->category_type);
        }
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $jobPosts = $query->orderBy('created_at', 'desc')->paginate(20);
        $statusLabels = JobPost::getStatusLabels();

        // Stats
        $stats = [
            'open' => JobPost::where('status', 'published')->count(),
            'matched' => JobPost::where('status', 'matched')->count(),
            'draft' => JobPost::where('status', 'draft')->count(),
            'closed' => JobPost::where('status', 'closed')->count(),
            'avg_score' => round(ListingApplication::whereNotNull('match_score')->avg('match_score'), 1),
            'accept_rate' => $this->getAcceptRate(),
        ];

        return view('admin.job_listings.index', compact('jobPosts', 'statusLabels', 'stats'));
    }

    public function show($id)
    {
        $post = JobPost::with(['owner', 'category', 'state', 'city', 'requirements'])
            ->withCount('applications')
            ->findOrFail($id);

        $applications = ListingApplication::where('job_post_id', $id)
            ->with('applicant')
            ->orderByDesc('match_score')
            ->paginate(20);

        $statusLabels = ListingApplication::getStatusLabels();
        $statusColors = ListingApplication::getStatusColors();

        return view('admin.job_listings.show', compact('post', 'applications', 'statusLabels', 'statusColors'));
    }

    public function suspend($id)
    {
        $post = JobPost::findOrFail($id);
        $post->status = JobPost::STATUS_CANCELLED;
        $post->save();

        flash('İlan askıya alındı.')->success();
        return back();
    }

    public function publish($id)
    {
        JobPost::findOrFail($id)->publish();
        flash('İlan yayınlandı.')->success();
        return back();
    }

    public function close($id)
    {
        JobPost::findOrFail($id)->close();
        flash('İlan kapatıldı.')->success();
        return back();
    }

    public function stats()
    {
        $stats = [
            'total_posts' => JobPost::count(),
            'open' => JobPost::where('status', 'published')->count(),
            'matched' => JobPost::where('status', 'matched')->count(),
            'avg_score' => round(ListingApplication::whereNotNull('match_score')->avg('match_score'), 1),
            'accept_rate' => $this->getAcceptRate(),
            'total_apps' => ListingApplication::count(),
        ];

        $recentScores = MatchScore::with(['jobPost', 'user'])
            ->orderByDesc('computed_at')
            ->limit(20)
            ->get();

        return view('admin.job_listings.stats', compact('stats', 'recentScores'));
    }

    private function getAcceptRate(): float
    {
        $total = ListingApplication::whereIn('status', ['accepted', 'rejected'])->count();
        $accepted = ListingApplication::where('status', 'accepted')->count();
        return $total > 0 ? round(($accepted / $total) * 100, 1) : 0;
    }
}
