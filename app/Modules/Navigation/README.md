# Navigation Module

Navigation owns menu registration, validation, visibility resolution, ordering, and localization-key labels.

Scope:

- Public navigation registry.
- Admin navigation manifest validation.
- Named-route references only.
- Translation key labels only.
- Locale-aware resolution context for future shells.

Boundaries:

- Admin owns shell rendering, not menu ownership.
- Authorization owns backend access rules.
- Feature Flags may affect operational visibility later.
- Translation owns label text.
- Localization owns locale and direction.

Rules:

- Do not hardcode feature menu lists into shells.
- Do not create placeholder, coming-soon, or removed-system entries.
- Hidden navigation is not authorization.
