---
name: api-state-integration
description: Improve frontend API integration and state handling. Use this when connecting pages to APIs, handling loading/error states, forms, optimistic updates, auth state, or data normalization.
compatibility: opencode
metadata:
  stack: frontend-api-state
---

## Purpose

Use this skill when frontend pages need clean integration with backend APIs or app state.

## Workflow

1. Locate existing API clients, hooks, services, or server actions.
2. Understand data flow:
   - Where data is fetched.
   - Where mutations happen.
   - How loading/error states are handled.
   - How auth/session state is handled.
3. Avoid duplicating API logic.
4. Add consistent loading, error, empty, and success states.
5. Keep UI components separate from data-fetching logic when practical.

## Rules

- Do not hardcode API responses.
- Do not hide errors silently.
- Preserve existing auth/session behavior.
- Prefer typed data when TypeScript is available.
- Keep API boundaries clear.
- Avoid unnecessary global state.
