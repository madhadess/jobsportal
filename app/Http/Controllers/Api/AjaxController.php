<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AjaxController extends BaseApiController
{
    public function filterDefaultCities(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function filterDefaultStates(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function filterLangCities(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function filterLangStates(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function filterCities(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function filterStates(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function filterDegreeTypes(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }
}
