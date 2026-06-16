<?php

namespace App\Modules\Installer\Data;

final readonly class InstallerCheck
{
    public function __construct(
        public string $key,
        public string $labelKey,
        public string $status,
        public string $messageKey,
    ) {
    }

    public function isBlocker(): bool
    {
        return $this->status === 'blocker';
    }
}
