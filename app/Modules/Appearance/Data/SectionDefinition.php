<?php

namespace App\Modules\Appearance\Data;

final readonly class SectionDefinition
{
    public function __construct(
        public string $key,
        public string $owner,
        public bool $enabled,
        public int $order,
        public bool $requiresContent = true,
        public bool $hasContent = false,
        public bool $isApprovedAdSlot = false,
    ) {
    }

    public function shouldRender(): bool
    {
        if (! $this->enabled) {
            return false;
        }

        return ! $this->requiresContent || $this->hasContent;
    }
}
