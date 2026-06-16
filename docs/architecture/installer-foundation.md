# Installer Foundation

The Installer module owns installation state detection, installation lock, bounded preflight checks, environment readiness validation, database readiness validation, filesystem permission checks, scheduler/cron readiness notes, installer-safe diagnostics, and install completion marking.

It does not own authentication, authorization, admin user creation, secret vaulting, deployment automation, backup/restore, business modules, or hosting control panel automation.

## State Model

Installation state combines the installer lock and sanitized preflight checks. A partial installation is not complete. Recovery from interruption is manual: fix blockers, rerun preflight, and create the lock after the application is ready.

The installer lock is valid only while the application environment file exists. If `.env` is removed, installation is treated as incomplete even if `storage/app/installer/installed.lock` still exists.

## Lock Behavior

The lock is stored under `storage/app/installer/installed.lock`, outside the public web root. Locked installers return HTTP 423 and do not expose the lock path. Browser unlock is intentionally not implemented.

The lock action must refuse to complete while blocker preflight checks remain. This prevents a broken or missing environment configuration from being marked installed.

## Preflight Checks

STEP008 checks environment file presence, PHP version, required extensions, APP_KEY presence, debug mode, database connection, migration table readiness, storage/cache/log writability, Vite manifest presence, scheduler cron expectations, and installer lock state.

Checks are lightweight and sanitized. They do not dump `phpinfo`, raw SQL errors, credentials, absolute paths, hostnames, usernames, stack traces, or `.env` contents.

## Environment Policy

The installer validates environment readiness but does not write `.env`. APP_KEY and credentials must be managed through Laravel-native deployment steps and hosting-safe secret handling. Bootstrap secrets must not be stored in Settings.

## Database Policy

The installer validates database reachability and migration status only. It does not drop, truncate, reset, seed, or run destructive migrations from the browser. If shell access is unavailable, deployment documentation must provide safe manual command guidance.

## Routes And Exposure

Installer routes live under `installer.*` names and `/install` URLs. State-changing lock creation uses POST and CSRF through Laravel web middleware. Routes are blocked after lock. Before authentication exists, public exposure remains a deployment risk and must be mitigated by completing the lock promptly.

Until installation is complete, non-installer web pages must redirect to `/install`. JSON requests receive a safe 503 response. Installer requests must not depend on database-backed sessions because database credentials may not exist yet; installer-open requests force a file session driver before Laravel starts the session.

## UI Standard

Installer screens must use `docs/UI-STANDARD.md`, the shared Blade layout/component system, Tailwind CSS, theme tokens, semantic landmarks, accessible forms, visible focus states, and clear setup-step presentation. Inline foundation CSS may exist only as a temporary bridge; production installer screens should not look or behave like disconnected legacy HTML pages.

Installer UI should present:

- requirement checks
- blocker/warning/ok states
- database/session/storage readiness
- cron/scheduler guidance
- safe lock action
- clear explanation of what the installer does not do

It must not expose secrets, raw paths, stack traces, provider internals, or `.env` contents.

## Installer Wizard Experience

The installer is a trust-critical onboarding wizard, not a raw technical checklist.

The installer UI should use:

- `x-installer.shell`
- `x-ui.stepper`
- `x-ui.card`
- `x-ui.alert`
- `x-ui.button`
- `x-ui.input`
- `x-ui.select`
- `x-ui.checkbox`
- `x-ui.loading-bar` where useful
- `x-ui.modal` only for confirmation if needed

Suggested wizard steps:

- Requirements
- Environment
- Database
- Admin
- Finish

The exact steps may be adapted to the implementation, but the stepper must reflect real installer state only.

Installer wizard rules:

- Do not rewrite installer business logic merely for UI.
- Do not depend on database-backed sessions before installation is complete.
- Use installer-safe step state.
- Keep expected setup errors inside the wizard with safe fix guidance.
- Refreshing the browser should return to the current safe step where practical.
- Do not show `.env` contents in the frontend.
- Do not expose database credentials, APP_KEY, tokens, provider secrets, paths, stack traces, SQL, or raw exceptions.
- Use semantic tokens, translation keys, and start/end logical alignment.
- No inline CSS.
- No inline JavaScript.
- No fake progress or placeholder content.

## Shared Hosting

No Docker, Redis, daemon, privileged filesystem operation, runtime Node.js process, or VPS-only command is required. Cron/scheduler readiness is documented as a hosting panel configuration task.


