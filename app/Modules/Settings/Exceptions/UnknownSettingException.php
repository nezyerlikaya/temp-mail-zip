<?php

namespace App\Modules\Settings\Exceptions;

use RuntimeException;

final class UnknownSettingException extends RuntimeException
{
    public static function forKey(string $key): self
    {
        return new self("Setting [{$key}] is not registered.");
    }
}
