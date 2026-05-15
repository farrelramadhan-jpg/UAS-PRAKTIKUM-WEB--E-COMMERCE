<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\View\View;

class SellerController extends Controller
{
    public function dashboard(): View
    {
        $user = auth()->user();
        
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalCustomers = \App\Models\User::where('role', 'buyer')->count();
        $totalRevenue = Order::sum('total_amount');

        $recentOrders = Order::with(['user', 'orderItems'])
            ->latest()
            ->limit(5)
            ->get();

        return view('seller.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalCustomers',
            'totalRevenue',
            'recentOrders'
        ));
    }
}
