<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
            'name' => $this->faker->word(), // Random product name
            'price' => $this->faker->randomFloat(2, 1000, 10000), // Price between 1000-10000
            'sale_price' => $this->faker->randomFloat(2, 500, 9000), // Discounted price
            'image' => $this->faker->imageUrl(640, 480, 'products', true), // Random product image URL
            'stock' => $this->faker->numberBetween(0, 1000), // Stock quantity
            'category_id' => Category::pluck('id')->random(), // Random category ID
        ];
    }
}
