<?php

namespace App\Modules\Translation\Exceptions;

use RuntimeException;

final class UnknownTranslationNamespaceException extends RuntimeException
{
    public static function forNamespace(string $namespace): self
    {
        return new self("Translation namespace [{$namespace}] is not registered.");
    }
}
