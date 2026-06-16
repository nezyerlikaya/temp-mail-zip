<?php

namespace App\Modules\Localization\Exceptions;

use RuntimeException;

final class UnsupportedLocaleException extends RuntimeException
{
    public static function forLocale(string $locale): self
    {
        return new self("Locale [{$locale}] is not supported.");
    }
}
