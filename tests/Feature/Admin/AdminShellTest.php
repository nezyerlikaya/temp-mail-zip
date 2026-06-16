<?php

namespace Tests\Feature\Admin;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class AdminShellTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        File::ensureDirectoryExists(storage_path('app/installer'));
        File::put(storage_path('app/installer/installed.lock'), 'installed=true');
    }

    protected function tearDown(): void
    {
        File::delete(storage_path('app/installer/installed.lock'));

        parent::tearDown();
    }

    public function test_admin_dashboard_renders_shell_in_non_production_environment(): void
    {
        $response = $this->get('/admin');

        $response->assertOk();
        $response->assertSee('lang="en"', false);
        $response->assertSee('dir="ltr"', false);
        $response->assertSee(__('admin.dashboard.title'));
        $response->assertSee(__('admin.dashboard.empty_title'));
    }

    public function test_admin_route_is_blocked_in_production_until_real_auth_exists(): void
    {
        $this->app->detectEnvironment(fn (): string => 'production');

        $this->get('/admin')->assertForbidden();
    }

    public function test_admin_shell_consumes_registry_navigation(): void
    {
        $response = $this->get('/admin');

        $response->assertOk();
        $response->assertSee('href="http://localhost/admin"', false);
        $response->assertSee(__('admin.navigation.dashboard'));
    }

    public function test_dashboard_does_not_render_placeholder_widgets_or_fake_metrics(): void
    {
        $content = $this->get('/admin')->getContent();

        $this->assertStringNotContainsString('coming soon', strtolower($content));
        $this->assertStringNotContainsString('placeholder', strtolower($content));
        $this->assertStringNotContainsString('chart', strtolower($content));
        $this->assertStringNotContainsString('metric', strtolower($content));
        $this->assertStringNotContainsString('42', $content);
    }
}
