<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrderController extends BaseApiController
{
    public function orderFreePackage(string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function orderPackage(string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function orderUpgradePackage(string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function getPaymentStatus(string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function getUpgradePaymentStatus(string $id): JsonResponse
    {
        return $this->notImplemented();
    }
}
