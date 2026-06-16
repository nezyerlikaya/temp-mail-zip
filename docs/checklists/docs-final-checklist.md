# DOCS Final Checklist

Use this before generating the new full prompt set.

## Structure

- [ ] `AGENTS.md` points to `docs/` as source of truth.
- [ ] `docs/README.md` explains reading order.
- [ ] `docs/roadmap/system-protocol-header.md` is the only active prompt header.
- [ ] Old master prompt/header files are removed.
- [ ] Architecture docs contain current standards.
- [ ] UI governance is documented.
- [ ] Content ownership/page surface governance is documented.
- [ ] Ops runtime contract is documented.
- [ ] Admin navigation governance is documented.
- [ ] Admin menu contracts exist for crowded menu areas.

## Scope Cleanliness

- [ ] Marketplace has no module, route, table, job, prompt, or placeholder.
- [ ] Community has no module, route, table, job, prompt, or placeholder.
- [ ] SDK has no module, route, table, job, prompt, or placeholder.
- [ ] AI translation has no module, route, table, job, prompt, or placeholder.
- [ ] Semantic/AI search has no module, route, table, job, prompt, or placeholder.
- [ ] Advanced analytics has no module, route, table, job, prompt, or placeholder.
- [ ] Public social profile/badges/reputation has no v1 module.
- [ ] Full developer portal has no v1 module.
- [ ] Public comments/discussion systems are out of scope for v1.
- [ ] Public status page is not a required v1 code module.

## UI And Frontend

- [ ] Tailwind CSS v4 CSS-first strategy is documented.
- [ ] Semantic tokens are required.
- [ ] No raw standalone HTML screens are allowed.
- [ ] Blade components are the default UI unit.
- [ ] Alpine.js is limited to local UI state.
- [ ] Livewire, Inertia, Vue, and React are not required.
- [ ] RTL/LTR logical spacing is documented.
- [ ] Atlas, Horizon, and Legacy are treated as composition themes, not color-only skins.

## Admin Navigation

- [ ] Admin navigation is registry-driven.
- [ ] Each menu item has one owner.
- [ ] Legacy menu policy is documented.
- [ ] Deprecated menu items are not visible by default.
- [ ] No placeholder sidebar entries are allowed.
- [ ] No duplicate admin navigation governance files remain.

## Content And Homepage

- [ ] Generic page builder is forbidden.
- [ ] Arbitrary HTML/CSS/JS editors are forbidden.
- [ ] Pages are owner-based surfaces.
- [ ] Empty sections do not render.
- [ ] Ads are restricted to approved slots.
- [ ] Mailbox/inbox locked core cannot be moved by optional sections.

## Operations

- [ ] Shared hosting is mandatory.
- [ ] Cron-compatible bounded jobs are required.
- [ ] Redis, Horizon, Supervisor, Reverb, and daemon-only flows are not required.
- [ ] Installer access rules are documented.
- [ ] Data lifecycle baseline is documented.
- [ ] Evidence is required before completion.

## Final Gate

- [ ] New prompts can be generated from DOCS without referring to old raw prompt packs.

