# Theme Module

Theme owns public theme composition registration and safe theme resolution.

Registered public themes:

- `atlas`
- `horizon`
- `legacy`

`horizon` is the safe fallback for missing or invalid theme keys.

Theme does not own business logic, content, navigation, mailbox logic, ads business rules, authorization, or translations. STEP006 registers theme definitions only and does not implement Blade theme compositions.
