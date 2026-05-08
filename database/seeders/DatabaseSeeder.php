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

        // Create categories
        Category::factory(5)->create();

        // Create products
        Product::factory(20)->create();
    }
}
