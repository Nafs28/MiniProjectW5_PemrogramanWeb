<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'sku' => fake()->unique()->bothify('PRD-####-???'),
            'name' => fake()->words(3, true),
            'price' => fake()->randomFloat(2, 10000, 2500000),
            'stock' => fake()->numberBetween(0, 150),
            'minimum_stock' => fake()->numberBetween(5, 15),
            'description' => fake()->sentence(),
        ];
    }
}
