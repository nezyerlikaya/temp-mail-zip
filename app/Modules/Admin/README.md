# Admin Module

Admin owns the admin shell and dashboard surface.

Scope:

- Admin layout shell.
- Dashboard route and view.
- Safe empty dashboard state.
- Shell consumption of resolved admin navigation.

Boundaries:

- Navigation owns admin menu registration and resolution.
- Authorization will own real admin access rules later.
- Auth will own login and sessions later.
- System Health, Monitoring, Audit, Backup, and business modules own dashboard data later.

Rules:

- Do not hardcode future menu lists into the shell.
- Do not render fake metrics, placeholder widgets, raw diagnostics, mailbox content, provider payloads, secrets, or tokens.
- The temporary admin middleware blocks production access until real auth/authorization is implemented.
