<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SeekerSendController extends BaseApiController
{
    public function submit_message(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function all_messages(): JsonResponse
    {
        return $this->notImplemented();
    }

    public function append_messages(): JsonResponse
    {
        return $this->notImplemented();
    }

    public function appendonly_messages(): JsonResponse
    {
        return $this->notImplemented();
    }

    public function submitnew_message(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }
}
