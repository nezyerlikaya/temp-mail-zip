<?php

namespace App\Modules\Installer\Services;

use App\Modules\Installer\Data\InstallerCheck;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Throwable;

final class InstallerPreflightChecker
{
    /**
     * @param null|callable(): void $databaseProbe
     */
    public function __construct(
        private readonly InstallationState $state = new InstallationState(),
        private readonly mixed $databaseProbe = null,
    ) {
    }

    /**
     * @return list<InstallerCheck>
     */
    public function checks(): array
    {
        return [
            $this->environmentCheck(),
            $this->phpVersionCheck(),
            $this->appKeyCheck(),
            $this->debugModeCheck(),
            $this->databaseCheck(),
            $this->storageCheck(),
            $this->viteManifestCheck(),
            $this->lockCheck(),
            new InstallerCheck('scheduler', 'installer.checks.scheduler', 'warning', 'installer.messages.scheduler_manual'),
        ];
    }

    public function hasBlockers(): bool
    {
        foreach ($this->checks() as $check) {
            if ($check->isBlocker()) {
                return true;
            }
        }

        return false;
    }

    public function safeDatabaseFailure(Throwable $exception): InstallerCheck
    {
        return new InstallerCheck(
            'database',
            'installer.checks.database',
            'blocker',
            'installer.messages.database_failed_safe',
        );
    }

    private function environmentCheck(): InstallerCheck
    {
        return File::exists(base_path('.env'))
            ? new InstallerCheck('environment', 'installer.checks.environment', 'ok', 'installer.messages.environment_ok')
            : new InstallerCheck('environment', 'installer.checks.environment', 'blocker', 'installer.messages.environment_missing');
    }

    private function phpVersionCheck(): InstallerCheck
    {
        return version_compare(PHP_VERSION, '8.3.0', '>=')
            ? new InstallerCheck('php', 'installer.checks.php', 'ok', 'installer.messages.php_ok')
            : new InstallerCheck('php', 'installer.checks.php', 'blocker', 'installer.messages.php_failed');
    }

    private function appKeyCheck(): InstallerCheck
    {
        return filled(config('app.key'))
            ? new InstallerCheck('app_key', 'installer.checks.app_key', 'ok', 'installer.messages.app_key_ok')
            : new InstallerCheck('app_key', 'installer.checks.app_key', 'blocker', 'installer.messages.app_key_missing');
    }

    private function debugModeCheck(): InstallerCheck
    {
        return config('app.debug')
            ? new InstallerCheck('debug', 'installer.checks.debug', 'warning', 'installer.messages.debug_warning')
            : new InstallerCheck('debug', 'installer.checks.debug', 'ok', 'installer.messages.debug_ok');
    }

    private function databaseCheck(): InstallerCheck
    {
        try {
            if (is_callable($this->databaseProbe)) {
                ($this->databaseProbe)();
            } else {
                DB::connection()->getPdo();
            }

            return new InstallerCheck('database', 'installer.checks.database', 'ok', 'installer.messages.database_ok');
        } catch (Throwable $exception) {
            return $this->safeDatabaseFailure($exception);
        }
    }

    private function storageCheck(): InstallerCheck
    {
        return is_writable(storage_path()) && is_writable(storage_path('logs'))
            ? new InstallerCheck('storage', 'installer.checks.storage', 'ok', 'installer.messages.storage_ok')
            : new InstallerCheck('storage', 'installer.checks.storage', 'blocker', 'installer.messages.storage_failed');
    }

    private function viteManifestCheck(): InstallerCheck
    {
        return File::exists(public_path('build/manifest.json'))
            ? new InstallerCheck('vite', 'installer.checks.vite', 'ok', 'installer.messages.vite_ok')
            : new InstallerCheck('vite', 'installer.checks.vite', 'warning', 'installer.messages.vite_missing');
    }

    private function lockCheck(): InstallerCheck
    {
        return $this->state->isInstalled()
            ? new InstallerCheck('lock', 'installer.checks.lock', 'ok', 'installer.messages.lock_present')
            : new InstallerCheck('lock', 'installer.checks.lock', 'warning', 'installer.messages.lock_missing');
    }
}
