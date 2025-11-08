<?php

namespace App\Services\Backend;

use App\Models\Order;
use App\Enums\OrderStatus;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function all(): Collection
    {
        return Order::with('user:id,name')->get();
    }

    public function show(Order $order)
    {
        $order->load(['user', 'products', 'billingAddress', 'orderDetails', 'shippingAddress']);
        return $order;
    }

    public function updateOrder(Order $order, array $data): ?Order
    {
        DB::beginTransaction();
        try {
            $order->update([
                'user_id' => $order->user_id,
                'order_number' => $data['order_number'],
                'discount' => $data['discount'] ?? null,
                'total' => $data['total'],
                'notes' => $data['notes'] ?? null,
                'payment_method' => $data['payment_method'] ?? 'cod',
                'payment_status' => $data['payment_status'],
                'status' => $data['status'],
            ]);

            DB::commit();
            return $order;
        } catch (\Throwable $th) {
            Log::error(['error' => $th->getMessage()]);
            DB::rollBack();
            return null;
        }
    }

    public function userOrders(): Collection
    {
        return Order::with('user:id,name')
            ->where('user_id', Auth::id())->get();
    }

    public function cancellOrder(Order $order): ?Order
    {
        if ($order->status !== OrderStatus::Pending->value) {
            return null;
        }

        DB::beginTransaction();
        try {
            $order->update([
                'status' => OrderStatus::Cancelled->value,
            ]);

            DB::commit();
            return $order;
        } catch (\Throwable $th) {
            Log::error(['error' => $th->getMessage()]);
            DB::rollBack();
            return null;
        }
    }

    public function deleteOrder(Order $order): bool
    {
        DB::beginTransaction();

        try {

            $order->delete();

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error deleting order: ' . $th->getMessage());
            return false;
        }
    }
}
