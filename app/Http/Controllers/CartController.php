<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = auth()->user()->carts()->with('product')->get();
        return view('cart.index', compact('carts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $qty = $request->quantity ?? 1;

        $cart = Cart::where('user_id', auth()->id())
                    ->where('product_id', $product->id)
                    ->first();

        if ($cart) {
            $cart->update([
                'quantity' => $cart->quantity + $qty
            ]);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $qty
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) abort(403);

        $request->validate(['quantity' => 'required|integer|min:1']);
        
        $cart->update(['quantity' => $request->quantity]);
        return back()->with('success', 'Jumlah keranjang diperbarui!');
    }

    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) abort(403);
        
        $cart->delete();
        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
