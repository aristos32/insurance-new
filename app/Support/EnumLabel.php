<?php

namespace App\Support;

final class EnumLabel
{
    public static function get(string $group, ?string $value): string
    {
        if ($value === null || $value === '') {
            return '';
        }

        $key = 'enums.'.$group.'.'.strtolower($value);
        $label = __($key);

        return $label === $key ? $value : $label;
    }
}
