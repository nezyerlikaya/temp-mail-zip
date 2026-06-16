# Content Governance

Content in Temp Mail SaaS is owner-based. Generic page builders, arbitrary HTML editors, and catch-all CMS buckets are not part of v1.

Each content surface must have a single owning module, a bounded route pattern, a clear localization rule, and an explicit versioning policy.

## Content Ownership Matrix

| Module Name | Content Type | Route Pattern | Ownership | L10N Requirement | Versioning |
| --- | --- | --- | --- | --- | --- |
| Blog | Post, article, author-linked article, tag-aware article | `/blog/{slug}` | Blog module | Full | Yes |
| Blog Tags | Tag index, tag archive | `/blog/tag/{slug}` | Blog module | Full | No |
| Blog Categories | Category index, category archive | `/blog/category/{slug}` | Blog module | Full | No |
| Knowledge Base | Help article | `/kb/{slug}` | Knowledge Base module | Full | Yes |
| Knowledge Base Categories | Category index, category archive | `/kb/category/{slug}` | Knowledge Base module | Full | No |
| Documentation | Docs page, docs article, API doc page | `/docs/{section}/{slug}` | Documentation module | Full | Yes |
| Legal Pages | Policy, terms, cookie, acceptable-use page | `/legal/{slug}` | Compliance module | Full | Yes |
| Pages Registry | Static page surface owned by a module, not a builder | `/pages/{slug}` or module-owned route patterns | Owning module of the page surface | Depends on surface | Depends on surface |
| Contact Pages | Contact request page, contact routing page | `/contact` or module-owned route pattern | Contact Center module | Full | No |
| Homepage Sections | Section content surfaced inside theme guardrails | Theme-owned section routes or embedded section data | Public Homepage / Theme / Appearance | Full | Depends on section |

## Rules

- A page surface must belong to one owner.
- Tags and categories are part of their owning content system, not a shared global taxonomy layer unless the owning module explicitly defines one.
- Documentation and Knowledge Base both support versioning, but their version models are separate.
- Legal pages are versioned records, not generic CMS pages.
- The Pages Registry is not a WordPress-style builder. It only exposes bounded page surfaces owned by other modules.
- Public localized content must only render for active locales.
- Passive locales do not appear in public selectors, hreflang output, sitemap output, or public section selectors.
- If a route surface has no meaningful content, it does not render an empty shell.
- Versioning is required whenever content changes must be auditable, rollback-safe, or locale-specific at publish time.

## Practical Ownership Notes

### Blog

Blog owns article publishing, tag archives, category archives, authors, and workflow. It is suitable for editorial content, announcements, and public posts.

### Knowledge Base

Knowledge Base owns help content and category organization. It is better for support articles, how-tos, and bounded help workflows.

### Documentation

Documentation owns official product/API docs. It is versioned and more structured than Blog.

### Legal

Legal owns immutable public policy surfaces such as privacy, terms, cookie, and acceptable-use content. It is locale-aware and versioned.

### Pages Registry

Pages are route surfaces, not a generic CMS. A page surface must still map to a real module owner, a bounded template, and a localization rule.

## Integration Rules

- Navigation may point to content routes, but navigation does not own content.
- SEO may consume content metadata, but SEO does not own content.
- Localization owns locale context and direction for all content surfaces.
- Theme and Appearance may style content surfaces, but they do not own the content itself.
- Content components must remain semantic, bounded, and reusable.



