<?php

namespace App\Enums;

enum InsuranceType: string
{
    case Motor = 'MOTOR';
    case Medical = 'MEDICAL';
    case Life = 'LIFE';
    case FireProperty = 'FIRE_PROPERTY';
    case EmployerLiability = 'EMPLOYER_LIABILITY';

    public function label(): string
    {
        return match ($this) {
            self::Motor => 'Motor',
            self::Medical => 'Medical',
            self::Life => 'Life',
            self::FireProperty => 'Fire / Property',
            self::EmployerLiability => 'Employer Liability',
        };
    }
}
