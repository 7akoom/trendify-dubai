<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Banner;
use App\Services\Backend\BannerService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Banner\StoreBannerRequest;
use App\Http\Requests\Banner\UpdateBannerRequest;

class BannerController extends Controller
{
    public function __construct(private BannerService $service) {}

    public function index()
    {
        $banners = $this->service->all();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(StoreBannerRequest $request)
    {
        $data = $request->validated();
        $image = $request->file('image');

        try {
            $this->service->create($data, $image);
            return redirect()
                ->route('admin.banners.index')
                ->with('success', 'تم إنشاء اللافتة بنجاح');
        } catch (Exception $e) {
            Log::error(['create product error' => $e->getMessage()]);
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'حدث خطأ غير متوقع');
        }
    }

    public function show(Banner $banner)
    {
        return view('admin.banners.show', compact('banner'));
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(UpdateBannerRequest $request, Banner $banner)
    {
        $this->service->update($banner, $request->validated());
        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner updated.');
    }

    public function destroy(Banner $banner)
    {
        $this->service->delete($banner);
        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner deleted.');
    }
}
