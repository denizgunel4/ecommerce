<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use App\Services\ApiTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductVariantController extends Controller
{
    protected $apiTokenService;

    public function __construct(ApiTokenService $apiTokenService)
    {
        $this->apiTokenService = $apiTokenService;
    }

    public function index()
    {
        $variants = ProductVariant::with(['product', 'variant', 'variantValue1', 'variantValue2', 'variantValue3'])->get();
        return response()->json($variants);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|integer',
            'variant_id' => 'required|integer',
            'variant_value1_id' => 'nullable|integer',
            'variant_value2_id' => 'nullable|integer',
            'variant_value3_id' => 'nullable|integer',
            'variant_price' => 'nullable|numeric',
            'variant_discount' => 'nullable|numeric',
            'variant_sale_price' => 'nullable|numeric',
            'variant_stock_amount' => 'nullable|integer',
            'variant_code' => 'nullable|string|max:255',
            'variant_product_code' => 'nullable|string|max:255',
            'barcode' => 'nullable|string|max:64',
            'variant_status' => 'nullable|integer',
            'variant_is_reduced' => 'nullable|boolean',
            'variant_seo_title' => 'nullable|string|max:255',
            'variant_seo_description' => 'nullable|string|max:255',
            'variant_seo_keywords' => 'nullable|string',
            'variant_seo_url' => 'nullable|string',
            'desi_kg' => 'nullable|numeric',
            'deger0' => 'nullable|string',
            'deger1' => 'nullable|string',
            'deger2' => 'nullable|string',
        ]);

        $variant = ProductVariant::create($validated);

        $token = $this->apiTokenService->getToken();
        $apiUrl = 'https://demotestt.hipotenus.net/extended/api/v1/json/AddVaryantToProduct';

        $payload = array_merge($productvariant->toApiArray(), [
            'token' => $token,
        ]);

        $response = Http::post($apiUrl, $payload);


        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to send variant to API',
                'details' => $response->json(),
            ], 500);
        }

        return response()->json([
            'message' => 'Product variant created successfully',
            'local_variant' => $variant,
            'api_response' => $response->json(),
        ]);
    }

    public function update(Request $request, ProductVariant $variant)
    {
        $variant->update($request->all());

        $token = $this->apiTokenService->getToken();
        $apiUrl = 'https://demotestt.hipotenus.net/extended/api/v1/json/AddVaryantToProduct';

        $payload = array_merge($productvariant->toApiArray(), [
            'ProductID' => $productvariant->product_id,
            'VariantID' => $productvariant->variant_id,
            'token' => $token,
        ]);

        $response = Http::post($apiUrl, $payload);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to update variant in API',
                'details' => $response->json(),
            ], 500);
        }

        return response()->json([
            'message' => 'Product variant updated successfully',
            'local_variant' => $variant,
            'api_response' => $response->json(),
        ]);
    }

    public function destroy(ProductVariant $variant)
    {
        $token = $this->apiTokenService->getToken();
        $apiUrl = 'https://demotestt.hipotenus.net/extended/api/v1/json/DeleteVaryant';

        $payload = [
            'ProductID' => $productvariant->product_id,
            'VariantID' => $productvariant->variant_id,
            'token' => $token,
        ];

        $response = Http::post($apiUrl, $payload);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to delete variant in API',
                'details' => $response->json(),
            ], 500);
        }

        $variant->delete();

        return response()->json([
            'message' => 'Product variant deleted successfully',
            'api_response' => $response->json(),
        ]);
    }
}
