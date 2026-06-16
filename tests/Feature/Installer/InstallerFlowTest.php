<?php

namespace Tests\Feature\Installer;

use App\Modules\Installer\Services\InstallationState;
use App\Modules\Installer\Services\InstallerPreflightChecker;
use App\Modules\Installer\Services\InstallerProgressRepository;
use App\Modules\Security\Services\SecretMasker;
use Illuminate\Support\Facades\File;
use RuntimeException;
use Tests\TestCase;

class InstallerFlowTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        File::delete(storage_path('app/installer/installed.lock'));
        File::delete(storage_path('app/installer/progress.json'));
    }

    protected function tearDown(): void
    {
        File::delete(storage_path('app/installer/installed.lock'));
        File::delete(storage_path('app/installer/progress.json'));

        parent::tearDown();
    }

    public function test_uninstalled_app_redirects_normal_routes_to_installer(): void
    {
        $this->get('/')->assertRedirect('/install');
    }

    public function test_json_requests_are_blocked_safely_before_installation(): void
    {
        $this->getJson('/')->assertStatus(503)->assertJson([
            'message' => __('installer.messages.install_required'),
        ]);
    }

    public function test_installer_is_accessible_before_installation(): void
    {
        $response = $this->get('/install');

        $response->assertOk();
        $response->assertSee(__('installer.shell.heading'));
        $response->assertSee(__('installer.steps.requirements'));
        $response->assertSee(__('installer.actions.lock'));
    }

    public function test_installer_is_blocked_after_installation(): void
    {
        File::ensureDirectoryExists(storage_path('app/installer'));
        File::put(storage_path('app/installer/installed.lock'), 'installed=true');

        $this->get('/install')->assertStatus(423);
        $this->get('/')->assertOk();
    }

    public function test_database_validation_failure_returns_safe_error(): void
    {
        $checker = new InstallerPreflightChecker(
            databaseProbe: fn () => throw new RuntimeException('SQLSTATE password=secret C:\\Users\\ALP\\Pictures\\mic\\.env')
        );

        $database = collect($checker->checks())->firstWhere('key', 'database');

        $this->assertSame('blocker', $database?->status);
        $this->assertSame('installer.messages.database_failed_safe', $database?->messageKey);
        $this->assertStringNotContainsString('secret', __($database->messageKey));
        $this->assertStringNotContainsString('C:\\Users', __($database->messageKey));
    }

    public function test_sensitive_installer_values_are_masked(): void
    {
        $masked = (new SecretMasker())->mask([
            'DB_PASSWORD' => 'super-secret',
            'APP_KEY' => 'base64:key',
            'public' => 'visible',
        ]);

        $this->assertSame('[masked]', $masked['DB_PASSWORD']);
        $this->assertSame('[masked]', $masked['APP_KEY']);
        $this->assertSame('visible', $masked['public']);
    }

    public function test_step_progress_survives_refresh_without_database_session_dependency(): void
    {
        $this->get('/install?step=database')->assertOk();

        $this->assertSame('database', (new InstallerProgressRepository())->currentStep());
        $this->get('/install')->assertSee(__('installer.steps.database'));
    }

    public function test_lock_creation_marks_installation_when_no_blockers_remain(): void
    {
        $state = new InstallationState();
        $state->clearLock();

        $this->post('/install/lock')->assertRedirect('/');

        $this->assertTrue($state->isInstalled());
    }
}
