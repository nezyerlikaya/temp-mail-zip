# AGENTS.md - Temp Mail SaaS Portable AI Execution Rules

## Primary Rule

This repository uses the `docs/` folder as the source of truth.

Before generating prompts, writing code, modifying code, changing architecture, or declaring completion, read the relevant files under `docs/`.

Start here:

1. `docs/README.md`
2. `docs/roadmap/system-protocol-header.md`
3. `docs/architecture/ai-execution-rules.md`
4. `docs/architecture/prompt-generation-rules.md`
5. Prompt-specific docs

Full reading order:

1. `docs/constitutions/`
2. `docs/adr/`
3. `docs/architecture/`
4. `docs/checklists/`
5. `docs/roadmap/`
6. Current prompt

If a prompt conflicts with a constitution, roadmap, architecture document, ownership matrix, or checklist, the docs win.

If required docs are missing, stop and report the missing docs instead of inventing architecture.

## Active Protocol

Use only:

- `docs/roadmap/system-protocol-header.md`

Do not recreate or use old master prompt/header files.

## Project Stack

- Laravel 13
- PHP 8.5.7
- Modular Monolith
- Blade layouts and Blade components
- Tailwind CSS v4 (CSS-first)
- Alpine.js for local UI state only
- Vite
- MySQL/MariaDB
- Pure SSR
- Shared Hosting First
- Security First
- Webhook First

## Runtime Contract

The application must remain shared-hosting compatible.

Do not require:

- Redis
- Horizon
- Supervisor
- Reverb
- Long-running daemons
- WebSocket-only flows
- VPS/Docker-only deployment assumptions

Jobs must be cron-compatible, bounded, idempotent, resumable, and lock-aware.

## Forbidden AI Behavior

Do not:

- invent new architecture outside `docs/`
- bypass existing DTOs, Actions, Services, Policies, Registries, or Audit services where they exist
- use IMAP as the core architecture
- create a WordPress-like CMS
- create a generic page builder
- create arbitrary HTML/CSS/JS editors
- create a general Media Library
- create an admin mailbox/message browser
- create public comments, forums, or discussion systems
- use Livewire, Inertia, Vue, or React as project requirements
- hardcode admin menu items into the shell
- log raw exceptions
- expose secrets, tokens, provider payloads, raw paths, or private diagnostics
- pass raw request arrays into services
- use unbounded `all()` / `get()` for lists
- write business logic in Blade
- create raw standalone HTML screens
- create placeholder modules, routes, tables, DTOs, jobs, services, or admin screens for future features

Removed v1 systems must not be recreated:

- Marketplace
- Community
- SDK
- AI translation
- Semantic/AI search
- Advanced analytics
- Public social profiles, badges, or reputation
- Full developer portal
- Public status page as a required code module

## UI And Content Rules

Follow:

- `docs/architecture/ui-governance.md`
- `docs/architecture/content-governance.md`
- `docs/architecture/admin-navigation-governance.md`

Key rules:

- Use semantic tokens, not scattered raw palette classes.
- Use start/end logical spacing for RTL/LTR safety.
- Use dumb Blade components for UI.
- Alpine.js may handle only local UI state.
- No inline CSS/JS quick fixes.
- No generic page builder.
- Empty content does not render placeholder sections.
- Admin navigation must be registry-driven and owner-controlled.

## Prompt Generation Rule

Future prompts must be generated from the current `docs/` folder.

Do not use old raw prompt packs as source of truth.

Each prompt must include:

- active system protocol
- prompt-specific docs
- goal
- scope
- out of scope
- required work
- verification
- completion self-audit

## Required Completion Behavior

Before declaring completion, provide a self-audit summary covering:

- Shared Hosting compliance
- Security compliance
- Module boundary compliance
- UI/content/admin navigation compliance where relevant
- Tests added or updated, or why tests were not run
- Documentation updated
- Evidence produced

