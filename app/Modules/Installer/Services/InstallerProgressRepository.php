<?php

namespace App\Modules\Installer\Services;

use Illuminate\Support\Facades\File;

final class InstallerProgressRepository
{
    /**
     * @var list<string>
     */
    private array $steps = ['requirements', 'environment', 'database', 'application', 'admin', 'finish'];

    public function __construct(private readonly ?string $path = null)
    {
    }

    public function currentStep(): string
    {
        if (! File::exists($this->path())) {
            return 'requirements';
        }

        $payload = json_decode((string) File::get($this->path()), true);
        $step = is_array($payload) ? ($payload['step'] ?? null) : null;

        return is_string($step) && in_array($step, $this->steps, true) ? $step : 'requirements';
    }

    public function remember(string $step): void
    {
        if (! in_array($step, $this->steps, true)) {
            return;
        }

        File::ensureDirectoryExists(dirname($this->path()));
        File::put($this->path(), json_encode(['step' => $step], JSON_THROW_ON_ERROR));
    }

    private function path(): string
    {
        return $this->path ?? storage_path('app/installer/progress.json');
    }
}
