<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Data dummy produk sepatu
    private $products = [
        [
            'id' => 1,
            'name' => 'Nike Air Max 270',
            'description' => 'Sepatu lari kasual, nyaman untuk sehari-hari.',
            'price' => 1850000,
            'stock' => 15,
            'category_id' => 1, // Olahraga
            'category_name' => 'Olahraga'
        ],
        [
            'id' => 2,
            'name' => 'Adidas Samba Classic',
            'description' => 'Sepatu klasik yang cocok untuk gaya vintage.',
            'price' => 1200000,
            'stock' => 22,
            'category_id' => 2, // Casual
            'category_name' => 'Casual'
        ],
        [
            'id' => 3,
            'name' => 'Pantofel Kulit Formal',
            'description' => 'Sepatu formal premium untuk acara resmi.',
            'price' => 850000,
            'stock' => 8,
            'category_id' => 3, // Formal
            'category_name' => 'Formal'
        ],
    ];

    /**
     * Menampilkan semua daftar produk.
     * GET /api/products
     */
    public function index()
    {
        return response()->json($this->products);
    }

    /**
     * Menampilkan detail satu produk berdasarkan ID.
     * GET /api/products/{id}
     */
    public function show($id)
    {
        // Cari produk berdasarkan ID
        $product = collect($this->products)->firstWhere('id', $id);

        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        return response()->json($product);
    }

    /**
     * Menyimpan produk baru.
     * POST /api/products
     */
    public function store(Request $request)
    {
        // Validasi input data
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|integer|min:1000',
                'stock' => 'required|integer|min:0',
                'category_id' => 'required|integer', // Asumsi ID kategori sudah ada
                'category_name' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        }

        $newProduct = [
            'id' => end($this->products)['id'] + 1, // Auto-increment ID dummy
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'category_name' => $request->category_name,
        ];

        // Simulasi penyimpanan (hanya ditambahkan ke array sementara)
        $this->products[] = $newProduct;

        return response()->json([
            'message' => 'Produk berhasil ditambahkan',
            'product' => $newProduct
        ], 201);
    }

    /**
     * Memperbarui detail produk.
     * PUT /api/products/{id}
     */
    public function update(Request $request, $id)
    {
        $index = -1;
        
        // Cari indeks produk
        foreach ($this->products as $key => $product) {
            if ($product['id'] == $id) {
                $index = $key;
                break;
            }
        }

        if ($index === -1) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        // Ambil data produk saat ini
        $product = $this->products[$index];

        // Lakukan update data (tanpa validasi menyeluruh untuk PUT sebagian/PATCH)
        $product['name'] = $request->name ?? $product['name'];
        $product['description'] = $request->description ?? $product['description'];
        $product['price'] = $request->price ?? $product['price'];
        $product['stock'] = $request->stock ?? $product['stock'];
        $product['category_id'] = $request->category_id ?? $product['category_id'];
        $product['category_name'] = $request->category_name ?? $product['category_name'];

        // Simulasikan pembaruan
        $this->products[$index] = $product;

        return response()->json([
            'message' => "Produk dengan ID $id berhasil diperbarui",
            'product' => $product
        ]);
    }

    /**
     * Menghapus produk (simulasi).
     * DELETE /api/products/{id}
     */
    public function destroy($id)
    {
        // Cari indeks produk
        $index = -1;
        foreach ($this->products as $key => $product) {
            if ($product['id'] == $id) {
                $index = $key;
                break;
            }
        }

        if ($index === -1) {
            // Walaupun simulasi, kita tetap memberikan pesan 404 jika ID tidak ada
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        // Simulasi penghapusan
        // unset($this->products[$index]); // Di environment nyata ini akan dihapus
        
        return response()->json([
            'message' => "Produk dengan ID $id berhasil dihapus (simulasi)"
        ]);
    }
}