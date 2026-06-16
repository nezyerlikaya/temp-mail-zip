<?php

namespace App\Modules\Uploads\Services;

use App\Modules\Uploads\Exceptions\InvalidUploadException;

final class FilenameSanitizer
{
    /**
     * @var list<string>
     */
    private array $dangerousExtensions = [
        'php',
        'phtml',
        'phar',
        'html',
        'htm',
        'js',
        'css',
        'svg',
        'exe',
        'bat',
        'cmd',
        'sh',
        'zip',
        'rar',
        '7z',
    ];

    public function sanitizeOriginalName(string $name): string
    {
        $this->assertNoPathInjection($name);
        $this->assertNoDangerousDoubleExtension($name);

        $name = preg_replace('/[\x00-\x1F\x7F]/u', '', $name) ?? '';
        $name = preg_replace('/[^A-Za-z0-9._-]+/', '-', $name) ?? '';
        $name = preg_replace('/-+\./', '.', $name) ?? $name;
        $name = trim($name, '.-_');

        if ($name === '') {
            return 'upload';
        }

        return substr($name, 0, 120);
    }

    public function extension(string $name): string
    {
        $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));

        if ($extension === '') {
            throw InvalidUploadException::forReason('Uploaded file must have an extension.');
        }

        return $extension;
    }

    private function assertNoPathInjection(string $name): void
    {
        if (
            str_contains($name, "\0")
            || str_contains($name, '..')
            || str_contains($name, '/')
            || str_contains($name, '\\')
            || preg_match('/^[A-Za-z]:/', $name) === 1
        ) {
            throw InvalidUploadException::forReason('Unsafe upload filename.');
        }
    }

    private function assertNoDangerousDoubleExtension(string $name): void
    {
        $parts = explode('.', strtolower($name));

        if (count($parts) <= 2) {
            return;
        }

        array_pop($parts);

        foreach ($parts as $part) {
            if (in_array($part, $this->dangerousExtensions, true)) {
                throw InvalidUploadException::forReason('Dangerous double extension rejected.');
            }
        }
    }
}
