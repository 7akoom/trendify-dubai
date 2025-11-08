<?php

namespace App\Services\Backend;

use App\Models\Size;
use Illuminate\Support\Collection;

class SizeService
{
    public function getAll(): Collection
    {
        return Size::select('id', 'name', 'created_at')->get();
    }

    public function create(array $data): Size
    {
        return Size::create($data);
    }

    public function update(Size $size, array $data): Size
    {
        $size->update($data);
        return $size;
    }

    public function delete(Size $size): bool
    {
        if ($size->products()->exists()) {
            return false;
        }

        $size->delete();
        return true;
    }
}
