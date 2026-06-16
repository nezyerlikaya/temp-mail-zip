<?php

namespace App\Modules\Uploads\Data;

use App\Modules\Uploads\Enums\UploadVisibility;
use InvalidArgumentException;

final readonly class UploadScope
{
    /**
     * @param list<string> $allowedExtensions
     * @param list<string> $allowedMimeTypes
     */
    public function __construct(
        public string $key,
        public string $owner,
        public string $directory,
        public UploadVisibility $visibility,
        public int $maxSizeBytes,
        public array $allowedExtensions,
        public array $allowedMimeTypes,
        public int $maxWidth,
        public int $maxHeight,
    ) {
        if (preg_match('/^[a-z][a-z0-9_]*$/', $this->key) !== 1) {
            throw new InvalidArgumentException('Upload scope keys must be lowercase identifiers.');
        }

        if (preg_match('/^[a-z][a-z0-9_\/-]*$/', $this->directory) !== 1 || str_contains($this->directory, '..')) {
            throw new InvalidArgumentException('Upload scope directories must be safe relative paths.');
        }

        if ($this->maxSizeBytes <= 0 || $this->maxWidth <= 0 || $this->maxHeight <= 0) {
            throw new InvalidArgumentException('Upload limits must be positive.');
        }
    }
}
