# Future-Proofing Without Placeholder Debt

Future-proofing means making today's implementation resilient to change without creating empty future modules, speculative tables, compatibility hooks, or unused abstractions.

## Core Rule

Future-proof the boundary, not the feature.

Do:

- use stable contracts where multiple implementations are real or imminent
- version public APIs, webhook payloads, exports, imports, and stored configuration shapes
- design database migrations to be reversible where practical
- keep data ownership clear
- make jobs bounded, idempotent, resumable, and lock-aware
- use semantic UI tokens instead of raw one-off styling
- document extension rules and ownership boundaries

Do not:

- create empty modules for later ideas
- create unused interfaces/DTOs for every small class
- create future routes, admin screens, jobs, tables, services, or compatibility layers
- add generic provider lists before a real provider exists
- leave TODO-driven architecture in production code
- build systems removed from v1 scope

## Versioned Boundaries

Version anything that external systems or long-lived data may depend on:

- API response contracts
- webhook payload schemas
- import/export formats
- backup metadata
- audit event names
- settings value shapes
- email template placeholder contracts
- public SEO/sitemap output rules where consumers depend on them

Internal classes do not need versioning unless they cross a durable module boundary.

## Database Change Safety

Migrations should:

- use explicit column names and types
- add indexes for bounded lookup paths
- avoid destructive changes without migration notes
- avoid nullable everything as a lazy future-proofing strategy
- avoid generic JSON blobs when queryable structure is known
- document data lifecycle expectations

Use JSON only when the field is truly flexible, bounded, validated, and owned by one module.

## UI Future-Proofing

UI future-proofing comes from:

- semantic tokens
- shared Blade components
- documented screen patterns
- accessibility baseline
- RTL/LTR support
- mobile-first layouts
- self-hosted fonts
- minimal JavaScript

Do not future-proof UI by adding page builders, arbitrary CSS editors, arbitrary JS editors, or custom HTML blocks.

## Provider Future-Proofing

Provider future-proofing means:

- define one focused contract when an adapter boundary is real
- implement one concrete provider/driver first
- keep credentials outside Settings
- keep diagnostics sanitized
- document unsupported providers instead of scaffolding empty drivers

Do not require S3, R2, B2, MinIO, Stripe, Paddle, LemonSqueezy, or multiple mail providers all at once unless the active prompt explicitly implements them.

## Security Future-Proofing

Security future-proofing means:

- deny by default
- validate server-side
- escape output
- mask secrets
- minimize PII
- use ownership-aware access checks
- avoid raw IP as ownership identity
- log only meaningful, sanitized events

Do not add security theater such as noisy audit spam, unused permission names, or placeholder policy methods that are never enforced.

## Documentation Requirement

When adding a future-proof boundary, document:

- the owner
- the reason the boundary exists now
- the current implementation
- the allowed extension path
- what is intentionally not implemented
- evidence that no placeholder module or unused abstraction was added


