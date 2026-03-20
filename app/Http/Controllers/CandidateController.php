<?php

namespace App\Http\Controllers;

use App\JobPost;
use App\ListingApplication;
use Illuminate\Http\Request;
use Auth;

/**
 * CandidateController — Hizmet Alan (Member) Paneli
 * Aday yönetimi: kısa listeye alma, davet etme, kabul, red.
 */
class CandidateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Aday listesi — kart formatında.
     */
    public function index(Request $request, $postId)
    {
        $post = JobPost::where('user_id', Auth::id())
            ->with('requirements')
            ->findOrFail($postId);

        $query = ListingApplication::where('job_post_id', $postId)
            ->with('applicant')
            ->orderByDesc('match_score');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $candidates = $query->paginate(20);
        $statusLabels = ListingApplication::getStatusLabels();
        $statusColors = ListingApplication::getStatusColors();

        return view('job_listings.candidates', compact('post', 'candidates', 'statusLabels', 'statusColors'));
    }

    /**
     * Kısa listeye al.
     */
    public function shortlist($postId, $appId)
    {
        $application = $this->getOwnedApplication($postId, $appId);
        abort_if(!in_array($application->status, [
            ListingApplication::STATUS_PENDING
        ]), 422, 'Bu aday zaten daha ileri bir aşamada.');

        $application->updateStatus(ListingApplication::STATUS_SHORTLISTED, 'Kısa listeye alındı.', 'member');

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Aday kısa listeye alındı.']);
        }
        flash('Aday kısa listeye alındı.')->success();
        return back();
    }

    /**
     * Görüşmeye davet et.
     */
    public function invite(Request $request, $postId, $appId)
    {
        $application = $this->getOwnedApplication($postId, $appId);
        abort_if(!in_array($application->status, [
            ListingApplication::STATUS_PENDING,
            ListingApplication::STATUS_SHORTLISTED,
        ]), 422, 'Bu aday görüşmeye davet edilemez.');

        $application->updateStatus(
            ListingApplication::STATUS_INVITED,
            $request->notes ?? 'Görüşmeye davet edildi.',
            'member'
        );

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Görüşme daveti gönderildi.']);
        }
        flash('Görüşme daveti gönderildi.')->success();
        return back();
    }

    /**
     * Adayı kabul et — ilan otomatik "eşleşti" olur.
     */
    public function accept(Request $request, $postId, $appId)
    {
        $application = $this->getOwnedApplication($postId, $appId);
        $post = $application->jobPost;

        abort_if($post->status === JobPost::STATUS_MATCHED, 422, 'Bu ilan zaten eşleşmiş.');

        // Accept this candidate
        $application->updateStatus(
            ListingApplication::STATUS_ACCEPTED,
            $request->notes ?? 'Aday kabul edildi.',
            'member'
        );

        // Auto-reject others
        ListingApplication::where('job_post_id', $postId)
            ->where('id', '!=', $appId)
            ->whereIn('status', [
                ListingApplication::STATUS_PENDING,
                ListingApplication::STATUS_SHORTLISTED,
                ListingApplication::STATUS_INVITED,
            ])
            ->each(function ($app) {
                $app->updateStatus(
                    ListingApplication::STATUS_REJECTED,
                    'Başka bir aday tercih edildi.',
                    'system'
                );
            });

        // Mark job post as matched
        $post->markMatched($application->user_id);

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Aday kabul edildi ve ilan eşleşti olarak işaretlendi.']);
        }
        flash('Aday kabul edildi! İlan "Eşleşti" olarak kapatıldı.')->success();
        return redirect()->route('job-posts.show', $postId);
    }

    /**
     * Adayı reddet.
     */
    public function reject(Request $request, $postId, $appId)
    {
        $application = $this->getOwnedApplication($postId, $appId);
        abort_if(in_array($application->status, [
            ListingApplication::STATUS_ACCEPTED,
            ListingApplication::STATUS_WITHDRAWN,
        ]), 422, 'Bu aday reddedilemez.');

        $application->updateStatus(
            ListingApplication::STATUS_REJECTED,
            $request->notes ?? 'Aday reddedildi.',
            'member'
        );

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Aday reddedildi.']);
        }
        flash('Aday reddedildi.')->info();
        return back();
    }

    /** Helper: owned application */
    private function getOwnedApplication(int $postId, int $appId): ListingApplication
    {
        $post = JobPost::where('user_id', Auth::id())->findOrFail($postId);

        return ListingApplication::where('job_post_id', $post->id)
            ->with('jobPost')
            ->findOrFail($appId);
    }
}
