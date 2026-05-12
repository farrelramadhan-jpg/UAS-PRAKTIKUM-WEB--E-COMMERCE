<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = auth()->user()->wishlists()->with('product')->get();
        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $wishlist = Wishlist::where('user_id', auth()->id())
                            ->where('product_id', $request->product_id)
                            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return back()->with('success', 'Produk dihapus dari wishlist.');
        } else {
            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id
            ]);
            return back()->with('success', 'Produk ditambahkan ke wishlist!');
        }
    }
}
