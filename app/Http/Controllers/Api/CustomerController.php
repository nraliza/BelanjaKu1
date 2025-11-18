<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Dummy Data Customer
    private $customers = [
        [
            "id" => 1,
            "name" => "Liza",
            "email" => "liza@example.com"
        ],
        [
            "id" => 2,
            "name" => "Budi",
            "email" => "budi@example.com"
        ]
    ];

    // INDEX - List semua customer
    public function index()
    {
        return response()->json([
            "success" => true,
            "data" => $this->customers
        ]);
    }

    // STORE - Tambah customer baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string",
            "email" => "required|email"
        ]);

        $newCustomer = [
            "id" => count($this->customers) + 1,
            "name" => $validated["name"],
            "email" => $validated["email"]
        ];

        return response()->json([
            "success" => true,
            "message" => "Customer created",
            "data" => $newCustomer
        ], 201);
    }

    // SHOW - Menampilkan customer tertentu
    public function show($id)
    {
        foreach ($this->customers as $customer) {
            if ($customer['id'] == $id) {
                return response()->json([
                    "success" => true,
                    "data" => $customer
                ]);
            }
        }

        return response()->json([
            "success" => false,
            "message" => "Customer not found"
        ], 404);
    }

    // UPDATE - Update data customer
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            "name" => "string",
            "email" => "email"
        ]);

        foreach ($this->customers as &$customer) {
            if ($customer['id'] == $id) {
                $customer['name'] = $validated["name"] ?? $customer['name'];
                $customer['email'] = $validated["email"] ?? $customer['email'];

                return response()->json([
                    "success" => true,
                    "message" => "Customer updated",
                    "data" => $customer
                ]);
            }
        }

        return response()->json([
            "success" => false,
            "message" => "Customer not found"
        ], 404);
    }

    // DESTROY - Hapus customer
    public function destroy($id)
    {
        foreach ($this->customers as $customer) {
            if ($customer['id'] == $id) {
                return response()->json([
                    "success" => true,
                    "message" => "Customer deleted"
                ]);
            }
        }

        return response()->json([
            "success" => false,
            "message" => "Customer not found"
        ], 404);
    }
}