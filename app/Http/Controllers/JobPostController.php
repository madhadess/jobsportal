<?php

namespace App\Http\Controllers;

use App\JobPost;
use App\JobPostRequirement;
use App\ListingApplication;
use App\ServiceCategory;
use App\State;
use App\City;
use App\Services\ListingMatchingService;
use Illuminate\Http\Request;
use Auth;

/**
 * JobPostController — Hizmet Alan (Member) Paneli
 * İlan oluşturma, güncelleme, yayınlama ve kapama işlemleri.
 */
class JobPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Kullanıcının ilanları listesi.
     */
    public function index(Request $request)
    {
        $query = JobPost::where('user_id', Auth::id())
            ->withCount('applications')
            ->orderBy('created_at', 'desc');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $jobPosts = $query->paginate(12);
        $statusLabels = JobPost::getStatusLabels();

        return view('job_listings.index', compact('jobPosts', 'statusLabels'));
    }

    /**
     * İlan oluşturma formu.
     */
    public function create()
    {
        $categories = ServiceCategory::orderBy('category_name')->get();
        $states = State::whereIn('country_id', [223, 805])->where('lang', 'tr')->orderBy('state')->get();
        $workTypes = JobPost::getWorkTypeLabels();

        return view('job_listings.create', compact('categories', 'states', 'workTypes'));
    }

    /**
     * İlanı kaydet (taslak).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'category_type' => 'required|in:caregiver,service',
            'category_id' => 'nullable|integer',
            'state_id' => 'nullable|integer',
            'city_id' => 'nullable|integer',
            'work_type' => 'required|in:full_time,part_time,daily',
            'work_hours_start' => 'nullable|date_format:H:i',
            'work_hours_end' => 'nullable|date_format:H:i',
            'min_experience_years' => 'nullable|integer|min:0|max:50',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'requires_certificate' => 'nullable|boolean',
            'requires_reference' => 'nullable|boolean',
            'description' => 'nullable|string|max:5000',
            'publish' => 'nullable',
            // Requirements
            'requirements.*.type' => 'nullable|string',
            'requirements.*.value' => 'nullable|string|max:200',
        ]);

        $post = JobPost::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'category_type' => $validated['category_type'],
            'category_id' => $validated['category_id'] ?? null,
            'state_id' => $validated['state_id'] ?? null,
            'city_id' => $validated['city_id'] ?? null,
            'work_type' => $validated['work_type'],
            'work_hours_start' => $validated['work_hours_start'] ?? null,
            'work_hours_end' => $validated['work_hours_end'] ?? null,
            'min_experience_years' => $validated['min_experience_years'] ?? 0,
            'salary_min' => $validated['salary_min'] ?? null,
            'salary_max' => $validated['salary_max'] ?? null,
            'requires_certificate' => $request->boolean('requires_certificate'),
            'requires_reference' => $request->boolean('requires_reference'),
            'description' => $validated['description'] ?? null,
            'status' => 'draft',
        ]);

        // Save requirements
        if (!empty($request->requirements)) {
            foreach ($request->requirements as $req) {
                if (!empty($req['value'])) {
                    JobPostRequirement::create([
                        'job_post_id' => $post->id,
                        'requirement_type' => $req['type'] ?? 'certificate',
                        'requirement_value' => $req['value'],
                        'is_mandatory' => !empty($req['is_mandatory']),
                    ]);
                }
            }
        }

        // Publish immediately if requested
        if ($request->has('publish')) {
            $post->publish();
            flash('İlan başarıyla yayımlandı!')->success();
        } else {
            flash('İlan taslak olarak kaydedildi.')->info();
        }

        return redirect()->route('job-posts.show', $post->id);
    }

    /**
     * İlan detayı (sahibi için).
     */
    public function show($id)
    {
        $post = JobPost::where('user_id', Auth::id())
            ->with(['requirements', 'matchedUser', 'applications.applicant'])
            ->findOrFail($id);

        $statusLabels = JobPost::getStatusLabels();
        $applicationLabels = ListingApplication::getStatusLabels();

        return view('job_listings.show', compact('post', 'statusLabels', 'applicationLabels'));
    }

    /**
     * İlan düzenleme formu.
     */
    public function edit($id)
    {
        $post = JobPost::where('user_id', Auth::id())
            ->with('requirements')
            ->findOrFail($id);

        abort_if($post->status === JobPost::STATUS_CLOSED || $post->status === JobPost::STATUS_CANCELLED, 403, 'Bu ilan düzenlenemez.');

        $categories = ServiceCategory::orderBy('category_name')->get();
        $states = State::whereIn('country_id', [223, 805])->where('lang', 'tr')->orderBy('state')->get();
        $workTypes = JobPost::getWorkTypeLabels();

        return view('job_listings.edit', compact('post', 'categories', 'states', 'workTypes'));
    }

    /**
     * İlanı güncelle.
     */
    public function update(Request $request, $id)
    {
        $post = JobPost::where('user_id', Auth::id())->findOrFail($id);
        abort_if(in_array($post->status, [JobPost::STATUS_CLOSED, JobPost::STATUS_CANCELLED]), 403);

        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'category_type' => 'required|in:caregiver,service',
            'category_id' => 'nullable|integer',
            'state_id' => 'nullable|integer',
            'city_id' => 'nullable|integer',
            'work_type' => 'required|in:full_time,part_time,daily',
            'work_hours_start' => 'nullable|date_format:H:i',
            'work_hours_end' => 'nullable|date_format:H:i',
            'min_experience_years' => 'nullable|integer|min:0|max:50',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'requires_certificate' => 'nullable|boolean',
            'requires_reference' => 'nullable|boolean',
            'description' => 'nullable|string|max:5000',
        ]);

        $post->fill($validated);
        $post->requires_certificate = $request->boolean('requires_certificate');
        $post->requires_reference = $request->boolean('requires_reference');
        $post->save();

        // Re-sync requirements
        if ($request->has('requirements')) {
            $post->requirements()->delete();
            foreach ($request->requirements as $req) {
                if (!empty($req['value'])) {
                    JobPostRequirement::create([
                        'job_post_id' => $post->id,
                        'requirement_type' => $req['type'] ?? 'certificate',
                        'requirement_value' => $req['value'],
                        'is_mandatory' => !empty($req['is_mandatory']),
                    ]);
                }
            }
        }

        flash('İlan güncellendi.')->success();
        return redirect()->route('job-posts.show', $post->id);
    }

    /**
     * İlanı yayınla.
     */
    public function publish($id)
    {
        $post = JobPost::where('user_id', Auth::id())->findOrFail($id);
        abort_if($post->status !== JobPost::STATUS_DRAFT, 422, 'Sadece taslak ilanlar yayınlanabilir.');

        $post->publish();

        flash('İlan yayına alındı.')->success();
        return back();
    }

    /**
     * İlanı kapat.
     */
    public function close($id)
    {
        $post = JobPost::where('user_id', Auth::id())->findOrFail($id);
        $post->close();

        flash('İlan kapatıldı.')->success();
        return back();
    }

    /**
     * İlanı iptal et.
     */
    public function cancel($id)
    {
        $post = JobPost::where('user_id', Auth::id())->findOrFail($id);
        $post->cancel();

        flash('İlan iptal edildi.')->success();
        return back();
    }

    /**
     * AJAX: İlçeleri getir (filtreleme için).
     */
    public function getCities(Request $request)
    {
        $cities = City::where('state_id', $request->state_id)
            ->where('lang', 'tr')
            ->orderBy('city')
            ->get(['city_id', 'city as name']);

        return response()->json($cities);
    }
}
