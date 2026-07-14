---
name: tailwind-responsive-rebuild
description: Rebuild or improve responsive frontend layouts using Tailwind CSS. Use this for mobile-first layout fixes, spacing, grids, flex layouts, cards, dashboards, and page responsiveness.
compatibility: opencode
metadata:
  stack: tailwind
---

## Purpose

Use this skill when rebuilding pages or components with Tailwind CSS.

## Responsive workflow

1. Start mobile-first.
2. Check layout at common widths:
   - mobile
   - tablet
   - laptop
   - desktop
3. Fix spacing and overflow.
4. Standardize containers.
5. Ensure forms, tables, cards, and nav elements work on small screens.

## Tailwind guidelines

- Prefer readable class groups.
- Avoid random one-off values unless necessary.
- Use consistent spacing scale.
- Use `grid` for card layouts and dashboards.
- Use `flex` for alignment and simple rows.
- Avoid deeply nested layout wrappers.
- Extract reusable components when class strings become too noisy.

## Common fixes

- Horizontal overflow on mobile.
- Buttons too small or too wide.
- Cards without consistent padding.
- Tables unusable on mobile.
- Modals too tall or too wide.
- Sidebars breaking page layout.
- Headers not wrapping correctly.

## Rules

- Do not sacrifice accessibility for visuals.
- Do not introduce custom CSS unless Tailwind becomes unreadable.
- Keep the UI clean, consistent, and practical.
