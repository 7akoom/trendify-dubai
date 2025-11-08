<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Pending = 'غير مدفوع';
    case Paid = 'مدفوع';
    case Failed = 'فشل';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function toSlug(self $theme): string
    {
        return match ($theme) {
            self::Pending => 'pending',
            self::Paid => 'paid',
            self::Failed => 'failed',
        };
    }
}
