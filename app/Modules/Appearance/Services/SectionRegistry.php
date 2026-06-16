<?php

namespace App\Modules\Appearance\Services;

use App\Modules\Appearance\Data\SectionDefinition;
use App\Modules\Appearance\Exceptions\InvalidSectionException;

final class SectionRegistry
{
    /**
     * @var list<string>
     */
    private array $approved = [
        'header',
        'footer',
        'mailbox_generator',
        'inbox_preview',
        'faq',
        'blog_teaser',
        'plans_teaser',
        'documentation_teaser',
        'knowledge_base_teaser',
        'cta',
        'trust_security',
        'ad_top',
        'ad_inline',
    ];

    /**
     * @var array<string, SectionDefinition>
     */
    private array $sections = [];

    public function register(SectionDefinition $section): void
    {
        if (! in_array($section->key, $this->approved, true)) {
            throw new InvalidSectionException("Section [{$section->key}] is not approved.");
        }

        if (isset($this->sections[$section->key])) {
            throw new InvalidSectionException("Section [{$section->key}] is already registered.");
        }

        if (str_starts_with($section->key, 'ad_') && ! $section->isApprovedAdSlot) {
            throw new InvalidSectionException('Ads must be represented only as approved slots.');
        }

        $this->sections[$section->key] = $section;
    }

    /**
     * @return list<SectionDefinition>
     */
    public function renderable(): array
    {
        $sections = array_filter($this->sections, fn (SectionDefinition $section): bool => $section->shouldRender());
        usort($sections, fn (SectionDefinition $a, SectionDefinition $b): int => $a->order <=> $b->order);

        return array_values($sections);
    }
}
