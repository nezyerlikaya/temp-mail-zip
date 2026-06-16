<?php

namespace App\Modules\Navigation\Enums;

enum NavigationStatus: string
{
    case Active = 'active';
    case Deprecated = 'deprecated';
    case Removed = 'removed';
}
