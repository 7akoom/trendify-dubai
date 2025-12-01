<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Department;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
             'department_id' => Department::inRandomOrder()->first()?->id ?? Department::factory(),
            'name' => $this->faker->words(2, true),
            'is_active' => 1,
        ];
    }
}
