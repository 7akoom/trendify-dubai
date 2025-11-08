<?php

namespace App\Services\Backend;

use App\Models\Order;
use App\Models\OrderLog;
use Illuminate\Support\Collection;

class OrderLogService
{
    public function all(): Collection
    {
        return OrderLog::with('order:id,order_number')
            ->select('id', 'order_id', 'type', 'payment_status', 'status')
            ->get();
    }

    public function create(array $data): Order
    {
        $order = Order::create($data);

        // Optional: log initial status or payment_status
        OrderLog::create([
            'order_id' => $order->id,
            'type' => 'status', // or 'payment_status' depending on what you're tracking
            'status' => $order->status, // e.g., 'new'
            'payment_status' => $order->payment_status,
        ]);

        return $order;
    }

    public function update(Order $order, array $data): Order
    {
        $originalStatus = $order->status;
        $originalPaymentStatus = $order->payment_status;

        $order->update($data);

        // Check if `status` changed
        if (isset($data['status']) && $data['status'] !== $originalStatus) {
            OrderLog::create([
                'order_id' => $order->id,
                'type' => 'status',
                'status' => $data['status'],
            ]);
        }

        // Check if `payment_status` changed
        if (isset($data['payment_status']) && $data['payment_status'] !== $originalPaymentStatus) {
            OrderLog::create([
                'order_id' => $order->id,
                'type' => 'payment_status',
                'payment_status' => $data['payment_status'],
            ]);
        }

        return $order;
    }


    public function delete(OrderLog $orderLog): void
    {
        $orderLog->delete();
    }
}
