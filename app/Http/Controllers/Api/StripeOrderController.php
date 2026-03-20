<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StripeOrderController extends BaseApiController
{
    public function stripeOrderForm(string $id, string $new_or_upgrade): JsonResponse
    {
        return $this->notImplemented();
    }

    public function stripeOrderPackage(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function stripeOrderUpgradePackage(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }
}
