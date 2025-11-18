<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException; // <-- Ditambahkan untuk menangani error validasi

class ProductController extends Controller
{
    // Data dummy produk sepatu (simulasi database)
    private $products = [
        [
            'id' => 1,
            'name' => 'Nike Air Max 270',
            'description' => 'Sepatu lari kasual, nyaman untuk sehari-hari.',
            'price' => 1850000,
            'stock' => 15,
            'category_id' => 1,
            'category_name' => 'Olahraga'
        ],
        [
            'id' => 2,
            'name' => 'Adidas Samba Classic',
            'description' => 'Sepatu klasik yang cocok untuk gaya vintage.',
            'price' => 1200000,
            'stock' => 22,
            'category_id' => 2,
            'category_name' => 'Casual'
        ],
        [
            'id' => 3,
            'name' => 'Pantofel Kulit Formal',
            'description' => 'Sepatu formal premium untuk acara resmi.',
            'price' => 850000,
            'stock' => 8,
            'category_id' => 3,
            'category_name' => 'Formal'
        ],
    ];

    /**
     * Menampilkan semua daftar produk.
     * GET /api/products
     * Tidak memerlukan JWT (Publik)
     */
    public function index()
    {
        return response()->json($this->products);
    }

    /**
     * Menampilkan detail satu produk berdasarkan ID.
     * GET /api/products/{id}
     * Tidak memerlukan JWT (Publik)
     */
    public function show($id)
    {
        // Mencari produk di array dummy
        $product = collect($this->products)->firstWhere('id', (int)$id);

        if (!$product) {
            return response()->json(['message' => "Produk dengan ID {$id} tidak ditemukan"], 404);
        }

        return response()->json($product);
    }

    /**
     * Menyimpan produk baru. (Endpoint WAJIB Anda)
     * POST /api/products
     * MEMERLUKAN JWT
     */
    public function store(Request $request)
    {
        // Validasi input data (Mengikuti pola CategoryController)
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|integer|min:1000',
                'stock' => 'required|integer|min:0',
                'category_id' => 'required|integer', 
                'category_name' => 'required|string',
            ]);
        } catch (ValidationException $e) { // <-- Menggunakan ValidationException yang sudah di-import
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        }

        // Simulasi auto-increment ID
        $lastId = end($this->products)['id'];
        
        $newProduct = array_merge($validated, [
            'id' => $lastId + 1,
        ]);

        // Simulasi penyimpanan data (tidak persistent)
        // $this->products[] = $newProduct; 

        return response()->json([
            'message' => 'Produk berhasil ditambahkan (dummy)',
            'product' => $newProduct
        ], 201);
    }

    /**
     * Memperbarui detail produk.
     * PUT /api/products/{id}
     * MEMERLUKAN JWT
     */
    public function update(Request $request, $id)
    {
        // 1. Cari Produk (Simulasi)
        $product = collect($this->products)->firstWhere('id', (int)$id);

        if (!$product) {
            return response()->json(['message' => "Produk dengan ID {$id} tidak ditemukan"], 404);
        }

        // 2. Lakukan update parsial (PUT/PATCH style)
        $product['name'] = $request->name ?? $product['name'];
        $product['description'] = $request->description ?? $product['description'];
        $product['price'] = $request->price ?? $product['price'];
        $product['stock'] = $request->stock ?? $product['stock'];
        $product['category_id'] = $request->category_id ?? $product['category_id'];
        $product['category_name'] = $request->category_name ?? $product['category_name'];

        // 3. Kembalikan Response
        return response()->json([
            'message' => "Produk dengan ID {$id} berhasil diperbarui (dummy)",
            'product' => $product
        ]);
    }

    /**
     * Menghapus produk (simulasi).
     * DELETE /api/products/{id}
     * MEMERLUKAN JWT
     */
    public function destroy($id)
    {
        // Cari produk (Simulasi)
        $product = collect($this->products)->firstWhere('id', (int)$id);

        if (!$product) {
            return response()->json(['message' => "Produk dengan ID {$id} tidak ditemukan"], 404);
        }
        
        // Simulasi penghapusan
        // unset($this->products[$index]); // Di environment nyata ini akan dihapus
        
        return response()->json([
            'message' => "Produk dengan ID {$id} berhasil dihapus (simulasi)"
        ]);
    }
}