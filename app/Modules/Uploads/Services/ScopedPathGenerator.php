<?php

namespace App\Modules\Uploads\Services;

use App\Modules\Uploads\Data\UploadScope;
use App\Modules\Uploads\Exceptions\InvalidUploadException;
use Illuminate\Support\Str;

final class ScopedPathGenerator
{
    public function generate(UploadScope $scope, string $extension): string
    {
        $extension = strtolower($extension);

        if (preg_match('/^[a-z0-9]+$/', $extension) !== 1) {
            throw InvalidUploadException::forReason('Unsafe upload extension.');
        }

        $path = $scope->directory.'/'.now()->format('Y/m').'/'.Str::uuid()->toString().'.'.$extension;

        if (str_starts_with($path, '/') || str_contains($path, '..') || str_contains($path, '\\')) {
            throw InvalidUploadException::forReason('Unsafe generated upload path.');
        }

        return $path;
    }
}
