<?php

namespace Tests\Feature\Settings;

use App\Modules\Settings\Data\SettingDefinition;
use App\Modules\Settings\Enums\SettingType;
use App\Modules\Settings\Exceptions\InvalidSettingValueException;
use App\Modules\Settings\Exceptions\SettingPersistenceMismatchException;
use App\Modules\Settings\Models\Setting;
use App\Modules\Settings\Repositories\SettingsRepository;
use App\Modules\Settings\Services\SettingValueCaster;
use App\Modules\Settings\Services\SettingsRegistry;
use App\Modules\Settings\Services\SettingsResolver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsResolverTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_registered_defaults_without_persisting_them(): void
    {
        $resolver = $this->resolverWith(new SettingDefinition(
            key: 'platform.display_name',
            type: SettingType::String,
            default: 'Temp Mail',
            owner: 'Settings',
        ));

        $this->assertSame('Temp Mail', $resolver->get('platform.display_name'));
        $this->assertDatabaseCount('settings', 0);
    }

    public function test_it_casts_and_persists_typed_values(): void
    {
        $resolver = $this->resolverWith(
            new SettingDefinition(
                key: 'platform.max_mailboxes',
                type: SettingType::Integer,
                default: 10,
                owner: 'Settings',
                validationRules: ['integer', 'min:1', 'max:100'],
            ),
            new SettingDefinition(
                key: 'platform.enabled',
                type: SettingType::Boolean,
                default: false,
                owner: 'Settings',
            ),
            new SettingDefinition(
                key: 'platform.options',
                type: SettingType::Array,
                default: ['mode' => 'basic'],
                owner: 'Settings',
            ),
        );

        $this->assertSame(25, $resolver->set('platform.max_mailboxes', '25'));
        $this->assertTrue($resolver->set('platform.enabled', 'true'));
        $this->assertSame(['mode' => 'strict'], $resolver->set('platform.options', ['mode' => 'strict']));

        $this->assertSame(25, $resolver->get('platform.max_mailboxes'));
        $this->assertTrue($resolver->get('platform.enabled'));
        $this->assertSame(['mode' => 'strict'], $resolver->get('platform.options'));
    }

    public function test_it_rejects_invalid_types_and_validation_failures(): void
    {
        $resolver = $this->resolverWith(new SettingDefinition(
            key: 'platform.max_mailboxes',
            type: SettingType::Integer,
            default: 10,
            owner: 'Settings',
            validationRules: ['integer', 'min:1', 'max:100'],
        ));

        try {
            $resolver->set('platform.max_mailboxes', 'loose');
            $this->fail('Expected invalid integer value to fail.');
        } catch (InvalidSettingValueException) {
            $this->assertDatabaseCount('settings', 0);
        }

        $this->expectException(InvalidSettingValueException::class);

        $resolver->set('platform.max_mailboxes', 500);
    }

    public function test_it_masks_sensitive_values_when_exposed(): void
    {
        $resolver = $this->resolverWith(new SettingDefinition(
            key: 'security.api_token',
            type: SettingType::String,
            default: 'default-token',
            owner: 'Security',
            isSensitive: true,
        ));

        $resolver->set('security.api_token', 'live-secret-token');

        $this->assertSame('live-secret-token', $resolver->get('security.api_token'));
        $this->assertSame('[masked]', $resolver->expose('security.api_token'));
    }

    public function test_it_rejects_stored_values_that_do_not_match_the_registered_owner_boundary(): void
    {
        $resolver = $this->resolverWith(new SettingDefinition(
            key: 'platform.display_name',
            type: SettingType::String,
            default: 'Temp Mail',
            owner: 'Settings',
        ));

        Setting::query()->create([
            'key' => 'platform.display_name',
            'value' => json_encode('Wrong Owner', JSON_THROW_ON_ERROR),
            'type' => SettingType::String->value,
            'owner' => 'Theme',
            'is_sensitive' => false,
        ]);

        $this->expectException(SettingPersistenceMismatchException::class);

        $resolver->get('platform.display_name');
    }

    public function test_setting_writes_do_not_modify_the_environment_file(): void
    {
        $envPath = base_path('.env');
        $before = is_file($envPath) ? file_get_contents($envPath) : null;

        $resolver = $this->resolverWith(new SettingDefinition(
            key: 'platform.display_name',
            type: SettingType::String,
            default: 'Temp Mail',
            owner: 'Settings',
        ));

        $resolver->set('platform.display_name', 'Runtime Name');

        $after = is_file($envPath) ? file_get_contents($envPath) : null;

        $this->assertSame($before, $after);
    }

    private function resolverWith(SettingDefinition ...$definitions): SettingsResolver
    {
        $registry = new SettingsRegistry(new SettingValueCaster());

        foreach ($definitions as $definition) {
            $registry->register($definition);
        }

        return new SettingsResolver(
            registry: $registry,
            repository: new SettingsRepository(),
            caster: new SettingValueCaster(),
        );
    }
}
