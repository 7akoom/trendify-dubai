<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductColor extends Model
{    
    use HasFactory;

    protected $fillable = [
        'product_id',
        'color_id',
    ];

    public function color()
    {
        return $this->belongsTo(Color::class);
    }
}
