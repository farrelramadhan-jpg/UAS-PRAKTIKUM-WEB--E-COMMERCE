<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->withSum('orderItems', 'quantity')
            ->latest()
            ->paginate(10);

        // Stats for dashboard cards
        $totalProducts = Product::count();
        $lowStockCount = Product::where(function($q) {
            $q->whereColumn('stock', '<', 'min_stock')
              ->orWhere(function($q2) {
                  $q2->whereNull('min_stock')->where('stock', '<', 10);
              });
        })->count();

        $inactiveCount = Product::where('is_active', false)->count();

        $soldToday = OrderItem::whereHas('order', function($q) {
            $q->whereDate('created_at', Carbon::today());
        })->sum('quantity');

        $route = request()->route() ? request()->route()->getName() : null;
        if ($route && str_starts_with($route, 'seller.')) {
            return view('seller.products.index', compact('products', 'totalProducts', 'lowStockCount', 'inactiveCount', 'soldToday'));
        }
        return view('admin.products.index', compact('products', 'totalProducts', 'lowStockCount', 'inactiveCount', 'soldToday'));
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
        ]);

        $validated['is_active'] = $request->is_active == '1';

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
        ]);

        $validated['is_active'] = $request->is_active == '1';

        $product->update($validated);

        $indexRoute = $this->productsIndexRouteName($request);
        return redirect()->route($indexRoute)->with('success', 'Data produk berhasil diperbarui!');
    }

    public function destroy(Request $request, Product $product)
    {
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