<?php

namespace Tests\Unit\Security;

use App\Modules\Security\Services\SafeDiagnosticsFormatter;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class SafeDiagnosticsFormatterTest extends TestCase
{
    public function test_it_formats_exceptions_without_raw_message_trace_or_path(): void
    {
        $formatter = new SafeDiagnosticsFormatter();
        $diagnostics = $formatter->format(
            new RuntimeException('Database password=secret failed at C:\\Users\\ALP\\Pictures\\mic\\.env'),
            [
                'path_hint' => 'Failed at C:\\Users\\ALP\\Pictures\\mic\\storage\\logs\\laravel.log',
                'token' => 'plain-token',
                'trace' => ['unsafe raw trace'],
            ]
        );

        $this->assertSame('RuntimeException', $diagnostics['exception']);
        $this->assertSame('A safe diagnostic summary is available.', $diagnostics['message']);
        $this->assertSame('Failed at [path]', $diagnostics['context']['path_hint']);
        $this->assertSame('[masked]', $diagnostics['context']['token']);
        $this->assertSame('[omitted]', $diagnostics['context']['trace']);
        $this->assertStringNotContainsString('Database password=secret', json_encode($diagnostics, JSON_THROW_ON_ERROR));
        $this->assertStringNotContainsString('C:\\Users\\ALP', json_encode($diagnostics, JSON_THROW_ON_ERROR));
    }

    public function test_it_omits_raw_payloads_and_mailbox_private_content(): void
    {
        $diagnostics = (new SafeDiagnosticsFormatter())->format(
            new InvalidArgumentException('Unsafe raw exception message'),
            [
                'request_body' => ['password' => 'secret'],
                'provider_payload' => ['token' => 'provider-token'],
                'summary' => 'Message from user@example.com includes mailbox-private content.',
                'safe_count' => 3,
            ]
        );

        $this->assertSame('[omitted]', $diagnostics['context']['request_body']);
        $this->assertSame('[omitted]', $diagnostics['context']['provider_payload']);
        $this->assertSame('[omitted]', $diagnostics['context']['summary']);
        $this->assertSame(3, $diagnostics['context']['safe_count']);
        $this->assertStringNotContainsString('provider-token', json_encode($diagnostics, JSON_THROW_ON_ERROR));
        $this->assertStringNotContainsString('user@example.com', json_encode($diagnostics, JSON_THROW_ON_ERROR));
    }

    public function test_it_bounds_diagnostic_depth_and_item_count(): void
    {
        $context = [];

        for ($i = 0; $i < 25; $i++) {
            $context['item_'.$i] = $i;
        }

        $context['deep'] = ['a' => ['b' => ['c' => ['d' => ['e' => 'too deep']]]]];

        $diagnostics = (new SafeDiagnosticsFormatter())->format(new RuntimeException('Unsafe'), $context);

        $this->assertArrayHasKey('_truncated', $diagnostics['context']);
    }
}
