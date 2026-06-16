# UI Modal And Empty States

Modal/dialog and empty-state components are shared UI primitives for safe interaction and meaningful absence of data.

## Components

- `x-ui.modal`
- `x-ui.empty-state`

## Modal Governance

Modals may own UI view-state:

- open/close
- transitions
- Escape handling
- backdrop handling
- focus management

They must remain business-dumb. They must not own:

- database queries
- route decisions
- authorization
- persistence
- session state
- provider calls
- mailbox logic
- durable workflow state

## Modal Accessibility

Modals/dialogs must support:

- `role="dialog"`
- `aria-modal="true"`
- `aria-labelledby` when a title exists
- keyboard close with Escape when closeable
- configurable backdrop close behavior
- configurable closeability for destructive or blocking flows
- focus management

Focus trapping may use Alpine `x-trap` if the required Alpine Focus plugin exists. If not, implement a safe focus management plan without adding a heavy dependency.

## Empty State Governance

Empty states are not placeholders.

They render only for real empty conditions and explain why the area is empty.

They may include a CTA only when a safe next action exists.

Do not render:

- fake records
- fake metrics
- decorative filler
- "coming soon" cards
- placeholder shells
- sensitive diagnostics
- provider payloads
- raw exceptions
- internal paths
- private mailbox content
- admin-only diagnostics

## Security

UI component inputs must be public-safe.

If non-public diagnostic data must be shown, it must be masked or anonymized before it reaches the component.

Do not place secrets, tokens, raw request bodies, provider payloads, private mailbox content, internal paths, or admin-only diagnostics in Blade, Alpine, JavaScript, or data attributes.

## Styling

- Use semantic tokens.
- No raw palette classes when semantic tokens exist.
- No inline CSS.
- No inline JavaScript.
- Use translation keys.
- Use start/end logical alignment where practical.
- Components must be responsive and RTL/LTR-safe.


