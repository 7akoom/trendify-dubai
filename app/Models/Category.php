<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasStatus;
    use HasFactory;

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
