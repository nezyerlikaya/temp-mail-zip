# Feature Gates Module

Feature Gates will own actor-specific access decisions in a later scoped prompt.

Feature Flags answer whether a capability is operationally available. Feature Gates answer whether a specific actor may use an available capability.

Boundaries:

- Feature Flags owns rollout and kill switches.
- Plans own plan definitions and entitlements.
- Subscriptions own active plan state.
- Authorization owns roles, permissions, policies, and gates.
- Navigation may consume gate results later but does not own gates.

STEP004 does not implement gate evaluation, billing plans, subscriptions, permissions, authorization policies, navigation visibility, or admin UI.
