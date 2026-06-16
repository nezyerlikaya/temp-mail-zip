# Admin Menu: Domains

## Purpose

Manage domain inventory and domain metadata needed by the Temp Mail engine.

## Owner Module

Domains

## Visible When

- The user has `domains.view`.
- Domain inventory foundation exists.

## Contains

- Domain inventory.
- Domain status.
- Domain type.
- Admin-safe notes.

## Does Not Contain

- Domain health intelligence.
- Pool selection.
- Provider API automation.
- DNS polling as a hidden side effect.

## Completion Checklist

- [ ] Menu item registered by Domains owner.
- [ ] Named routes only.
- [ ] Translation keys only.
- [ ] Permissions enforced.
- [ ] No non-domain responsibility included.
