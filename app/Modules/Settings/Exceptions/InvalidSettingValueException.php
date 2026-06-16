<?php

namespace App\Modules\Settings\Exceptions;

use RuntimeException;

final class InvalidSettingValueException extends RuntimeException
{
    public static function forKey(string $key, string $reason): self
    {
        return new self("Setting [{$key}] is invalid: {$reason}");
    }
}
