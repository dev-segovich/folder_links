---
name: accessibility-ux-review
description: Review frontend UI for accessibility and UX issues. Use this to check labels, keyboard navigation, focus states, contrast, semantic HTML, forms, modals, buttons, and user feedback states.
compatibility: opencode
metadata:
  area: accessibility-ux
---

## Purpose

Use this skill to make the frontend easier and safer to use.

## Checklist

Review:

- Semantic HTML
- Button vs link usage
- Form labels
- Error messages
- Required fields
- Keyboard navigation
- Focus states
- Modal focus behavior
- ARIA usage only when needed
- Color contrast
- Loading states
- Empty states
- Error states
- Success feedback
- Responsive usability

## UX standards

Every important user action should have:

- Clear label
- Clear result
- Loading state
- Success or error feedback
- Recovery path if something fails

## Rules

- Prefer native HTML behavior before ARIA.
- Do not add ARIA incorrectly.
- Do not hide focus outlines unless replacing them with an accessible visible focus style.
- Mention issues clearly and suggest practical fixes.
