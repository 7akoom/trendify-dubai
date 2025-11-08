<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Color extends Model
{
    protected $fillable = ['name', 'hex'];

    public function hex(): Attribute
    {
        return Attribute::get(fn($value) => ltrim($value, '#'));
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
