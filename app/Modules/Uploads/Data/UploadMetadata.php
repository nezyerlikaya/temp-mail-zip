<?php

namespace App\Modules\Uploads\Data;

use App\Modules\Uploads\Enums\UploadVisibility;

final readonly class UploadMetadata
{
    public function __construct(
        public string $scope,
        public string $disk,
        public UploadVisibility $visibility,
        public string $originalName,
        public string $generatedName,
        public string $relativePath,
        public int $sizeBytes,
        public string $mimeType,
        public string $extension,
        public string $sha256,
        public ?int $width = null,
        public ?int $height = null,
    ) {
    }

    /**
     * @return array<string, int|string|null>
     */
    public function toSafeArray(): array
    {
        return [
            'scope' => $this->scope,
            'disk' => $this->disk,
            'visibility' => $this->visibility->value,
            'original_name' => $this->originalName,
            'generated_name' => $this->generatedName,
            'relative_path' => $this->relativePath,
            'size_bytes' => $this->sizeBytes,
            'mime_type' => $this->mimeType,
            'extension' => $this->extension,
            'sha256' => $this->sha256,
            'width' => $this->width,
            'height' => $this->height,
        ];
    }
}
