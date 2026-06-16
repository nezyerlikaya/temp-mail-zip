# Temp Mail SaaS - Prompt List Draft

This file is a draft delivery sequence. The final prompt set must be regenerated from the current `docs/` folder before implementation.

Every prompt must use `docs/roadmap/system-protocol-header.md` and follow `docs/architecture/prompt-generation-rules.md`.

Global architecture docs for all prompts: `docs/architecture/tech-stack.md`, `docs/architecture/ai-execution-rules.md`, `docs/architecture/prompt-generation-rules.md`, `docs/architecture/ui-governance.md`, `docs/architecture/content-governance.md`, `docs/architecture/ops-runtime-contract.md`, and `docs/architecture/public-interaction-boundary.md` where public interaction is touched.

## Phase 0 - Governance

001. Project Structure Foundation. Docs: roadmap, ownership matrix, cleanup rules.
002. Security Baseline Foundation. Docs: cleanup rules, ownership matrix, security baseline.
003. Settings Registry Foundation. Docs: cleanup rules, ownership matrix, settings registry.
004. Feature Flags And Feature Gates Baseline. Docs: cleanup rules, ownership matrix, feature flags/gates.
005. Localization And Translation Foundation. Docs: cleanup rules, ownership matrix, localization architecture.
006. Navigation, Admin Navigation, Theme, Appearance, And Section Registry Foundation. Docs: cleanup rules, ownership matrix, navigation/theme architecture, admin navigation governance, UI governance.
007. Admin Shell Foundation. Docs: cleanup rules, ownership matrix, admin shell, admin navigation governance.
008. Installer Foundation. Docs: cleanup rules, ownership matrix, installer foundation, ops runtime contract.
009. Scoped Upload Core Foundation. Docs: cleanup rules, ownership matrix, scoped upload core.
010. Legal Pages And Email Template Foundation. Docs: cleanup rules, ownership matrix, content governance, legal/email architecture.

## Phase 1 - Core Health And Mail Base

011. System Health Foundation. Docs: cleanup rules, ownership matrix, system health foundation, ops runtime contract.
012. Domain Inventory Foundation. Docs: cleanup rules, ownership matrix, domain inventory foundation.
013. Domain Health Foundation. Docs: cleanup rules, ownership matrix, domain health foundation.
014. Domain Pool Management Foundation. Docs: cleanup rules, ownership matrix.
015. Mail Provider Contract Foundation. Docs: cleanup rules, ownership matrix.
016. Webhook Intake Foundation. Docs: cleanup rules, ownership matrix.
017. Payload Verification Foundation. Docs: cleanup rules, ownership matrix.
018. Message Normalization Foundation. Docs: cleanup rules, ownership matrix.

## Phase 2 - Temp Mail Engine

019. Mailbox Generation Foundation. Docs: cleanup rules, ownership matrix, public homepage experience.
020. Mailbox Lifecycle Foundation. Docs: cleanup rules, ownership matrix.
021. Message Storage Foundation. Docs: cleanup rules, ownership matrix.
022. Attachment Metadata Foundation. Docs: cleanup rules, ownership matrix, scoped upload core.
023. Retention Engine Foundation. Docs: cleanup rules, ownership matrix, ops runtime contract.
024. Cleanup Engine Foundation. Docs: cleanup rules, ownership matrix, ops runtime contract.
025. Abuse Foundation. Docs: cleanup rules, ownership matrix.
026. Rate Limit Foundation. Docs: cleanup rules, ownership matrix.
027. Quarantine Foundation. Docs: cleanup rules, ownership matrix.
028. Transactional Mail Foundation. Docs: cleanup rules, ownership matrix.
029. Notification Foundation. Docs: cleanup rules, ownership matrix.
030. Domain Health Intelligence Foundation. Docs: cleanup rules, ownership matrix, domain health foundation.
031. Concrete Mail Provider Adapter Foundation. Docs: cleanup rules, ownership matrix.

## Phase 3 - SaaS Platform

032. Authentication Foundation. Docs: cleanup rules, ownership matrix.
033. Authorization Foundation. Docs: cleanup rules, ownership matrix.
034. Staff Management Foundation. Docs: cleanup rules, ownership matrix.
035. Profile Foundation. Docs: cleanup rules, ownership matrix.
036. Avatar System Foundation. Docs: cleanup rules, ownership matrix, scoped upload core.
037. Plans Foundation. Docs: cleanup rules, ownership matrix.
038. Subscription Foundation. Docs: cleanup rules, ownership matrix.
039. Feature Gates Foundation. Docs: cleanup rules, ownership matrix.
040. API Access Foundation. Docs: cleanup rules, ownership matrix.
041. Outbound Webhook API Foundation. Docs: cleanup rules, ownership matrix.

## Phase 4 - Website And Content

042. Legal Pages Foundation. Docs: cleanup rules, ownership matrix, content governance.
043. FAQ/Help Pages Foundation. Docs: cleanup rules, ownership matrix, content governance.
044. Contact Form Foundation. Docs: cleanup rules, ownership matrix, content governance.
045. Optional Blog Foundation. Docs: cleanup rules, ownership matrix, content governance.
046. Documentation Pages Foundation. Docs: cleanup rules, ownership matrix, content governance.
047. SEO And Sitemap Foundation. Docs: cleanup rules, ownership matrix, content governance.
048. Basic Keyword Search Foundation. Docs: cleanup rules, ownership matrix.
049. Localization Verification For Content And SEO. Docs: cleanup rules, ownership matrix, localization architecture.

## Phase 5 - Public Homepage Experience

050. Atlas Homepage Theme And Appearance Foundation. Docs: cleanup rules, ownership matrix, navigation/theme architecture, public homepage experience, UI governance, product quality checklist.
051. Horizon Homepage Theme And Mailbox Experience. Docs: cleanup rules, ownership matrix, navigation/theme architecture, public homepage experience, UI governance, product quality checklist.
052. Legacy Homepage Theme And Final Homepage Verification. Docs: cleanup rules, ownership matrix, navigation/theme architecture, public homepage experience, UI governance, product quality checklist.

## Phase 6 - Operations And Readiness

053. Monitoring, Audit, Compliance, Backup, Disaster Recovery, Production Hardening Docs, Launch Readiness Checklist, And Platform Certification Checklist. Docs: cleanup rules, ownership matrix, ops runtime contract, product quality checklist.

## Phase UI - Cross-Cutting Design System

UI-01A. Input And Form Control Foundation. Docs: UI standard, UI governance, future-proofing, UI modernization checklist, `docs/architecture/ui-form-controls.md`.
UI-01B. Stepper And Setup Flow Foundation. Docs: UI standard, UI governance, future-proofing, installer foundation, UI modernization checklist, `docs/architecture/ui-stepper-and-setup-flow.md`.
UI-01C. Loading Feedback Foundation. Docs: UI standard, UI governance, `docs/architecture/ui-loading-feedback.md`.
UI-01D. Modal And Empty State Foundation. Docs: UI standard, UI governance, product quality checklist, security baseline, `docs/architecture/ui-modal-and-empty-states.md`.
UI-02. Installer Wizard Experience. Integrated into STEP008 Installer Foundation. Docs: tech stack, installer foundation, UI standard, UI governance, security baseline.
UI-03. Admin Shell Modernization. Docs: admin shell, UI standard, UI governance, admin navigation governance.

## Phase L10N - Cross-Cutting Localization Governance

L10N-01. Language Registry And Middleware. Docs: localization architecture, settings registry, UI standard, product quality checklist.
L10N-02. Translation Layer And Key Management. Docs: localization architecture, ownership matrix, security baseline.
L10N-03. RTL/LTR UI Governance. Docs: localization architecture, UI standard, UI governance, UI modernization checklist.
L10N-04. SEO And Sitemap Localization Verification. Docs: localization architecture, product quality checklist, SEO and sitemap foundation.

## Notes

The core product prompt count is 53. UI and L10N phases are cross-cutting governance tracks and do not replace the 53 product prompts.

Removed raw prompts: Public Identity, Reputation, Developer Portal, Community Foundation, SDK Foundation, Integration Marketplace Foundation. Removed traces: AI translation, semantic/AI search, advanced analytics, public comments, public status as required module.



