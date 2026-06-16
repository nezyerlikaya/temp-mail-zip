<?php

namespace App\Modules\Settings\Exceptions;

use RuntimeException;

final class SettingPersistenceMismatchException extends RuntimeException
{
    public static function forKey(string $key): self
    {
        return new self("Stored setting [{$key}] does not match its registered definition.");
    }
}
