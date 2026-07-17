<?php

namespace App\Enums;

enum SaleStatus: string
{
    case Active = 'ACTIVE';
    case Cancelled = 'CANCELLED';
    case Expired = 'EXPIRED';
}
