<?php

namespace App\Enum;

enum HistoryType: string
{
    case Contract = 'CONTRACT';
    case User = 'USER';
    case Customer = 'CUSTOMER';
}
