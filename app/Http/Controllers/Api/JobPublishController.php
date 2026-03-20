<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class JobPublishController extends BaseApiController
{
    public function createFrontJob(): JsonResponse
    {
        return $this->notImplemented();
    }

    public function storeFrontJob(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function editFrontJob(string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function updateFrontJob(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function deleteJob(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }
}
