# Translation Module

Translation owns key-based UI and system strings.

Scope:

- Namespace-based translation keys.
- Translation namespace ownership.
- Locale fallback behavior for UI/system strings.
- Placeholder validation.
- Raw HTML translation rejection.

Boundaries:

- Localization owns language availability, active locale context, fallback locale, and direction.
- Blog, Knowledge Base, Documentation, Legal, SEO, and other content owners own their long-form translated content.
- AI translation is out of scope and must not be introduced.

Rules:

- User-facing UI/system text must use translation keys.
- Keys use namespace dot notation such as `auth.login` or `mailboxes.create.success`.
- Fallback never switches namespace silently.
- Raw HTML translations are prohibited in this foundation.
- Replacement placeholders must exactly match the registered placeholders.
