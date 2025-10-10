<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ApiTokenService
{
    public function getToken(): string
    {
        $token = Cache::get('api_token');

        if (!$token) {
            $response = Http::post('https://demotestt.hipotenus.net/extended/api/v1/json/ApiLogin', [
                'Username' => 'denizapi', 
                'Password' => 'e809345d36',
            ]);

            if ($response->failed()) {
                throw new \Exception('API request failed: ' . $response->status());
            }

            $data = $response->json();
            $token = $data['result']['Token'] ?? null;

            if (!$token) {
                throw new \Exception('Token could not be retrieved from API');
            }

            Cache::put('api_token', $token, now()->addDay());
        }

        return $token;
    }
}
