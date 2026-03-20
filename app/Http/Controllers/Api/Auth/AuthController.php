<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthController extends BaseApiController
{
    public function forgot_password(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function change_password(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }
}
