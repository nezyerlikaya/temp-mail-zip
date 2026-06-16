<?php

namespace App\Modules\FeatureFlags\Data;

use App\Modules\FeatureFlags\Enums\FeatureFlagState;
use App\Modules\Settings\Data\SettingDefinition;
use App\Modules\Settings\Enums\SettingType;
use InvalidArgumentException;

final readonly class FeatureFlagDefinition
{
    public function __construct(
        public string $key,
        public FeatureFlagState $defaultState,
        public string $owner,
        public bool $isKillSwitch = false,
        public int $rolloutPercentage = 0,
        public string $rolloutSalt = '',
        public bool $isPublic = false,
    ) {
        if (preg_match('/^[a-z][a-z0-9_]*(\.[a-z][a-z0-9_]*)+$/', $this->key) !== 1) {
            throw new InvalidArgumentException('Feature flag keys must use lowercase owner-aware dot notation.');
        }

        if (trim($this->owner) === '') {
            throw new InvalidArgumentException('Feature flags must declare an owner.');
        }

        if ($this->rolloutPercentage < 0 || $this->rolloutPercentage > 100) {
            throw new InvalidArgumentException('Rollout percentage must be between 0 and 100.');
        }
    }

    public function settingsKey(): string
    {
        return 'featureflags.'.$this->key;
    }

    public function settingsDefinition(): SettingDefinition
    {
        return new SettingDefinition(
            key: $this->settingsKey(),
            type: SettingType::String,
            default: $this->defaultState->value,
            owner: 'FeatureFlags',
            validationRules: ['string', 'in:enabled,disabled,beta,deprecated'],
        );
    }

    public function publicKey(): ?string
    {
        return $this->isPublic ? $this->key : null;
    }
}
