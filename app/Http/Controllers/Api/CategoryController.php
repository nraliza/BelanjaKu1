<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // CREATE - POST /api/categories
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:50',
                'deskripsi' => 'required|string|max:255'
            ]);
        } catch (\Illuminate\Validation\ValidationException $th) {
            return response()->json([
                "message" => "Validation failed",
                "errors" => $th->validator->errors()
            ], 422);
        }

        return response()->json([
            "message" => "Category created successfully (dummy)",
            "data" => $validated
        ], 201);
    }

    // READ - GET /api/categories
    public function index()
    {
        $categories = [
            [
                "id" => 1,
                "nama" => "Olahraga",
                "deskripsi" => "Kategori untuk sepatu olahraga"
            ],
            [
                "id" => 2,
                "nama" => "Casual",
                "deskripsi" => "Kategori sepatu harian / casual"
            ],
            [
                "id" => 3,
                "nama" => "Formal",
                "deskripsi" => "Sepatu untuk acara formal atau kerja"
            ]
        ];

        return response()->json($categories);
    }

    // UPDATE - PUT /api/categories/{id}
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'nama' => 'sometimes|required|string|max:50',
                'deskripsi' => 'sometimes|required|string|max:255'
            ]);
        } catch (\Illuminate\Validation\ValidationException $th) {
            return response()->json([
                "message" => "Validation failed",
                "errors" => $th->validator->errors()
            ], 422);
        }

        return response()->json([
            "message" => "Category {$id} updated successfully (dummy)",
            "data" => array_merge(['id' => $id], $validated)
        ]);
    }

    // DELETE - DELETE /api/categories/{id}
    public function destroy($id)
    {
        return response()->json([
            "message" => "Category {$id} deleted successfully (dummy)"
        ]);
    }
}