# UI Stepper And Setup Flow

Steppers are shared progress components for bounded multi-step flows such as installer, setup, onboarding, and safe admin workflows.

## Component

- `x-ui.stepper`
- `x-ui.stepper-item` only when a sub-component keeps implementation cleaner

## Ownership

The stepper is a presentation component, not a workflow engine.

Flow state is owned by the module running the flow. The stepper receives state and renders it.

It must not read:

- database rows
- routes
- sessions
- request state
- config
- installer locks
- durable workflow state

## Rendering Contract

Stepper props should stay limited to rendering concerns:

- `steps`
- `current`
- `completed`

Recommended step shape:

```php
[
    ['id' => 'requirements', 'label' => __('installer.steps.requirements')],
    ['id' => 'environment', 'label' => __('installer.steps.environment')],
    ['id' => 'finish', 'label' => __('installer.steps.finish')],
]
```

## States

- completed: success semantic tokens
- active: brand semantic tokens
- pending: muted content and subtle border tokens

State must not be communicated by color alone.

## Accessibility

- Use semantic list structure where practical.
- Active step uses `aria-current="step"`.
- Include screen-reader-friendly state text where practical.
- Ensure labels are escaped.
- Mobile-condensed layouts must keep labels available visually or to screen readers.

## Rules

- No wizard engine in the component.
- No database, route, session, or installer business logic.
- No raw palette classes when semantic tokens exist.
- No inline CSS.
- No inline JavaScript.
- Mobile-first and RTL/LTR-safe.


