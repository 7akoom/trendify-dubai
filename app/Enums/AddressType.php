<?php

namespace App\Enums;

enum AddressType: string
{
    case Billing = 'دفع';
    case Shipping = 'شحن';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function toSlug(self $theme): string
    {
        return match ($theme) {
            self::Billing => 'billing',
            self::Shipping => 'shipping',
        };
    }

    public static function fromSlug(string $slug): self
    {
        return match ($slug) {
            'billing' => self::Billing,
            'shipping' => self::Shipping,
            default => throw new \InvalidArgumentException("Invalid Address Type: {$slug}"),
        };
    }
}
