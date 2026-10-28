<?php

namespace App\Enums;

use App\Enums\Concerns\TranslatesLabel;

enum SaleStatus: string
{
    use TranslatesLabel;

    case Active = 'ACTIVE';
    case Cancelled = 'CANCELLED';
    case Expired = 'EXPIRED';

    public function label(): string
    {
        return match ($this) {
            self::Active => __('enums.sale_status.active'),
            self::Cancelled => __('enums.sale_status.cancelled'),
            self::Expired => __('enums.sale_status.expired'),
        };
    }
}
