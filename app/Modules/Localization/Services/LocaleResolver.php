<?php

namespace App\Modules\Localization\Services;

use App\Modules\Localization\Data\LanguageDefinition;
use App\Modules\Localization\Data\LocaleContext;
use App\Modules\Localization\Exceptions\UnsupportedLocaleException;
use Illuminate\Http\Request;

final class LocaleResolver
{
    public function __construct(private readonly LocalizationRegistry $registry)
    {
    }

    public function resolve(
        ?string $routeLocale = null,
        ?string $userPreference = null,
        ?string $cookieLocale = null,
        ?string $acceptLanguage = null,
    ): LocaleContext {
        $language = $this->firstResolvable([
            $routeLocale,
            $userPreference,
            $cookieLocale,
            ...$this->parseAcceptLanguage($acceptLanguage),
        ]);

        return new LocaleContext(
            activeLanguage: $language ?? $this->registry->default(),
            fallbackLanguage: $this->registry->fallback(),
        );
    }

    public function resolveFromRequest(Request $request): LocaleContext
    {
        return $this->resolve(
            routeLocale: is_string($request->route('locale')) ? $request->route('locale') : null,
            cookieLocale: $request->cookies->get('locale'),
            acceptLanguage: $request->headers->get('Accept-Language'),
        );
    }

    public function validateRouteLocale(string $locale): LanguageDefinition
    {
        return $this->registry->validateRouteLocale($locale)
            ?? throw UnsupportedLocaleException::forLocale($locale);
    }

    /**
     * @param list<string|null> $candidates
     */
    private function firstResolvable(array $candidates): ?LanguageDefinition
    {
        foreach ($candidates as $candidate) {
            if (! is_string($candidate) || trim($candidate) === '') {
                continue;
            }

            $language = $this->registry->validateRouteLocale($candidate);

            if ($language !== null) {
                return $language;
            }
        }

        return null;
    }

    /**
     * @return list<string>
     */
    private function parseAcceptLanguage(?string $header): array
    {
        if ($header === null || trim($header) === '') {
            return [];
        }

        $parsed = [];

        foreach (explode(',', $header) as $part) {
            $pieces = explode(';q=', trim($part));
            $locale = trim($pieces[0]);

            if ($locale !== '' && $locale !== '*') {
                $parsed[] = $locale;
                $base = explode('-', str_replace('_', '-', $locale))[0];

                if ($base !== $locale) {
                    $parsed[] = $base;
                }
            }
        }

        return $parsed;
    }
}
