<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\ApiTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CategoryController extends Controller
{
    protected $apiTokenService;

    public function __construct(ApiTokenService $apiTokenService)
    {
        $this->apiTokenService = $apiTokenService;
    }

    public function index()
    {
        $categories = Category::with('children')->get();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:200',
            'category_text' => 'nullable|string',
            'category_status' => 'nullable|integer',
            'category_order' => 'nullable|integer',
            'category_int_code' => 'nullable|string|max:255',
            'parent_id' => 'nullable|integer',
            'category_seo_title' => 'nullable|string|max:255',
            'category_seo_text' => 'nullable|string|max:255',
            'category_seo_keyword' => 'nullable|string',
        ]);

        $category = Category::create($validated);

        $token = $this->apiTokenService->getToken();
        $apiUrl = 'https://demotestt.hipotenus.net/extended/api/v1/json/AddCategory';

        $payload = array_merge($category->toApiArray(), [
            'token' => $token,
        ]);

        $response = Http::post($apiUrl, $payload);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to send category to API',
                'details' => $response->json(),
            ], 500);
        }

        return response()->json([
            'message' => 'Category created successfully',
            'local_category' => $category,
            'api_response' => $response->json(),
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->all());

        $token = $this->apiTokenService->getToken();
        $apiUrl = 'https://demotestt.hipotenus.net/extended/api/v1/json/EditCategory';

        $payload = array_merge($category->toApiArray(), [
            'ID' => $category->id,
            'token' => $token,
        ]);

        $response = Http::post($apiUrl, $payload);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to update category in API',
                'details' => $response->json(),
            ], 500);
        }

        return response()->json([
            'message' => 'Category updated successfully',
            'local_category' => $category,
            'api_response' => $response->json(),
        ]);
    }

    public function destroy(Category $category)
    {
        $token = $this->apiTokenService->getToken();
        $apiUrl = 'https://demotestt.hipotenus.net/extended/api/v1/json/DeleteCategory';

        $payload = [
            'ID' => $category->id,
            'CategoryIntCode' => $category->category_int_code,
            'token' => $token,
        ];

        $response = Http::post($apiUrl, $payload);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to delete category in API',
                'details' => $response->json(),
            ], 500);
        }

        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully',
            'api_response' => $response->json(),
        ]);
    }
}

