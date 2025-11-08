<?php

namespace App\Models;

use App\Traits\HasStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasStatus;

    protected $fillable = [
        'user_id',
        'discount',
        'total',
        'payment_method',
        'payment_status',
        'status',
        'sub_total',
        'discount',
        'total',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Anonymous'
        ]);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_details')
            ->using(OrderDetails::class)
            ->withPivot([
                'product_name',
                'purchase_price',
                // 'discount_price',
                'sale_price',
                'quantity',
                'amount',
            ]);
    }

    protected static function booted()
    {
        static::creating(function (Order $order) {
            $order->order_number = Order::getNextOrderNumber();
        });
    }

    public static function getNextOrderNumber()
    {
        $year = Carbon::now()->year;
        $last_number = Order::whereYear('created_at', $year)->max('order_number');
        if ($last_number) {
            return $last_number + 1;
        }
        return $year . '0001';
    }

    public function addresses()
    {
        return $this->hasMany(OrderAddress::class);
    }

    public function billingAddress()
    {
        return $this->hasOne(OrderAddress::class, 'order_id', 'id')
            ->where('type', 'دفع');
    }

    public function shippingAddress()
    {
        return $this->hasOne(OrderAddress::class, 'order_id', 'id')
            ->where('type', 'شحن');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class);
    }
}
