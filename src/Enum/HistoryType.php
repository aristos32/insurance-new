<?php

namespace App\Enum;

enum HistoryType: string
{
    case Contract = 'CONTRACT';
    case User = 'USER';
    case Client = 'CLIENT';
}
