<?php

namespace App\Modules\Translation\Services;

use App\Modules\Translation\Exceptions\InvalidTranslationException;

final class TranslationResolver
{
    /**
     * @param array<string, array<string, string>> $lines
     */
    public function __construct(
        private readonly TranslationNamespaceRegistry $namespaces,
        private array $lines = [],
    ) {
    }

    /**
     * @param array<string, string|int|float|bool> $replacements
     */
    public function get(string $key, string $locale, string $fallbackLocale, array $replacements = []): string
    {
        $this->namespaces->assertRegisteredKey($key);

        $isMissing = ! isset($this->lines[$locale][$key]) && ! isset($this->lines[$fallbackLocale][$key]);
        $line = $this->lines[$locale][$key] ?? $this->lines[$fallbackLocale][$key] ?? "[missing:{$locale}:{$key}]";

        $this->assertSafeLine($line);

        if (! $isMissing) {
            $this->assertPlaceholdersMatch($key, $line, $replacements);
        }

        foreach ($replacements as $name => $value) {
            $line = str_replace(':'.$name, e((string) $value), $line);
        }

        return $line;
    }

    public function forget(string $locale, string $namespace): void
    {
        foreach (array_keys($this->lines[$locale] ?? []) as $key) {
            if (str_starts_with($key, $namespace.'.')) {
                unset($this->lines[$locale][$key]);
            }
        }
    }

    private function assertSafeLine(string $line): void
    {
        if ($line !== strip_tags($line)) {
            throw new InvalidTranslationException('Raw HTML translations are prohibited.');
        }
    }

    /**
     * @param array<string, string|int|float|bool> $replacements
     */
    private function assertPlaceholdersMatch(string $key, string $line, array $replacements): void
    {
        preg_match_all('/:([a-zA-Z_][a-zA-Z0-9_]*)/', $line, $matches);
        $expected = array_unique($matches[1]);
        sort($expected);

        $actual = array_keys($replacements);
        sort($actual);

        if ($expected !== $actual) {
            throw new InvalidTranslationException("Translation placeholders for [{$key}] do not match replacements.");
        }
    }
}
