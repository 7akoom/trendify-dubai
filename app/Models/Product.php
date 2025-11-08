<?php

namespace App\Models;

use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasStatus;

    protected $preventLazyLoading = true;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'discount',
        'is_featured',
        'is_active',
        'is_new',
        'qty',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function featuredImage()
    {
        return $this->morphOne(Image::class, 'imageable')
            ->where('is_featured', 1);
    }

    public function price()
    {
        return $this->hasOne(ProductPrice::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_colors');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_sizes');
    }
}
