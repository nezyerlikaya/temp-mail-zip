<?php

namespace Tests\Feature\Navigation;

use App\Modules\Navigation\Data\AdminNavigationItem;
use App\Modules\Navigation\Data\NavigationItem;
use App\Modules\Navigation\Enums\NavigationStatus;
use App\Modules\Navigation\Exceptions\DuplicateNavigationItemException;
use App\Modules\Navigation\Exceptions\InvalidNavigationItemException;
use App\Modules\Navigation\Services\AdminNavigationRegistry;
use App\Modules\Navigation\Services\NavigationManifest;
use App\Modules\Navigation\Services\NavigationRegistry;
use Tests\TestCase;

class NavigationRegistryTest extends TestCase
{
    public function test_navigation_manifest_registers_only_real_public_home_route(): void
    {
        $registry = new NavigationRegistry();

        (new NavigationManifest())->registerDefaults($registry);

        $items = $registry->resolve('public');

        $this->assertCount(1, $items);
        $this->assertSame('public.home', $items[0]->key);
        $this->assertSame('navigation.public.home', $items[0]->labelKey);
    }

    public function test_duplicate_navigation_keys_are_rejected(): void
    {
        $registry = new NavigationRegistry();
        $item = new NavigationItem('public.home', 'Navigation', 'public', 'navigation.public.home', 'home');

        $registry->register($item);

        $this->expectException(DuplicateNavigationItemException::class);

        $registry->register($item);
    }

    public function test_invalid_menu_metadata_is_rejected(): void
    {
        $this->expectException(InvalidNavigationItemException::class);

        new NavigationItem('public.home', 'Navigation', 'public', 'Home', 'home');
    }

    public function test_missing_named_routes_are_rejected(): void
    {
        $this->expectException(InvalidNavigationItemException::class);

        (new NavigationRegistry())->register(new NavigationItem(
            key: 'public.missing',
            owner: 'Navigation',
            area: 'public',
            labelKey: 'navigation.public.missing',
            routeName: 'missing.route',
        ));
    }

    public function test_deprecated_admin_navigation_is_hidden_by_default(): void
    {
        $registry = new AdminNavigationRegistry();
        $registry->register(new AdminNavigationItem(
            key: 'admin.dashboard',
            owner: 'Admin',
            group: 'system',
            labelKey: 'admin.navigation.dashboard',
            routeName: 'home',
            permission: 'admin.view',
            order: 10,
            status: NavigationStatus::Active,
            version: 1,
        ));
        $registry->register(new AdminNavigationItem(
            key: 'admin.legacy',
            owner: 'Admin',
            group: 'system',
            labelKey: 'admin.navigation.legacy',
            routeName: 'home',
            permission: 'admin.view',
            order: 20,
            status: NavigationStatus::Deprecated,
            version: 1,
        ));

        $this->assertSame(['admin.dashboard'], array_map(fn ($item) => $item->key, $registry->visible()));
        $this->assertSame(['admin.dashboard', 'admin.legacy'], array_map(fn ($item) => $item->key, $registry->visible(includeDeprecated: true)));
    }

    public function test_placeholder_admin_navigation_entries_are_rejected(): void
    {
        $this->expectException(InvalidNavigationItemException::class);

        new AdminNavigationItem(
            key: 'admin.placeholder',
            owner: 'Admin',
            group: 'system',
            labelKey: 'admin.navigation.placeholder',
            routeName: 'home',
            permission: 'admin.view',
            order: 10,
            status: NavigationStatus::Active,
            version: 1,
        );
    }
}
