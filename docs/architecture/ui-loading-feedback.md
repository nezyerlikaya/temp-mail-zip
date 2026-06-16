# UI Loading Feedback

Loading feedback shows real work in progress without fake progress, placeholder data, or hidden business logic.

## Components

- `x-ui.spinner`
- `x-ui.loading-bar`
- button loading state through `x-ui.button`

## Component Scope

`x-ui.spinner` is component-level feedback.

`x-ui.loading-bar` is shell-level feedback for bounded page actions, form transitions, or small transparent native `fetch` interactions.

Buttons may show loading state to prevent duplicate submissions and communicate that the submitted action is in progress.

## Rules

- Loading components are UI-state components.
- They do not own database, route, authorization, session, provider, mailbox, or business logic.
- Do not fake progress percentages.
- Do not render fake records or placeholder content.
- No raw palette classes when semantic tokens exist.
- No inline CSS.
- No inline JavaScript.
- User-facing loading labels use translation keys.
- Respect `prefers-reduced-motion` where motion is used.

## Accessibility

- Spinners use `role="status"` or an equivalent accessible pattern.
- Loading bars use `role="progressbar"` where appropriate.
- Indeterminate progress should not claim exact percentages.
- Loading labels should be available to screen readers.

## Interaction Model

Default flow is server-rendered:

- standard form submit
- POST/redirect/GET
- server-side validation
- flash/alert feedback

Native `fetch` may be used only when it stays bounded, transparent, and simple. Livewire, Inertia, Vue, React, WebSocket/Reverb-required flows, and daemon-required interaction are not part of v1.


