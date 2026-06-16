<?php

namespace Tests\Feature\Localization;

use App\Modules\Localization\Enums\LanguageDirection;
use App\Modules\Localization\Exceptions\UnsupportedLocaleException;
use App\Modules\Localization\Services\LocaleResolver;
use App\Modules\Localization\Services\LocalizationRegistry;
use Tests\TestCase;

class LocaleResolverTest extends TestCase
{
    public function test_it_resolves_default_locale_when_no_candidate_is_available(): void
    {
        $context = $this->resolver()->resolve();

        $this->assertSame('en', $context->lang());
        $this->assertSame('ltr', $context->dir());
        $this->assertSame('en', $context->fallbackLanguage->code);
    }

    public function test_route_locale_wins_over_other_candidates(): void
    {
        $context = $this->resolver()->resolve(
            routeLocale: 'tr',
            userPreference: 'de',
            cookieLocale: 'fr',
            acceptLanguage: 'es,en;q=0.8',
        );

        $this->assertSame('tr', $context->lang());
    }

    public function test_inactive_locales_are_not_public_or_resolvable_by_default(): void
    {
        $registry = new LocalizationRegistry($this->customLanguages([
            [
                'code' => 'ar',
                'name' => 'Arabic',
                'native_name' => 'Arabic',
                'direction' => 'rtl',
                'status' => 'disabled',
                'is_default' => false,
                'is_public' => false,
            ],
        ]));

        $this->assertNull($registry->validateRouteLocale('ar'));
        $this->assertNotContains('ar', array_map(fn ($language) => $language->code, $registry->publicLanguages()));
    }

    public function test_hidden_locales_can_be_resolved_only_when_allowed(): void
    {
        $registry = new LocalizationRegistry($this->customLanguages([
            [
                'code' => 'ar',
                'name' => 'Arabic',
                'native_name' => 'Arabic',
                'direction' => 'rtl',
                'status' => 'hidden',
                'is_default' => false,
                'is_public' => false,
            ],
        ]));

        $this->assertNull($registry->validateRouteLocale('ar'));
        $this->assertSame('ar', $registry->validateRouteLocale('ar', allowHidden: true)?->code);
    }

    public function test_accept_language_falls_back_to_supported_base_locale(): void
    {
        $context = $this->resolver()->resolve(acceptLanguage: 'de-DE,de;q=0.9,en;q=0.8');

        $this->assertSame('de', $context->lang());
    }

    public function test_direction_metadata_supports_rtl_and_route_validation_rejects_disabled_locale(): void
    {
        $registry = new LocalizationRegistry($this->customLanguages([
            [
                'code' => 'ar',
                'name' => 'Arabic',
                'native_name' => 'Arabic',
                'direction' => 'rtl',
                'status' => 'active',
                'is_default' => false,
                'is_public' => true,
            ],
        ]));

        $this->assertSame(LanguageDirection::Rtl, $registry->find('ar')?->direction);
        $this->assertSame('rtl', (new LocaleResolver($registry))->resolve(routeLocale: 'ar')->dir());

        $this->expectException(UnsupportedLocaleException::class);

        (new LocaleResolver($registry))->validateRouteLocale('zz');
    }

    private function resolver(): LocaleResolver
    {
        return new LocaleResolver(new LocalizationRegistry());
    }

    /**
     * @param list<array<string, mixed>> $extra
     *
     * @return list<array<string, mixed>>
     */
    private function customLanguages(array $extra): array
    {
        return [
            [
                'code' => 'en',
                'name' => 'English',
                'native_name' => 'English',
                'direction' => 'ltr',
                'status' => 'active',
                'is_default' => true,
                'is_public' => true,
            ],
            ...$extra,
        ];
    }
}
