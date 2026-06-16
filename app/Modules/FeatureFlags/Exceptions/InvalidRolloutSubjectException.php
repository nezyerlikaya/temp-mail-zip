<?php

namespace App\Modules\FeatureFlags\Exceptions;

use InvalidArgumentException;

final class InvalidRolloutSubjectException extends InvalidArgumentException
{
    public static function forSubject(): self
    {
        return new self('Rollout subject keys must be stable non-PII identifiers.');
    }
}
