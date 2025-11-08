<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Order;
use App\Observers\OrderObserver;
use Illuminate\Support\Facades\App;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CartRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            \App\Repositories\CartRepositoryInterface::class,
            \App\Repositories\CartRepository::class,
        );
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        Order::observe(OrderObserver::class);

        View::composer('*', function ($view) {
            $cartRepo = app(CartRepositoryInterface::class);
            $totals = $cartRepo->totals();

            $view->with([
                'cartCount' => $cartRepo->count(),
                'cartSubTotal'  => $totals['subtotal'],
                'shippingCosts' => $totals['shipping'],
                'cartTotal'     => $totals['total'],
            ]);
        });
    }
}
