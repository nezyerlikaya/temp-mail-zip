<?php

namespace App\Modules\FeatureFlags\Services;

use App\Modules\FeatureFlags\Data\FeatureFlagDefinition;
use App\Modules\FeatureFlags\Enums\FeatureFlagState;
use App\Modules\FeatureFlags\Exceptions\InvalidRolloutSubjectException;
use App\Modules\Settings\Exceptions\UnknownSettingException;
use App\Modules\Settings\Services\SettingsResolver;
use ValueError;

final class FeatureFlagResolver
{
    public function __construct(
        private readonly FeatureFlagRegistry $registry,
        private readonly ?SettingsResolver $settings = null,
    ) {
    }

    public function isAvailable(string $key, ?string $rolloutSubjectKey = null): bool
    {
        $definition = $this->registry->definition($key);
        $state = $this->stateFor($definition);

        if ($definition->isKillSwitch) {
            return $state !== FeatureFlagState::Enabled;
        }

        return match ($state) {
            FeatureFlagState::Enabled => true,
            FeatureFlagState::Disabled, FeatureFlagState::Deprecated => false,
            FeatureFlagState::Beta => $this->isInRollout($definition, $rolloutSubjectKey),
        };
    }

    public function state(string $key): FeatureFlagState
    {
        return $this->stateFor($this->registry->definition($key));
    }

    public function publicKey(string $key): ?string
    {
        return $this->registry->definition($key)->publicKey();
    }

    private function stateFor(FeatureFlagDefinition $definition): FeatureFlagState
    {
        if ($this->settings === null) {
            return $definition->defaultState;
        }

        try {
            $value = $this->settings->get($definition->settingsKey());
        } catch (UnknownSettingException) {
            return $definition->defaultState;
        }

        try {
            return FeatureFlagState::from((string) $value);
        } catch (ValueError) {
            return $definition->defaultState;
        }
    }

    private function isInRollout(FeatureFlagDefinition $definition, ?string $rolloutSubjectKey): bool
    {
        if ($definition->rolloutPercentage <= 0 || $rolloutSubjectKey === null) {
            return false;
        }

        if ($definition->rolloutPercentage >= 100) {
            $this->assertSafeSubjectKey($rolloutSubjectKey);

            return true;
        }

        $this->assertSafeSubjectKey($rolloutSubjectKey);

        $hash = hash('sha256', $definition->key.'|'.$definition->rolloutSalt.'|'.$rolloutSubjectKey);
        $bucket = hexdec(substr($hash, 0, 8)) % 100;

        return $bucket < $definition->rolloutPercentage;
    }

    private function assertSafeSubjectKey(string $subjectKey): void
    {
        if (
            filter_var($subjectKey, FILTER_VALIDATE_EMAIL) !== false
            || filter_var($subjectKey, FILTER_VALIDATE_IP) !== false
            || preg_match('/mozilla|chrome|safari|firefox|edge|opera|user-agent/i', $subjectKey) === 1
        ) {
            throw InvalidRolloutSubjectException::forSubject();
        }
    }
}
