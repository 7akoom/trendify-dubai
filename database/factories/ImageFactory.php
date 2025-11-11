<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition()
    {
        // Create and store a fake image in storage/app/public/banners
        $imagePath = 'banners/' . $this->faker->unique()->uuid() . '.jpg';

        Storage::disk('public')->put($imagePath, file_get_contents("https://picsum.photos/800/400"));

        return [
            'path' => $imagePath,
            'is_featured' => $this->faker->boolean(),
        ];
    }
}