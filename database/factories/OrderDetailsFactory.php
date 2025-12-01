<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrderDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
          $product = Product::inRandomOrder()->first() ?? Product::factory();

        return [
            'order_id' => Order::inRandomOrder()->first()?->id ?? Order::factory(),
            'product_id' => $product->id,
            'product_name' => $product->name,
            'purchase_price' => $this->faker->randomFloat(2, 5, 200),
            'sale_price' => $this->faker->randomFloat(2, 10, 300),
            'quantity' => $this->faker->numberBetween(1, 5),
            'amount' => $this->faker->randomFloat(2, 30, 500),
        ];
    }
}
