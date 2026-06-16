<?php

namespace App\Modules\Settings\Services;

use App\Modules\Security\Services\SecretMasker;
use App\Modules\Settings\Data\SettingDefinition;
use App\Modules\Settings\Exceptions\InvalidSettingValueException;
use App\Modules\Settings\Exceptions\SettingPersistenceMismatchException;
use App\Modules\Settings\Repositories\SettingsRepository;
use Illuminate\Support\Facades\Validator;

final class SettingsResolver
{
    public function __construct(
        private readonly SettingsRegistry $registry,
        private readonly SettingsRepository $repository,
        private readonly SettingValueCaster $caster = new SettingValueCaster(),
        private readonly SecretMasker $secretMasker = new SecretMasker(),
    ) {
    }

    public function get(string $key): mixed
    {
        $definition = $this->registry->definition($key);
        $stored = $this->repository->find($key);

        if ($stored === null) {
            return $this->caster->cast($key, $definition->type, $definition->default);
        }

        $this->assertStoredDefinitionMatches($definition, $stored->type, $stored->owner, $stored->is_sensitive);

        $value = $this->caster->decode($key, $definition->type, $stored->value);
        $this->validate($definition, $value);

        return $value;
    }

    public function set(string $key, mixed $value): mixed
    {
        $definition = $this->registry->definition($key);
        $cast = $this->caster->cast($key, $definition->type, $value);

        $this->validate($definition, $cast);

        $this->repository->put($definition, $this->caster->encode($key, $definition->type, $cast));

        return $cast;
    }

    public function forget(string $key): void
    {
        $this->registry->definition($key);
        $this->repository->delete($key);
    }

    public function expose(string $key): mixed
    {
        $definition = $this->registry->definition($key);
        $value = $this->get($key);

        if ($definition->isSensitive) {
            return $this->secretMasker->mask([$key => $value])[$key];
        }

        return $value;
    }

    private function validate(SettingDefinition $definition, mixed $value): void
    {
        if ($definition->validationRules === []) {
            return;
        }

        $validator = Validator::make(
            ['value' => $value],
            ['value' => $definition->validationRules]
        );

        if ($validator->fails()) {
            throw InvalidSettingValueException::forKey($definition->key, 'validation failed');
        }
    }

    private function assertStoredDefinitionMatches(
        SettingDefinition $definition,
        string $storedType,
        string $storedOwner,
        bool $storedSensitivity,
    ): void {
        if (
            $storedType !== $definition->type->value
            || $storedOwner !== $definition->owner
            || $storedSensitivity !== $definition->isSensitive
        ) {
            throw SettingPersistenceMismatchException::forKey($definition->key);
        }
    }
}
