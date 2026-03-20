<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class JobController extends BaseApiController
{
    public function jobsBySearch(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function jobDetail(string $slug): JsonResponse
    {
        return $this->notImplemented();
    }

    public function job_search(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function job_categories(): JsonResponse
    {
        return $this->notImplemented();
    }

    public function jobs_by_category(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function display_job_details(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function apply_job_form(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function store_apply_job(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function applyJob(string $slug): JsonResponse
    {
        return $this->notImplemented();
    }

    public function postApplyJob(Request $request, string $slug): JsonResponse
    {
        return $this->notImplemented();
    }

    public function addToFavouriteJob(string $job_slug): JsonResponse
    {
        return $this->notImplemented();
    }

    public function removeFromFavouriteJob(string $job_slug): JsonResponse
    {
        return $this->notImplemented();
    }

    public function myJobApplications(): JsonResponse
    {
        return $this->notImplemented();
    }

    public function myFavouriteJobs(): JsonResponse
    {
        return $this->notImplemented();
    }
}
