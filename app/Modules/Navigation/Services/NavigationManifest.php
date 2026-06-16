<?php

namespace App\Modules\Navigation\Services;

use App\Modules\Navigation\Data\NavigationItem;

final class NavigationManifest
{
    public function registerDefaults(NavigationRegistry $registry): void
    {
        $registry->register(new NavigationItem(
            key: 'public.home',
            owner: 'Navigation',
            area: 'public',
            labelKey: 'navigation.public.home',
            routeName: 'home',
            order: 10,
        ));
    }
}
