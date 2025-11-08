<?php

namespace App\Services\Backend;

use App\Models\Department;
use Illuminate\Support\Collection;
use Exception;

class DepartmentService
{
    public function getAll(): Collection
    {
        return Department::select('id', 'name', 'created_at')->get();
    }

    public function create(array $data): Department
    {
        return Department::create($data);
    }

    public function update(Department $department, array $data): Department
    {
        $department->update($data);
        return $department;
    }

    public function delete(Department $department): bool
    {
        if ($department->categories()->exists()) {
            return false;
        }

        $department->delete();
        return true;
    }
}
