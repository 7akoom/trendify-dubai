<?php

namespace App\Models;

use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasStatus;

    protected $fillable = [
        'title',
        'description',
        'status',
    ];

    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
