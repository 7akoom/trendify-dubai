<?php

namespace App\Services\Backend;

use Exception;
use App\Models\Banner;
use Illuminate\Support\Arr;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BannerService
{
    public function all(): Collection
    {
        return Banner::select('id', 'title', 'description', 'status')
            ->with('images')->get();
    }

    public function create(array $data, UploadedFile $image): Banner
    {
        $storedPath = null;

        try {
            return DB::transaction(
                function () use ($data, $image, &$storedPath) {
                    $bannerData = Arr::except($data, 'image');
                    $banner = Banner::create([
                        'title'  => $bannerData['title'],
                        'description'  => $bannerData['description'],
                        'status'    => $bannerData['status'],
                    ]);

                    if ($image) {
                        $this->storeImage($banner, $image, $storedPath);
                    }
                    return $banner;
                }
            );
        } catch (Exception $e) {
            Log::error(['create product error' => $e->getMessage()]);

            if ($storedPath) {
                Storage::disk('public')->delete($storedPath);
            }

            throw new Exception('فشل في إنشاء المنتج: ' . $e->getMessage());
        }
    }

    protected function storeImage(Banner $banner, UploadedFile $image, ?string &$storedPath): void
    {
        $path = $image->store("banners", 'public');
        if (!$path) {
            throw new Exception("تعذّر رفع الصورة.");
        }
        $storedPath = $path;

        $banner->images()->create([
            'path'        => $path,
            'is_featured' => false,
        ]);
    }

    public function update(Banner $banner, array $data): Banner
    {
        return DB::transaction(function () use ($banner, $data) {
            if (!empty($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $this->replaceImage($banner, $data['image']);
            }

            $banner->update(
                Arr::except($data, 'image')
            );

            return $banner->refresh();
        });
    }

    public function replaceImage(Banner $banner, UploadedFile $image): void
    {
        if ($banner->images) {
            Storage::disk('public')->delete($banner->images->path);
            $banner->images()->delete();
        }

        $path = $image->store('banners', 'public');

        $banner->images()->create([
            'path' => $path,
            'is_featured' => false,
        ]);
    }




    public function delete(Banner $banner): void
    {
        if ($banner->images) {
            Storage::disk('public')->delete($banner->images->path);
            $banner->images()->delete();
        }

        $banner->delete();
    }
}
