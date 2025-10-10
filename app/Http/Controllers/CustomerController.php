<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Services\ApiTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CustomerController extends Controller
{
    protected $apiTokenService;

    public function __construct(ApiTokenService $apiTokenService)
    {
        $this->apiTokenService = $apiTokenService;
    }

    public function index()
    {
        $customers = Customer::all();
        return response()->json($customers);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:50',
            'customer_address' => 'nullable|string',
            'customer_status' => 'nullable|integer',
            'customer_int_code' => 'nullable|string|max:255',
        ]);

        $customer = Customer::create($validated);

        $token = $this->apiTokenService->getToken();
        $apiUrl = 'https://demotestt.hipotenus.net/extended/api/v1/json/AddCustomer';

        $response = Http::withToken($token)->post($apiUrl, $customer->toApiArray());

        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to send customer to API',
                'details' => $response->json(),
            ], 500);
        }

        return response()->json([
            'message' => 'Customer created successfully',
            'local_customer' => $customer,
            'api_response' => $response->json(),
        ]);
    }

    public function update(Request $request, Customer $customer)
    {
        $customer->update($request->all());

        $token = $this->apiTokenService->getToken();
        $apiUrl = 'https://demotestt.hipotenus.net/extended/api/v1/json/EditCustomer';

        $response = Http::withToken($token)->post($apiUrl, $customer->toApiArray() + ['ID' => $customer->id]);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to update customer in API',
                'details' => $response->json(),
            ], 500);
        }

        return response()->json([
            'message' => 'Customer updated successfully',
            'local_customer' => $customer,
            'api_response' => $response->json(),
        ]);
    }

    public function destroy(Customer $customer)
    {
        $token = $this->apiTokenService->getToken();
        $apiUrl = 'https://demotestt.hipotenus.net/extended/api/v1/json/DeleteCustomer';

        $response = Http::withToken($token)->post($apiUrl, [
            'ID' => $customer->id,
            'CustomerIntCode' => $customer->customer_int_code,
        ]);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to delete customer in API',
                'details' => $response->json(),
            ], 500);
        }

        $customer->delete();

        return response()->json([
            'message' => 'Customer deleted successfully',
            'api_response' => $response->json(),
        ]);
    }
}
