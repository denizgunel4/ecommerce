<?php

namespace App\Http\Controllers;

use App\Models\Variant;
use App\Models\VariantValue;
use App\Services\ApiTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VariantController extends Controller
{
    protected $apiTokenService;

    public function __construct(ApiTokenService $apiTokenService)
    {
        $this->apiTokenService = $apiTokenService;
    }

    public function index()
    {
        $variants = Variant::with('values')->get();
        return response()->json($variants);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'variant_name' => 'required|string|max:255',
            'variant_status' => 'nullable|integer',
            'variant_order' => 'nullable|integer',
            'values' => 'required|array',
        ]);

        $variant = Variant::updateOrCreate(
            ['variant_name' => $validated['variant_name']],
            [
                'variant_status' => $validated['variant_status'] ?? 1,
                'variant_order' => $validated['variant_order'] ?? 0,
            ]
        );

        $variant->values()->delete();
        foreach ($validated['values'] as $val) {
            VariantValue::create([
                'variant_id' => $variant->id,
                'value_name' => $val['value_name'],
                'integration_code' => $val['integration_code'],
                'value_order' => $val['value_order'] ?? 0,
            ]);
        }

        $token = $this->apiTokenService->getToken();
        $apiUrl = 'https://demotestt.hipotenus.net/extended/api/v2/json/AddVaryant';

        $payload = [
            'token' => $token,
            'VaryantName' => $variant->variant_name,
            'VaryantStatus' => $variant->variant_status,
            'VaryantOrder' => $variant->variant_order,
            'VaryantValues' => $variant->values->map(fn($v) => $v->toApiArray('v2'))->values(),
        ];

        $response = Http::post($apiUrl, $payload);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to sync variant with remote API',
                'details' => $response->json(),
            ], 500);
        }

        return response()->json([
            'message' => 'Variant saved successfully',
            'local_variant' => $variant,
            'api_response' => $response->json(),
        ]);
    }

    public function update(Request $request, Variant $variant)
    {
        $variant->update($request->only(['variant_name', 'variant_status', 'variant_order']));

        if ($request->has('values')) {
            $variant->values()->delete();
            foreach ($request->values as $val) {
                VariantValue::create([
                    'variant_id' => $variant->id,
                    'value_name' => $val['value_name'],
                    'integration_code' => $val['integration_code'],
                    'value_order' => $val['value_order'] ?? 0,
                ]);
            }
        }

        $token = $this->apiTokenService->getToken();
        $apiUrl = 'https://demotestt.hipotenus.net/extended/api/v2/json/AddVaryant';

        $payload = [
            'token' => $token,
            'VaryantName' => $variant->variant_name,
            'VaryantStatus' => $variant->variant_status,
            'VaryantOrder' => $variant->variant_order,
            'VaryantValues' => $variant->values->map(fn($v) => $v->toApiArray('v2'))->values(),
        ];

        $response = Http::post($apiUrl, $payload);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to update variant in remote API',
                'details' => $response->json(),
            ], 500);
        }

        return response()->json([
            'message' => 'Variant updated successfully',
            'api_response' => $response->json(),
        ]);
    }

    public function destroy(Variant $variant)
    {
        $token = $this->apiTokenService->getToken();
        $apiUrl = 'https://demotestt.hipotenus.net/extended/api/v1/json/DeleteVaryant';

        $response = Http::post($apiUrl, [
            'token' => $token,
            'ID' => $variant->id,
        ]);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to delete variant in remote API',
                'details' => $response->json(),
            ], 500);
        }

        $variant->values()->delete();
        $variant->delete();

        return response()->json([
            'message' => 'Variant deleted successfully',
            'api_response' => $response->json(),
        ]);
    }

    public function destroyValue(Request $request, VariantValue $variantValue)
    {
        $token = $this->apiTokenService->getToken();
        $apiUrl = 'https://demotestt.hipotenus.net/extended/api/v1/json/DeleteVaryantValue';

        $response = Http::post($apiUrl, [
            'token' => $token,
            'ID' => $variantValue->variant_id,
            'IntegrationCode' => $variantValue->integration_code,
        ]);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to delete variant value in remote API',
                'details' => $response->json(),
            ], 500);
        }

        $variantValue->delete();

        return response()->json([
            'message' => 'Variant value deleted successfully',
            'api_response' => $response->json(),
        ]);
    }
}
