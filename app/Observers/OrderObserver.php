<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\OrderLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class OrderObserver
{
    public function created(Order $order): void
    {
        //
    }

    public function updated(Order $order)
    {
        $oldStatus = $order->getOriginal('status');
        $oldPaymentStatus = $order->getOriginal('payment_status');
        $adminId = Auth::guard('admin')->id();
        $userId = Auth::guard('web')->id();

        if ($oldStatus !== $order->status) {
            OrderLog::create([
                'order_id' => $order->id,
                'admin_id' => $adminId,
                'user_id' => $userId,
                'type' => 2,
                'status' => $order->status,
            ]);
        }

        if ($oldPaymentStatus !== $order->payment_status) {
            OrderLog::create([
                'order_id' => $order->id,
                'admin_id' => $adminId,
                'type' => 1,
                'status' => $order->payment_status,
            ]);
        }
    }

    public function deleted(Order $order): void
    {
        //
    }

    public function restored(Order $order): void
    {
        //
    }

    public function forceDeleted(Order $order): void
    {
        //
    }
}
