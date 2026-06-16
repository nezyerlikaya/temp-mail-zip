<?php

namespace App\Modules\Installer\Services;

use Illuminate\Support\Facades\File;

final class InstallationState
{
    public function __construct(
        private readonly ?string $environmentPath = null,
        private readonly ?string $lockPath = null,
    ) {
    }

    public function isInstalled(): bool
    {
        return File::exists($this->environmentPath()) && File::exists($this->lockPath());
    }

    public function markInstalled(): void
    {
        File::ensureDirectoryExists(dirname($this->lockPath()));
        File::put($this->lockPath(), 'installed='.now()->toIso8601String().PHP_EOL);
    }

    public function clearLock(): void
    {
        if (File::exists($this->lockPath())) {
            File::delete($this->lockPath());
        }
    }

    private function environmentPath(): string
    {
        return $this->environmentPath ?? base_path('.env');
    }

    private function lockPath(): string
    {
        return $this->lockPath ?? storage_path('app/installer/installed.lock');
    }
}
