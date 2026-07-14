---
name: frontend-rebuild-plan
description: Create a frontend rebuild plan from an existing app. Use this after auditing the current frontend to propose a step-by-step migration or redesign strategy.
compatibility: opencode
metadata:
  stack: react-next-vite-tailwind
---

## Purpose

Use this skill to plan a safe frontend rebuild without breaking the app.

## Output format

Create a rebuild plan with these sections:

1. Current frontend summary
2. Target architecture
3. Design system strategy
4. Component migration plan
5. Routing/layout plan
6. API and state integration plan
7. Responsive strategy
8. Accessibility strategy
9. Testing checklist
10. Implementation phases

## Recommended phases

### Phase 1: Stabilize
- Identify broken or fragile UI.
- Keep existing business logic working.
- Avoid large rewrites before understanding the app.

### Phase 2: Create foundation
- Create or clean layout components.
- Define tokens for spacing, colors, typography, radius, shadows.
- Create base components: Button, Input, Select, Card, Modal, Tabs, Table, Badge, Alert.

### Phase 3: Rebuild feature by feature
- Start with isolated pages.
- Replace duplicated UI.
- Keep APIs compatible.
- Add loading, error, and empty states.

### Phase 4: Polish
- Responsive pass.
- Accessibility pass.
- Performance pass.
- Remove dead code.

## Rules

- Never recommend rewriting everything at once unless the project is very small.
- Prefer incremental migration.
- Protect working business logic.
- Explain tradeoffs when choosing between quick refactor and full rebuild.
