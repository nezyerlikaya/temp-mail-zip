<?php

namespace App\Modules\Security\Services;

use Stringable;

final class SecretMasker
{
    private const MASK = '[masked]';

    /**
     * @var list<string>
     */
    private const SENSITIVE_KEYS = [
        'password',
        'token',
        'secret',
        'apikey',
        'appkey',
        'accesskey',
        'encryptionkey',
        'privatekey',
        'authorization',
        'cookie',
        'session',
    ];

    public function mask(mixed $value): mixed
    {
        if (is_array($value)) {
            return $this->maskArray($value);
        }

        if (is_string($value)) {
            return $this->maskString($value);
        }

        if ($value instanceof Stringable) {
            return $this->maskString((string) $value);
        }

        if (is_object($value)) {
            return '[object:'.str_replace('\\', '.', $value::class).']';
        }

        return $value;
    }

    /**
     * @param array<array-key, mixed> $values
     *
     * @return array<array-key, mixed>
     */
    private function maskArray(array $values): array
    {
        $masked = [];

        foreach ($values as $key => $value) {
            if (is_string($key) && $this->isSensitiveKey($key)) {
                $masked[$key] = self::MASK;

                continue;
            }

            $masked[$key] = $this->mask($value);
        }

        return $masked;
    }

    public function maskString(string $value): string
    {
        $masked = preg_replace(
            '/\b(authorization\s*[:=]\s*)(bearer\s+)?[^\s,;]+/i',
            '$1$2'.self::MASK,
            $value
        ) ?? $value;

        $masked = preg_replace(
            '/\b(password|token|secret|api[_-]?key|access[_-]?key|private[_-]?key|authorization|cookie)\s*=\s*([^&\s;]+)/i',
            '$1='.self::MASK,
            $masked
        ) ?? $masked;

        return preg_replace('/\b(Bearer\s+)[A-Za-z0-9._~+\/=-]+/i', '$1'.self::MASK, $masked) ?? $masked;
    }

    private function isSensitiveKey(string $key): bool
    {
        $normalized = strtolower((string) preg_replace('/[^a-zA-Z0-9]/', '', $key));

        foreach (self::SENSITIVE_KEYS as $sensitiveKey) {
            if (str_contains($normalized, $sensitiveKey)) {
                return true;
            }
        }

        return false;
    }
}
