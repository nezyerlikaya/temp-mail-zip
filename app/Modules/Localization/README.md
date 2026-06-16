# Localization Module

Localization owns language metadata, locale resolution, fallback locale behavior, and text direction.

Scope:

- Registry-driven language definitions.
- Active, hidden, disabled, and deprecated language status.
- Default and fallback locale resolution.
- Locale direction metadata for future layout shells.
- Safe request locale resolution from route, user preference, cookie, Accept-Language, then default.

Boundaries:

- Translation owns UI and system translation keys.
- Content owners own translated long-form content.
- SEO owns hreflang and canonical output later.
- Theme, Admin, Public, Auth, Installer, and Content shells consume locale context but do not own it.

UI/L10N rules for future prompts:

- Shells render `lang` and `dir` from the active locale context.
- Use logical utilities such as `ms-*`, `me-*`, `ps-*`, `pe-*`, `start-*`, and `end-*`.
- Avoid hard-coded `ml-*`, `mr-*`, `pl-*`, `pr-*`, `left-*`, and `right-*` unless documented and unavoidable.
- Public selectors consume only active public languages.

STEP005 does not add language admin UI, content workflows, SEO output, or public header/theme UI.
