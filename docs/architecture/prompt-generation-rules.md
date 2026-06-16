# Prompt Generation Rules

All future Temp Mail SaaS prompts must be generated from the current DOCS architecture, not from old prompt packs.

## Required Header

Every generated implementation prompt starts with:

```text
[SYSTEM PROTOCOL: CODEX_L1_ACTIVE]
```

Do not duplicate the old long header. The protocol owns stack, UI, localization, security, operations, and completion requirements.

## Prompt Shape

Use this structure:

```text
# STEPXXX - Name

[SYSTEM PROTOCOL: CODEX_L1_ACTIVE]

Prompt-specific docs:
- docs/...

Goal:
One bounded goal.

Scope:
- What this prompt implements.

Out Of Scope:
- What this prompt must not implement.

Required Work:
1. Concrete implementation steps.

Verification:
- Tests, commands, static checks, or manual verification.

Completion Self-Audit:
- Shared Hosting compliance
- Security compliance
- Module boundary compliance
- UI/Localization compliance when touched
- Tests/build/checks
- Documentation updates
```

## Generation Rules

- One prompt, one bounded job.
- Use owner names from `docs/roadmap/03-ownership-matrix.md`.
- Use `docs/roadmap/v1-scope-cleanup-rules.md` to remove future clutter.
- Use `docs/architecture/future-proofing.md` only for real boundaries.
- Use `docs/architecture/tech-stack.md` for stack constraints.
- Use `docs/architecture/ui-governance.md` and `docs/UI-STANDARD.md` for UI.
- Use `docs/architecture/localization-and-translation.md` for language/translation.
- Use `docs/architecture/content-governance.md` for content surfaces.
- Use `docs/architecture/public-interaction-boundary.md` for public interaction.
- Use `docs/architecture/admin-navigation-governance.md` for admin navigation.

## Forbidden Prompt Content

Do not include:

- old `ROLE / TARGET STACK / DOCS-FIRST REQUIREMENT` blocks
- copied legacy prompt headers
- placeholder/future modules
- speculative tables/routes/jobs/services
- generic provider lists
- page builders
- arbitrary HTML/CSS/JS editors
- Livewire/Inertia/Vue/React requirements
- public comments/discussion systems
- Redis/Horizon/Supervisor/Reverb/daemon requirements
- raw standalone HTML screens

## Prompt Evidence

Every prompt must require evidence before completion:

- files changed
- tests/build/checks run or why not run
- security boundary notes
- shared-hosting notes
- module ownership notes
- UI/localization notes when touched

No prompt should declare completion without evidence.



