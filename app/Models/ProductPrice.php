<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductPrice extends Model
{   
     use HasFactory;

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
