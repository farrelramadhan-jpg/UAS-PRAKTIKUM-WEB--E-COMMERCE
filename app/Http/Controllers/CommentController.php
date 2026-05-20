<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;

class CommentController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Input Bawaan Anda
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        $komentarTeks = $request->comment;
        
        // 2. Logic: Simpan komentar baru
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