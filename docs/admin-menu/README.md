# Admin Menu README

This folder documents what each admin menu area is allowed to contain.

Admin navigation is registry-driven. These files are acceptance contracts for future prompts; they are not implementation code.

## Required Shape For Each Menu Document

Each admin menu document must include:

- Purpose.
- Owner module.
- Visible when.
- Contains.
- Does not contain.
- Required named routes.
- Required permissions.
- UI rules.
- Compatibility/deprecation notes.
- Completion checklist.

## Global Menu Rules

- No static sidebar entries.
- No placeholder menus.
- No coming-soon screens.
- No duplicate ownership.
- No raw labels; use translation keys.
- No hidden authorization; routes must still use policies/gates.
- Empty groups do not render.

## Suggested Top-Level Order

1. Dashboard
2. Setup
3. Settings
4. Localization
5. Navigation
6. Appearance
7. Domains
8. Mailboxes
9. Security
10. Users
11. Billing
12. Content
13. Monitoring
14. Ops
