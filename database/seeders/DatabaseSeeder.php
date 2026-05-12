<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        // Create guest user
        User::factory()->create([
            'name' => 'Guest User',
            'email' => 'guest@example.com',
            'role' => 'guest',
        ]);

        $categories = [
            ['name' => 'Fashion Pria', 'description' => 'Pakaian dan aksesoris pria terbaru'],
            ['name' => 'Fashion Wanita', 'description' => 'Pakaian dan aksesoris wanita terbaru'],
            ['name' => 'Elektronik & Gadget', 'description' => 'Smartphone, laptop, dan perangkat elektronik lainnya'],
            ['name' => 'Buku & Alat Tulis', 'description' => 'Buku fiksi, non-fiksi, dan perlengkapan sekolah'],
            ['name' => 'Rumah Tangga', 'description' => 'Perabotan dan perlengkapan rumah tangga'],
        ];

        foreach ($categories as $catData) {
            Category::create($catData);
        }

        $products = [
            [
                'name' => 'Kemeja Flanel Lengan Panjang Pria Premium',
                'category_id' => 1,
                'sku' => 'KMP-001',
                'description' => 'Kemeja flanel pria dengan bahan premium yang nyaman dipakai untuk cuaca dingin maupun panas. Cocok untuk acara kasual maupun semi-formal.',
                'price' => 175000,
                'cost_price' => 120000,
                'stock' => 50,
                'min_stock' => 10,
                'weight' => 300,
                'is_active' => true,
            ],
            [
                'name' => 'Laptop Gaming ASUS ROG Strix G15',
                'category_id' => 3,
                'sku' => 'LAP-ROG-015',
                'description' => 'Laptop gaming dengan performa tinggi, dilengkapi dengan prosesor Intel Core i7 terbaru dan kartu grafis RTX 4060.',
                'price' => 22500000,
                'cost_price' => 20000000,
                'stock' => 15,
                'min_stock' => 5,
                'weight' => 2500,
                'is_active' => true,
            ],
            [
                'name' => 'Buku "Belajar Laravel 11 dari Nol"',
                'category_id' => 4,
                'sku' => 'BKM-LRV-11',
                'description' => 'Buku panduan lengkap belajar framework PHP paling populer, Laravel versi 11. Ditulis dengan bahasa yang mudah dipahami.',
                'price' => 95000,
                'cost_price' => 60000,
                'stock' => 120,
                'min_stock' => 20,
                'weight' => 400,
                'is_active' => true,
            ],
            [
                'name' => 'Meja Belajar Minimalis Modern',
                'category_id' => 5,
                'sku' => 'MJB-MNM-01',
                'description' => 'Meja belajar dengan desain minimalis scandinavian. Material kokoh dengan finishing anti gores dan air.',
                'price' => 650000,
                'cost_price' => 450000,
                'stock' => 30,
                'min_stock' => 5,
                'weight' => 15000,
                'is_active' => true,
            ],
            [
                'name' => 'Dress Wanita Casual Korea Lengan Pendek',
                'category_id' => 2,
                'sku' => 'DRW-KOR-02',
                'description' => 'Dress cantik bergaya korea yang sangat cocok untuk jalan-jalan atau kencan santai. Bahan adem dan jatuh.',
                'price' => 145000,
                'cost_price' => 90000,
                'stock' => 80,
                'min_stock' => 15,
                'weight' => 250,
                'is_active' => true,
            ],
            [
                'name' => 'Smartwatch Apple Watch Series 9',
                'category_id' => 3,
                'sku' => 'SWT-APL-09',
                'description' => 'Jam tangan pintar terbaru dari Apple dengan fitur monitoring kesehatan lengkap dan layar super terang.',
                'price' => 7800000,
                'cost_price' => 6500000,
                'stock' => 25,
                'min_stock' => 10,
                'weight' => 150,
                'is_active' => true,
            ],
            [
                'name' => 'Sofa Ruang Tamu 3 Seater Scandinavian',
                'category_id' => 5,
                'sku' => 'SOF-SCD-03',
                'description' => 'Sofa empuk dengan desain skandinavia yang estetik. Tersedia dalam berbagai pilihan warna pastel yang cantik.',
                'price' => 2100000,
                'cost_price' => 1500000,
                'stock' => 8,
                'min_stock' => 2,
                'weight' => 45000,
                'is_active' => true,
            ],
            [
                'name' => 'Novel "Bumi Manusia" by Pramoedya Ananta Toer',
                'category_id' => 4,
                'sku' => 'NVL-PRM-01',
                'description' => 'Karya masterpiece dari sastrawan ternama Indonesia. Buku pertama dari Tetralogi Buru yang sangat legendaris.',
                'price' => 110000,
                'cost_price' => 75000,
                'stock' => 45,
                'min_stock' => 10,
                'weight' => 350,
                'is_active' => true,
            ]
        ];

        foreach ($products as $prodData) {
            Product::create($prodData);
        }
    }
}
