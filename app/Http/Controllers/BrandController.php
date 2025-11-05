<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Services\ApiTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BrandController extends Controller
{
    protected $apiTokenService;

    public function __construct(ApiTokenService $apiTokenService)
    {
        $this->apiTokenService = $apiTokenService;
    }

    public function index()
    {
        $brands = Brand::all();
        return response()->json($brands);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_name' => 'required|string|max:200',
            'brand_int_code' => 'nullable|string|max:255',
            'brand_status' => 'nullable|integer',
            'brand_order' => 'nullable|integer',
            'brand_text' => 'nullable|string',
            'brand_seo_title' => 'nullable|string|max:255',
            'brand_seo_text' => 'nullable|string|max:255',
            'brand_seo_keyword' => 'nullable|string',
        ]);

        $brand = Brand::create($validated);

        $token = $this->apiTokenService->getToken();
        $apiUrl = 'https://demotestt.hipotenus.net/extended/api/v1/json/AddBrand';

        $payload = array_merge($brand->toApiArray(), [
            'token' => $token,
        ]);

        $response = Http::post($apiUrl, $payload);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to send brand to API',
                'details' => $response->json(),
            ], 500);
        }

        return response()->json([
            'message' => 'Brand created successfully',
            'local_brand' => $brand,
            'api_response' => $response->json(),
        ]);
    }

    public function update(Request $request, Brand $brand)
    {
        $brand->update($request->all());

        $token = $this->apiTokenService->getToken();
        $apiUrl = 'https://demotestt.hipotenus.net/extended/api/v1/json/EditBrand';

        $payload = array_merge($brand->toApiArray(), [
            'ID' => $brand->id,
            'token' => $token,
        ]);

        $response = Http::post($apiUrl, $payload);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to update brand in API',
                'details' => $response->json(),
            ], 500);
        }

        return response()->json([
            'message' => 'Brand updated successfully',
            'local_brand' => $brand,
            'api_response' => $response->json(),
        ]);
    }

    public function destroy(Brand $brand)
    {
        $token = $this->apiTokenService->getToken();
        $apiUrl = 'https://demotestt.hipotenus.net/extended/api/v1/json/DeleteBrand';

        $payload = [
            'ID' => $brand->id,
            'BrandIntCode' => $brand->brand_int_code,
            'token' => $token,
        ];

        $response = Http::post($apiUrl, $payload);
        
        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to delete brand in API',
                'details' => $response->json(),
            ], 500);
        }

        $brand->delete();

        return response()->json([
            'message' => 'Brand deleted successfully',
            'api_response' => $response->json(),
        ]);
    }
}

