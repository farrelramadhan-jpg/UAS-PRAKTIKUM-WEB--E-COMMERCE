<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sku' => 'SKU-' . $this->faker->unique()->randomNumber(5, true),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->numberBetween(50000, 1000000),
            'cost_price' => $this->faker->numberBetween(30000, 800000),
            'stock' => $this->faker->numberBetween(0, 150),
            'min_stock' => $this->faker->numberBetween(5, 20),
            'weight' => $this->faker->randomFloat(2, 100, 2000),
            'length' => $this->faker->randomFloat(2, 10, 50),
            'width' => $this->faker->randomFloat(2, 10, 50),
            'height' => $this->faker->randomFloat(2, 10, 50),
            'is_active' => $this->faker->boolean(80),
            'category_id' => Category::factory(),
        ];
    }
}
