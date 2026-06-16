<?php

namespace App\Modules\Navigation\Data;

use App\Modules\Navigation\Enums\NavigationStatus;
use App\Modules\Navigation\Exceptions\InvalidNavigationItemException;

final readonly class NavigationItem
{
    public function __construct(
        public string $key,
        public string $owner,
        public string $area,
        public string $labelKey,
        public string $routeName,
        public int $order = 100,
        public NavigationStatus $status = NavigationStatus::Active,
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        if (preg_match('/^[a-z][a-z0-9_]*(\.[a-z][a-z0-9_]*)+$/', $this->key) !== 1) {
            throw new InvalidNavigationItemException('Navigation keys must use owner-aware dot notation.');
        }

        if (! in_array($this->area, ['public', 'guest', 'user', 'admin'], true)) {
            throw new InvalidNavigationItemException('Unsupported navigation area.');
        }

        if (trim($this->owner) === '' || trim($this->routeName) === '') {
            throw new InvalidNavigationItemException('Navigation owner and route are required.');
        }

        if (preg_match('/^[a-z][a-z0-9_]*(\.[a-z][a-z0-9_]*)+$/', $this->labelKey) !== 1) {
            throw new InvalidNavigationItemException('Navigation labels must be translation keys.');
        }

        if (str_contains(strtolower($this->labelKey), 'coming soon') || str_contains(strtolower($this->key), 'placeholder')) {
            throw new InvalidNavigationItemException('Placeholder navigation entries are not allowed.');
        }
    }
}
