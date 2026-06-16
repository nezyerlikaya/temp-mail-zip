# Feature Flags Module

Feature Flags owns operational rollout and kill switches.

Scope:

- Register feature flag definitions before use.
- Resolve operational availability from explicit safe defaults.
- Support runtime state overrides through Settings-owned `featureflags.*` definitions.
- Support deterministic beta rollout using non-PII subject keys.
- Support kill switches that can only remove availability.

Boundaries:

- Feature Gates owns actor-specific access decisions later.
- Settings owns typed runtime persistence.
- Plans own plan definitions.
- Subscriptions own active plan state.
- Authorization owns roles, permissions, policies, and gates.
- Navigation may consume results later but does not own flags.

Rules:

- Unknown flags fail explicitly and must not grant access.
- Security safeguards, authorization, validation, rate limits, audit integrity, retention, and legal protections must not be controlled by flags.
- Do not add admin UI, routes, controllers, database tables, or placeholder flags for future systems.
