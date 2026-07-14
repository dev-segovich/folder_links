---
name: design-system-extractor
description: Extract or create a frontend design system from an existing UI. Use this to standardize colors, typography, spacing, buttons, forms, cards, tables, modals, and layout patterns.
compatibility: opencode
metadata:
  stack: react-tailwind
---

## Purpose

Use this skill when the frontend looks inconsistent or needs a clean visual foundation.

## Workflow

1. Inspect existing UI components and styles.
2. Identify repeated patterns:
   - Buttons
   - Inputs
   - Cards
   - Modals
   - Tables
   - Navigation
   - Sidebars
   - Headers
   - Empty states
   - Loading states
3. Extract common variants.
4. Propose reusable components.
5. Replace duplicated markup with shared components.

## Component standards

Each reusable component should support:

- Clear props.
- Sensible defaults.
- Variants only when needed.
- Disabled/loading/error states when relevant.
- Accessible labels and keyboard support.
- Consistent spacing and typography.

## Design token priorities

Standardize:

- Colors
- Font sizes
- Font weights
- Spacing
- Border radius
- Shadows
- Z-index layers
- Breakpoints

## Rules

- Do not create an over-engineered design system.
- Start with components actually used in the project.
- Prefer simple, readable APIs.
- Avoid introducing new UI libraries unless requested.
