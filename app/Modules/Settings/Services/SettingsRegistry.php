<?php

namespace App\Modules\Settings\Services;

use App\Modules\Settings\Data\SettingDefinition;
use App\Modules\Settings\Exceptions\DuplicateSettingException;
use App\Modules\Settings\Exceptions\UnknownSettingException;

final class SettingsRegistry
{
    /**
     * @var array<string, SettingDefinition>
     */
    private array $definitions = [];

    public function __construct(private readonly SettingValueCaster $caster = new SettingValueCaster())
    {
    }

    public function register(SettingDefinition $definition): void
    {
        if (isset($this->definitions[$definition->key])) {
            throw DuplicateSettingException::forKey($definition->key);
        }

        $this->caster->cast($definition->key, $definition->type, $definition->default);

        $this->definitions[$definition->key] = $definition;
    }

    public function definition(string $key): SettingDefinition
    {
        return $this->definitions[$key] ?? throw UnknownSettingException::forKey($key);
    }

    public function has(string $key): bool
    {
        return isset($this->definitions[$key]);
    }
}
