<?php

namespace App\Modules\FeatureFlags\Exceptions;

use RuntimeException;

final class UnknownFeatureFlagException extends RuntimeException
{
    public static function forKey(string $key): self
    {
        return new self("Feature flag [{$key}] is not registered.");
    }
}
