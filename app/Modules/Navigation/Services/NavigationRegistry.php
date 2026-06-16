<?php

namespace App\Modules\Navigation\Services;

use App\Modules\Navigation\Data\NavigationItem;
use App\Modules\Navigation\Enums\NavigationStatus;
use App\Modules\Navigation\Exceptions\DuplicateNavigationItemException;
use App\Modules\Navigation\Exceptions\InvalidNavigationItemException;
use Illuminate\Support\Facades\Route;

final class NavigationRegistry
{
    /**
     * @var array<string, NavigationItem>
     */
    private array $items = [];

    public function register(NavigationItem $item): void
    {
        if (isset($this->items[$item->key])) {
            throw DuplicateNavigationItemException::forKey($item->key);
        }

        if (! Route::has($item->routeName)) {
            throw new InvalidNavigationItemException("Navigation route [{$item->routeName}] is not registered.");
        }

        $this->items[$item->key] = $item;
    }

    /**
     * @return list<NavigationItem>
     */
    public function resolve(string $area, bool $includeDeprecated = false): array
    {
        $items = array_filter($this->items, function (NavigationItem $item) use ($area, $includeDeprecated): bool {
            if ($item->area !== $area || $item->status === NavigationStatus::Removed) {
                return false;
            }

            return $includeDeprecated || $item->status === NavigationStatus::Active;
        });

        usort($items, fn (NavigationItem $a, NavigationItem $b): int => $a->order <=> $b->order);

        return array_values($items);
    }
}
