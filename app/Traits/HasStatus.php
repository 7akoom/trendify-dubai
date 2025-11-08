<?php

namespace App\Traits;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasStatus
{

    public function statusLabel(): Attribute
    {
        return new Attribute(
            get: fn() => $this->is_active ? 'مفعلة' : 'غير مفعلة'
        );
    }

    public function statusBadgeClass(): Attribute
    {
        return new Attribute(
            get: fn() => $this->is_active
                ? 'bg-gradient-success'
                : 'bg-gradient-danger'
        );
    }

    public function isActiveLabel(): Attribute
    {
        return new Attribute(
            get: fn() => $this->status ? 'مفعلة' : 'غير مفعلة'
        );
    }

    public function isActiveBadgeClass(): Attribute
    {
        return new Attribute(
            get: fn() => $this->status
                ? 'bg-gradient-success'
                : 'bg-gradient-danger'
        );
    }

    public function orderStatusBadgeClass(): Attribute
    {
        return new Attribute(
            get: function () {
                return match ($this->status) {
                    OrderStatus::Pending->value => 'bg-warning',
                    OrderStatus::Processing->value, OrderStatus::Delivering->value => 'bg-gradient-secondary',
                    OrderStatus::Completed->value => 'bg-gradient-success',
                    OrderStatus::Cancelled->value, OrderStatus::Refunded->value => 'bg-gradient-danger',
                    default => 'bg-gradient-gray',
                };
            }
        );
    }
}
