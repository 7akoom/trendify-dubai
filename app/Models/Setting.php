<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
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
