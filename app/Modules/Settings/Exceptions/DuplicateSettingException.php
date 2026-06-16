<?php

namespace App\Modules\Settings\Exceptions;

use RuntimeException;

final class DuplicateSettingException extends RuntimeException
{
    public static function forKey(string $key): self
    {
        return new self("Setting [{$key}] is already registered.");
    }
}
