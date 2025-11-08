<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Services\Backend\DepartmentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Department\{StoreDepartmentRequest, UpdateDepartmentRequest};

class DepartmentController extends Controller
{
    public function __construct(private DepartmentService $service) {}

    public function index()
    {
        $departments = $this->service->getAll();
        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.departments.create');
    }

    public function store(StoreDepartmentRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'تم إضافة القسم بنجاح');
    }

    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $this->service->update($department, $request->validated());
        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'تم تحديث القسم بنجاح');
    }

    public function destroy(Department $department)
    {
        if (! $this->service->delete($department)) {
            return redirect()
                ->route('admin.departments.index')
                ->with('error', 'هذا القسم يحتوي على فئات مرتبطة ولا يمكن حذفه.');
        }

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'تم حذف القسم بنجاح.');
    }
}
