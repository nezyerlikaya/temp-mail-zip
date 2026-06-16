# Uploads Module

Uploads owns shared upload validation, scoped path generation, storage safety, and safe metadata extraction.

Scope:

- Validate files against registered upload scopes.
- Generate relative storage paths inside the owning scope.
- Sanitize original filenames for metadata only.
- Keep public/private visibility explicit.
- Prepare safe metadata for future owning modules.

Boundaries:

- Avatars owns avatar records and UI later.
- Message Storage owns email attachment metadata later.
- Content modules own their records and lifecycle later.
- Security owns masking and safe diagnostics.

Rules:

- No general Media Library.
- No media manager admin UI.
- No avatar upload UI.
- No message attachment ingestion.
- No virus scanning or external storage provider list in this foundation.
- No private file direct public serving.
- No absolute paths in returned metadata.
