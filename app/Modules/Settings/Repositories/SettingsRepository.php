<?php

namespace App\Modules\Settings\Repositories;

use App\Modules\Settings\Data\SettingDefinition;
use App\Modules\Settings\Models\Setting;

final class SettingsRepository
{
    public function find(string $key): ?Setting
    {
        return Setting::query()
            ->where('key', $key)
            ->first();
    }

    public function put(SettingDefinition $definition, mixed $encodedValue): Setting
    {
        return Setting::query()->updateOrCreate(
            ['key' => $definition->key],
            [
                'value' => $encodedValue,
                'type' => $definition->type->value,
                'owner' => $definition->owner,
                'is_sensitive' => $definition->isSensitive,
            ]
        );
    }

    public function delete(string $key): void
    {
        Setting::query()
            ->where('key', $key)
            ->delete();
    }
}
