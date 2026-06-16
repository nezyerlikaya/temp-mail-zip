<?php

namespace App\Modules\Settings\Data;

use App\Modules\Settings\Enums\SettingType;
use InvalidArgumentException;

final readonly class SettingDefinition
{
    /**
     * @param list<string> $validationRules
     */
    public function __construct(
        public string $key,
        public SettingType $type,
        public mixed $default,
        public string $owner,
        public array $validationRules = [],
        public bool $isSensitive = false,
        public bool $isPublic = false,
    ) {
        if (preg_match('/^[a-z][a-z0-9_]*(\.[a-z][a-z0-9_]*)+$/', $this->key) !== 1) {
            throw new InvalidArgumentException('Setting keys must use lowercase owner-aware dot notation.');
        }

        if (trim($this->owner) === '') {
            throw new InvalidArgumentException('Settings must declare an owner.');
        }

        if ($this->isSensitive && $this->isPublic) {
            throw new InvalidArgumentException('Sensitive settings cannot be public.');
        }
    }
}
