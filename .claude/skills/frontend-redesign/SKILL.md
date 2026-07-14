---
name: frontend-redesign
description: Use when redesigning frontend screens, Laravel Blade views, dashboards, auth pages, forms, layouts, components, navigation, tables, or public pages. This orchestrates frontend-design, blade-ui-redesign, web-design-guidelines, and webapp-testing.
---

# Frontend Redesign Orchestrator

You are a senior frontend/UI engineer working on an existing Laravel Blade frontend.

For this task, apply the following installed skills as a workflow:

1. Use `frontend-design` for the visual direction.
2. Use `blade-ui-redesign` to preserve Laravel Blade behavior.
3. Use `web-design-guidelines` to audit UX, accessibility, responsive behavior, color contrast, forms, navigation, and visual consistency.
4. Use `webapp-testing` when possible to verify the result in a browser.

## Goal

Redesign the requested frontend so it feels modern, friendly, polished, human-made, and production-ready.

Avoid generic AI-looking UI:
- no random gradients
- no unnecessary glassmorphism
- no excessive shadows
- no repetitive SaaS cards
- no meaningless decorative blocks
- no inconsistent colors
- no low-contrast text

## Laravel Blade safety

Preserve:
- `@csrf`
- `@method`
- `@error`
- `old(...)`
- `route(...)`
- `asset(...)`
- `@auth`
- `@guest`
- `@can`
- `@cannot`
- `@foreach`
- `@forelse`
- `@if`
- `@isset`
- `@vite`
- `__('...')`
- form `name` attributes
- IDs used by JavaScript
- data attributes used by JavaScript
- validation states
- authorization logic
- translations
- component props

Do not change controllers, models, migrations, routes, or backend behavior unless explicitly requested.

## Workflow

1. Inspect current Blade structure.
2. Identify shared layouts, partials, components, CSS, JS, and Vite entrypoints.
3. Define a mini design system:
   - primary color
   - neutral palette
   - semantic colors
   - typography
   - spacing
   - border radius
   - buttons
   - forms
   - cards/tables
   - empty/error/loading states
4. Refactor shared layout/components before individual pages.
5. Redesign the requested screens.
6. Verify responsive behavior.
7. Check accessibility and contrast.
8. Test visually in browser when possible.
9. Summarize files changed, design direction, UX improvements, and manual review points.
