# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Overview

**Kernel** is a Laravel 11 ticket-management system layered on top of a project directory. It began as a static HTML page (the deleted `script.js` / `style.css` / `favicon.svg` in git status) and was rebuilt as a server-rendered Laravel app. The UI is Blade + Tailwind CSS v4, in **Spanish** (`APP_LOCALE=es`), with a dark dashboard theme. There is no JS framework — interactivity is vanilla JS inline in Blade.

## Commands

```bash
# Setup
composer install && npm install
php artisan migrate:fresh --seed        # rebuild DB + seed users and projects

# Run (two processes)
php artisan serve                       # PHP backend
npm run dev                             # Vite dev server (HMR for CSS/JS)
npm run build                           # production asset build

# Tests (PHPUnit, runs against in-memory SQLite — see phpunit.xml)
php artisan test                        # all tests
php artisan test --filter=SomeTest      # single test / method
./vendor/bin/phpunit tests/Feature/ExampleTest.php

# Format (Laravel Pint)
./vendor/bin/pint                       # apply
./vendor/bin/pint --test                # check only

# Console
php artisan tinker
```

## Environment note

`.env` points dev at **MySQL** (`DB_CONNECTION=mysql`, database `kernel_tickets`, user `root`, empty password). Tests override this to SQLite `:memory:` via `phpunit.xml`. A stray `database/database.sqlite` exists but is not what dev uses. Session, cache, and queue all use the `database` driver, so those tables must be migrated.

## Architecture

### Domain model
`Project` → has many `ProjectLink` and `Ticket`. A `Ticket` belongs to a project, a creator (`created_by`) and an optional assignee (`assigned_to`), and has many `TicketSubtask`, `TicketComment`, `TicketFile`, and `AuditLog`. See `app/Models/`.

- **Ticket status** (string enum): `backlog`, `en_progreso`, `en_revision`, `done`. "Active" = the first three (`Ticket::isActive()`, and repeated inline in controllers).
- **Ticket priority**: `baja`, `media`, `alta`, `critica`.
- Enum *values are Spanish* and appear in DB, validation rules, and `orderByRaw` sorts — keep them consistent when adding filters.
- `Ticket::getProgressAttribute()` computes subtask completion %.
- **Activity timestamps**: `tickets.completed_at` / `assigned_at` are derived, not user input — they are **not fillable** and are stamped in `Ticket::booted()` (a `saving` hook) whenever `status` crosses into/out of `done` or `assigned_to` changes. That hook is the single place both the web and API controllers rely on; don't set these columns by hand. The dashboard heatmap buckets by them.

### Roles & visibility (the core cross-cutting concern)
Two roles only: `dev` and `boss` (`User::isDev()` / `isBoss()`; `role` column). Auth is hand-rolled session auth (`LoginController`), **not** Breeze/Jetstream. The `role` middleware alias maps to `App\Http\Middleware\CheckRole` (registered in `bootstrap/app.php`), though routes currently gate only on `auth`/`guest`.

The **boss visibility rule is not centralized** — it is re-implemented as query scopes in every controller that lists data:
- Projects: hidden when `projects.hidden_from_boss = true`.
- Tickets: visible to a boss only if `tickets.visible_from_boss = true` **OR** the parent project is not hidden.
- On create/update, a dev may set `visible_from_boss`; a boss's tickets are forced visible.

When adding any list/detail endpoint, replicate this filtering or you will leak hidden data to bosses.

### Controllers — note the singular/plural split
- `TicketsController` (plural) — collection actions: `index`, `create`, `store`.
- `TicketController` (singular) — single-ticket actions: `show`, `update`, and all nested resources (`storeSubtask`/`toggleSubtask`/`destroySubtask`, `storeComment`/`destroyComment`, `storeFile`/`downloadFile`/`destroyFile`).

All routes are in `routes/web.php` (no API). Mutations redirect back to `tickets.show` (classic PRG, no JSON/AJAX).

### Audit logging
`AuditLog` entries are written **manually** inside controller actions (status change, priority change, subtask/comment/file create & delete). There is no observer or trait — if you add a mutating action that should be tracked, write the `AuditLog::create([...])` call yourself. `AuditLog` has `$timestamps = false` and uses only `created_at`; because of that, MySQL used to default the column to its own `CURRENT_TIMESTAMP` (the DB server's clock, which drifts from the app's UTC), so `AuditLog::booted()` now stamps `created_at = now()` on create. Assignment changes are still **not** audited.

### File uploads
Ticket attachments go to the `public` disk under `tickets/{ticket_id}` (`Storage::disk('public')`). Download/delete routes look up the `TicketFile` by its stored `path`, and delete is restricted to the uploader. Run `php artisan storage:link` for public access.

### Seeding
`ProjectSeeder` reads **`projects.json`** at the repo root as the source of truth for the project directory (name, env, image, prod/local URLs, and nested `links`). Edit `projects.json` and re-seed to change the directory, rather than inserting projects by hand. `UserSeeder` creates `dev@kernel.local` and `boss@kernel.local`, both password `password`.

### Views
Blade under `resources/views/`: `layouts/app.blade.php` (sidebar shell) and `layouts/app-no-sidebar.blade.php`. Reusable UI lives in `resources/views/partials/_*.blade.php` (`_badge`, `_btn`, `_alert`, `_project_card`, `_stats_grid`, `_filters_bar`, `_env_toggle`). Assets are loaded via `@vite(['resources/css/app.css','resources/js/app.js'])`. The `env` (prod/local) toggle is a UI concept for showing prod vs local project URLs — passed as a `$env` request param through views, unrelated to `APP_ENV`.

## OpenSpec workflow

This repo uses **OpenSpec** (spec-driven changes) under `openspec/`. Proposals, specs, tasks, and designs live in `openspec/changes/` (completed work is moved to `openspec/changes/archive/`). Corresponding slash commands/skills are available (`openspec-propose`, `openspec-apply-change`, `openspec-archive-change`, `openspec-sync-specs`, `openspec-explore`). Prefer this flow for non-trivial feature work; `openspec/project.md` is currently empty.
