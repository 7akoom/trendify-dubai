<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CartRepository implements CartRepositoryInterface
{
    protected $items;

    public function __construct()
    {
        $this->items = \collect([]);
    }

    protected function query()
    {
        $query = Cart::with(['product', 'user', 'featuredImage']);

        // if (Auth::check()) {
        //     $query->where('user_id', Auth::id());
        // } else {
        //     $cookieId = Cookie::get('cart_id');
        //     $query->where('cookie_id', $cookieId);
        // }
        $cookieId = Cookie::get('cart_id');
        $query->where('cookie_id', $cookieId);
        return $query;
    }

    public function get(): Collection
    {
        if (!$this->items->count()) {
            $this->items = $this->query()->get();
        }
        return $this->items;
    }

    public function count(): int
    {
        return $this->get()->count();
    }

    public function add(Product $product, $qty = 1)
    {
        $item = Cart::where('product_id', $product->id)->first();
        if (!$item) {
            return Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'qty' => $qty,
            ]);
            $this->get()->push($cart);
        }
        return $item->increment('qty', $qty);
    }

    public function update($id, $qty)
    {
        Cart::where('id', $id)
            ->update([
                'qty' => $qty,
            ]);
    }

    public function delete($id)
    {
        Cart::where('id', $id)->delete();
    }

    public function empty()
    {
        Cart::query()->delete();
    }

    public function total(): float
    {
        $subtotal = $this->get()->sum(function ($item) {
            $product = optional($item->product);
            $price   = optional($product->price);

            $discountPrice = $price->discount_price ?? 0;
            $salePrice     = $price->sale_price ?? 0;
            $isFeatured    = $product->is_featured ?? false;

            if ($isFeatured && $discountPrice > 0) {
                return $item->qty * $discountPrice;
            }
            return $item->qty * $salePrice;
        });

        $shipping = optional(\App\Models\Setting::first())->shipping_costs ?? 0.0;

        return $subtotal + $shipping;
    }

    public function totals(): array
    {
        $subtotal = $this->get()->sum(function ($item) {
            $product = optional($item->product);
            $price   = optional($product->price);

            $discountPrice = $price->discount_price ?? 0;
            $salePrice     = $price->sale_price ?? 0;
            $isFeatured    = $product->is_featured ?? false;

            if ($isFeatured && $discountPrice > 0) {
                return $item->qty * $discountPrice;
            }
            return $item->qty * $salePrice;
        });

        $shipping = $subtotal > 0 ? optional(\App\Models\Setting::first())->shipping_costs : 0.0;
        $total = $subtotal + $shipping;

        return [
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'total'    => $total,
        ];
    }
}
