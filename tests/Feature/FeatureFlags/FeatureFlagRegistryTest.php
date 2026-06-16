<?php

namespace Tests\Feature\FeatureFlags;

use App\Modules\FeatureFlags\Data\FeatureFlagDefinition;
use App\Modules\FeatureFlags\Enums\FeatureFlagState;
use App\Modules\FeatureFlags\Exceptions\DuplicateFeatureFlagException;
use App\Modules\FeatureFlags\Exceptions\UnknownFeatureFlagException;
use App\Modules\FeatureFlags\Services\FeatureFlagRegistry;
use Tests\TestCase;

class FeatureFlagRegistryTest extends TestCase
{
    public function test_it_registers_flag_definitions_and_rejects_unknown_flags(): void
    {
        $registry = new FeatureFlagRegistry();
        $registry->register(new FeatureFlagDefinition(
            key: 'mailboxes.generation',
            defaultState: FeatureFlagState::Disabled,
            owner: 'FeatureFlags',
        ));

        $this->assertTrue($registry->has('mailboxes.generation'));
        $this->assertSame('FeatureFlags', $registry->definition('mailboxes.generation')->owner);

        $this->expectException(UnknownFeatureFlagException::class);

        $registry->definition('mailboxes.unknown');
    }

    public function test_it_rejects_duplicate_flags(): void
    {
        $registry = new FeatureFlagRegistry();
        $definition = new FeatureFlagDefinition(
            key: 'mailboxes.generation',
            defaultState: FeatureFlagState::Disabled,
            owner: 'FeatureFlags',
        );

        $registry->register($definition);

        $this->expectException(DuplicateFeatureFlagException::class);

        $registry->register($definition);
    }
}
