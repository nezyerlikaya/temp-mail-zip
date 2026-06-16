# Public Interaction Boundary

Temp Mail SaaS is a utility-first SaaS product, not a public discussion platform.

## Out Of Scope For v1

Do not build:

- public comments
- public discussion threads
- forums
- public ratings with visible user-generated text
- community feeds
- moderation workflows for public discussion
- comment notification systems
- comment reputation systems

These features create spam, abuse, moderation, legal, privacy, and security surface area that does not support the v1 temp-mail core.

## Allowed Public Interaction

Allowed interaction is transactional and bounded:

- contact form
- support request
- abuse report
- account/admin forms
- mailbox actions
- safe product feedback signals

## Feedback Signals

Simple feedback such as "Was this helpful?" may exist only when:

- it belongs to the owning content module
- it is not a public comment stream
- it stores bounded telemetry only
- it does not expose user-generated text publicly
- it follows validation, rate-limit, privacy, and retention rules

## Ownership

- Contact requests belong to Contact Center.
- Abuse reports belong to Abuse or the relevant intake owner.
- Knowledge Base helpfulness belongs to Knowledge Base.
- Documentation helpfulness belongs to Documentation.
- Blog comments are not part of v1.

## Security

Public interaction must not expose raw request bodies, private mailbox content, provider payloads, tokens, internal diagnostics, IP-based ownership, or admin-only data.

If a future comments/discussion layer is required, it must be introduced as a separate future owner with its own moderation, rate limit, abuse, audit, retention, notification, and legal boundaries.



