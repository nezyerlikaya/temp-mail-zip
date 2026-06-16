# System Protocol Header

Use this protocol header at the top of every Temp Mail SaaS implementation prompt.

```text
[SYSTEM PROTOCOL: CODEX_L1_ACTIVE]

Role:
Codex working on Temp Mail SaaS.

Target Stack:
Laravel 13 | PHP 8.5.7 | Modular Monolith | Blade Components | Tailwind CSS v4 CSS-first | Alpine.js | Vite | MySQL/MariaDB | Shared Hosting First.

Required Docs Before Code:
1. AGENTS.md
2. docs/roadmap/v1-scope-cleanup-rules.md
3. docs/roadmap/00-executive-summary.md
4. docs/roadmap/02-corrected-master-roadmap.md
5. docs/roadmap/03-ownership-matrix.md
6. docs/roadmap/04-prompt-list.md
7. docs/architecture/tech-stack.md
8. docs/UI-STANDARD.md
9. docs/architecture/ui-governance.md
10. docs/architecture/future-proofing.md
11. docs/architecture/admin-navigation-governance.md
12. docs/architecture/content-governance.md
13. docs/architecture/ops-runtime-contract.md
14. Prompt-specific architecture/checklist/runbook docs

Architecture Rules:
- One owner per concept.
- No placeholder or future modules.
- No speculative tables, services, DTOs, interfaces, routes, jobs, screens, or compatibility layers.
- Scope discipline: do only the current STEP.
- Future-proof boundaries only when they serve the current scope.
- Use current Laravel 13 conventions.
- Shared hosting compatible: no Redis, Horizon, Supervisor, Reverb, daemons, or long-running workers as requirements.
- Jobs must be cron-compatible, bounded, idempotent, resumable, and lock-aware.
- Frontend is pure SSR with Alpine.js only for UI-local state.
- No Livewire, no Inertia, no Vue, and no React.

UI/UX Rules:
- Follow docs/UI-STANDARD.md and docs/architecture/ui-governance.md.
- Blade components first.
- Tailwind CSS v4 CSS-first tokens from resources/css/app.css.
- No raw palette classes when semantic tokens exist.
- No inline CSS or inline JavaScript.
- No raw standalone HTML screens.
- Dumb Blade components: no business logic in Blade.
- Meaningful data only; no fake dashboard metrics, placeholder cards, or empty decorative panels.

Localization Rules:
- Follow docs/architecture/localization-and-translation.md.
- Registry-driven languages.
- No hardcoded user-facing text; use translation keys.
- RTL/LTR ready.
- Use logical spacing/alignment: ms/me/ps/pe/start/end.
- Avoid ml/mr/pl/pr/left/right unless documented and unavoidable.
- Public output exposes active public locales only.

Security Rules:
- Validate input with Laravel validation.
- Escape output in Blade.
- Mask secrets.
- Do not log raw exceptions, raw requests, tokens, provider payloads, private mailbox content, or internal paths.
- Use policies/gates for admin and protected actions.
- Protect PII, private files, audit details, and provider internals.

Operational Rules:
- Zero placeholders.
- Evidence required before completion.
- No low-value high-volume audit spam.
- Cache keys must include user, role, locale, plan, visibility, privacy, and route context when those affect output.
- v1 out of scope: Marketplace, Community, SDK, AI translation, semantic/AI search, advanced analytics, public social profile/reputation, full developer portal, public status as required code module, and generic page builders.
- Public comments/discussion systems are out of scope for v1.

Completion Rules:
Before completion, provide evidence:
- Files changed
- Tests/build/checks run, or why not run
- Shared Hosting compliance
- Security compliance
- Module boundary compliance
- UI/Localization compliance when UI is touched
- Documentation updated if behavior or architecture changed
```

## Usage

Every implementation prompt should start with:

```text
[SYSTEM PROTOCOL: CODEX_L1_ACTIVE]

[PROMPT BODY]
...
```

The protocol does not replace prompt-specific scope. It sets the non-negotiable execution baseline.

Prompt-specific docs and acceptance evidence still belong in the prompt body.

If a prompt conflicts with this protocol, constitutions, roadmap, ownership matrix, and architecture docs win.




