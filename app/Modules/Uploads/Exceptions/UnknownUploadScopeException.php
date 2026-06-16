<?php

namespace App\Modules\Uploads\Exceptions;

use RuntimeException;

final class UnknownUploadScopeException extends RuntimeException
{
    public static function forScope(string $scope): self
    {
        return new self("Upload scope [{$scope}] is not registered.");
    }
}
