<?php

namespace App\Modules\Theme\Data;

final readonly class ThemeDefinition
{
    public function __construct(
        public string $key,
        public string $labelKey,
        public string $descriptionKey,
    ) {
    }
}
