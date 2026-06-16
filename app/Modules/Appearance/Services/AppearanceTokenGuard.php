<?php

namespace App\Modules\Appearance\Services;

use App\Modules\Appearance\Exceptions\UnsafeAppearanceValueException;

final class AppearanceTokenGuard
{
    /**
     * @param list<string> $allowedValues
     */
    public function assertAllowed(string $value, array $allowedValues): string
    {
        if (str_contains($value, '<') || str_contains($value, '>') || str_contains($value, '{') || str_contains($value, ';')) {
            throw new UnsafeAppearanceValueException('Arbitrary HTML, CSS, and JavaScript are not allowed in Appearance values.');
        }

        if (! in_array($value, $allowedValues, true)) {
            throw new UnsafeAppearanceValueException('Appearance value is not in the approved token list.');
        }

        return $value;
    }
}
