<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'معلّق';
    case Processing = 'قيد التنفيذ';
    case Delivering = 'قيد التوصيل';
    case Completed = 'مكتمل';
    case Cancelled = 'ملغى';
    case Refunded = 'مرتجع';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function toSlug(self $theme): string
    {
        return match ($theme) {
            self::Pending => 'pending',
            self::Processing => 'processing',
            self::Delivering => 'delivering',
            self::Completed => 'completed',
            self::Cancelled => 'cancelled',
            self::Refunded => 'refunded',
        };
    }
}
