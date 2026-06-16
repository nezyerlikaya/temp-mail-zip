# UI Form Controls

Form controls are shared, accessible, themeable Blade components.

They are part of the UI foundation and must be used across installer, admin, auth, settings, public, and content screens.

## Components

- `x-ui.input`
- `x-ui.textarea`
- `x-ui.select`
- `x-ui.checkbox`
- `x-ui.radio`

## Shared Contract

Each component supports the relevant subset of:

- `id`
- `name`
- `label`
- `hint`
- `error`
- `disabled`
- `required`
- `aria-invalid`
- `aria-describedby`

## Rules

- Components are dumb presentation components.
- Components do not own database, route, authorization, session, or business logic.
- User-facing text must use translation keys.
- No raw palette classes when semantic tokens exist.
- No raw hex colors.
- No inline CSS.
- No inline JavaScript.
- Use Tailwind CSS v4 semantic tokens from `resources/css/app.css`.
- Do not assume `tailwind.config.js` exists.
- Keep touch targets at least 44px high where practical.

## Accessibility

- Labels use proper `for` and `id` relationships where applicable.
- Text-like controls use `aria-invalid`.
- Hint and error text must be linked through `aria-describedby`.
- Disabled controls are visually and semantically disabled.
- Focus states are visible.

## Semantic Styling

Use tokens such as:

- `bg-surface-card`
- `text-content-primary`
- `text-content-muted`
- `border-border-subtle`
- `border-border-strong`
- `border-status-danger`
- `focus:ring-focus-ring/20`
- `focus:border-focus-ring`
- `h-control-md`
- `px-control-padding-x-md`
- `rounded-control`

## Component Notes

`x-ui.input` supports text-like input types and defaults to `type="text"`.

`x-ui.textarea` follows the same field behavior as input, uses a practical minimum height, and may support vertical resize.

`x-ui.select` supports slot-based options and does not own option data logic.

`x-ui.checkbox` and `x-ui.radio` use horizontal label layouts, semantic focus states, and practical touch targets.


