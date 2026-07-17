<?php

namespace App\Enums;

enum UserRole: string
{
    case Anonymous = '1';
    case Customer = '2';
    case Employee = '3';
    case Agent = '4';
    case Administrator = '5';
    case Super = '6';

    public function label(): string
    {
        return match ($this) {
            self::Anonymous => 'Anonymous',
            self::Customer => 'Customer',
            self::Employee => 'Employee',
            self::Agent => 'Agent',
            self::Administrator => 'Administrator',
            self::Super => 'Super',
        };
    }

    public function laravelRole(): string
    {
        return match ($this) {
            self::Anonymous => 'ROLE_ANONYMOUS',
            self::Customer => 'ROLE_CUSTOMER',
            self::Employee => 'ROLE_EMPLOYEE',
            self::Agent => 'ROLE_AGENT',
            self::Administrator => 'ROLE_ADMIN',
            self::Super => 'ROLE_SUPER',
        };
    }

    public function atLeast(self $minimum): bool
    {
        return (int) $this->value >= (int) $minimum->value;
    }
}
