# Security Module

The Security module owns shared safety helpers for Temp Mail SaaS.

Scope:

- Secret masking for logs, diagnostics, reports, and safe internal summaries.
- Public-safe diagnostic formatting.
- Path-safe diagnostic output.

Boundaries:

- Authentication owns login, registration, sessions, password reset, and 2FA.
- Authorization owns roles, permissions, policies, and gates.
- Rate Limits owns traffic and action throttling.
- Audit Center owns audit events.
- Payload Verification owns webhook signature, replay, timestamp, and idempotency checks.
- Uploads owns upload validation, scoped storage paths, and file safety.

Rules:

- Do not log raw exceptions, raw request bodies, provider payloads, mailbox-private content, tokens, secrets, cookies, or local filesystem paths.
- Do not add placeholder services, routes, tables, jobs, screens, or future hooks.
- Keep this module limited to cross-cutting security helpers until a later scoped prompt expands it.
