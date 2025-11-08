<?php

namespace App\Services\Backend;

use Exception;
use App\Models\Product;
use Illuminate\Support\Arr;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function all()
    {
        return Product::select('id', 'category_id', 'name', 'is_featured', 'is_active', 'is_new')
            ->with([
                'category:id,name',
                'featuredImage',
                'price'
            ])
            ->get();
    }

    public function create(array $data, array $images): Product
    {
        $storedPaths = [];

        try {
            return DB::transaction(function () use ($data, $images, &$storedPaths) {

                $productData = Arr::except($data, ['images', 'colors', 'sizes', 'purchase_price', 'sale_price']);

                $product = Product::create([
                    'category_id'  => $productData['category_id'],
                    'name'         => $productData['name'],
                    'description'  => $productData['description'],
                    'is_featured'  => $productData['is_featured'],
                    'is_active'    => $productData['is_active'],
                    'is_new'       => $productData['is_new'] ?? false,
                    'qty'          => $productData['qty'] ?? 0,
                ]);

                if (!empty($images)) {
                    $this->storeImages($product, $images, $storedPaths);
                }

                $product->price()->create([
                    'purchase_price' => $data['purchase_price'],
                    'sale_price'     => $data['sale_price'],
                    'discount_price'     => $data['discount_price'],
                ]);

                if (!empty($data['colors']) && is_array($data['colors'])) {
                    $colorIds = collect($data['colors'])->pluck('color_id')->filter()->toArray();
                    $product->colors()->sync($colorIds);
                }

                if (!empty($data['sizes']) && is_array($data['sizes'])) {
                    $sizeIds = collect($data['sizes'])->pluck('size_id')->filter()->toArray();
                    $product->sizes()->sync($sizeIds);
                }

                return $product;
            });
        } catch (Exception $e) {
            Log::error(['create product error' => $e->getMessage()]);

            foreach ($storedPaths as $path) {
                Storage::disk('public')->delete($path);
            }

            throw new Exception('فشل في إنشاء المنتج: ' . $e->getMessage());
        }
    }


    protected function storeImages(Product $product, array $images, array &$storedPaths): void
    {
        foreach ($images as $index => $file) {
            $path = $file->store("products", 'public');
            if (!$path) {
                throw new Exception("تعذّر رفع الصورة رقم {$index}.");
            }

            $storedPaths[] = $path;

            $product->images()->create([
                'path'        => $path,
                'is_featured' => ($index === 0),
            ]);
        }
    }

    public function update(Product $product, array $data, array $images): Product
    {
        $storedPaths = [];

        try {
            return DB::transaction(function () use ($product, $data, $images, &$storedPaths) {
                $productData = Arr::except($data, ['images', 'colors', 'sizes', 'purchase_price', 'sale_price']);

                $product->update([
                    'category_id'  => $productData['category_id'],
                    'name'         => $productData['name'],
                    'description'  => $productData['description'],
                    'is_featured'  => $productData['is_featured'],
                    'is_active'    => $productData['is_active'],
                    'is_new'       => $productData['is_new'] ?? false,
                    'qty'          => $productData['qty'] ?? 0,
                ]);

                if (!empty($data['images']) && is_array($data['images'])) {
                    $this->replaceImages($product, $data['images']);
                }
                if (isset($data['featured_image_id'])) {
                    $product->images()->update(['is_featured' => false]);
                    $product->images()
                        ->where('id', $data['featured_image_id'])
                        ->update(['is_featured' => true]);
                }

                if ($product->price) {
                    $product->price()->update([
                        'purchase_price' => $data['purchase_price'],
                        'sale_price'     => $data['sale_price'],
                        'discount_price' => $data['discount_price'],
                    ]);
                } else {
                    $product->price()->create([
                        'purchase_price' => $data['purchase_price'],
                        'sale_price'     => $data['sale_price'],
                        'discount_price' => $data['discount_price'],
                    ]);
                }

                if (!empty($data['colors']) && is_array($data['colors'])) {
                    $colorIds = collect($data['colors'])->pluck('color_id')->filter()->toArray();
                    if (!empty($colorIds)) {
                        $product->colors()->detach();
                        $product->colors()->attach($colorIds);
                    }
                }

                if (!empty($data['sizes']) && is_array($data['sizes'])) {
                    $sizeIds = collect($data['sizes'])->pluck('size_id')->filter()->toArray();
                    if (!empty($sizeIds)) {
                        $product->sizes()->detach();
                        $product->sizes()->attach($sizeIds);
                    }
                }

                return $product->fresh();
            });
        } catch (Exception $e) {
            Log::error(['update product error' => $e->getMessage()]);

            foreach ($storedPaths as $path) {
                Storage::disk('public')->delete($path);
            }

            throw new Exception('فشل في تعديل المنتج: ' . $e->getMessage());
        }
    }



    public function replaceImages(Product $product, array $images): void
    {
        // foreach ($product->images as $img) {
        //     Storage::disk('public')->delete($img->path);
        //     $img->delete();
        // }

        foreach ($images as $index => $image) {
            $path = $image->store('products', 'public');

            $product->images()->create([
                'path' => $path,
                'is_featured' => $index === 0,
            ]);
        }
    }


    public function delete(Product $product): void
    {
        foreach ($product->images as $image) {
            if (Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);
            }
        }

        $product->images()->delete();
        $product->delete();
    }
}
