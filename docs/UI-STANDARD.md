# Modern SaaS UI Standard

This document defines the visual and interaction standard for every Temp Mail SaaS screen.

It applies to:

- public homepage themes
- mailbox screens and public mailbox controls
- installer screens
- admin screens
- auth screens
- settings/forms
- legal/content pages
- support/contact pages
- docs/blog/knowledge base pages
- error, empty, loading, and locked states

## Design Philosophy

The product UI should combine:

- Stripe-like trust
- Linear-like minimalism
- Vercel-like deployment clarity

The result should feel clean, calm, modern, technical, and safe.

## Lessons Learned

The new project must not repeat these UI mistakes:

- building installer screens as raw technical checklists
- using inline `<style>` blocks as the primary UI system
- scattering one-off button/card/input markup across Blade views
- adding UI without a reusable component contract
- treating Tailwind as random utility strings instead of semantic tokens
- letting admin, installer, public, and content screens drift into different visual languages
- fixing one page visually while leaving the rest of the product on an older UI system

The UI standard is global. Installer polish is only the first visible use case, not the whole goal.

## Default Surface Theme

Admin, installer, auth, settings, and operational surfaces use Zinc Light by default.

Public homepage themes may have their own composition and mood, but they must still consume semantic tokens and shared Blade components where practical.

## Semantic Token System

Use semantic tokens instead of hard-coded one-off colors.

Do not place raw palette utilities such as `bg-zinc-950`, `bg-indigo-600`, or raw hex values directly into Blade when a semantic token exists. Prefer tokens such as `bg-surface-card`, `text-content-muted`, `border-border-subtle`, and `bg-brand-primary`.

This keeps dark mode, theme changes, and brand changes centralized.

Tailwind CSS v4 uses CSS-first configuration. Do not assume `tailwind.config.js` exists. Define design tokens in `resources/css/app.css` using `@theme` unless the project explicitly adds a config file.

Core light tokens:

- `bg-surface-canvas`: zinc-50
- `bg-surface-card`: white
- `bg-surface-muted`: zinc-100
- `text-content-primary`: zinc-950
- `text-content-secondary`: zinc-700
- `text-content-muted`: zinc-600
- `border-border-subtle`: zinc-200
- `border-border-strong`: zinc-300
- `bg-brand-primary`: indigo-600
- `bg-brand-primary-hover`: indigo-700

Semantic size tokens should be preferred where a size repeats across components:

- `h-control-sm`
- `h-control-md`
- `h-control-lg`
- `px-control-padding-x-sm`
- `px-control-padding-x-md`
- `px-control-padding-x-lg`
- `rounded-control`
- `rounded-button`
- `rounded-card`
- `shadow-subtle`
- `shadow-card`

Do not repeatedly scatter raw sizing such as `h-10` when a semantic control token exists.

Status tokens:

- success: emerald
- warning: amber
- danger: red
- info: sky

Do not scatter raw color values through Blade views when a semantic token exists.

## Component Strategy

Blade components come first.

UI layering must follow this order:

```text
Design Tokens -> Base UI Components -> Layout Components -> Feature Components -> Pages
```

Pages should not create their own visual system.

Base UI components should be mostly dumb presentation components. They may handle visual variants, sizes, accessibility attributes, and basic states, but they should not own business rules, database behavior, module decisions, or feature workflows.

Shared UI components live under:

```text
resources/views/components/ui/
```

Initial shared components:

- `button`
- `card`
- `input`
- `textarea`
- `select`
- `checkbox`
- `radio`
- `badge`
- `alert`
- `modal`
- `stepper`
- `loading-bar`
- `empty-state`

## Form Control Family

The form-control family must remain consistent across all screens:

- `x-ui.input`
- `x-ui.textarea`
- `x-ui.select`
- `x-ui.checkbox`
- `x-ui.radio`

These components should share the same field behavior contract:

- `id`
- `name`
- `label`
- `hint`
- `error`
- `disabled`
- `required`
- `aria-invalid`
- `aria-describedby`

Use `focus:ring-focus-ring/20`, `focus:border-focus-ring`, `border-status-danger`, `rounded-control`, `h-control-md`, and related semantic tokens instead of one-off style decisions.

Each reusable component should define:

- supported variants
- supported sizes where relevant
- disabled/loading/error states where relevant
- accessibility behavior
- RTL/LTR expectations where relevant
- whether it may contain arbitrary HTML

Use consistent prop names across components:

- `variant="primary|secondary|ghost|danger|success|warning|info"`
- `size="sm|md|lg"`
- `disabled`
- `loading`
- `label`
- `description`
- `error`

Use slots for flexible composition. Complex components should expose named slots such as:

- `header`
- default body slot
- `footer`
- `actions`

Do not force every component into rigid text-only props when slot composition is cleaner.

Buttons must support disabled and loading states. Loading buttons should prevent duplicate submissions and show a visual progress indicator such as a spinner or loading label.

Installer-specific components live under:

```text
resources/views/components/installer/
```

Feature-specific components may live under their owning namespace, for example:

```text
resources/views/components/admin/
resources/views/components/public/
resources/views/components/mailbox/
resources/views/components/content/
```

Those components must still consume the shared token system and shared UI primitives where practical.

## Global Screen Standard

All product screens should use:

- a clear page shell
- consistent max-width containers
- semantic headings
- card-based grouping where useful
- reusable buttons, inputs, badges, alerts, modals, and tables
- visible focus states
- bounded empty/loading/error states
- localization keys for UI text
- locale-aware `lang` and `dir` shell attributes
- responsive layout from the beginning

Installer screens should use a Stripe/Linear/Vercel-style setup wizard:

- clean cards
- stepper/progress flow
- safe diagnostics
- status badges
- accessible controls
- responsive layout
- no raw legacy HTML screens

## Interaction Rules

Use Alpine.js only for minor UI states:

- dropdowns
- modals
- tabs
- small toggles
- loading indicators

Do not introduce SPA-style state management for server-rendered screens.

If a behavior can be handled by Blade, Laravel validation, redirects, sessions, or simple server-rendered state, do not move it into Alpine.

Alpine.js may manage:

- dropdown visibility
- modal visibility
- tabs
- small toggles
- temporary loading indicators
- local optimistic UI hints

Alpine.js must not own:

- database queries
- authorization decisions
- billing decisions
- mailbox ownership
- security checks
- provider calls
- durable installer completion state

Ship minimal JavaScript. If Alpine behavior becomes complex, move it out of inline `x-data="{ ... }"` blobs and into a small module under `resources/js/components/`, then import it through Vite. Keep HTML clean and behavior reusable.

Avoid embedding large JavaScript objects in Blade attributes. Do not place private data, secrets, provider payloads, raw mailbox content, or admin-only state in Alpine data.

## Fonts

Use clean modern sans-serif fonts such as Inter, Geist, or Plus Jakarta Sans for the SaaS surface when licensing allows.

Fonts should be self-hosted by the application instead of loaded from a third-party CDN. This improves privacy, GDPR posture, reliability, and performance.

Font loading should:

- avoid blocking rendering where practical
- use sane fallback stacks
- avoid layout shift
- respect LTR and RTL readability
- avoid loading many weights unnecessarily

## Forbidden UI Patterns

Do not use:

- raw standalone HTML screens
- inline CSS for production screens
- arbitrary custom CSS editors
- arbitrary custom JavaScript editors
- page builders
- business logic in Blade
- inaccessible icon-only controls
- raw palette utilities when a semantic token exists
- hard-coded user-facing text when a translation key should be used
- hard-coded left/right spacing when logical start/end utilities can be used

Foundation screens may temporarily contain bridge styles, but production UI must migrate to Blade components, Tailwind utilities, and semantic tokens.

Inline `style="..."` is not allowed for production screens.

If a temporary migration fix is unavoidable, use a dedicated bridge stylesheet such as `resources/css/bridge.css` and document the cleanup owner and removal plan. Bridge CSS is temporary debt, not a design system.

## UI Debt Policy

- No new legacy UI.
- Existing legacy UI must be migrated when touched.
- A feature is not complete if it introduces new inline CSS, inline JS, raw standalone HTML, or one-off component systems.
- If an exception is unavoidable, document the owner, reason, risk, and removal plan.
- Do not introduce a new visual style without updating this document.

## Migration Rule

When modernizing an old screen:

1. Identify legacy markup, inline CSS, inline JS, hard-coded colors, and one-off component patterns.
2. Map each repeated pattern to a shared `ui` component or feature component.
3. Migrate the screen to semantic tokens and Blade components.
4. Remove the old inline CSS/JS after the component replacement exists.
5. Verify accessibility, responsive behavior, RTL/LTR where relevant, and empty/loading/error states.
6. Update docs or checklist evidence.

## Screen-Specific Guidance

### Public Homepage

Atlas, Horizon, and Legacy are distinct compositions, not color-only skins. They use the shared token/component language but keep their own layout rhythm and visual character.

### Admin

Admin screens should feel like a modern SaaS control panel:

- compact but readable navigation
- clear page headers
- section cards
- tables with bounded pagination
- safe empty states
- no decorative noise
- no raw technical dumps

Admin dashboard follows Meaningful Data Only and Zero Placeholder rules. It must show bounded widgets only when real admin-safe data exists. Otherwise, it should render actionable empty states or omit unavailable widgets.

Dashboard is a composition surface, not a data owner.

### Installer

Installer screens should feel like a modern setup wizard:

- stepper/progress flow
- requirement checks
- status badges
- safe diagnostics
- clear lock/finish action

Installer is a trust-critical setup wizard. It must be the first polished experience of the product. It must never look like a raw technical checklist.

Installer state must be consistent. If the user refreshes the browser during a later step, the installer should return to the current safe step instead of forcing the user back to the beginning. Use server-side session or another safe bounded installer state mechanism; do not rely only on fragile client-side state.

Installer errors should keep the user inside the wizard, show the failed step, explain the safe fix, and provide a re-check path. Do not send users to a generic error page for expected setup blockers.

### Layout And Shells

Use separated layout shells for major product areas:

- public app shell
- admin shell
- installer shell
- auth shell
- content/legal shell where useful

Major shell changes should happen in one shell component, not across many pages.

### Forms

Forms should use shared input, select, checkbox, radio, textarea, button, alert, and validation components. Help text should explain why a value is needed without leaking internals.

Form controls must support consistent field behavior:

- `id`
- `name`
- `label`
- `hint`
- `error`
- `disabled`
- `required`
- `aria-invalid`
- `aria-describedby`

Text-like controls should use semantic focus and error tokens such as `focus:ring-focus-ring/20`, `focus:border-focus-ring`, and `border-status-danger`.

Checkbox and radio controls should use horizontal label layouts and maintain practical touch targets.

Validation UX should be calm and specific:

- field errors appear under the related field where practical
- form-level errors use `x-ui.alert`
- errors use semantic danger tokens
- error text should be short and actionable
- successful submissions should avoid duplicate clicks through disabled/loading states

### Stepper And Setup Flow

Multi-step flows such as installer, setup, onboarding, and future bounded admin flows should use the shared stepper pattern.

The stepper is a presentation component, not a workflow engine.

Stepper components:

- `x-ui.stepper`
- `x-ui.stepper-item` where a sub-component keeps the implementation cleaner

Stepper state is owned by the flow owner. The component receives state and renders it. It must not read sessions, routes, request state, database rows, installer locks, or config.

Stepper props should stay limited to rendering concerns:

- `steps`
- `current`
- `completed`

Stepper states:

- completed: success semantic tokens
- active: brand semantic tokens
- pending: muted content and subtle border tokens

Accessibility requirements:

- active step uses `aria-current="step"`
- step order is exposed through semantic list structure where practical
- state is not communicated by color alone
- mobile-condensed layouts keep readable or screen-reader-safe labels

Responsive behavior:

- mobile-first markers are acceptable
- desktop can expand labels and supporting text
- layout must not overflow in RTL or LTR

### Tables

Tables must be bounded and paginated where data can grow. Do not use unbounded public or admin list queries.

### Error And Empty States

Every module should provide safe empty/error states. Avoid broken blank panels, raw exceptions, stack traces, SQL strings, absolute paths, provider payloads, and debug text.

Empty states should guide the next action. Do not show only "nothing here" when a safe next step exists.

Empty states must be meaningful. They explain why an area is empty and may provide a CTA only when a safe next action exists. They must not render fake records, fake metrics, decorative filler, placeholder cards, or "coming soon" panels.

Modal/dialog components may use Alpine.js for UI state such as open/close, Escape handling, focus management, and transitions. They must remain business-dumb and must not own database, route, authorization, session, provider, mailbox, or durable workflow logic.

Modals/dialogs must include `role="dialog"`, `aria-modal="true"`, `aria-labelledby` when a title exists, and a focus management strategy. Destructive or blocking flows must be able to configure Escape and backdrop-close behavior.

## Responsive And Touch

Design mobile-first. Default classes should work on phones, then `sm:`, `md:`, `lg:`, and larger breakpoints may enhance layout.

Interactive touch targets should be at least 44px high or wide where practical. Avoid tiny icon-only controls on mobile.

## Accessibility

Every screen should protect:

- visible focus states
- readable contrast
- keyboard navigation
- semantic landmarks
- accessible labels for icon-only actions
- `prefers-reduced-motion` where motion exists
- RTL/LTR-safe layout where localization applies

Use visible focus styling such as focus rings on buttons, links, inputs, selects, tabs, and modal controls. Muted text must remain readable on light surfaces; avoid overly pale text for essential information.

## Localization And Direction

Every major shell must receive the active locale context and render `lang` and `dir` consistently.

Use logical CSS utilities for direction-safe spacing and alignment:

- `ms-*` instead of `ml-*`
- `me-*` instead of `mr-*`
- `ps-*` instead of `pl-*`
- `pe-*` instead of `pr-*`
- start/end alignment where practical instead of left/right

Component APIs should not assume LTR. Public homepage themes, admin shell, installer shell, auth shell, forms, mailbox controls, FAQ, ads, and footer/header layouts must remain usable in both LTR and RTL.

Direction-aware shell changes are allowed when logical utilities alone are not enough, but they must be centralized in shell or component code rather than scattered through pages.



