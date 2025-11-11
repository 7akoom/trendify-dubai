<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

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
             'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(8),
            'is_featured' => $this->faker->boolean(),
            'is_active' => 1,
            'is_new' => $this->faker->boolean(),
            'qty' => $this->faker->numberBetween(5, 100),
        ];
    }
}
