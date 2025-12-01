<?php

namespace App\Services\Front;

use App\Models\Order;
use App\Enums\AddressType;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\DB;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Repositories\CartRepositoryInterface;

class OrderService
{
    public function __construct(private CartRepositoryInterface $cartRepo) {}

    public function storeOrder(array $data): ?Order
    {
        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'payment_method' => $data['payment_method'],
                'discount' => $data['discount'] ?? null,
                'total' => $data['total'],
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($this->cartRepo->get() as $item) {
                $unitPrice = $item->product->is_featured
                    ? ($item->product->price->discount_price ?? $item->product->price->sale_price)
                    : $item->product->price->sale_price;

                $amount = $unitPrice * $item->qty;

                OrderDetails::create([
                    'order_id'       => $order->id,
                    'product_id'     => $item->product_id,
                    'product_name'   => $item->product->name,
                    'purchase_price' => $item->product->price->purchase_price,
                    // 'discount_price' => $item->product->price->discount_price ?? 0,
                    'sale_price'     => $unitPrice,
                    'quantity'       => $item->qty,
                    'amount'         => $amount,
                ]);
            }


            foreach ($data['addr'] as $type => $address) {
                $address['type'] = AddressType::fromSlug($type)->value;
                $order->addresses()->create($address);
            }

            $this->cartRepo->empty();

            DB::commit();
            $billingAddress = $order->addresses()->where('type', AddressType::Billing)->first();

            if ($billingAddress && isset($billingAddress->email)) {
                Mail::to($billingAddress->email)->send(new OrderConfirmationMail($order));
            }
            return $order;
        } catch (\Throwable $th) {
            Log::error(['error' => $th->getMessage()]);
            DB::rollBack();
            return null;
        }
    }
}
