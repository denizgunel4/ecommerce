<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ApiTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    protected $apiTokenService;

    public function __construct(ApiTokenService $apiTokenService)
    {
        $this->apiTokenService = $apiTokenService;
    }

    public function index()
    {
        return response()->json(Product::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric',
            'product_brand_id' => 'nullable|integer',
            'product_supplier_id' => 'nullable|integer',
            'product_code' => 'nullable|string',
        ]);

        $product = Product::create($validated);

        $token = $this->apiTokenService->getToken();
        $apiUrl = 'https://demotestt.hipotenus.net/extended/api/v1/json/AddProduct';

        $payload = array_merge($product->toApiArray(), [
            'token' => $token,
        ]);

        $response = Http::post($apiUrl, $payload);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to send product to external API',
                'details' => $response->json(),
            ], 500);
        }

        return response()->json([
            'message' => 'Product created successfully',
            'local_product' => $product,
            'api_response' => $response->json(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->all());

        $token = $this->apiTokenService->getToken();
        $apiUrl = 'https://demotestt.hipotenus.net/extended/api/v1/json/UpdateProduct';

        $payload = array_merge($product->toApiArray(), [
            'ID' => $product->id,
            'token' => $token,
        ]);

        $response = Http::post($apiUrl, $payload);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to update product in external API',
                'details' => $response->json(),
            ], 500);
        }

        return response()->json([
            'message' => 'Product updated successfully',
            'local_product' => $product,
            'api_response' => $response->json(),
        ]);
    }

    public function destroy(Product $product)
    {
        $token = $this->apiTokenService->getToken();
        $apiUrl = 'https://demotestt.hipotenus.net/extended/api/v1/json/DeleteProduct';

        $payload = [
            'ID' => $product->id,
            'ProductCode' => $product->product_code,
            'token' => $token,
        ];

        $response = Http::post($apiUrl, $payload);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to delete product from API',
                'details' => $response->json(),
            ], 500);
        }

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully',
            'api_response' => $response->json(),
        ]);
    }
}


