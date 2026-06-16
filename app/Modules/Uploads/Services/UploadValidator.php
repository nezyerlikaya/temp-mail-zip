<?php

namespace App\Modules\Uploads\Services;

use App\Modules\Uploads\Data\UploadMetadata;
use App\Modules\Uploads\Data\UploadScope;
use App\Modules\Uploads\Exceptions\InvalidUploadException;
use Illuminate\Http\UploadedFile;

final class UploadValidator
{
    public function __construct(
        private readonly UploadScopeRegistry $scopes = new UploadScopeRegistry(),
        private readonly FilenameSanitizer $filenames = new FilenameSanitizer(),
        private readonly ScopedPathGenerator $paths = new ScopedPathGenerator(),
    ) {
    }

    public function validate(string $scopeKey, UploadedFile $file): UploadMetadata
    {
        $scope = $this->scopes->get($scopeKey);

        if (! $file->isValid()) {
            throw InvalidUploadException::forReason('Uploaded file is not valid.');
        }

        $size = (int) $file->getSize();

        if ($size <= 0 || $size > $scope->maxSizeBytes) {
            throw InvalidUploadException::forReason('Uploaded file size is not allowed.');
        }

        $originalName = $this->filenames->sanitizeOriginalName($file->getClientOriginalName());
        $extension = $this->filenames->extension($originalName);

        if (! in_array($extension, $scope->allowedExtensions, true)) {
            throw InvalidUploadException::forReason('Uploaded file extension is not allowed.');
        }

        $mimeType = (string) $file->getMimeType();

        if (! in_array($mimeType, $scope->allowedMimeTypes, true)) {
            throw InvalidUploadException::forReason('Uploaded file MIME type is not allowed.');
        }

        [$width, $height] = $this->imageDimensions($file, $scope);
        $relativePath = $this->paths->generate($scope, $extension);
        $generatedName = basename($relativePath);
        $hash = hash_file('sha256', $file->getRealPath());

        if ($hash === false) {
            throw InvalidUploadException::forReason('Unable to calculate upload hash.');
        }

        return new UploadMetadata(
            scope: $scope->key,
            disk: 'local',
            visibility: $scope->visibility,
            originalName: $originalName,
            generatedName: $generatedName,
            relativePath: $relativePath,
            sizeBytes: $size,
            mimeType: $mimeType,
            extension: $extension,
            sha256: $hash,
            width: $width,
            height: $height,
        );
    }

    /**
     * @return array{0: int|null, 1: int|null}
     */
    private function imageDimensions(UploadedFile $file, UploadScope $scope): array
    {
        $dimensions = @getimagesize($file->getRealPath());

        if ($dimensions === false) {
            throw InvalidUploadException::forReason('Uploaded file is not a valid image.');
        }

        $width = (int) $dimensions[0];
        $height = (int) $dimensions[1];

        if ($width <= 0 || $height <= 0 || $width > $scope->maxWidth || $height > $scope->maxHeight) {
            throw InvalidUploadException::forReason('Uploaded image dimensions are not allowed.');
        }

        return [$width, $height];
    }
}
