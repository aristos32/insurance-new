<?php

namespace App\Enum;

enum InsuranceType: string
{
    case Motor = 'MOTOR';
    case Medical = 'MEDICAL';
    case Life = 'LIFE';
    case FireProperty = 'FIRE_PROPERTY';
    case EmployerLiability = 'EMPLOYER_LIABILITY';
}
