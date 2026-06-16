# Settings Module

The Settings module owns runtime-adjustable typed configuration for Temp Mail SaaS.

Scope:

- Register setting definitions before use.
- Resolve typed values with registered defaults.
- Persist runtime setting values through the Settings repository.
- Validate writes against the registered definition.
- Mask sensitive values before exposing them to UI, logs, or diagnostics.

Boundaries:

- Environment and bootstrap secrets stay in `.env` and Laravel config.
- Feature Flags owns rollout toggles.
- Feature Gates owns access decisions.
- Theme and Appearance own visual tokens and theme selection.
- Localization owns languages and locale behavior.
- Security owns secret masking and safe diagnostics.

Rules:

- Other modules must use the Settings resolver/service boundary instead of raw model or table access.
- Unknown keys fail explicitly.
- Duplicate registrations fail explicitly.
- Do not create placeholder settings for future modules.
- Do not build an admin UI, routes, controllers, feature flags, feature gates, or `.env` editing here.
