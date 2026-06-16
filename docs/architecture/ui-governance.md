# UI Governance

UI Governance prevents Temp Mail SaaS from drifting into disconnected screens, one-off CSS, or inconsistent component systems.

## Ownership

UI ownership is layered:

| Layer | Owner | Responsibility |
| --- | --- | --- |
| Design philosophy | UI Standard | Stripe-like trust, Linear-like minimalism, Vercel-like clarity. |
| Tokens | Theme / Appearance | Semantic colors, radius, shadows, typography, focus, status colors. |
| Base components | UI Kit | Buttons, cards, inputs, badges, alerts, modals, tables, steppers, loading bars. |
| Layout components | Layout owners | Public, admin, installer, auth, content, and operational shells. |
| Feature components | Feature owner | Domain-specific UI composed from base components and tokens. |
| Pages | Route/module owner | Page composition only; no new visual system. |

## Global Rule

Every UI screen must be composed from semantic tokens, shared Blade UI components, and documented screen patterns.

New one-off visual systems are not allowed.

UI future-proofing comes from semantic tokens, shared components, documented screen patterns, accessibility, responsive behavior, RTL/LTR support, self-hosted fonts, and minimal JavaScript. It must not become page builders, arbitrary CSS editors, arbitrary JS editors, or custom HTML blocks.

## Required Screen Patterns

The project should standardize these patterns before large feature work:

- Setup Wizard
- Admin Dashboard
- Admin List Page
- Admin Form Page
- Settings Page
- Public Tool Page
- Public Content Page
- Empty State
- Error State
- Loading State
- Locked/Unavailable State

## Dashboard/Admin Principles

Admin and dashboard screens follow:

- Meaningful Data Only
- Zero Placeholder
- Shell First
- Bounded Widgets
- Actionable Empty States

Dashboard widgets are consumers, not owners. They compose safe summaries from owning modules and must not invent data ownership.

Fake metrics, placeholder cards, empty decorative panels, `&nbsp;` filler, and "coming soon" widgets are not allowed.

If the owning module is not implemented or not enabled, the widget does not render.

If a module exists but has no meaningful data yet, render an actionable empty state.

## Theme Governance

Themes manage composition, not content.

- Themes consume shared `x-ui` foundation components.
- Each theme may own its Blade composition, spacing rhythm, hero treatment, mailbox presentation, inbox presentation, CTA treatment, optional section presentation, and footer density.
- Business logic, content ownership, mailbox logic, SEO ownership, and localization ownership remain in their owning modules.
- Empty optional sections do not render.
- Ads render only in approved slots.
- Themes must remain RTL/LTR-safe and semantic-token driven.
- No page builder, custom HTML editor, custom CSS editor, or custom JavaScript editor.

## Controlled Section Governance

Homepage sections are controlled registry entries, not free-form page-builder blocks.

- Sections are pre-defined, registered Blade components.
- Admin may only enable, disable, and reorder sections through defined registry settings.
- Admin must not edit arbitrary section HTML, CSS, or JavaScript.
- No content means no render. Section rendering must check for valid public localized data before adding DOM output.
- Themes such as Atlas, Horizon, and Legacy decide the section composition and visual treatment, not the admin.
- Header, footer, mailbox generator, and inbox preview remain locked core sections.
- Ads are restricted to approved slots and must not intrude into header internals, footer internals, mailbox input, inbox rows, or other core functional areas.
- Empty ad slots do not render.

## Component Contract

Reusable UI components should define:

- supported variants
- supported sizes
- disabled/loading/error behavior
- slot behavior
- accessibility labels and ARIA expectations
- keyboard behavior where interactive
- RTL/LTR behavior where relevant
- whether arbitrary HTML is allowed

Base components should stay presentation-focused. They may expose variants, sizes, slots, disabled/loading/error states, and accessibility attributes. They must not own business logic, persistence, authorization, provider calls, or module workflows.

Buttons must include disabled and loading contracts. Loading buttons prevent duplicate submissions and provide visible feedback.

Steppers are render-only progress components. They receive steps, current state, and completed state from the owning flow. They must not own installer state, session state, route decisions, database queries, or wizard progression rules.

Modals may own UI view-state such as open/close, transitions, Escape handling, and focus management. They must remain business-dumb and must not own database, route, authorization, persistence, session, provider, mailbox, or workflow logic.

Empty states are not placeholders. They render only for real empty conditions, explain the state, and may show a safe next action when one exists.

Use consistent prop names across the UI kit:

- `variant`
- `size`
- `disabled`
- `loading`
- `label`
- `description`
- `error`

Prefer slots for flexible composition:

- `header`
- default body slot
- `footer`
- `actions`

For example, a card component should not be limited to a fixed title/body string API if a header/body/footer slot contract is more reusable.

## Layout And Shell Strategy

Major product areas need dedicated shell components:

- public shell
- admin shell
- installer shell
- auth shell
- content/legal shell where useful

Shells own persistent layout concerns such as navigation, header, sidebar, breadcrumbs, content width, and base landmarks. Pages compose content inside shells and should not duplicate shell structure.

Admin should be wrapped by a single admin shell component so sidebar/header changes update the entire admin area consistently.

Shells also own locale wrapper behavior. Public, admin, installer, auth, and content shells must render the resolved `lang` and `dir` values from Localization. Pages and feature components should consume that context instead of inventing their own locale direction logic.

Use logical start/end utilities by default. Hard-coded left/right spacing is treated as UI debt unless there is a documented component-specific reason.

## Alpine Boundary

Alpine.js is a UI-state helper only.

Use it for dropdowns, modals, tabs, small toggles, and temporary loading indicators.

Do not use Alpine.js for database queries, durable installer state, authorization, billing, mailbox ownership, security checks, or provider calls.

If Blade/Laravel can render the state safely, prefer Blade/Laravel.

Complex Alpine behavior belongs in `resources/js/components/` and should be imported through Vite. Avoid large inline `x-data="{ ... }"` blobs. Ship minimal JavaScript.

Alpine state must not contain secrets, provider payloads, private mailbox content, or admin-only internals.

UI components must receive public-safe data. Sensitive diagnostics, raw exceptions, provider payloads, internal paths, private mailbox content, raw request bodies, secrets, and tokens must be omitted or masked before reaching Blade, Alpine, JavaScript, or data attributes.

## Font Policy

Modern SaaS fonts such as Inter, Geist, or Plus Jakarta Sans may be used when licensing allows.

Fonts must be self-hosted. Do not load UI fonts from third-party CDNs.

Font choices must account for:

- performance
- privacy/GDPR
- fallback stacks
- LTR and RTL readability
- limited weight count

## Installer State Consistency

Installer is a wizard, not a static checklist.

Installer should preserve safe current step state across refreshes. Expected setup blockers should render inside the wizard with fix guidance and re-check actions.

Do not send users to a generic error page for normal installer failures such as missing `.env`, missing APP_KEY, database connection failure, storage permission failure, or missing build assets.

## No Aesthetic Drift

Do not introduce a new visual direction without updating `docs/UI-STANDARD.md`.

Feature modules may have their own layout needs, but they must not create a new visual language.

## Legacy UI Cleanup

Legacy UI includes:

- inline `<style>`
- inline `<script>`
- raw standalone HTML screens
- page-specific CSS systems
- hard-coded colors where tokens exist
- raw palette utility classes where semantic tokens exist
- repeated raw sizing utilities where semantic size tokens exist
- one-off buttons, cards, badges, alerts, inputs, modals, and tables
- business logic in Blade

Cleanup order:

1. Create or reuse a shared component.
2. Move markup to the component.
3. Replace hard-coded colors with semantic tokens.
4. Remove inline CSS/JS.
5. Verify accessibility and responsive behavior.
6. Document any exception.

If a temporary CSS bridge is unavoidable, place it in a dedicated bridge stylesheet such as `resources/css/bridge.css`. Do not use inline `style="..."` quick fixes. Bridge CSS requires an owner, reason, and removal plan.

## Exception Policy

Production UI exceptions require:

- owner
- reason
- risk
- removal plan
- review before launch

Trusted ad slots are the only planned case where third-party markup may be rendered, and only through the Ads ownership rules.



