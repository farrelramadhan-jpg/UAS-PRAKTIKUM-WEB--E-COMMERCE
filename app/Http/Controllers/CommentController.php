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

        $prompt = "Analisis komentar e-commerce ini:\n\n" .
                  "\"" . $komentarTeks . "\"\n\n" .
                  "Apakah komentar ini mengandung kata kasar (toxic), kebencian, atau spam? " .
                  "Jawab HANYA dengan kata 'SAFE' atau 'REJECT' tanpa penjelasan apapun.";

        $response = Http::withOptions([
            'verify' => false, 
            'timeout' => 15
        ])
        ->withToken(env('GROQ_API_KEY'))
        ->post("https://api.groq.com/openai/v1/chat/completions", [
            'model' => 'llama-3.3-70b-versatile',
            'messages' => [
                ['role' => 'system', 'content' => 'Kamu adalah sistem filter keamanan otomatis yang kaku.'],
                ['role' => 'user', 'content' => $prompt]
            ],
            'temperature' => 0.1 
        ]);

        $isSafe = true; 
        
        if ($response->successful()) {
            $aiDecision = trim($response->json('choices.0.message.content'));
            
            if (str_contains(strtoupper($aiDecision), 'REJECT')) {
                $isSafe = false;
            }
        }

        if (!$isSafe) {
            return back()->with('error', '⚠️ Sistem AI kami menolak komentar Anda karena terdeteksi mengandung kata-kata tidak pantas atau spam.');
        }
        // ==========================================
        // END OF BLOK FILTER AI
        // ==========================================

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

        // 4. Logic Bawaan Anda: Simpan komentar baru
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