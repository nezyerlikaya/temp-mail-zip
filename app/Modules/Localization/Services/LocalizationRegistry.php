<?php

namespace App\Modules\Localization\Services;

use App\Modules\Localization\Data\LanguageDefinition;
use App\Modules\Localization\Enums\LanguageDirection;
use App\Modules\Localization\Enums\LanguageStatus;
use App\Modules\Localization\Exceptions\InvalidLanguageRegistryException;

final class LocalizationRegistry
{
    /**
     * @var array<string, LanguageDefinition>
     */
    private array $languages;

    /**
     * @param list<array<string, mixed>>|null $languageConfig
     */
    public function __construct(
        ?array $languageConfig = null,
        private readonly ?string $defaultLocale = null,
        private readonly ?string $fallbackLocale = null,
    ) {
        $this->languages = $this->buildLanguages($languageConfig ?? config('localization.languages', []));
        $this->assertExactlyOneDefault();
    }

    public function find(string $code): ?LanguageDefinition
    {
        return $this->languages[$this->normalize($code)] ?? null;
    }

    public function default(): LanguageDefinition
    {
        $configuredDefault = $this->defaultLocale ?? config('localization.default_locale');

        if (is_string($configuredDefault) && ($language = $this->find($configuredDefault)) !== null && $language->isResolvable()) {
            return $language;
        }

        foreach ($this->languages as $language) {
            if ($language->isDefault && $language->isResolvable()) {
                return $language;
            }
        }

        throw new InvalidLanguageRegistryException('No active default locale is registered.');
    }

    public function fallback(): LanguageDefinition
    {
        $configuredFallback = $this->fallbackLocale ?? config('localization.fallback_locale');

        if (is_string($configuredFallback) && ($language = $this->find($configuredFallback)) !== null && $language->isResolvable()) {
            return $language;
        }

        return $this->default();
    }

    /**
     * @return list<LanguageDefinition>
     */
    public function publicLanguages(): array
    {
        return array_values(array_filter(
            $this->languages,
            fn (LanguageDefinition $language): bool => $language->status === LanguageStatus::Active && $language->isPublic
        ));
    }

    public function validateRouteLocale(?string $locale, bool $allowHidden = false): ?LanguageDefinition
    {
        if ($locale === null || $locale === '') {
            return null;
        }

        $language = $this->find($locale);

        if ($language === null || ! $language->isResolvable($allowHidden)) {
            return null;
        }

        return $language;
    }

    private function normalize(string $code): string
    {
        $parts = explode('-', str_replace('_', '-', trim($code)));

        if (count($parts) === 1) {
            return strtolower($parts[0]);
        }

        return strtolower($parts[0]).'-'.strtoupper($parts[1]);
    }

    /**
     * @param list<array<string, mixed>> $languageConfig
     *
     * @return array<string, LanguageDefinition>
     */
    private function buildLanguages(array $languageConfig): array
    {
        $languages = [];

        foreach ($languageConfig as $language) {
            $definition = new LanguageDefinition(
                code: (string) $language['code'],
                name: (string) $language['name'],
                nativeName: (string) ($language['native_name'] ?? $language['name']),
                direction: LanguageDirection::from((string) $language['direction']),
                status: LanguageStatus::from((string) $language['status']),
                isDefault: (bool) ($language['is_default'] ?? false),
                isPublic: (bool) ($language['is_public'] ?? false),
            );

            if (isset($languages[$definition->code])) {
                throw new InvalidLanguageRegistryException("Duplicate locale [{$definition->code}] registered.");
            }

            $languages[$definition->code] = $definition;
        }

        return $languages;
    }

    private function assertExactlyOneDefault(): void
    {
        $defaults = array_filter(
            $this->languages,
            fn (LanguageDefinition $language): bool => $language->isDefault
        );

        if (count($defaults) !== 1) {
            throw new InvalidLanguageRegistryException('Exactly one default language must be registered.');
        }
    }
}
