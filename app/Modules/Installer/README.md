# Installer Module

Installer owns installation state detection, preflight checks, installer progress, and install lock creation.

Scope:

- Detect installed state from `.env` plus `storage/app/installer/installed.lock`.
- Redirect normal web routes to `/install` until installed.
- Block `/install` after installation.
- Run safe preflight checks without exposing secrets, raw paths, SQL, stack traces, or `.env` contents.
- Persist wizard progress with file storage rather than database-backed sessions.

Boundaries:

- Installer validates environment readiness but does not write `.env`.
- Installer validates database readiness but does not drop, reset, seed, or run destructive migrations.
- Auth owns future login flows.
- Authorization owns future admin access rules.
- Settings owns runtime settings after installation.
- Security owns masking and safe diagnostics.

Shared-hosting rule: no Redis, Horizon, Supervisor, Reverb, daemon, Docker, or privileged shell dependency is required.
