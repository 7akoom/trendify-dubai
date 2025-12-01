<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'phone',
        'address',
        'facebook_url',
        'instagram_url',
        'shipping_costs'
    ];

    public function logo()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
