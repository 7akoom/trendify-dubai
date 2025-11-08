<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasStatus;

class Category extends Model
{
    use HasStatus;

    protected $fillable = ['department_id', 'name', 'is_active'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
