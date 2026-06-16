<?php

namespace Tests\Feature\FeatureFlags;

use App\Modules\FeatureFlags\Data\FeatureFlagDefinition;
use App\Modules\FeatureFlags\Enums\FeatureFlagState;
use App\Modules\FeatureFlags\Exceptions\InvalidRolloutSubjectException;
use App\Modules\FeatureFlags\Exceptions\UnknownFeatureFlagException;
use App\Modules\FeatureFlags\Services\FeatureFlagRegistry;
use App\Modules\FeatureFlags\Services\FeatureFlagResolver;
use App\Modules\Settings\Repositories\SettingsRepository;
use App\Modules\Settings\Services\SettingValueCaster;
use App\Modules\Settings\Services\SettingsRegistry;
use App\Modules\Settings\Services\SettingsResolver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeatureFlagResolverTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_resolves_explicit_safe_default_states(): void
    {
        $resolver = $this->resolverWithFlags(
            new FeatureFlagDefinition('mailboxes.generation', FeatureFlagState::Enabled, 'FeatureFlags'),
            new FeatureFlagDefinition('messages.preview', FeatureFlagState::Disabled, 'FeatureFlags'),
            new FeatureFlagDefinition('domains.legacy_check', FeatureFlagState::Deprecated, 'FeatureFlags'),
        );

        $this->assertTrue($resolver->isAvailable('mailboxes.generation'));
        $this->assertFalse($resolver->isAvailable('messages.preview'));
        $this->assertFalse($resolver->isAvailable('domains.legacy_check'));
    }

    public function test_unknown_flags_fail_explicitly_without_granting_access(): void
    {
        $resolver = $this->resolverWithFlags();

        $this->expectException(UnknownFeatureFlagException::class);

        $resolver->isAvailable('marketplace.removed');
    }

    public function test_kill_switches_only_remove_availability(): void
    {
        $resolver = $this->resolverWithFlags(
            new FeatureFlagDefinition(
                key: 'messages.intake_kill_switch',
                defaultState: FeatureFlagState::Enabled,
                owner: 'FeatureFlags',
                isKillSwitch: true,
            ),
            new FeatureFlagDefinition(
                key: 'messages.cleanup_kill_switch',
                defaultState: FeatureFlagState::Disabled,
                owner: 'FeatureFlags',
                isKillSwitch: true,
            ),
        );

        $this->assertFalse($resolver->isAvailable('messages.intake_kill_switch'));
        $this->assertTrue($resolver->isAvailable('messages.cleanup_kill_switch'));
    }

    public function test_runtime_settings_override_registered_default_state(): void
    {
        $definition = new FeatureFlagDefinition(
            key: 'mailboxes.generation',
            defaultState: FeatureFlagState::Disabled,
            owner: 'FeatureFlags',
        );

        [$resolver, $settings] = $this->resolverWithSettings($definition);

        $this->assertFalse($resolver->isAvailable('mailboxes.generation'));

        $settings->set($definition->settingsKey(), 'enabled');

        $this->assertTrue($resolver->isAvailable('mailboxes.generation'));
        $this->assertDatabaseHas('settings', [
            'key' => 'featureflags.mailboxes.generation',
            'owner' => 'FeatureFlags',
            'is_sensitive' => false,
        ]);
    }

    public function test_beta_rollout_is_deterministic_and_rejects_pii_subjects(): void
    {
        $resolver = $this->resolverWithFlags(new FeatureFlagDefinition(
            key: 'mailboxes.beta_generator',
            defaultState: FeatureFlagState::Beta,
            owner: 'FeatureFlags',
            rolloutPercentage: 100,
            rolloutSalt: 'test-salt',
        ));

        $this->assertTrue($resolver->isAvailable('mailboxes.beta_generator', 'user-123'));

        $this->expectException(InvalidRolloutSubjectException::class);

        $resolver->isAvailable('mailboxes.beta_generator', 'person@example.com');
    }

    public function test_internal_flag_names_are_not_exposed_as_public_keys(): void
    {
        $resolver = $this->resolverWithFlags(
            new FeatureFlagDefinition('mailboxes.public_surface', FeatureFlagState::Enabled, 'FeatureFlags', isPublic: true),
            new FeatureFlagDefinition('security.internal_switch', FeatureFlagState::Disabled, 'FeatureFlags'),
        );

        $this->assertSame('mailboxes.public_surface', $resolver->publicKey('mailboxes.public_surface'));
        $this->assertNull($resolver->publicKey('security.internal_switch'));
    }

    public function test_no_removed_feature_flags_are_registered_by_default(): void
    {
        $registry = new FeatureFlagRegistry();

        foreach ([
            'marketplace',
            'community',
            'sdk',
            'ai_translation',
            'semantic_search',
            'advanced_analytics',
            'comments',
            'reputation',
            'developer_portal',
        ] as $removedFeature) {
            $this->assertFalse($registry->has($removedFeature));
        }
    }

    /**
     * @return array{FeatureFlagResolver, SettingsResolver}
     */
    private function resolverWithSettings(FeatureFlagDefinition $definition): array
    {
        $flagRegistry = new FeatureFlagRegistry();
        $flagRegistry->register($definition);

        $settingsRegistry = new SettingsRegistry(new SettingValueCaster());
        $settingsRegistry->register($definition->settingsDefinition());

        $settingsResolver = new SettingsResolver(
            registry: $settingsRegistry,
            repository: new SettingsRepository(),
            caster: new SettingValueCaster(),
        );

        return [
            new FeatureFlagResolver($flagRegistry, $settingsResolver),
            $settingsResolver,
        ];
    }

    private function resolverWithFlags(FeatureFlagDefinition ...$definitions): FeatureFlagResolver
    {
        $registry = new FeatureFlagRegistry();

        foreach ($definitions as $definition) {
            $registry->register($definition);
        }

        return new FeatureFlagResolver($registry);
    }
}
