<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'sku'         => 'required|string|unique:products,sku',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'cost_price'  => 'nullable|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'min_stock'   => 'nullable|integer|min:0',
            'weight'      => 'nullable|numeric|min:0',
            'length'      => 'nullable|numeric|min:0',
            'width'       => 'nullable|numeric|min:0',
            'height'      => 'nullable|numeric|min:0',
            'is_active'   => 'nullable|boolean',
            'main_image'  => 'nullable|image|max:2048',
            'gallery_images.*' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('main_image')) {
            $validated['main_image'] = $request->file('main_image')->store('products', 'public');
        }

        if ($request->hasFile('gallery_images')) {
            $gallery = [];
            foreach ($request->file('gallery_images') as $image) {
                $gallery[] = $image->store('products', 'public');
            }
            $validated['gallery_images'] = $gallery;
        }

        $validated['is_active'] = $request->has('is_active') ? $request->is_active : false;

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show(Product $product)
    {
        $product->load('category');
        // Fallback to basic view if admin view doesn't exist for show
        if (view()->exists('admin.products.show')) {
            return view('admin.products.show', compact('product'));
        }
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'sku'         => 'required|string|unique:products,sku,'.$product->id,
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'cost_price'  => 'nullable|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'min_stock'   => 'nullable|integer|min:0',
            'weight'      => 'nullable|numeric|min:0',
            'length'      => 'nullable|numeric|min:0',
            'width'       => 'nullable|numeric|min:0',
            'height'      => 'nullable|numeric|min:0',
            'is_active'   => 'nullable|boolean',
            'main_image'  => 'nullable|image|max:2048',
            'gallery_images.*' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('main_image')) {
            if ($product->main_image) {
                Storage::disk('public')->delete($product->main_image);
            }
            $validated['main_image'] = $request->file('main_image')->store('products', 'public');
        }

        if ($request->hasFile('gallery_images')) {
            if ($product->gallery_images) {
                foreach ($product->gallery_images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            $gallery = [];
            foreach ($request->file('gallery_images') as $image) {
                $gallery[] = $image->store('products', 'public');
            }
            $validated['gallery_images'] = $gallery;
        }

        $validated['is_active'] = $request->has('is_active') ? $request->is_active : false;

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Data produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->main_image) {
            Storage::disk('public')->delete($product->main_image);
        }
        if ($product->gallery_images) {
            foreach ($product->gallery_images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        $product->delete();
        
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}