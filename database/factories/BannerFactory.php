<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BannerFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->sentence(8),
            'status' => 1,
        ];
    }

    public function withImages($count = 1)
    {
        return $this->afterCreating(function ($banner) use ($count) {
            \App\Models\Image::factory($count)->create([
                'imageable_id' => $banner->id,
                'imageable_type' => \App\Models\Banner::class,
            ]);
        });
    }
}