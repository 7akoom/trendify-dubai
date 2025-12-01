<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Color extends Model
{
    use HasFactory;

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
