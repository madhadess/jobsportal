<?php

namespace App\Http\Controllers;

use App\JobPost;
use App\ListingApplication;
use App\State;
use App\City;
use App\ServiceCategory;
use App\Services\ListingMatchingService;
use Illuminate\Http\Request;
use Auth;

/**
 * ApplicationController — Personel / Bakıcı Paneli
 * İlanları listeleme, filtreleme ve başvuru işlemleri.
 */
class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * İlanları listele ve filtrele — Personel / Bakıcı görünümü.
     */
    public function browse(Request $request)
    {
        $user = Auth::user();

        // Verify active user (not suspended)
        abort_if(!empty($user->is_suspended) || !empty($user->account_deactivated), 403, 'Hesabınız askıya alınmış.');

        $query = JobPost::published()
            ->with(['category', 'state', 'city'])
            ->withCount('applications');

        // Filters
        if ($request->state_id) {
            $query->where('state_id', $request->state_id);
        }
        if ($request->city_id) {
            $query->where('city_id', $request->city_id);
        }
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->category_type) {
            $query->where('category_type', $request->category_type);
        }
        if ($request->work_type) {
            $query->where('work_type', $request->work_type);
        }
        if ($request->salary_min) {
            $query->where('salary_max', '>=', $request->salary_min);
        }
        if ($request->salary_max) {
            $query->where('salary_min', '<=', $request->salary_max);
        }
        if ($request->min_experience) {
            $query->where('min_experience_years', '<=', $request->min_experience);
        }

        $jobPosts = $query->orderBy('published_at', 'desc')->paginate(15);

        // Compute scores for current page
        $matchingService = new ListingMatchingService();
        $userApplications = ListingApplication::where('user_id', Auth::id())
            ->pluck('status', 'job_post_id')
            ->toArray();

        $scores = [];
        foreach ($jobPosts as $post) {
            try {
                $result = $matchingService->computeScore($user, $post);
                $scores[$post->id] = $result;
            } catch (\Exception $e) {
                $scores[$post->id] = ['total_score' => 0, 'explanation' => ''];
            }
        }

        // Apply score filter if requested
        if ($request->min_score) {
            $minScore = (float) $request->min_score;
            $jobPosts->setCollection(
                $jobPosts->getCollection()->filter(fn($p) => ($scores[$p->id]['total_score'] ?? 0) >= $minScore)
            );
        }

        $defaultCountryId = \App\SiteSetting::first()->default_country_id ?? 225; // 225 = Turkey fallback
        $states = State::where('country_id', $defaultCountryId)->orderBy('state')->get();
        $categories = ServiceCategory::orderBy('category_name')->get();
        $workTypes = JobPost::getWorkTypeLabels();

        return view('applications.browse', compact(
            'jobPosts',
            'scores',
            'userApplications',
            'states',
            'categories',
            'workTypes'
        ));
    }

    /**
     * İlan detayı — Personel için, uygunluk skoru ile.
     */
    public function show($id)
    {
        $post = JobPost::published()
            ->with(['requirements', 'category', 'state', 'city', 'owner'])
            ->findOrFail($id);

        $user = Auth::user();
        $hasApplied = ListingApplication::where('job_post_id', $id)
            ->where('user_id', $user->id)
            ->exists();

        // Compute eligibility score
        $matchingService = new ListingMatchingService();
        $scoreData = $matchingService->computeScore($user, $post);

        // Check minimum criteria (score >= 30 to apply)
        $canApply = !$hasApplied && $post->isOpen() && $scoreData['total_score'] >= 30;

        return view('applications.show', compact('post', 'hasApplied', 'scoreData', 'canApply'));
    }

    /**
     * Başvuru yap.
     */
    public function apply(Request $request, $id)
    {
        $user = Auth::user();
        abort_if(!empty($user->is_suspended) || !empty($user->account_deactivated), 403, 'Hesabınız askıya alınmış.');

        $post = JobPost::published()->findOrFail($id);

        // Çift başvuru engeli (DB unique constraint, ama önce kontrol edelim)
        $existing = ListingApplication::where('job_post_id', $id)
            ->where('user_id', $user->id)
            ->whereNull('deleted_at')
            ->first();

        if ($existing) {
            flash('Bu ilana zaten başvurmuşsunuz.')->warning();
            return back();
        }

        // ─── Günlük Başvuru Limiti (max 5/gün) ─────────────────────────────
        $dailyLimit = 5;
        $todayCount = ListingApplication::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->count();

        if ($todayCount >= $dailyLimit) {
            flash("Günlük başvuru limitine ulaştınız ({$dailyLimit} başvuru/gün). Yarın tekrar deneyin.")->warning();
            return back();
        }
        // ─────────────────────────────────────────────────────────────────────

        $request->validate([
            'cover_note' => 'nullable|string|max:1000',
        ]);


        // Compute score
        $matchingService = new ListingMatchingService();
        $scoreData = $matchingService->computeScore($user, $post);

        $application = ListingApplication::create([
            'job_post_id' => $id,
            'user_id' => $user->id,
            'cover_note' => $request->cover_note,
            'status' => ListingApplication::STATUS_PENDING,
            'match_score' => $scoreData['total_score'],
            'match_breakdown' => $scoreData['breakdown'],
            'match_explanation' => $scoreData['explanation'],
            'is_auto_matched' => false,
        ]);

        // Log to match_scores table
        \App\MatchScore::create([
            'job_post_id' => $id,
            'user_id' => $user->id,
            'total_score' => $scoreData['total_score'],
            'breakdown' => $scoreData['breakdown'],
            'explanation' => $scoreData['explanation'],
            'engine_version' => $scoreData['engine_version'],
            'computed_at' => now(),
        ]);

        // Increment counter
        $post->increment('applications_count');

        // Log initial status
        $application->logStatusChange(
            ListingApplication::STATUS_PENDING,
            'Başvuru yapıldı',
            'applicant'
        );

        flash('Başvurunuz alındı! İlan sahibi inceleyecektir.')->success();
        return redirect()->route('my-applications.index');
    }

    /**
     * Başvurularım listesi.
     */
    public function myApplications(Request $request)
    {
        $applications = ListingApplication::where('user_id', Auth::id())
            ->with(['jobPost.category', 'jobPost.state'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $statusLabels = ListingApplication::getStatusLabels();
        $statusColors = ListingApplication::getStatusColors();

        return view('applications.my_applications', compact('applications', 'statusLabels', 'statusColors'));
    }

    /**
     * Başvuru detayı (başvuran personel için).
     */
    public function applicationDetail($id)
    {
        $application = ListingApplication::where('user_id', Auth::id())
            ->with(['jobPost.category', 'jobPost.state', 'statusHistory.changedByUser'])
            ->findOrFail($id);

        return view('applications.detail', compact('application'));
    }

    /**
     * Başvuruyu geri çek.
     */
    public function withdraw($id)
    {
        $application = ListingApplication::where('user_id', Auth::id())
            ->whereIn('status', [ListingApplication::STATUS_PENDING, ListingApplication::STATUS_SHORTLISTED])
            ->findOrFail($id);

        $application->updateStatus(ListingApplication::STATUS_WITHDRAWN, 'Başvuru adayın kendisi tarafından geri çekildi.', 'applicant');

        // Decrement counter
        $application->jobPost()->decrement('applications_count');

        flash('Başvurunuz geri çekildi.')->info();
        return back();
    }
}
