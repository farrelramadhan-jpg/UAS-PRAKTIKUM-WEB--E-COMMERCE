<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        // Check if user already commented on this product
        $existingComment = Comment::where('user_id', auth()->id())
            ->where('product_id', $request->input('product_id'))
            ->first();

        if ($existingComment) {
            if ($existingComment->status !== 'approved') {
                $existingComment->update([
                    'rating' => $request->rating,
                    'comment' => $request->comment,
                    'status' => 'approved',
                    'approved_at' => now(),
                    'approved_by' => auth()->id(),
                ]);

                return back()->with('success', 'Ulasan Anda telah diperbarui dan langsung ditampilkan.');
            }

            return back()->with('error', 'Anda sudah memberikan ulasan untuk produk ini.');
        }

        Comment::create([
            'user_id' => auth()->id(),
            'product_id' => $request->input('product_id'),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Ulasan Anda telah diposting dan langsung ditampilkan.');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        // Only allow users to delete their own comments
        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
