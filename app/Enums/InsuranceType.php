<?php

namespace App\Enums;

use App\Enums\Concerns\TranslatesLabel;

enum InsuranceType: string
{
    use TranslatesLabel;
    case Motor = 'MOTOR';
    case Medical = 'MEDICAL';
    case Life = 'LIFE';
    case FireProperty = 'FIRE_PROPERTY';
    case EmployerLiability = 'EMPLOYER_LIABILITY';

    public function label(): string
    {
        return match ($this) {
            self::Motor => __('enums.insurance.motor'),
            self::Medical => __('enums.insurance.medical'),
            self::Life => __('enums.insurance.life'),
            self::FireProperty => __('enums.insurance.fire_property'),
            self::EmployerLiability => __('enums.insurance.employer_liability'),
        };
    }
}
