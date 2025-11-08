<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    protected $fillable = [
        'product_id',
        'purchase_price',
        'sale_price',
        'discount_price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
