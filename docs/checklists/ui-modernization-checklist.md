# UI Modernization Checklist

Use this checklist when creating or changing any UI screen.

## Required Docs

- `docs/UI-STANDARD.md` was read.
- `docs/architecture/ui-governance.md` was read.
- Relevant module architecture docs were read.
- Product quality checklist was considered.

## Legacy Cleanup

- No inline `<style>` block was introduced.
- No inline `<script>` block was introduced.
- No raw standalone HTML screen was introduced.
- No static admin screen was introduced.
- No one-off page-specific CSS system was introduced.
- No hard-coded color was used when a semantic token exists.
- No raw palette utility class was used when a semantic token exists.
- No repeated raw sizing utility was used where a semantic size token exists.
- No business logic was added to Blade.
- No inline `style="..."` quick fix was introduced.

## Component Usage

- Shared UI components are used for buttons.
- Shared UI components are used for cards/panels.
- Shared UI components are used for inputs/forms.
- Shared UI components are used for badges/status labels.
- Shared UI components are used for alerts/errors.
- Feature-specific components consume shared tokens and primitives.
- Component props follow shared names such as `variant`, `size`, `disabled`, `loading`, `label`, `description`, and `error`.
- Complex components use slots for header/body/footer/actions where useful.
- Base components remain presentation-focused and do not own business logic.
- Buttons support disabled/loading state where they submit or trigger work.
- Modal components may own view-state, but they must remain business-dumb.
- Empty-state components explain an actual empty condition and do not render placeholder filler.

## Layout

- Screen has a clear page shell.
- Spacing is consistent.
- Content width is bounded.
- Mobile layout is usable.
- Long text does not break the layout.
- Empty/loading/error states are designed.
- Touch targets are at least 44px where practical.
- Layout is mobile-first and enhanced with breakpoints.

## Accessibility

- Keyboard navigation works.
- Focus states are visible.
- Icon-only buttons have labels.
- Form errors are associated with fields where practical.
- Contrast is readable.
- Muted text remains readable on light surfaces.
- Motion respects `prefers-reduced-motion` where motion exists.
- Modals/dialogs use `role="dialog"`, `aria-modal="true"`, and `aria-labelledby` when a title exists.
- Modals/dialogs have a focus management strategy.
- Modal Escape and backdrop-close behavior is configurable when action destructiveness requires it.

## UI Foundation Governance

### Modal And Dialogs

- Modal/dialog components include `role="dialog"`, `aria-modal="true"`, and `aria-labelledby` when a title exists.
- Modal/dialog components implement focus trapping or a documented focus management plan.
- Escape and backdrop-close behavior is configurable based on action destructiveness.
- Modal/dialog components may use Alpine for UI state only.
- Modal/dialog components must not own database, route, authorization, session, provider, or business workflow logic.

### Empty States

- Empty states are meaningful and explain why the area is empty.
- Empty states may include an optional CTA only when a safe next action exists.
- Empty states do not render placeholder images, fake records, fake metrics, decorative filler, or "coming soon" cards.

### Security Governance

- UI component inputs are public-safe.
- Secrets, tokens, provider payloads, raw exceptions, internal paths, private mailbox content, raw request bodies, and admin-only diagnostics are not rendered in Blade, Alpine, JavaScript, or data attributes.
- Public-safe olmayan diagnostic data must be masked or anonymized before it reaches the component.

## JavaScript And Fonts

- Alpine is used only for small UI state.
- Complex Alpine behavior lives in `resources/js/components/` and is imported through Vite.
- No secrets/private payloads are placed in Alpine state.
- UI fonts are self-hosted, not loaded from third-party CDNs.
- Font weight count is limited for performance.

## Forms And Validation

- Form controls support consistent props: `id`, `name`, `label`, `hint`, `error`, `disabled`, and `required`.
- Form controls use `aria-invalid`.
- Form controls use `aria-describedby` when hint or error exists.
- Labels use proper `for`/`id` relationships where applicable.
- Field-level errors render near the related input.
- Form-level errors use alert components.
- Error text is short and actionable.
- Submit buttons show loading/disabled state where needed.
- Duplicate submissions are prevented where practical.

## Stepper And Setup Flow

- Stepper components receive state through props only.
- Stepper components do not read sessions, routes, database rows, request state, or config.
- Active step uses `aria-current="step"`.
- Completed, active, and pending states are visually distinct.
- State is not communicated by color alone.
- Mobile layout remains usable and does not overflow.
- Desktop layout may show expanded labels.
- Stepper does not introduce a wizard engine or installer business logic.

## RTL / LTR

- Locale direction is respected where relevant.
- Major shells render `lang` and `dir` from the resolved locale context.
- Start/end logical alignment is used where practical.
- `ms-*`, `me-*`, `ps-*`, and `pe-*` are used instead of `ml-*`, `mr-*`, `pl-*`, and `pr-*` where practical.
- Controls do not break in RTL.
- Text alignment is not hard-coded left/right unless intentionally documented.
- Direction-specific flex/grid behavior is centralized in shell/component code, not scattered through pages.

## Installer-Specific

- Installer uses setup wizard structure.
- Installer preserves safe current-step state across refresh where practical.
- Stepper/progress is clear.
- Checks show ok/warning/blocker states.
- Diagnostics are safe and sanitized.
- Expected setup failures stay inside the wizard with fix guidance.
- Lock/finish action is clear.
- Installer does not depend on database-backed sessions before setup is complete.

## Admin-Specific

- Page header is clear.
- Admin shell exists before individual admin pages are polished.
- Navigation uses registry output.
- Tables are bounded and paginated where data can grow.
- Forms use shared form components.
- Empty states are safe and useful.
- No raw technical dumps are exposed.
- Dashboard widgets show meaningful data only.
- Dashboard does not render fake metrics, placeholder cards, empty decorative panels, or "coming soon" widgets.
- Dashboard widgets consume safe summaries from owning modules.
- Missing/unimplemented module widgets are omitted.
- Implemented modules with no data render actionable empty states.

## Public Homepage-Specific

- Theme composition remains distinct.
- Mailbox generator remains visible.
- Inbox preview remains visible.
- Optional sections do not render empty shells.
- Ads stay inside approved slots.
- Active/passive locale behavior is respected.

## Evidence

Before completion, provide:

- changed screens
- components used or added
- removed legacy patterns
- JavaScript added or avoided
- font behavior if changed
- accessibility notes
- responsive notes
- tests or manual verification notes

## Self-Audit Format

Use this completion format for UI prompts:

```text
Completion Self-Audit
Components created or updated: ...
Semantic tokens used: ...
Accessibility attributes implemented: ...
Raw palette / inline CSS check result: ...
Touch target notes: ...
Security governance notes: ...
Tests / build command result or why not run: ...
```

Checklist expectation:

- If a component exists for the required pattern, reuse it.
- If a component does not exist, create the minimum reusable version.
- If a component is only partially complete, document the gap before completion.


