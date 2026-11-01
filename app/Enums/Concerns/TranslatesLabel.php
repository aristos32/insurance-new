<?php

namespace App\Enums\Concerns;

trait TranslatesLabel
{
    public static function labelFor(?string $value): string
    {
        $case = self::tryFrom((string) $value);

        return $case?->label() ?? (string) $value;
    }
}
