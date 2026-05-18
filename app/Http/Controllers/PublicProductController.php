<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PublicProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Product::with('category')->where('is_active', true);

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search') && !empty($request->search)) {
            $userQuery = $request->search;

            // 1. Ambil "Katalog Mini" untuk dibaca oleh AI (ID, Nama, Harga, sebagian deskripsi)
            // Asumsi: tabel products Anda memiliki kolom 'description'
            $catalog = Product::where('is_active', true)->get(['id', 'name', 'price', 'description']);
            
            $catalogText = $catalog->map(function($p) {
                $shortDesc = substr(strip_tags($p->description), 0, 150); 
                return "ID:{$p->id} | Nama:{$p->name} | Rp{$p->price} | Deskripsi:{$shortDesc}";
            })->implode("\n");

            $prompt = "Katalog Produk:\n" . $catalogText . "\n\n" .
                      "Kueri Pembeli: \"{$userQuery}\"\n\n" .
                      "Tugas: Pilih maksimal 8 ID produk yang paling relevan dengan kueri pembeli berdasarkan deskripsi/nama. " .
                      "PENTING: Balas HANYA dengan format JSON array berisi angka ID. Jangan tulis penjelasan apapun. Contoh balasan yang benar: [1, 4, 12]";

            // 3. Eksekusi API Groq Llama 3.3
            $response = Http::withOptions(['verify' => false, 'timeout' => 20])
                ->withToken(env('GROQ_API_KEY'))
                ->post("https://api.groq.com/openai/v1/chat/completions", [
                    'model' => 'llama-3.3-70b-versatile',
                    'messages' => [
                        ['role' => 'system', 'content' => 'Kamu adalah mesin pencari database e-commerce. Output mutlak hanya JSON array.'],
                        ['role' => 'user', 'content' => $prompt]
                    ],
                    'temperature' => 0.1 // Sangat rendah agar AI logis dan tidak berhalusinasi
                ]);

            $useAiFallback = true;

            if ($response->successful()) {
                $aiResponseText = trim($response->json('choices.0.message.content'));
                
                // 4. Ekstrak Array JSON menggunakan Regex (mencegah format ```json [...] ```)
                preg_match('/\[.*\]/s', $aiResponseText, $matches);
                
                if (!empty($matches)) {
                    $matchedIds = json_decode($matches[0], true);
                    
                    if (is_array($matchedIds) && count($matchedIds) > 0) {
                        // 5. Terapkan ID rekomendasi AI ke dalam kueri database
                        $query->whereIn('id', $matchedIds);
                        
                        // Urutkan persis sesuai urutan relevansi yang diberikan AI
                        $idString = implode(',', $matchedIds);
                        $query->orderByRaw("FIELD(id, {$idString})");
                        
                        $useAiFallback = false;
                    }
                }
            }

            // 6. Sistem Fallback (Jaring Pengaman)
            // Jika API Groq down atau JSON gagal di-parsing, gunakan pencarian SQL LIKE biasa
            if ($useAiFallback) {
                $query->where('name', 'like', '%' . $userQuery . '%');
            }
        }
        else {
             // Default order jika tidak ada pencarian
             $query->latest();
        }

        $products = $query->paginate(12);
        
        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }
        $product->load(['category', 'comments' => function($query) {
            $query->approved()->with('user')->latest();
        }]);
        return view('products.show', compact('product'));
    }
}