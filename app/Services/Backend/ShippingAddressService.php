<?php

namespace App\Services\Backend;

use App\Models\ShippingAddress;
use Illuminate\Support\Collection;

class ShippingAddressService
{
    public function all(): Collection
    {
        return ShippingAddress::with('order:id,order_number')
            ->select('id', 'order_id', 'first_name', 'last_name', 'email', 'phone', 'country', 'post_code', 'address1', 'address2')
            ->get();
    }

    public function create(array $data): ShippingAddress
    {
        return ShippingAddress::create($data);
    }

    public function update(ShippingAddress $address, array $data): ShippingAddress
    {
        $address->update($data);
        return $address;
    }

    public function delete(ShippingAddress $address): void
    {
        $address->delete();
    }
}
