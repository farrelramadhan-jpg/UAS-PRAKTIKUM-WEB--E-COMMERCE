<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // 1. Menampilkan semua data produk di tabel (Untuk Admin)
    public function index()
    {
        // Memanggil produk beserta nama kategorinya agar tidak memberatkan database
        $products = Product::with('category')->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    // 2. Menampilkan halaman form tambah produk
    public function create()
    {
        // Kita butuh data kategori untuk ditampilkan di dropdown form
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // 3. Menyimpan data dari form ke database
    public function store(Request $request)
    {
        // Ini fitur andalanmu: Validasi! 
        // Memastikan tidak ada data kosong atau salah ketik yang masuk ke database
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock'       => 'required|integer|min:0', // Stok tidak boleh minus
            'price'       => 'required|numeric|min:0', // Harga harus angka
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan ke etalase AnoShop!');
    }

    // 4. Menampilkan detail satu produk
    public function show(Product $product)
    {
        $product->load('category');
        return view('products.show', compact('product'));
    }

    // 5. Menampilkan halaman form edit produk
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    // 6. Menyimpan perubahan data (Update)
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock'       => 'required|integer|min:0',
            'price'       => 'required|numeric|min:0',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Data produk AnoShop berhasil diperbarui!');
    }

    // 7. Menghapus data dari database
    public function destroy(Product $product)
    {
        $product->delete();
        
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus dari sistem AnoShop.');
    }
}