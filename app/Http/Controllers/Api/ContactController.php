<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ContactController extends BaseApiController
{
    public function emailToFriend(string $job_slug): JsonResponse
    {
        return $this->notImplemented();
    }

    public function emailToFriendPost(Request $request, string $job_slug): JsonResponse
    {
        return $this->notImplemented();
    }

    public function emailToFriendThanks(): JsonResponse
    {
        return $this->notImplemented();
    }

    public function reportAbuse(string $job_slug): JsonResponse
    {
        return $this->notImplemented();
    }

    public function reportAbusePost(Request $request, string $job_slug): JsonResponse
    {
        return $this->notImplemented();
    }

    public function reportAbuseThanks(): JsonResponse
    {
        return $this->notImplemented();
    }

    public function reportAbuseCompany(string $company_slug): JsonResponse
    {
        return $this->notImplemented();
    }

    public function reportAbuseCompanyPost(Request $request, string $company_slug): JsonResponse
    {
        return $this->notImplemented();
    }

    public function reportAbuseCompanyThanks(): JsonResponse
    {
        return $this->notImplemented();
    }

    public function index(): JsonResponse
    {
        return $this->notImplemented();
    }

    public function postContact(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function thanks(): JsonResponse
    {
        return $this->notImplemented();
    }
}
