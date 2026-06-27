<?php

namespace App\Enum;

enum UserStatus: string
{
    case Active = 'ACTIVE';
    case Suspended = 'SUSPENDED';
}
