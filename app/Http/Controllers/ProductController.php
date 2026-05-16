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
        $route = request()->route() ? request()->route()->getName() : null;
        if ($route && str_starts_with($route, 'seller.')) {
            return view('seller.products.index', compact('products'));
        }
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $route = request()->route() ? request()->route()->getName() : null;
        if ($route && str_starts_with($route, 'seller.')) {
            return view('seller.products.create', compact('categories'));
        }
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

        $indexRoute = $this->productsIndexRouteName($request);
        return redirect()->route($indexRoute)->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show(Product $product)
    {
        $product->load('category');
        $route = request()->route() ? request()->route()->getName() : null;
        if ($route && str_starts_with($route, 'seller.')) {
            return view('seller.products.show', compact('product'));
        }
        if (view()->exists('admin.products.show')) {
            return view('admin.products.show', compact('product'));
        }
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $route = request()->route() ? request()->route()->getName() : null;
        if ($route && str_starts_with($route, 'seller.')) {
            return view('seller.products.edit', compact('product', 'categories'));
        }
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

        $indexRoute = $this->productsIndexRouteName($request);
        return redirect()->route($indexRoute)->with('success', 'Data produk berhasil diperbarui!');
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

        $indexRoute = $this->productsIndexRouteName($request);
        return redirect()->route($indexRoute)->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Determine the correct named index route for products based on current route name.
     */
    protected function productsIndexRouteName(Request $request): string
    {
        $current = $request->route() ? $request->route()->getName() : null;
        if ($current) {
            $parts = explode('.', $current);
            // if route name contains a prefix like 'seller.products.store' or 'admin.products.update'
            if (count($parts) >= 3) {
                return $parts[0] . '.products.index';
            }
        }
        return 'products.index';
    }
}