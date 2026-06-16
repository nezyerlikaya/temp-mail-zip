# Ops Runtime Contract

Temp Mail SaaS is shared-hosting-first.

## Runtime Rule

The application must work without daemon-only infrastructure.

Do not require:

- Redis.
- Horizon.
- Supervisor.
- Reverb.
- Long-running workers.
- WebSocket-only flows.
- VPS/Docker-only deployment assumptions.

## Scheduler And Jobs

Jobs must be compatible with Laravel scheduler triggered by shared-hosting cron.

Batch work must be:

- Bounded.
- Idempotent.
- Resumable.
- Lock-aware.
- Safe to retry.

Public requests must not execute heavy cleanup, backup, provider polling, or bulk processing synchronously.

## Installer Runtime

Installer must:

- Be available when the app is not installed.
- Block normal app access until installation is complete.
- Become inaccessible after installation.
- Avoid database-backed session dependency before database setup is valid.
- Mask secrets and diagnostics.

## Data Lifecycle

Every data-owning module must define its relationship to:

- Retention.
- Cleanup.
- Backup.
- Export.
- Deletion.
- Audit.
- PII minimization.

Retention decides what should expire.
Cleanup performs deletion/anonymization.
Backup protects recoverability.
Export/deletion handles user/privacy rights where applicable.
Audit records privileged and materially important lifecycle events.

## Monitoring And Health

Monitoring must be lightweight and shared-hosting compatible.

System health may collect local checks and public-safe degraded signals.

Do not audit or log high-volume low-value events such as every query, every check, every documentation view, or every successful routine delivery.

## Production Readiness

Production hardening, launch readiness, and platform certification are docs/checklists/runbooks for v1 unless a prompt explicitly requires a small supporting code surface.

They must not become large placeholder modules.



