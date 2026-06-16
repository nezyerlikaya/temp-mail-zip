# Tech Stack Contract

Temp Mail SaaS uses a conservative, shared-hosting-first Laravel stack.

## Backend

- Laravel 13
- PHP 8.5.7
- Modular monolith
- MySQL/MariaDB-compatible migrations
- Laravel validation, policies/gates, events, jobs, scheduler, and tests

## Frontend

- Server-rendered Blade layouts and Blade components
- Tailwind CSS v4 CSS-first configuration
- Alpine.js only for UI-local state
- Vite for asset bundling

## Explicitly Out Of Scope

Do not introduce these as v1 requirements:

- Livewire
- Inertia
- Vue
- React
- SPA-first frontend architecture
- Redis-required UI flows
- WebSocket/Reverb-required UI flows
- daemon-only runtime behavior

## Interaction Model

Default interaction is server-rendered Laravel:

- standard HTML forms
- POST/redirect/GET flows
- Laravel validation
- server-side flash/alert feedback
- bounded native `fetch` only where it stays simple and transparent

Alpine.js may manage:

- dropdowns
- modals
- tabs
- small toggles
- temporary loading state
- focus/view state

Alpine.js must not own:

- database queries
- authorization
- durable installer state
- mailbox ownership
- provider calls
- billing decisions
- security decisions

## Tailwind CSS v4

Design tokens live in `resources/css/app.css` using `@theme` unless the project explicitly adds a Tailwind config for a justified plugin need.

Use semantic tokens. Do not scatter raw palette classes or raw hex values across Blade views when semantic tokens exist.

## Shared Hosting

The system must work without Redis, Horizon, Supervisor, Reverb, or long-running daemons as hard requirements.

Jobs must be bounded, idempotent, resumable, lock-aware, and cron-compatible.



