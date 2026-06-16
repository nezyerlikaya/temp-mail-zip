# Admin Menu: Settings

## Purpose

Manage typed runtime settings and safe configuration surfaces.

## Owner Module

Settings

## Visible When

- The user has `settings.view`.
- Settings registry foundation exists.

## Contains

- General site settings.
- Typed settings values.
- Sensitive setting masking.
- Settings validation.

## Does Not Contain

- Feature rollout decisions owned by Feature Flags.
- Plan entitlements owned by Plans/Feature Gates.
- Raw `.env` editor.
- Arbitrary PHP/config file editing.

## Completion Checklist

- [ ] Menu item registered by Settings owner.
- [ ] Sensitive values masked.
- [ ] No raw `.env` editor.
- [ ] Permissions enforced.
