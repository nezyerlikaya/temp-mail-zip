<?php

namespace App\Modules\Navigation\Exceptions;

use RuntimeException;

final class DuplicateNavigationItemException extends RuntimeException
{
    public static function forKey(string $key): self
    {
        return new self("Navigation item [{$key}] is already registered.");
    }
}
