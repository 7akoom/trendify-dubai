<?php

namespace App\Observers;

use App\Models\Cart;
use Illuminate\Support\Str;

class CartObserver
{

    public function creating(Cart $cart): void
    {
        $cart->id = Str::uuid();
        $cart->cookie_id = Cart::getCookieId();
    }


    public function updated(Cart $cart): void
    {
        //
    }


    public function deleted(Cart $cart): void
    {
        //
    }


    public function restored(Cart $cart): void
    {
        //
    }


    public function forceDeleted(Cart $cart): void
    {
        //
    }
}
