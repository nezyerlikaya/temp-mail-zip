# Temp Mail SaaS - Ownership Matrix

Each concept must have one owner. Other modules may consume the owner through a service, resolver, contract, DTO, event, or query object, but must not duplicate the owned data or logic.

| Concept | Owning Module | Notes |
| --- | --- | --- |
| Stack and execution rules | Governance | Laravel 13, PHP 8.5.7, Blade, Tailwind CSS v4 CSS-first, Alpine, Vite, Pure SSR, shared hosting. |
| Security baseline | Security | Secrets, masking, path safety, sanitized diagnostics, CSRF/rate-limit standards. |
| Settings | Settings | Runtime settings, typed values, sensitive value rules. |
| Feature flags | Feature Flags | Operational rollout and kill switches only. |
| Feature access | Feature Gates | User access decisions from subscription, entitlements, permissions, and flags. |
| Localization | Localization | Locale registry, route locale, user/browser/cookie/default resolution. |
| Translation | Translation | UI/system translation keys, namespaces, fallback, import/export. |
| Navigation | Navigation | Named-route navigation registry and visibility-aware menus. |
| Admin navigation | Navigation/Admin | Module-owned manifest registry for admin menus; no hardcoded shell sidebar. |
| Theme | Theme | Theme tokens and presentation rules, not content ownership. |
| Appearance | Theme/Appearance | Safe token, font, theme, section, and ad configuration. No arbitrary HTML/CSS/JS editor. |
| Sections | Theme/Sections | Registry-defined optional public sections. Empty sections do not render. |
| Admin shell | Admin | Admin layout, navigation consumption, dashboard shell, admin-safe access. |
| Upload safety | Uploads | Core upload validation, scoped paths, storage safety, file policy. |
| Avatars | Avatars | Profile images using safe upload/storage core. |
| Email attachments | Message Storage | Attachment metadata; binary handling follows Uploads policy. |
| Legal documents | Compliance | Legal document registry, versions, localized legal text references. |
| Transactional email | Mail/Notifications | Templates and delivery for system notifications. |
| Notifications | Notifications | Notification preferences and delivery orchestration. |
| System health | System Health | Local health checks and degraded-state signals. |
| Monitoring | Monitoring | Operational checks, alert rules, queue/domain/service status. |
| Public status docs/checklist | Ops/Monitoring | Optional future public surface; not a required v1 code module. |
| Audit | Audit Center | Central privileged/security/compliance audit registry. |
| Domains | Domains | Inventory, status, ownership, DNS metadata. |
| Domain health | Domain Health | DNS/MX/reputation measurements. |
| Domain pool | Domain Pool | Eligibility and selection of domains for mailbox generation. |
| Provider abstraction | Mail Providers | Inbound/outbound provider contracts and selected provider adapter. |
| Inbound webhook intake | Webhook Intake | Receiving provider payloads only after verification rules are satisfied. |
| Payload verification | Payload Verification | Signature, replay, timestamp, idempotency for inbound payloads. |
| Message normalization | Message Normalization | Canonical message DTO from verified provider payload. |
| Mailboxes | Mailboxes | Address generation, lifecycle, status transitions. |
| Messages | Message Storage | Canonical messages, recipients, body/metadata storage. |
| Retention | Retention | Expiration policy calculation. |
| Cleanup | Cleanup | Physical deletion/anonymization execution from retention results. |
| Abuse | Abuse | Abuse signals, decisions, and moderation-safe outcomes. |
| Rate limiting | Rate Limits | Traffic and action throttling. |
| Quarantine | Quarantine | Isolated resources and review/release workflow. |
| Authentication | Auth | Login, registration, sessions, credentials, 2FA readiness. |
| Authorization | Authorization | Roles, permissions, policies, gates. |
| Staff | Staff | Staff identity, staff status, assignment compatibility. |
| Profile | Profile | Private/profile preferences and username ownership. |
| Plans | Plans | Plan definitions, entitlements, limits. |
| Subscriptions | Subscriptions | Activation of plans, lifecycle, trials, grace periods. |
| API access | API Access | API credentials, scopes, quotas, usage counters. |
| Outbound webhooks | Webhook API | Registered endpoints, signed delivery, retries, DLQ. |
| Blog | Blog | Optional public blog articles, tags, and categories; no public comments in v1. |
| FAQ/help pages | Knowledge Base | Simple FAQ/help pages first; full KB workflow/versioning can be deferred. |
| Documentation pages | Documentation | Official product/API documentation pages; no full developer portal in v1. |
| Contact form | Contact | Public/authenticated contact request intake and admin notification. |
| SEO | SEO | Metadata, canonical, OG/Twitter, structured data resolution. |
| Search | Search | Basic keyword search only where needed; no semantic/AI search. |
| Sitemap | Sitemap | XML sitemap and sitemap index generation. |
| Compliance | Compliance | Consent, export/deletion requests, legal document compliance. |
| Backup | Backup | Backup policies, jobs, verification, restore preparation. |
| Disaster recovery | Disaster Recovery | Recovery plans, RTO/RPO, restore testing, continuity docs. |
| Production hardening docs | Production Hardening | Technical readiness checks and findings as docs/runbooks unless explicitly scoped. |
| Launch readiness checklist | Launch Readiness | Go/no-go governance, risk, approvals, rollback readiness as checklist. |
| Platform certification checklist | Certification | Final release-bound sign-off and evidence review as checklist. |

Content surfaces such as Blog, FAQ/help pages, Documentation, Legal Pages, and module-owned page routes are governed in `docs/architecture/content-governance.md`.

## Removed Owners

The following owner modules do not exist in v1: Marketplace, Community, SDK, AI Translation, Semantic Search, Advanced Analytics, Public Identity, Reputation, Developer Portal, Public Comments, Generic Page Builder.



