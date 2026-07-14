---
name: frontend-qa
description: QA a rebuilt frontend before handoff. Use this to check builds, linting, TypeScript, routes, responsive behavior, accessibility basics, forms, API states, and visual consistency.
compatibility: opencode
metadata:
  area: frontend-quality
---

## Purpose

Use this skill after implementing frontend changes.

## QA checklist

Check:

1. Build passes.
2. TypeScript passes.
3. Lint passes.
4. No obvious console errors.
5. Main routes render.
6. Forms validate correctly.
7. Loading states appear.
8. Error states appear.
9. Empty states appear.
10. Mobile layout works.
11. Tablet layout works.
12. Desktop layout works.
13. Buttons, links, and inputs are accessible.
14. No dead imports.
15. No unused components from the old frontend unless intentionally kept.

## Final report

Return:

- What was checked.
- What passed.
- What failed.
- Files changed.
- Remaining risks.
- Recommended next steps.

## Rules

- Be honest about what was not tested.
- Do not claim the app works unless checks were actually run.
- If commands fail, summarize the cause and suggest the next fix.
