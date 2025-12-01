<?php

namespace Database\Factories;

use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
          return [
            'order_number' => 'ORD-' . $this->faker->unique()->numerify('#####'),
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'discount' => $this->faker->randomFloat(2, 0, 20),
            'total' => $this->faker->randomFloat(2, 20, 1000),
            'payment_method' => $this->faker->randomElement(['cash', 'card']),
            'payment_status' => 'مدفوع',
            'status' => 'مكتمل',
        ];
    }
}
