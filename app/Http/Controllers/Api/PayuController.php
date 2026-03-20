<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PayuController extends BaseApiController
{
    public function orderPackage(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function orderPackageStatus(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function orderCvSearchPackage(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function orderPackageCvSearchStatus(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }
}
