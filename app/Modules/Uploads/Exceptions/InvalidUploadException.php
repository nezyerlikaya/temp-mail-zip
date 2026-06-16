<?php

namespace App\Modules\Uploads\Exceptions;

use RuntimeException;

final class InvalidUploadException extends RuntimeException
{
    public static function forReason(string $reason): self
    {
        return new self($reason);
    }
}
