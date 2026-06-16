<?php

namespace Tests\Feature\Appearance;

use App\Modules\Appearance\Data\SectionDefinition;
use App\Modules\Appearance\Exceptions\InvalidSectionException;
use App\Modules\Appearance\Exceptions\UnsafeAppearanceValueException;
use App\Modules\Appearance\Services\AppearanceTokenGuard;
use App\Modules\Appearance\Services\SectionRegistry;
use Tests\TestCase;

class AppearanceRegistryTest extends TestCase
{
    public function test_appearance_tokens_must_be_approved_values(): void
    {
        $guard = new AppearanceTokenGuard();

        $this->assertSame('brand.primary', $guard->assertAllowed('brand.primary', ['brand.primary']));

        $this->expectException(UnsafeAppearanceValueException::class);

        $guard->assertAllowed('body { display:none; }', ['brand.primary']);
    }

    public function test_section_registry_accepts_only_approved_sections(): void
    {
        $registry = new SectionRegistry();
        $registry->register(new SectionDefinition(
            key: 'faq',
            owner: 'Theme',
            enabled: true,
            order: 20,
            hasContent: true,
        ));

        $this->assertSame(['faq'], array_map(fn ($section) => $section->key, $registry->renderable()));

        $this->expectException(InvalidSectionException::class);

        $registry->register(new SectionDefinition(
            key: 'custom_html_block',
            owner: 'Theme',
            enabled: true,
            order: 30,
            hasContent: true,
        ));
    }

    public function test_empty_or_disabled_sections_do_not_render(): void
    {
        $registry = new SectionRegistry();
        $registry->register(new SectionDefinition('faq', 'Theme', true, 20, hasContent: false));
        $registry->register(new SectionDefinition('cta', 'Theme', false, 10, hasContent: true));
        $registry->register(new SectionDefinition('header', 'Theme', true, 1, requiresContent: false));

        $this->assertSame(['header'], array_map(fn ($section) => $section->key, $registry->renderable()));
    }

    public function test_ads_must_be_registered_as_approved_slots(): void
    {
        $registry = new SectionRegistry();
        $registry->register(new SectionDefinition(
            key: 'ad_top',
            owner: 'Appearance',
            enabled: true,
            order: 5,
            requiresContent: false,
            isApprovedAdSlot: true,
        ));

        $this->assertSame(['ad_top'], array_map(fn ($section) => $section->key, $registry->renderable()));

        $this->expectException(InvalidSectionException::class);

        (new SectionRegistry())->register(new SectionDefinition(
            key: 'ad_inline',
            owner: 'Appearance',
            enabled: true,
            order: 5,
            requiresContent: false,
            isApprovedAdSlot: false,
        ));
    }
}
