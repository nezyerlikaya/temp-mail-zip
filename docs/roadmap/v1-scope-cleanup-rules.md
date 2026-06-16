# Temp Mail SaaS - Scope Cleanup Rules

This document is the cleanup filter for the corrected v1 roadmap and prompt list.

## Target Stack

- Laravel 13
- PHP 8.5.7
- Blade layouts and Blade components
- Tailwind CSS v4 (CSS-first)
- Alpine.js
- Vite
- Pure SSR
- MySQL/MariaDB-compatible migrations
- Laravel scheduler with shared-hosting cron
- Laravel validation, policies/gates, events, jobs, and tests

Do not build raw standalone HTML pages. UI must use Blade layouts, reusable components, named routes, localization keys, navigation resolution, SEO resolution where needed, and theme tokens. Do not build page builders, arbitrary HTML editors, arbitrary CSS editors, arbitrary JavaScript editors, or static admin screens.

## Out Of Scope For v1

The following systems are removed from the v1 roadmap and prompt list:

- Marketplace
- Community
- SDK
- AI translation
- Semantic or AI search
- Advanced analytics
- Public social profiles, badges, and reputation
- Full developer portal
- Comments / public discussion systems
- Public status page as a required v1 code module

Do not create modules, tables, DTOs, services, jobs, routes, admin preparations, compatibility layers, placeholder abstractions, or future hooks for these systems in v1.

Frontend remains pure SSR with Alpine.js only for UI-local state. Do not add Livewire, Inertia, Vue, or React as v1 requirements.

## Cleanup Rules

Remove future-compatibility clutter from prompts. A prompt must implement only its own current scope.

Future-proofing is allowed only when it strengthens the current scope without adding placeholder debt. Future-proof the boundary, not the feature.

Avoid unnecessary provider lists. For v1, prefer a contract plus one real driver/provider where needed. Do not require S3, R2, B2, MinIO, Stripe, Paddle, and LemonSqueezy all at once.

Do not audit low-value high-volume events such as query executed, check executed, documentation viewed, or every successful delivery. Audit privileged, security, compliance, and materially important lifecycle events.

Do not force DTOs and interfaces for every tiny class. Use contracts, DTOs, enums, services, and repositories only where they reduce real complexity or protect a module boundary.

Remove any link between payment status and trust. Premium, paid, or subscribed users must not receive reputation or trust bonuses merely for paying.

Do not use global public cache blobs for user, locale, role, plan, visibility, or privacy-dependent output. Cache keys must include the required context or avoid caching sensitive output.

## Added Standards

### System Protocol Requirement

Every execution prompt must start with:

```text
[SYSTEM PROTOCOL: CODEX_L1_ACTIVE]
```

The centralized protocol lives at `docs/roadmap/system-protocol-header.md` and owns:

- target stack
- required docs before code
- architecture rules
- UI/UX rules
- localization rules
- security rules
- operational rules
- completion evidence rules

Prompt bodies should include only prompt-specific scope, dependencies, forbidden work, and acceptance evidence. Do not duplicate the old long header in each prompt.

### Scope Discipline

Each prompt must do one bounded job. It must not implement another module's responsibility.

### One Owner Per Concept

Every major concept must have exactly one owning module. Other modules may consume it through a service, resolver, contract, or DTO, but must not recreate it.

### Admin Navigation Manifest

Admin navigation must be module-owned and registry-driven. Do not hardcode menu items into the admin shell. Legacy menu entries must be deprecated or removed and must not coexist with the replacing menu item. See `docs/architecture/admin-navigation-governance.md`.

### No Placeholder Modules

Do not create empty modules, tables, routes, services, jobs, DTOs, enums, or admin screens for future features.

### Future-Proofing Without Placeholder Debt

Use `docs/architecture/future-proofing.md` when a prompt introduces durable boundaries, versioned contracts, provider contracts, public APIs, webhook payloads, import/export formats, settings schemas, UI tokens, or data lifecycle rules.

Allowed future-proofing:

- stable owner boundaries
- versioned external contracts
- reversible and explicit migrations where practical
- semantic UI tokens
- focused contracts only where multiple implementations are real or imminent
- bounded/idempotent jobs
- documented extension rules

Forbidden future-proofing:

- empty modules
- unused interfaces/DTOs
- speculative tables
- future routes/admin screens/jobs
- generic provider lists without implementation
- compatibility hooks for removed v1 systems
- TODO-driven architecture

### Evidence Required

Every implementation prompt must finish with evidence: tests, command output, generated report, or a concrete verification note.

### Shared Hosting Runtime Contract

The detailed runtime contract lives in `docs/architecture/ops-runtime-contract.md`.

- No daemon-only design.
- No mandatory long-running workers.
- Jobs must be cron-compatible.
- Batch work must be bounded, idempotent, resumable, and lock-aware.
- Heavy work must not run synchronously during public requests.

### Security Baseline

Every relevant prompt must preserve:

- CSRF protection
- Rate limiting
- Server-side validation
- Authorization through policies/gates where needed
- Output escaping
- Secret masking
- Path protection
- Signed URL rules where private files are served
- Sanitized logging

### Data Lifecycle Baseline

Every data-owning module must define its relationship to:

- Retention
- Cleanup
- Backup
- Export
- Deletion
- Audit
- Privacy and PII minimization

### Laravel 13 Baseline

Do not assume older Laravel structures unless they exist in the project. Use current Laravel conventions for routing, middleware, service container, config, migrations, scheduling, validation, policies/gates, Blade, and tests.

### Public UI Quality Baseline

Public, admin, installer, auth, content, support, and operational screens must be modern, component-driven, accessible, responsive, and theme-token aware. Foundation screens may be simple, but they must not look or behave like disconnected legacy HTML pages. Use `docs/UI-STANDARD.md`, `docs/architecture/ui-governance.md`, `docs/checklists/ui-modernization-checklist.md`, and the product quality checklist before declaring UI work complete.

Tailwind CSS v4 uses CSS-first configuration. Do not assume `tailwind.config.js` exists. Define design tokens in `resources/css/app.css` using `@theme` unless the project explicitly adds a config file.

Use semantic tokens instead of raw palette classes when a token exists. Do not scatter `bg-zinc-*`, `text-zinc-*`, `bg-indigo-*`, or raw hex colors across Blade views for standard surfaces.

Ship minimal JavaScript. Alpine.js is for small UI state only; complex behavior belongs in `resources/js/components/` and must be imported through Vite. UI fonts must be self-hosted instead of loaded from third-party CDNs.

Inline `style="..."` quick fixes are forbidden in production screens. If temporary bridge CSS is unavoidable during migration, place it in a dedicated bridge stylesheet with an owner and removal plan.

## Final Principle

Not fewer features for their own sake. Clean features, clear ownership, and no architectural residue.




