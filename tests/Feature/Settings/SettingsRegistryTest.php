<?php

namespace Tests\Feature\Settings;

use App\Modules\Settings\Data\SettingDefinition;
use App\Modules\Settings\Enums\SettingType;
use App\Modules\Settings\Exceptions\DuplicateSettingException;
use App\Modules\Settings\Exceptions\UnknownSettingException;
use App\Modules\Settings\Services\SettingsRegistry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsRegistryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_registers_definitions_and_rejects_unknown_keys(): void
    {
        $registry = new SettingsRegistry();
        $registry->register(new SettingDefinition(
            key: 'platform.display_name',
            type: SettingType::String,
            default: 'Temp Mail',
            owner: 'Settings',
        ));

        $this->assertTrue($registry->has('platform.display_name'));
        $this->assertSame('Settings', $registry->definition('platform.display_name')->owner);

        $this->expectException(UnknownSettingException::class);

        $registry->definition('platform.unknown');
    }

    public function test_it_rejects_duplicate_definitions(): void
    {
        $registry = new SettingsRegistry();
        $definition = new SettingDefinition(
            key: 'platform.display_name',
            type: SettingType::String,
            default: 'Temp Mail',
            owner: 'Settings',
        );

        $registry->register($definition);

        $this->expectException(DuplicateSettingException::class);

        $registry->register($definition);
    }
}
