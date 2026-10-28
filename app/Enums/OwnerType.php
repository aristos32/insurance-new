<?php

namespace App\Enums;

use App\Enums\Concerns\TranslatesLabel;

enum OwnerType: string
{
    use TranslatesLabel;

    case Account = 'account';
    case Lead = 'lead';

    public function label(): string
    {
        return match ($this) {
            self::Account => __('enums.owner_type.account'),
            self::Lead => __('enums.owner_type.lead'),
        };
    }
}
