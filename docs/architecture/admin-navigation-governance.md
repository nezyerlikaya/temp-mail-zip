# Admin Navigation Governance

Admin navigation is not a static sidebar. It is a permission-aware, module-owned, registry-driven navigation surface.

## Core Rule

No admin menu item may be hardcoded into the shell. A menu item is visible only when it is registered by its owning module and passes the current Admin Navigation Manifest contract.

## Manifest Contract

Each registered admin menu item must define:

- `key`: stable unique identifier, for example `domains.inventory`.
- `owner`: owning module, for example `Domains`.
- `group`: top-level admin group, for example `domains`.
- `label`: translation key, not raw text.
- `route`: named route.
- `permission`: authorization ability or permission.
- `status`: `active`, `deprecated`, or `removed`.
- `version`: current menu contract version.
- `order`: integer ordering within its group.

Missing required fields make the menu item invalid and it must not render.

## One Owner Per Menu

Each admin menu concept has one owner:

| Menu Area | Owner |
| --- | --- |
| Dashboard | Admin/System Health |
| Setup/Installer | Installer |
| Settings | Settings |
| Feature Flags/Gates | Feature Flags / Feature Gates |
| Languages | Localization |
| Translations | Translation |
| Navigation | Navigation |
| Themes/Appearance | Theme / Appearance |
| Domains | Domains |
| Mailboxes | Mailboxes |
| Messages | Message Storage |
| Abuse/Rate Limits/Quarantine | Abuse / Rate Limits / Quarantine |
| Users/Auth/Roles/Staff | Auth / Authorization / Staff |
| Plans/Subscriptions/API | Plans / Subscriptions / API Access |
| Content | Owning content modules |
| Monitoring/Audit/Backup/Ops | Monitoring / Audit / Backup / Ops owners |

Other modules may contribute only through documented extension slots. They must not duplicate or hijack another owner menu.

## Legacy Menu Protection

Old and new menu items must not coexist for the same user journey.

Lifecycle:

```text
active -> deprecated -> removed
```

Rules:

- A deprecated menu item is not visible in the sidebar unless explicitly allowed for a migration screen.
- If a new menu replaces an old one, the old menu must define `replaces` or `replaced_by`.
- Old routes may redirect, but old sidebar entries must disappear.
- No legacy menu item may remain visible unless it passes the current manifest contract.

## Collision Checks

Before completion, verify:

- No duplicate `key`.
- No duplicate route with different owners.
- No visible deprecated items.
- No raw labels.
- No missing permissions.
- No menu item registered by a non-owner module.
- No placeholder or coming-soon sidebar entries.

## UI Rules

- Admin shell renders resolved menu only.
- Hidden navigation is not authorization. Policies/gates must still protect routes.
- Empty menu groups do not render.
- Contextual screens such as edit/detail/history may exist without sidebar entries.
- Use Blade components and semantic tokens. No raw standalone HTML admin screens.


