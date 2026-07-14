---
name: frontend-audit
description: Audit an existing frontend before rebuilding it. Use this to inspect structure, routes, components, styles, state, duplicated UI, UX issues, and risky dependencies before making changes.
compatibility: opencode
metadata:
  stack: react-next-vite-tailwind
---

## Purpose

Use this skill before changing a frontend. The goal is to understand the current UI, architecture, routes, components, styling system, and technical debt.

## Workflow

1. Identify the framework:
   - Next.js, Vite, React, Vue, Svelte, Astro, etc.
   - Routing system.
   - Styling system.
   - State management.
   - Form handling.
   - API layer.

2. Map the frontend structure:
   - Pages/routes.
   - Layouts.
   - Shared components.
   - Feature-specific components.
   - Hooks.
   - Utilities.
   - Assets.
   - Global styles.

3. Detect problems:
   - Duplicated components.
   - Inconsistent spacing, typography, colors, buttons, inputs, cards.
   - Components doing too much.
   - Inline styles or hardcoded design values.
   - Poor responsive behavior.
   - Accessibility issues.
   - Broken loading/error/empty states.
   - Unclear API boundaries.

4. Produce a concise audit report:
   - Current structure.
   - Main problems.
   - What should be preserved.
   - What should be replaced.
   - Rebuild priorities.
   - Suggested file/folder structure.

## Rules

- Do not modify files during the audit unless explicitly asked.
- Prefer reading code first instead of guessing.
- Prioritize practical changes that reduce complexity.
- Mention uncertainty clearly when the codebase does not provide enough evidence.
