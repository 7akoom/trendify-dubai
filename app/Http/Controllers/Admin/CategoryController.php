<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Department;
use App\Services\Backend\CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $service) {}

    public function index()
    {
        $categories = $this->service->all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('admin.categories.create', compact('departments'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'تم إضافة الفئة بنجاح');
    }

    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $departments = Department::select('id', 'name')->get();
        return view('admin.categories.edit', compact('category', 'departments'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->service->update($category, $request->validated());
        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'تم تحديث الفئة بنجاح');
    }

    public function destroy(Category $category)
    {
        if (! $this->service->delete($category)) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'هذه الفئة تحتوي على منتجات مرتبطة ولا يمكن حذفها.');
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'تم حذف الفئة بنجاح.');
    }
}
