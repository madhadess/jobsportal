<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BlogController extends BaseApiController
{
    public function index(): JsonResponse
    {
        return $this->notImplemented();
    }

    public function search(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function details(string $slug): JsonResponse
    {
        return $this->notImplemented();
    }

    public function categories($blog): JsonResponse
    {
        return $this->notImplemented();
    }
}
