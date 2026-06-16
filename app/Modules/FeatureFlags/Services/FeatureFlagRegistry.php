<?php

namespace App\Modules\FeatureFlags\Services;

use App\Modules\FeatureFlags\Data\FeatureFlagDefinition;
use App\Modules\FeatureFlags\Exceptions\DuplicateFeatureFlagException;
use App\Modules\FeatureFlags\Exceptions\UnknownFeatureFlagException;

final class FeatureFlagRegistry
{
    /**
     * @var array<string, FeatureFlagDefinition>
     */
    private array $definitions = [];

    public function register(FeatureFlagDefinition $definition): void
    {
        if (isset($this->definitions[$definition->key])) {
            throw DuplicateFeatureFlagException::forKey($definition->key);
        }

        $this->definitions[$definition->key] = $definition;
    }

    public function definition(string $key): FeatureFlagDefinition
    {
        return $this->definitions[$key] ?? throw UnknownFeatureFlagException::forKey($key);
    }

    public function has(string $key): bool
    {
        return isset($this->definitions[$key]);
    }
}
