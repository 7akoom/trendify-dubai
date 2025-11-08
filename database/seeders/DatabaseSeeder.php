<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\Setting;
use Illuminate\Database\Seeder;

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
    }
}
