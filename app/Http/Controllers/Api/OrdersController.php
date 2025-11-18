<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data order
        try {
            $validated = $request->validate([
                'customer_id' => 'required|numeric',
                'products' => 'required|array|min:1',
                'products.*.product_id' => 'required|numeric',
                'products.*.qty' => 'required|numeric|min:1',
                'total_price' => 'required|numeric|min:0',
                'status' => 'required|string|in:pending,paid,shipped,cancelled'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                "message" => "Validation failed",
                "errors" => $e->validator->errors()
            ], 422);
        }

        // Data dummy hasil penyimpanan
        $order = array_merge([
            "id" => rand(100, 999)
        ], $validated);

        return response()->json([
            "message" => "Order created successfully (dummy)",
            "data" => $order
        ], 201);
    }
    public function index()
    {
    // Dummy JSON orders
    $orders = [
        [
            "id" => 1,
            "customer_id" => 5,
            "products" => [
                ["product_id" => 1, "qty" => 2],
                ["product_id" => 3, "qty" => 1]
            ],
            "total_price" => 45000,
            "status" => "pending"
        ],
        [
            "id" => 2,
            "customer_id" => 3,
            "products" => [
                ["product_id" => 2, "qty" => 1]
            ],
            "total_price" => 15000,
            "status" => "paid"
        ]
    ];

    return response()->json($orders);
    }

    // PUT /api/orders/{id}
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'customer_id' => 'sometimes|required|numeric',
                'products' => 'sometimes|required|array',
                'products.*.product_id' => 'sometimes|required|numeric',
                'products.*.qty' => 'sometimes|required|numeric|min:1',
                'total_price' => 'sometimes|required|numeric|min:0',
                'status' => 'sometimes|required|string|in:pending,paid,shipped,cancelled'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                "message" => "Validation failed",
                "errors" => $e->validator->errors()
            ], 422);
        }

        // Dummy updated data
        $updatedOrders = array_merge(['id' => $id], $validated);

        return response()->json([
            "message" => "Order {$id} updated successfully (dummy)",
            "data" => $updatedOrders
        ]);
    }

    // DELETE /api/orders/{id}
    public function destroy($id)
    {
        return response()->json([
            "message" => "Order {$id} deleted successfully (dummy)"
        ]);
    }
}

