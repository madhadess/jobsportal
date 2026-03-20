<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CmsController extends BaseApiController
{
    public function getPage(string $slug): JsonResponse
    {
        return $this->notImplemented();
    }

    public function termsOfUse(): JsonResponse
    {
        return $this->notImplemented();
    }
}
