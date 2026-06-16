<?php

namespace App\Modules\Localization\Data;

final readonly class LocaleContext
{
    public function __construct(
        public LanguageDefinition $activeLanguage,
        public LanguageDefinition $fallbackLanguage,
    ) {
    }

    public function lang(): string
    {
        return $this->activeLanguage->code;
    }

    public function dir(): string
    {
        return $this->activeLanguage->direction->value;
    }
}
