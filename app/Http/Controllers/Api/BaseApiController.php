<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

abstract class BaseApiController extends Controller
{
    /**
     * Return 501 Not Implemented for API stubs.
     *
     * @param string|null $message
     * @return JsonResponse
     */
    protected function notImplemented(?string $message = null): JsonResponse
    {
        return response()->json([
            'message' => $message ?? 'Not implemented',
        ], 501);
    }
}
