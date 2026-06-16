# Temp Mail SaaS - Corrected Master Roadmap

This roadmap replaces the raw 72-step order. It removes out-of-scope systems, merges duplicated foundations, and moves localization, security, ownership, admin navigation, UI governance, content governance, and shared-hosting rules earlier.

## Phase 0 - Governance And Architecture

1. Establish project constitution, stack baseline, docs-first rule, and shared-hosting constraints.
2. Create module ownership matrix and dependency rules.
3. Define security, privacy, audit, cache, upload, retention, frontend, content, and admin-navigation baselines.
4. Prepare system protocol header, prompt generation rules, admin navigation rules, and evidence requirements.

## Phase 1 - Core Platform Foundation

1. Project structure and modular boundaries.
2. Security foundation.
3. Settings registry.
4. Feature flags and feature gate baseline.
5. Localization and translation foundation.
6. Navigation, admin navigation, theme, appearance, and section registry foundation.
7. Admin shell and staff-safe admin foundation.
8. Installer foundation.
9. Scoped uploads baseline.
10. Compliance/legal pages foundation.
11. Email templates and transactional notification baseline.
12. System health baseline.

## Phase 2 - Temp Mail Engine

1. Domain inventory.
2. Domain health.
3. Domain pool management.
4. Provider abstraction for inbound mail.
5. Webhook intake.
6. Payload verification.
7. Message normalization.
8. Mailbox generation.
9. Mailbox lifecycle.
10. Message storage.
11. Attachment metadata through safe upload/storage rules.
12. Retention engine.
13. Cleanup engine.
14. Abuse foundation.
15. Rate limit foundation.
16. Quarantine foundation.
17. Transactional mail and notification delivery.
18. Domain health intelligence.
19. Concrete mail provider adapter.

## Phase 3 - SaaS Platform

1. Authentication.
2. Authorization.
3. Staff management.
4. Profile foundation.
5. Avatar system.
6. Plans foundation.
7. Subscription foundation.
8. Feature gates foundation.
9. API access foundation.
10. Outbound webhook API foundation.

## Phase 4 - Website And Content

1. Legal and compliance pages.
2. FAQ/help pages.
3. Contact form and admin notification.
4. Optional blog foundation.
5. Documentation pages.
6. SEO foundation.
7. Basic keyword search only where needed.
8. Sitemap foundation.
9. Localization verification for content and SEO.

## Phase 5 - Public Homepage Experience

1. Atlas homepage theme and Appearance foundation.
2. Horizon homepage theme and mailbox experience.
3. Legacy homepage theme and final homepage verification.

Atlas, Horizon, and Legacy are distinct compositions, not color-only skins. Appearance owns safe tokens, fonts, sections, and ads. Mailbox logic remains owned by mailbox/message modules.

## Phase 6 - Operations And Readiness

Monitoring, audit center, compliance, backup, disaster recovery, production hardening docs/runbooks, launch readiness checklist, and platform certification checklist remain required readiness areas.

Production hardening, launch readiness, and platform certification are docs/checklist/runbook concerns for v1 unless a prompt explicitly requires a small supporting code surface. They must not become placeholder modules.

## Merged Or Corrected Areas

- Localization: merge raw STEP007, STEP010, STEP065, STEP066 into one coherent early foundation plus later verification.
- SEO and sitemap: merge raw STEP014, STEP059, STEP064 ownership rules.
- Upload/avatar/attachments: use one safe upload/storage/processing baseline.
- Monitoring/system health/public status: system health feeds monitoring; any public-facing status is optional/future and must be public-safe.
- Audit: all audit-worthy events flow through one audit center; low-value high-volume events are not audit spam.
- Plans/subscriptions/feature gates: plans define entitlements, subscriptions activate plans, feature gates evaluate access, feature flags handle operational rollout.
- Homepage experience: locked mailbox/inbox core stays intact across themes; sections are registry-defined and data-driven.

## Removed From v1

- Marketplace foundation
- Community foundation
- SDK foundation
- Integration marketplace foundation
- AI translation
- Semantic or AI search
- Advanced analytics
- Public social profile, badges, and reputation
- Full developer portal
- Public comments/discussion systems
- Public status page as a required code module
- Generic page builder or arbitrary HTML/CSS/JS editor



