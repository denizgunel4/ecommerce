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


/*
Route::get('/get-token', function () {
    $token = Cache::get('api_token');
    $fromCache = false;

    if (!$token) {
        $response = Http::post('https://demotestt.hipotenus.net/extended/api/v1/json/ApiLogin', [
            'Username' => 'denizapi', 
            'Password' => 'e809345d36',
        ]);

        if ($response->failed()) {
            return response()->json([
                'error' => 'API isteği başarısız oldu',
                'status' => $response->status(),
                'body' => $response->json()
            ], 500);
        }

        $data = $response->json();

        $token = $data['result']['Token'] ?? null;

        if (!$token) {
            return response()->json([
                'error' => 'Token alınamadı',
                'response' => $data
            ], 500);
        }

        Cache::put('api_token', $token, now()->addDay());
    } else {
        $fromCache = true;
    }

    return response()->json([
        'token' => $token,
        'from_cache' => $fromCache,
    ]);
});
*/
