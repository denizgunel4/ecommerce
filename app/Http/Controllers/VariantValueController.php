<?php

namespace App\Http\Controllers;

use App\Models\VariantValue;
use App\Services\ApiTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VariantValueController extends Controller
{
    protected $apiTokenService;

    public function __construct(ApiTokenService $apiTokenService)
    {
        $this->apiTokenService = $apiTokenService;
    }

    public function index()
    {
        $values = VariantValue::with('variant')->get();
        return response()->json($values);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'variant_id' => 'required|integer|exists:variants,id',
            'value_name' => 'required|string|max:255',
            'integration_code' => 'required|string|max:255',
            'value_order' => 'nullable|integer',
        ]);

        $value = VariantValue::updateOrCreate(
            ['integration_code' => $validated['integration_code']],
            $validated
        );

        return response()->json([
            'message' => 'Variant value saved locally (API handles sync via VariantController)',
            'variant_value' => $value
        ]);
    }

    public function destroy(VariantValue $variantValue)
    {
        $token = $this->apiTokenService->getToken();
        $apiUrl = 'https://demotestt.hipotenus.net/extended/api/v1/json/DeleteVaryantValue';

        $response = Http::withToken($token)->post($apiUrl, [
            'ID' => $variantValue->variant_id,
            'IntegrationCode' => $variantValue->integration_code,
        ]);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to delete variant value from API',
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

