<?php

namespace App\Services\Backend;

use App\Models\Color;
use Illuminate\Support\Collection;

class ColorService
{
    public function getAll(): Collection
    {
        return Color::select('id', 'name', 'hex', 'created_at')->get();
    }

    public function create(array $data): Color
    {
        return Color::create($data);
    }

    public function update(Color $color, array $data): Color
    {
        $color->update($data);
        return $color;
    }

    public function delete(Color $color): bool
    {
        if ($color->products()->exists()) {
            return false;
        }

        $color->delete();
        return true;
    }
}
