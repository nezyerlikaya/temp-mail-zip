<?php

namespace App\Modules\Translation\Services;

use App\Modules\Translation\Exceptions\DuplicateTranslationNamespaceException;
use App\Modules\Translation\Exceptions\UnknownTranslationNamespaceException;

final class TranslationNamespaceRegistry
{
    /**
     * @var array<string, string>
     */
    private array $owners = [];

    public function register(string $namespace, string $owner): void
    {
        if (preg_match('/^[a-z][a-z0-9_]*$/', $namespace) !== 1) {
            throw new UnknownTranslationNamespaceException('Translation namespaces must be lowercase identifiers.');
        }

        if (isset($this->owners[$namespace])) {
            throw DuplicateTranslationNamespaceException::forNamespace($namespace);
        }

        $this->owners[$namespace] = $owner;
    }

    public function owner(string $namespace): string
    {
        return $this->owners[$namespace] ?? throw UnknownTranslationNamespaceException::forNamespace($namespace);
    }

    public function assertRegisteredKey(string $key): string
    {
        $namespace = explode('.', $key, 2)[0] ?? '';
        $this->owner($namespace);

        if (preg_match('/^[a-z][a-z0-9_]*(\.[a-z][a-z0-9_]*)+$/', $key) !== 1) {
            throw new UnknownTranslationNamespaceException('Translation keys must use namespace dot notation.');
        }

        return $namespace;
    }
}
