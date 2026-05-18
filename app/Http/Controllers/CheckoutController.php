<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function create()
    {
        $carts = auth()->user()->carts()->with('product')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('success', 'Keranjang Anda kosong.');
        }

        $subtotal = $carts->reduce(function ($carry, $cart) {
            return $carry + ($cart->product->price * $cart->quantity);
        }, 0);

        return view('orders.checkout', compact('carts', 'subtotal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:2000',
            'billing_address' => 'required|string|max:2000',
            'shipping_type' => 'required|in:standard,express',
            'payment_method' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:2000',
        ]);

        $user = auth()->user();
        $carts = $user->carts()->with('product')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('success', 'Keranjang Anda kosong.');
        }

        $subtotal = $carts->reduce(function ($carry, $cart) {
            return $carry + ($cart->product->price * $cart->quantity);
        }, 0);

        $shippingAmount = $request->shipping_type === 'express' ? 30000 : 15000;
        $totalAmount = $subtotal + $shippingAmount;

        DB::transaction(function () use ($request, $user, $carts, $subtotal, $shippingAmount, $totalAmount, &$order) {
            $order = Order::create([
                'order_number' => strtoupper('ORD-' . Str::random(6)),
                'user_id' => $user->id,
                'subtotal' => $subtotal,
                'tax_amount' => 0,
                'shipping_amount' => $shippingAmount,
                'discount_amount' => 0,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method ?? 'cod',
                'shipping_type' => $request->shipping_type,
                'shipping_address' => $request->shipping_address,
                'billing_address' => $request->billing_address,
                'notes' => $request->notes,
            ]);

            foreach ($carts as $cart) {
                if ($cart->product->stock < $cart->quantity) {
                    throw new \Exception("Stok produk {$cart->product->name} tidak mencukupi.");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product->id,
                    'product_name' => $cart->product->name,
                    'product_sku' => $cart->product->sku,
                    'quantity' => $cart->quantity,
                    'unit_price' => $cart->product->price,
                    'total_price' => $cart->product->price * $cart->quantity,
                ]);

                $cart->product->decrement('stock', $cart->quantity);
            }

            Cart::where('user_id', $user->id)->delete();
        });

        return redirect()->route('orders.user.show', $order)->with('success', 'Pesanan berhasil dibuat dan tercatat di admin.');
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('orderItems.product');

        return view('orders.show', compact('order'));
    }
}
