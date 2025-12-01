<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'admin_id',
        'user_id',
        'type',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            1 => 'payment_status',
            2 => 'status',
        };
    }
}
