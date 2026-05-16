<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        $route = request()->route() ? request()->route()->getName() : null;
        if ($route && str_starts_with($route, 'seller.')) {
            return view('seller.orders.index', compact('orders'));
        }
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.orders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // This would typically be handled by the checkout process
        // For admin, we might allow manual order creation
        $indexRoute = $this->indexRouteName($request, 'orders');
        return redirect()->route($indexRoute)->with('success', 'Order created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('user', 'orderItems.product');
        $route = request()->route() ? request()->route()->getName() : null;
        if ($route && str_starts_with($route, 'seller.')) {
            return view('seller.orders.show', compact('order'));
        }
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'notes' => 'nullable|string',
        ]);

        $order->update($validated);

        $indexRoute = $this->indexRouteName($request, 'orders');
        return redirect()->route($indexRoute)->with('success', 'Order updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        $indexRoute = $this->indexRouteName($request, 'orders');
        return redirect()->route($indexRoute)->with('success', 'Order deleted successfully');
    }

    protected function indexRouteName(Request $request, string $resource): string
    {
        $current = $request->route() ? $request->route()->getName() : null;
        if ($current) {
            $parts = explode('.', $current);
            if (count($parts) >= 3) {
                return $parts[0] . '.' . $resource . '.index' ?? $resource . '.index';
            }
        }
        return $resource . '.index';
    }
}
