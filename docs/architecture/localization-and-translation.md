# Localization And Translation

Localization owns locale context and resolution. Translation owns key-based UI and system text. Long-form content translations for Blog, Knowledge Base, Documentation, legal documents, SEO, search, and sitemap remain outside STEP005 and belong to their content owner modules.

## Localization Commandment

Localization is not only text translation. It owns locale availability, request locale resolution, direction, fallback behavior, and the public visibility of languages.

The binding rules are:

- Use registry-driven language definitions.
- Active languages may be resolved and exposed publicly.
- Passive/disabled languages must not appear in public selectors, hreflang, sitemap, public content filters, or public theme language controls.
- Every public/admin/layout shell must render the current locale code and direction through the global wrapper.
- UI text must use translation keys. Hard-coded user-facing strings are not accepted in production screens.
- RTL/LTR support is part of the layout contract, not a later visual patch.

Global wrappers such as admin, public, installer, auth, and content shells must render:

```blade
<html lang="{{ $activeLanguage->code }}" dir="{{ $activeLanguage->direction }}">
```

If the active language object is not available directly in a shell, the shell must receive a safe locale view model or use the approved locale context service. Shells must not query arbitrary tables directly.

## Locale Standard

Locale identifiers are normalized as BCP 47-compatible values such as `en`, `tr`, or `en-US`. Initial supported locales are `en`, `tr`, `de`, `fr`, and `es`.

Exactly one default locale is registered. Default locale and fallback locale are separate concepts. Runtime choices such as default locale, fallback locale, cookie lifetime, and default-locale URL prefix policy are Settings-owned values registered by Localization.

Language definitions are stored and managed through the Localization module. Persistence is accessed through repositories; runtime request resolution consumes a cache-aware `LocalizationRegistry` / `LocaleResolver` service. Public requests must not hit the database repeatedly for the same bounded locale metadata.

## Locale Status

- `active`: selectable and resolvable.
- `hidden`: resolvable but excluded from public selectors.
- `disabled`: not selectable for new requests.
- `deprecated`: must define fallback behavior.

Existing unavailable preferences safely fall back through the resolver.

Passive public behavior:

- Disabled locales are rejected by route validation and fall back according to the documented fallback policy or return a safe 404 where route semantics require it.
- Hidden locales are resolvable only where explicitly allowed, but are not shown publicly.
- Public selectors, SEO output, sitemap output, localized sections, and theme language controls use active public locales only.

## Resolution Priority

Locale resolution uses:

1. Validated route locale
2. Authenticated user preference supplied by Auth/Profile integration when available
3. Validated locale cookie
4. Bounded `Accept-Language` parsing
5. System default locale

Unsupported and malformed input is ignored safely.

## Routing Policy

Locale route parameters are validated centrally by `LocaleResolver::validateRouteLocale`. Route names are not localized. The default locale does not require a URL prefix by default; that policy is controlled by `localization.default_locale_prefix`.

Middleware must resolve locale early enough for validation, translation, navigation labels, theme direction, and public content filtering. Middleware must not trust raw route, query, cookie, or header locale values without registry validation.

## Translation Rules

Translations use canonical keys such as `auth.login` and `mailboxes.create.success`. The namespace is the first segment and ownership is registered in `TranslationNamespaceRegistry`.

Stable application strings use registry/file-style providers in STEP005. Database-backed translation tables are introduced only when runtime management is genuinely required. If database storage is approved, file/provider values must remain the lower-precedence stable source unless documented otherwise.

User-facing production text in Blade, controllers, validation responses, emails, installer screens, admin screens, and public pages must use translation keys. Exceptions are limited to non-user-facing developer identifiers, enum keys, internal test labels, and documented diagnostics.

## Fallback

Runtime lookup order is:

1. Requested locale value
2. Configured locale fallback value
3. Visible missing-key marker appropriate to environment

Fallback never switches namespace silently.

## Placeholders And Safety

Registered placeholder names must match translation placeholders and supplied replacements exactly. Replacement values are escaped. Raw HTML translations are prohibited in this foundation. Translation values must not contain secrets or internal diagnostics.

## Cache

Locale definitions are bounded registry values. Translation values cache per locale and namespace; there is no global translation blob. Invalidation is per locale/namespace through `TranslationResolver::forget`.

Locale metadata cache must be keyed by the language registry version or invalidated when language status, default locale, fallback locale, or direction changes.

## Direction And Logical Layout

Locale direction is a first-class field with allowed values:

- `ltr`
- `rtl`

The UI must use logical CSS direction patterns:

- use `ms-*` instead of `ml-*`
- use `me-*` instead of `mr-*`
- use `ps-*` instead of `pl-*`
- use `pe-*` instead of `pr-*`
- use start/end alignment where practical instead of hard-coded left/right

Hard-coded `left`, `right`, `ml-*`, `mr-*`, `pl-*`, and `pr-*` are not allowed when logical start/end alternatives can express the same layout.

Some component structures may still require conditional layout behavior, especially complex flex/grid shells. In those cases, the owning shell/component may apply explicit direction-aware classes based on the resolved locale direction. This belongs in layout components such as admin/public shells, not scattered through pages.

## Admin Language Management

Admin language management should use shared UI components:

- active/passive status through `x-ui.checkbox` or a bounded toggle component
- direction through `x-ui.select` with `ltr` and `rtl`
- default language through `x-ui.radio` or a single-default action
- preview through a safe preview route or mode that does not publish changes automatically

Language management must enforce exactly one default language, validate BCP 47-compatible codes, validate direction, and prevent disabling the only usable default without a safe replacement.


