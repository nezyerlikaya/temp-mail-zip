<?php

namespace App\Modules\Localization\Enums;

enum LanguageStatus: string
{
    case Active = 'active';
    case Hidden = 'hidden';
    case Disabled = 'disabled';
    case Deprecated = 'deprecated';
}
