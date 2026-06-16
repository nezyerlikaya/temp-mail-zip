<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        File::ensureDirectoryExists(storage_path('app/installer'));
        File::put(storage_path('app/installer/installed.lock'), 'installed=true');
    }

    protected function tearDown(): void
    {
        File::delete(storage_path('app/installer/installed.lock'));

        parent::tearDown();
    }

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
