<?php

namespace App\Modules\Navigation\Services;

use App\Modules\Navigation\Data\AdminNavigationItem;
use App\Modules\Navigation\Enums\NavigationStatus;
use App\Modules\Navigation\Exceptions\DuplicateNavigationItemException;
use App\Modules\Navigation\Exceptions\InvalidNavigationItemException;
use Illuminate\Support\Facades\Route;

final class AdminNavigationRegistry
{
    /**
     * @var array<string, AdminNavigationItem>
     */
    private array $items = [];

    public function register(AdminNavigationItem $item): void
    {
        if (isset($this->items[$item->key])) {
            throw DuplicateNavigationItemException::forKey($item->key);
        }

        if (! Route::has($item->routeName)) {
            throw new InvalidNavigationItemException("Admin route [{$item->routeName}] is not registered.");
        }

        $this->items[$item->key] = $item;
    }

    /**
     * @return list<AdminNavigationItem>
     */
    public function visible(bool $includeDeprecated = false): array
    {
        $items = array_filter($this->items, function (AdminNavigationItem $item) use ($includeDeprecated): bool {
            if ($item->status === NavigationStatus::Removed) {
                return false;
            }

            return $includeDeprecated || $item->status === NavigationStatus::Active;
        });

        usort($items, fn (AdminNavigationItem $a, AdminNavigationItem $b): int => $a->order <=> $b->order);

        return array_values($items);
    }
}
