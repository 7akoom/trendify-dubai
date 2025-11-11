<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductPrice>
 */
class ProductPriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         $sale = $this->faker->randomFloat(2, 10, 500);
        return [
            'product_id' => Product::inRandomOrder()->first()?->id ?? Product::factory(),
            'purchase_price' => $sale - 5,
            'sale_price' => $sale,
            'discount_price' => $this->faker->boolean() ? $sale - 10 : null,
        ];
    }
}
