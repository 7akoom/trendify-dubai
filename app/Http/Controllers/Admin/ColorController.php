<?php

namespace App\Http\Controllers\Admin;

use App\Models\Color;
use App\Services\Backend\ColorService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Color\{StoreColorRequest, UpdateColorRequest};

class ColorController extends Controller
{
    public function __construct(private ColorService $service) {}

    public function index()
    {
        $colors = $this->service->getAll();
        return view('admin.colors.index', compact('colors'));
    }

    public function create()
    {
        return view('admin.colors.create');
    }

    public function store(StoreColorRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()
            ->route('admin.colors.index')
            ->with('success', 'تم إضافة اللون بنجاح');
    }

    public function edit(Color $color)
    {
        return view('admin.colors.edit', compact('color'));
    }

    public function update(UpdateColorRequest $request, Color $color)
    {
        $this->service->update($color, $request->validated());
        return redirect()
            ->route('admin.colors.index')
            ->with('success', 'تم تحديث اللون بنجاح');
    }

    public function destroy(Color $color)
    {
        if (! $this->service->delete($color)) {
            return redirect()
                ->route('admin.colors.index')
                ->with('error', 'هذا اللون يحتوي على منتجات مرتبطة ولا يمكن حذفه.');
        }

        return redirect()
            ->route('admin.colors.index')
            ->with('success', 'تم حذف القسم بنجاح.');
    }
}
