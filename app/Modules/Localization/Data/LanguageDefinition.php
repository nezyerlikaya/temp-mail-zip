<?php

namespace App\Modules\Localization\Data;

use App\Modules\Localization\Enums\LanguageDirection;
use App\Modules\Localization\Enums\LanguageStatus;
use InvalidArgumentException;

final readonly class LanguageDefinition
{
    public function __construct(
        public string $code,
        public string $name,
        public string $nativeName,
        public LanguageDirection $direction,
        public LanguageStatus $status,
        public bool $isDefault = false,
        public bool $isPublic = false,
    ) {
        if (preg_match('/^[a-z]{2}(?:-[A-Z]{2})?$/', $this->code) !== 1) {
            throw new InvalidArgumentException('Locale codes must be BCP 47-compatible, such as en, tr, or en-US.');
        }

        if ($this->isPublic && $this->status !== LanguageStatus::Active) {
            throw new InvalidArgumentException('Only active languages may be public.');
        }
    }

    public function isResolvable(bool $allowHidden = false): bool
    {
        if ($this->status === LanguageStatus::Active) {
            return true;
        }

        return $allowHidden && $this->status === LanguageStatus::Hidden;
    }
}
