<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
         Admin::create([
            'name' => 'Hkmt Ali',
            'email' => 'admin@gmail.com',
            'phone' => '07517065163',
            'password' => '151020019',
        ]);

        Setting::create([
            'email' => 'a7akoom96@gmail.com',
            'phone' => '07517065163',
            'facebook_url' => 'https://www.instagram.com',
            'instagram_url' => 'https://www.facebook.com',
            'address' => 'Dubai',
        ]);
        $this->faker = \Faker\Factory::create();

    \App\Models\Department::factory(10)->create();
    \App\Models\Category::factory(10)->create();
    \App\Models\Color::factory(10)->create();
    \App\Models\Size::factory(10)->create();

    \App\Models\Product::factory(10)->create();
    \App\Models\ProductPrice::factory(10)->create();

    // Product Sizes & Colors (unique)
    foreach (\App\Models\Product::all() as $product) {
        $product->sizes()->sync(\App\Models\Size::inRandomOrder()->take(rand(1, 5))->pluck('id'));
        $product->colors()->sync(\App\Models\Color::inRandomOrder()->take(rand(1, 5))->pluck('id'));
     for ($i = 0; $i < rand(1, 3); $i++) {

        $imagePath = 'products/' . \Str::uuid() . '.jpg';

        \Storage::disk('public')->put($imagePath, file_get_contents('https://picsum.photos/600/600'));

        \App\Models\Image::create([
            'imageable_id' => $product->id,
            'imageable_type' => \App\Models\Product::class,
            'path' => $imagePath,
            'is_featured' => $i === 0 ? 1 : 0,
        ]);
    }
    }

    \App\Models\Banner::factory(10)->create();
    \App\Models\User::factory(10)->create();

    \App\Models\Order::factory(10)->create();
    \App\Models\OrderAddress::factory(10)->create();

    // ✅ This prevents duplicate order details
    foreach (\App\Models\Order::all() as $order) {

        $products = \App\Models\Product::inRandomOrder()->take(rand(1, 4))->get();

        foreach ($products as $product) {

            $purchasePrice = $this->faker->randomFloat(2, 10, 200);
            $salePrice = $purchasePrice + rand(5, 50);
            $qty = rand(1, 5);

            \App\Models\OrderDetails::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'purchase_price' => $purchasePrice,
                'sale_price' => $salePrice,
                'quantity' => $qty,
                'amount' => $salePrice * $qty,
            ]);
        }
    }

    \App\Models\Review::factory(10)->create();
    \App\Models\Banner::factory(10)->withImages(1)->create();

     }
}
