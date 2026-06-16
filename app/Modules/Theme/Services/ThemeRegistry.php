<?php

namespace App\Modules\Theme\Services;

use App\Modules\Theme\Data\ThemeDefinition;

final class ThemeRegistry
{
    /**
     * @var array<string, ThemeDefinition>
     */
    private array $themes;

    public function __construct()
    {
        $this->themes = [
            'atlas' => new ThemeDefinition('atlas', 'theme.atlas.label', 'theme.atlas.description'),
            'horizon' => new ThemeDefinition('horizon', 'theme.horizon.label', 'theme.horizon.description'),
            'legacy' => new ThemeDefinition('legacy', 'theme.legacy.label', 'theme.legacy.description'),
        ];
    }

    public function resolve(?string $key): ThemeDefinition
    {
        return $this->themes[$key ?? ''] ?? $this->themes['horizon'];
    }

    /**
     * @return list<string>
     */
    public function keys(): array
    {
        return array_keys($this->themes);
    }
}
