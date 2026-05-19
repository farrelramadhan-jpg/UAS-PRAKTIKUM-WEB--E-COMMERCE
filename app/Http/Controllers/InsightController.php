<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InsightController extends Controller
{
    public function index()
    {
        // 1. Ambil 5 produk dengan stok terbanyak tapi penjualan terendah (Dead Stock murni)
        $products = Product::leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->select(
                'products.id', 
                'products.name', 
                'products.stock', 
                'products.price', 
                DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold')
            )
            ->where('products.is_active', true)
            ->where('products.stock', '>', 0)
            ->groupBy('products.id', 'products.name', 'products.stock', 'products.price')
            ->orderBy('total_sold', 'asc') // Penjualan paling sedikit
            ->orderBy('products.stock', 'desc') // Stok paling banyak
            ->take(5)
            ->get();

        // 2. Siapkan Data Teks untuk Prompt Groq AI
        $dataTeks = $products->map(function ($item) {
            return "- {$item->name} (Stok Sisa: {$item->stock} unit | Total Terjual: {$item->total_sold} unit | Harga: Rp" . number_format($item->price, 0, ',', '.') . ")";
        })->implode("\n");

        $prompt = "Berikut adalah data 5 produk 'dead stock' di gudang kami (stok tinggi namun penjualan sangat rendah):\n\n" . 
                  $dataTeks . 
                  "\n\nSebagai analis e-commerce profesional, berikan:\n1. Evaluasi singkat mengapa barang ini mungkin tidak laku.\n2. Saran strategi promosi spesifik (misal: bundling, flash sale, diskon) untuk masing-masing barang agar gudang cepat kosong. Gunakan bahasa Indonesia yang to the point.";

        // 3. Eksekusi API Groq (Model Llama 3)
        $response = Http::withOptions([
            'verify' => false,
            'timeout' => 60
        ])
        ->withToken(env('GROQ_API_KEY'))
        ->post("https://api.groq.com/openai/v1/chat/completions", [
            'model' => 'llama-3.3-70b-versatile',
            'messages' => [
                ['role' => 'system', 'content' => 'Kamu adalah analis e-commerce profesional.'],
                ['role' => 'user', 'content' => $prompt]
            ],
            'temperature' => 0.7
        ]);

        // 4. Proses Hasil AI
        if ($response->successful()) {
            $aiResponseText = $response->json('choices.0.message.content');
        } else {
            $aiResponseText = "⚠️ **Gagal terhubung ke AI.**\n\nPesan: " . $response->json('error.message', 'Unknown error');
        }

        $insightHtml = Str::markdown((string) $aiResponseText);

        return view('admin.insight.index', compact('insightHtml', 'products'));
    }
}