<?php

namespace App\Http\Controllers\Admin;

use App\Models\Size;
use App\Services\Backend\SizeService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Size\{StoreSizeRequest, UpdateSizeRequest};

class SizeController extends Controller
{
    public function __construct(private SizeService $service) {}

    public function index()
    {
        $sizes = $this->service->getAll();
        return view('admin.sizes.index', compact('sizes'));
    }

    public function create()
    {
        return view('admin.sizes.create');
    }

    public function store(StoreSizeRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()
            ->route('admin.sizes.index')
            ->with('success', 'تم إضافة المقاس بنجاح');
    }

    public function edit(Size $size)
    {
        return view('admin.sizes.edit', compact('size'));
    }

    public function update(UpdateSizeRequest $request, Size $size)
    {
        $this->service->update($size, $request->validated());
        return redirect()
            ->route('admin.sizes.index')
            ->with('success', 'تم تحديث المقاس بنجاح');
    }

    public function destroy(Size $size)
    {
        if (! $this->service->delete($size)) {
            return redirect()
                ->route('admin.sizes.index')
                ->with('error', 'هذا المقاس يحتوي على منتجات مرتبطة ولا يمكن حذفه.');
        }

        return redirect()
            ->route('admin.sizes.index')
            ->with('success', 'تم حذف المقاس بنجاح.');
    }
}
