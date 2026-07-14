---
name: react-component-refactor
description: Refactor React components for clarity, reuse, maintainability, and separation of concerns. Use this when components are too large, duplicated, messy, or hard to test.
compatibility: opencode
metadata:
  stack: react-next-vite
---

## Purpose

Use this skill to clean React components while preserving behavior.

## Refactor checklist

1. Read the component and its usages.
2. Identify responsibilities:
   - UI rendering
   - Data fetching
   - State management
   - Validation
   - Formatting
   - Side effects
3. Split only when it improves readability.
4. Extract reusable UI components.
5. Extract hooks only when logic is reused or complex.
6. Keep prop names clear.
7. Preserve existing behavior.
8. Run or suggest relevant tests/build checks.

## Preferred structure

For feature components:

- `components/` for UI pieces
- `hooks/` for stateful logic
- `utils/` for formatting/helpers
- `types.ts` for shared local types when useful

## Rules

- Do not change behavior accidentally.
- Do not split components just for the sake of splitting.
- Avoid premature abstraction.
- Prefer explicit readable code over clever code.
- Keep accessibility in mind.
