# Admin Shell

The Admin module owns the admin Blade layout, admin page shell, admin navigation composition, breadcrumbs, flash/alert presentation, safe empty states, and dashboard shell preparation.

It does not own authentication, authorization, staff records, business modules, settings definitions, navigation definitions owned by other modules, theme definitions, audit storage, monitoring, mailbox content, or message content.

Admin menu rules are governed by `docs/architecture/admin-navigation-governance.md`.

## Routes

Admin routes live in `routes/admin.php`, use the `admin.` route-name prefix, and use the URL prefix from `config/admin.php`. The initial shell route is `admin.dashboard`.

Authentication and authorization are not implemented yet. The temporary shell middleware blocks production access until STEP032 and STEP033 provide real protection. There are no fake role checks, hardcoded admin emails, or business management routes.

## Layout And Components

The admin shell uses Blade components under `resources/views/components/admin` and `resources/views/components/layouts/admin.blade.php`. Components use escaped output, semantic landmarks, theme tokens, shared UI primitives from `resources/views/components/ui` where practical, and translation keys.

Admin UI follows `docs/UI-STANDARD.md`: Zinc Light surfaces, clear page headers, section cards, bounded tables, safe empty states, accessible controls, and no raw technical dumps.

The dashboard view is a verification shell only. It contains no statistics, charts, business queries, monitoring data, mailbox/message content, support content, or placeholder cards for future modules.

## Dashboard And Admin Constitution

Admin follows these principles:

- Meaningful Data Only
- Zero Placeholder
- Shell First
- Bounded Widgets
- Actionable Empty States

Admin dashboard must never show fake metrics, placeholder widgets, empty cards, decorative panels, `&nbsp;` filler, or "coming soon" cards.

If meaningful data exists, show a bounded widget.

If meaningful data does not exist, show an actionable empty state.

If the owning module is not implemented or not enabled, do not render the widget.

Dashboard widgets are consumers, not owners:

- System Health owns health data.
- Domains owns domain inventory.
- Audit Center owns audit events.
- Backup owns backup freshness.
- Launch Readiness owns launch checklist state.
- Admin dashboard only composes admin-safe summaries from owning modules.

Dashboard must not query business tables directly when an owning module exposes a safe summary resolver/service.

## Admin Shell First

Before modernizing individual admin pages, establish the admin shell:

- persistent sidebar/topbar structure
- page header
- breadcrumbs where useful
- main content container
- responsive navigation behavior
- safe flash/alert area
- shared empty state area

Pages should compose inside the shell instead of duplicating shell markup.

## Admin Component Hierarchy

Admin screens should prefer:

- `x-admin.shell`
- `x-admin.page-header`
- `x-admin.breadcrumbs`
- `x-ui.card`
- `x-ui.badge`
- `x-ui.button`
- `x-ui.empty-state`
- `x-ui.alert`

Do not introduce dashboard-specific one-off card systems.

## Integrations

Admin consumes:

- Navigation Registry area `admin`
- Translation Resolver for labels and shell text
- Locale Resolver for `lang` and `dir`
- Theme Resolver for `data-theme`
- Security headers from the global security middleware

Hidden navigation is not authorization. Admin actions must use server-side authorization when their owning modules introduce state-changing behavior.

## Security And Accessibility

The shell must not render secrets, raw exceptions, internal paths, provider payloads, tokens, audit metadata, or sensitive profile data. It includes semantic regions, a skip link, keyboard focus styles, and accessible navigation labels. Alpine usage is limited to local sidebar state and does not contain private data.

## Shared Hosting

The shell requires no runtime Node.js process, websocket, Redis, daemon, or external UI service. Built Vite assets remain static deployable assets.


