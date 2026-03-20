<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CompanyController extends BaseApiController
{
    public function listRejectedUsers(string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function resume_search_packages(): JsonResponse
    {
        return $this->notImplemented();
    }

    public function unlocked_users(): JsonResponse
    {
        return $this->notImplemented();
    }

    public function unlock($user): JsonResponse
    {
        return $this->notImplemented();
    }

    public function index(): JsonResponse
    {
        return $this->notImplemented();
    }

    public function companyProfile(): JsonResponse
    {
        return $this->notImplemented();
    }

    public function updateCompanyProfile(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function companyDetail(string $slug): JsonResponse
    {
        return $this->notImplemented();
    }

    public function sendContactForm(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function sendApplicantContactForm(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function listAppliedUsers(string $job_id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function listHiredUsers(string $job_id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function listFavouriteAppliedUsers(string $job_id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function addToFavouriteApplicant(string $application_id, string $user_id, string $job_id, string $company_id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function removeFromFavouriteApplicant(string $application_id, string $user_id, string $job_id, string $company_id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function hireFromFavouriteApplicant(string $application_id, string $user_id, string $job_id, string $company_id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function removehireFromFavouriteApplicant(string $application_id, string $user_id, string $job_id, string $company_id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function applicantProfile(string $application_id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function rejectApplicantProfile(string $application_id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function userProfile(string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function companyFollowers(): JsonResponse
    {
        return $this->notImplemented();
    }

    public function companyMessageDetail(string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function company_listing(): JsonResponse
    {
        return $this->notImplemented();
    }
}
