<?php

namespace App\Services\Backend;

use App\Models\{StoreHouse, ProductPrice, ProductVariant};

class StoreHouseService
{
    public function create(array $data): void
    {
        $productId = $data['product_id'];

        if ($data['use_variant_prices'] == 0) {
            ProductPrice::create([
                'product_id'     => $productId,
                'color_id'       => null,
                'size_id'        => null,
                'purchase_price' => $data['purchase_price'],
                'sale_price'     => $data['sale_price'],
            ]);

            StoreHouse::create([
                'product_id' => $productId,
                'color_id'   => null,
                'size_id'    => null,
                'qty'        => $data['qty'],
            ]);
        } else {
            foreach ($data['variants'] as $variant) {
                $colorId = $variant['color_id'] ?? null;
                $sizeId  = $variant['size_id'] ?? null;

                ProductVariant::firstOrCreate([
                    'product_id' => $productId,
                    'color_id'   => $colorId,
                    'size_id'    => $sizeId,
                ]);

                ProductPrice::create([
                    'product_id'     => $productId,
                    'color_id'       => $colorId,
                    'size_id'        => $sizeId,
                    'purchase_price' => $variant['purchase_price'],
                    'sale_price'     => $variant['sale_price'],
                ]);

                StoreHouse::create([
                    'product_id' => $productId,
                    'color_id'   => $colorId,
                    'size_id'    => $sizeId,
                    'qty'        => $variant['qty'],
                ]);
            }
        }
    }
}
