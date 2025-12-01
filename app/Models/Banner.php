<?php

namespace App\Models;

use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends Model
{
    use HasStatus;
    use HasFactory;

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
