<?php

namespace App\Modules\Security\Services;

use Throwable;

final class SafeDiagnosticsFormatter
{
    private const MAX_DEPTH = 4;

    private const MAX_ITEMS = 20;

    private const MAX_STRING_LENGTH = 240;

    /**
     * @var list<string>
     */
    private const OMITTED_KEYS = [
        'body',
        'content',
        'email',
        'exception',
        'file',
        'message_body',
        'payload',
        'provider_payload',
        'raw',
        'raw_content',
        'request',
        'request_body',
        'trace',
    ];

    public function __construct(private readonly SecretMasker $secretMasker = new SecretMasker())
    {
    }

    /**
     * @param array<string, mixed> $context
     *
     * @return array<string, mixed>
     */
    public function format(Throwable $exception, array $context = []): array
    {
        return [
            'status' => 'error',
            'exception' => $this->safeClassName($exception::class),
            'message' => 'A safe diagnostic summary is available.',
            'context' => $this->sanitizeArray($context),
        ];
    }

    /**
     * @param array<array-key, mixed> $values
     *
     * @return array<array-key, mixed>
     */
    private function sanitizeArray(array $values, int $depth = 0): array
    {
        if ($depth >= self::MAX_DEPTH) {
            return ['_truncated' => 'Maximum diagnostic depth reached.'];
        }

        $safe = [];
        $count = 0;

        foreach ($values as $key => $value) {
            if ($count >= self::MAX_ITEMS) {
                $safe['_truncated'] = 'Maximum diagnostic item count reached.';

                break;
            }

            if (is_string($key) && $this->shouldOmitKey($key)) {
                $safe[$key] = '[omitted]';
                $count++;

                continue;
            }

            if (is_string($key)) {
                $maskedByKey = $this->secretMasker->mask([$key => $value]);

                if (array_key_exists($key, $maskedByKey) && $maskedByKey[$key] === '[masked]') {
                    $safe[$key] = '[masked]';
                    $count++;

                    continue;
                }
            }

            $safe[$key] = $this->sanitizeValue($value, $depth + 1);
            $count++;
        }

        return $safe;
    }

    private function sanitizeValue(mixed $value, int $depth): mixed
    {
        if (is_array($value)) {
            return $this->sanitizeArray($value, $depth);
        }

        if (is_string($value)) {
            return $this->sanitizeString($value);
        }

        if ($value instanceof Throwable) {
            return '[exception:'.$this->safeClassName($value::class).']';
        }

        if (is_object($value)) {
            return '[object:'.$this->safeClassName($value::class).']';
        }

        return $value;
    }

    private function sanitizeString(string $value): string
    {
        if ($this->looksLikeMailboxPrivateContent($value)) {
            return '[omitted]';
        }

        $safe = $this->secretMasker->maskString($value);
        $safe = $this->anonymizePaths($safe);

        if (strlen($safe) > self::MAX_STRING_LENGTH) {
            return substr($safe, 0, self::MAX_STRING_LENGTH).'...';
        }

        return $safe;
    }

    private function shouldOmitKey(string $key): bool
    {
        $normalized = strtolower((string) preg_replace('/[^a-zA-Z0-9]/', '', $key));

        foreach (self::OMITTED_KEYS as $omittedKey) {
            if (str_contains($normalized, strtolower(str_replace('_', '', $omittedKey)))) {
                return true;
            }
        }

        return false;
    }

    private function anonymizePaths(string $value): string
    {
        $value = preg_replace('/[A-Z]:\\\\(?:[^\\\\\s]+\\\\)+[^\\\\\s]*/i', '[path]', $value) ?? $value;

        return preg_replace('#/(?:home|var|tmp|private|Users|usr)/(?:[^\s:;]+/?)+#', '[path]', $value) ?? $value;
    }

    private function looksLikeMailboxPrivateContent(string $value): bool
    {
        if (strlen($value) < 20) {
            return false;
        }

        return preg_match('/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}/i', $value) === 1;
    }

    private function safeClassName(string $class): string
    {
        $parts = explode('\\', $class);

        return end($parts) ?: 'Unknown';
    }
}
