<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Services\ApiTokenService;

Route::get('/get-token', function (ApiTokenService $apiTokenService) {
    try {
        $token = $apiTokenService->getToken();
        return response()->json([
            'token' => $token,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
        ], 500);
    }
});

