<?php

namespace App\Enum;

enum UserRole: int
{
    case Anonymous = 1;
    case Customer = 2;
    case Employee = 3;
    case Agent = 4;
    case Administrator = 5;
    case Super = 6;

    public function symfonyRole(): string
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

    public static function fromLegacy(string $value): self
    {
        return self::from((int) $value);
    }
}
