<?php

namespace Tests\Unit\Security;

use App\Modules\Security\Services\SecretMasker;
use PHPUnit\Framework\TestCase;
use stdClass;

class SecretMaskerTest extends TestCase
{
    public function test_it_masks_common_sensitive_keys_case_insensitively(): void
    {
        $masked = (new SecretMasker())->mask([
            'password' => 'secret-password',
            'API_KEY' => 'api-key-value',
            'Authorization' => 'Bearer token-value',
            'cookie' => 'session=value',
            'safe' => 'visible',
        ]);

        $this->assertSame('[masked]', $masked['password']);
        $this->assertSame('[masked]', $masked['API_KEY']);
        $this->assertSame('[masked]', $masked['Authorization']);
        $this->assertSame('[masked]', $masked['cookie']);
        $this->assertSame('visible', $masked['safe']);
    }

    public function test_it_masks_recursively_and_does_not_serialize_objects(): void
    {
        $masked = (new SecretMasker())->mask([
            'nested' => [
                'private_key' => '-----BEGIN PRIVATE KEY-----',
                'notes' => 'authorization: Bearer inline-token',
                'object' => new stdClass(),
            ],
        ]);

        $this->assertSame('[masked]', $masked['nested']['private_key']);
        $this->assertSame('authorization: Bearer [masked]', $masked['nested']['notes']);
        $this->assertSame('[object:stdClass]', $masked['nested']['object']);
    }

    public function test_it_masks_inline_secret_fragments_in_strings(): void
    {
        $masked = (new SecretMasker())->maskString(
            'token=abc123 password=hunter2 Authorization: Bearer abc.def.ghi cookie=laravel_session'
        );

        $this->assertSame(
            'token=[masked] password=[masked] Authorization: Bearer [masked] cookie=[masked]',
            $masked
        );
    }
}
