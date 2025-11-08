<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    protected $fillable = [
        'order_id',
        'type',
        'first_name',
        'last_name',
        'email',
        'phone',
        'street_address',
        'state',
        'city',
        'country',
        'postal_code',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
