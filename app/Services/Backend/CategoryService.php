<?php

namespace App\Services\Backend;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryService
{
    public function all(): Collection
    {
        return Category::select('id', 'department_id', 'name', 'is_active', 'created_at')
            ->with(['department:id,name'])
            ->get();
    }

    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function update(Category $category, array $data): Category
    {
        $category->update($data);
        return $category;
    }

    public function delete(Category $category): bool
    {
        if ($category->products()->exists()) {
            return false;
        }

        $category->delete();
        return true;
    }
}
