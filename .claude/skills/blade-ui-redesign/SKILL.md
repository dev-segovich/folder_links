---
name: blade-ui-redesign
description: Use when redesigning Laravel Blade views, layouts, components, forms, dashboards, auth pages, admin panels, and public pages. Focus on modern, human, non-generic UI while preserving Blade directives, Laravel routes, validation, permissions, translations, form behavior, and backend logic.
---

# Blade UI Redesign

You are redesigning an existing Laravel Blade frontend. Your goal is to improve visual quality, usability, consistency, accessibility, and responsiveness without breaking Laravel behavior.

## Main goals

- Make the interface feel modern, polished, friendly, and production-ready.
- Avoid generic AI-looking UI: no random gradients, no excessive glassmorphism, no meaningless cards, no repetitive sections, no fake “SaaS template” look.
- Use a consistent design system: spacing, typography, border radius, shadows, colors, buttons, forms, tables, alerts, empty states, and navigation.
- Prefer restrained, standard color systems: neutral backgrounds, one primary color, semantic colors for success/warning/error/info, and accessible contrast.
- Keep one memorable design detail per page, not many decorative effects.

## Laravel Blade safety rules

Before editing, inspect the Blade structure:

- layouts
- partials
- components
- includes
- forms
- route names
- validation errors
- authorization directives
- localization strings
- Vite/CSS/JS entrypoints

Never break or remove these unless explicitly required:

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
- `@role`
- `@foreach`
- `@forelse`
- `@if`
- `@isset`
- `@vite`
- `__('...')`
- component props
- input `name` attributes
- form actions
- IDs used by JavaScript
- data attributes used by JavaScript

Do not change controllers, models, migrations, or routes unless the user asks for backend changes.

## Redesign workflow

1. Audit the current UI.
   - Identify repeated patterns.
   - Identify layout problems.
   - Identify inconsistent colors, spacing, forms, buttons, tables, and navigation.
   - Identify Blade components or partials that should be centralized.

2. Define a mini design system before editing.
   - Primary color
   - Neutral scale
   - Semantic colors
   - Typography scale
   - Spacing scale
   - Border radius
   - Button styles
   - Form styles
   - Card/table styles
   - Empty/error/loading states

3. Refactor shared layout first.
   - Update main layout, nav, sidebar, header, footer, and common containers.
   - Create or improve Blade components where useful.
   - Avoid duplicating the same markup in many views.

4. Redesign page by page.
   - Keep functionality unchanged.
   - Preserve all dynamic Blade expressions.
   - Improve visual hierarchy.
   - Make forms easier to scan.
   - Make tables responsive.
   - Add useful empty states.
   - Add clear validation and error states.

5. Validate.
   - Run formatting/build commands if available.
   - Check desktop and mobile.
   - Check keyboard focus.
   - Check color contrast.
   - Check that forms still submit correctly.
   - Check that dropdowns/modals/navigation still work.

## Visual direction

Prefer:

- calm neutral backgrounds
- clear spacing
- strong typography hierarchy
- modern but simple cards
- clean tables
- readable forms
- consistent buttons
- subtle shadows
- clear focus states
- responsive layouts
- friendly empty states

Avoid:

- random purple/blue gradients everywhere
- too many shadows
- too many rounded cards
- fake dashboard widgets
- excessive animations
- stock AI landing page look
- inconsistent spacing
- low contrast text
- replacing Blade with React/Vue unless requested

## Output expectations

When proposing changes:

- Explain the design direction briefly.
- List the files to modify.
- Modify shared components before individual pages.
- Preserve Laravel behavior.
- After editing, summarize what changed and what still needs visual review.