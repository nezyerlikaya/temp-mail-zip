<?php

namespace App\Modules\Navigation\Data;

use App\Modules\Navigation\Enums\NavigationStatus;
use App\Modules\Navigation\Exceptions\InvalidNavigationItemException;

final readonly class AdminNavigationItem
{
    public function __construct(
        public string $key,
        public string $owner,
        public string $group,
        public string $labelKey,
        public string $routeName,
        public string $permission,
        public int $order,
        public NavigationStatus $status,
        public int $version,
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        foreach ([
            'key' => $this->key,
            'owner' => $this->owner,
            'group' => $this->group,
            'label' => $this->labelKey,
            'route' => $this->routeName,
            'permission' => $this->permission,
        ] as $field => $value) {
            if (trim($value) === '') {
                throw new InvalidNavigationItemException("Admin navigation {$field} is required.");
            }
        }

        if (preg_match('/^[a-z][a-z0-9_]*(\.[a-z][a-z0-9_]*)+$/', $this->key) !== 1) {
            throw new InvalidNavigationItemException('Admin navigation keys must use owner-aware dot notation.');
        }

        if (preg_match('/^[a-z][a-z0-9_]*(\.[a-z][a-z0-9_]*)+$/', $this->labelKey) !== 1) {
            throw new InvalidNavigationItemException('Admin navigation labels must be translation keys.');
        }

        if (str_contains(strtolower($this->key.$this->labelKey), 'placeholder') || str_contains(strtolower($this->key.$this->labelKey), 'comingsoon')) {
            throw new InvalidNavigationItemException('Placeholder admin navigation entries are not allowed.');
        }
    }
}
