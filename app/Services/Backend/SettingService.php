<?php

namespace App\Services\Backend;

use App\Models\Setting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class SettingService
{
    public function all(): ?Setting
    {
        return Setting::select('id', 'email', 'phone', 'address', 'facebook_url', 'instagram_url', 'shipping_costs')
            ->with('logo')->first();
    }

    public function create(array $data): Setting
    {
        return Setting::create($data);
    }

    public function update(Setting $setting, array $data): Setting
    {
        $setting->update($data);
        return $setting;
    }




    public function delete(Setting $setting): void
    {
        $setting->delete();
    }
}
