<?php

namespace App\Modules\FeatureFlags\Exceptions;

use RuntimeException;

final class DuplicateFeatureFlagException extends RuntimeException
{
    public static function forKey(string $key): self
    {
        return new self("Feature flag [{$key}] is already registered.");
    }
}
