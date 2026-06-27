<?php

namespace App\Enum;

enum SaleStatus: string
{
    case Active = 'ACTIVE';
    case Cancelled = 'CANCELLED';
    case Expired = 'EXPIRED';
}
