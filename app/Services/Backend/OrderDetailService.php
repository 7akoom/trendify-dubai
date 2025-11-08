<?php

namespace App\Services\Backend;

use App\Models\OrderDetails;
use Illuminate\Support\Collection;

class OrderDetailService
{
    public function all(): Collection
    {
        return OrderDetails::with(['user:id,name', 'order:id,order_number', 'product:id,name'])
            ->select('id', 'user_id', 'order_id', 'product_id', 'quantity', 'price', 'amount')
            ->get();
    }

    public function create(array $data): OrderDetails
    {
        return OrderDetails::create($data);
    }

    public function update(OrderDetails $orderDetail, array $data): OrderDetails
    {
        $orderDetail->update($data);
        return $orderDetail;
    }

    public function delete(OrderDetails $orderDetail): void
    {
        $orderDetail->delete();
    }
}
