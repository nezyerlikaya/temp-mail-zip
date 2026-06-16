<?php

namespace Tests\Feature\Theme;

use App\Modules\Theme\Services\ThemeRegistry;
use Tests\TestCase;

class ThemeRegistryTest extends TestCase
{
    public function test_it_registers_public_theme_keys(): void
    {
        $registry = new ThemeRegistry();

        $this->assertSame(['atlas', 'horizon', 'legacy'], $registry->keys());
    }

    public function test_invalid_theme_falls_back_to_horizon(): void
    {
        $registry = new ThemeRegistry();

        $this->assertSame('horizon', $registry->resolve('unknown')->key);
        $this->assertSame('horizon', $registry->resolve(null)->key);
        $this->assertSame('atlas', $registry->resolve('atlas')->key);
    }
}
