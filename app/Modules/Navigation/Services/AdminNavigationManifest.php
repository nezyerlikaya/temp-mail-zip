<?php

namespace App\Modules\Navigation\Services;

use App\Modules\Navigation\Data\AdminNavigationItem;
use App\Modules\Navigation\Enums\NavigationStatus;

final class AdminNavigationManifest
{
    public function registerDefaults(AdminNavigationRegistry $registry): void
    {
        $registry->register(new AdminNavigationItem(
            key: 'admin.dashboard',
            owner: 'Admin',
            group: 'system',
            labelKey: 'admin.navigation.dashboard',
            routeName: 'admin.dashboard',
            permission: 'admin.view',
            order: 10,
            status: NavigationStatus::Active,
            version: 1,
        ));
    }
}
