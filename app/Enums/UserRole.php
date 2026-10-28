<?php

namespace App\Enums;

use App\Enums\Concerns\TranslatesLabel;

enum UserRole: string
{
    use TranslatesLabel;
    case Anonymous = '1';
    case Customer = '2';
    case Employee = '3';
    case Agent = '4';
    case Administrator = '5';
    case Super = '6';

    public function label(): string
    {
        return match ($this) {
            self::Anonymous => __('enums.role.anonymous'),
            self::Customer => __('enums.role.customer'),
            self::Employee => __('enums.role.employee'),
            self::Agent => __('enums.role.agent'),
            self::Administrator => __('enums.role.administrator'),
            self::Super => __('enums.role.super'),
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
