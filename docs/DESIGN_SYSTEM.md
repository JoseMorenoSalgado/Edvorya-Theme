# Edvorya Design System

## Purpose

The Edvorya Design System is the transversal product presentation layer for `theme_edvorya`. Boost is the compatibility parent and owns generic Moodle/Bootstrap mechanics. Edvorya owns visual identity, density, hierarchy, responsive containment and product-specific experiences.

Moodle continues to own component semantics, data, JavaScript controllers, validation, navigation state, modal behavior, activity behavior and plugin integration.

## Architecture

Canonical source modules:

```text
src/styles/tailwind.css
src/styles/design-system.css
src/styles/moodle-forms.css
src/styles/filemanager.css
src/styles/action-menu.css
src/styles/page-experiences.css
src/styles/learning-support-experiences.css
src/styles/operational-experiences.css
src/styles/activity-common.css
src/styles/activity-assign.css
src/styles/activity-quiz.css
src/styles/activity-forum.css
src/styles/activity-h5p.css
src/styles/tertiary-navigation.css
```

Unified build entrypoint:

```text
src/styles/index.css
```

Compiled production artifact:

```text
style/edvorya.css
```

Tailwind is used only as development/build tooling. Production requires neither Node.js nor a Tailwind runtime.

## Ownership rule

A transversal Edvorya rule is retained only when it does at least one of the following:

1. expresses the Edvorya visual language through colour, typography, radius, shadow or density;
2. enforces an Edvorya accessibility requirement such as minimum touch size or visible focus;
3. fixes a proven responsive containment issue covered by browser acceptance;
4. styles an Edvorya-owned shell or contextual experience.

Rules that merely reproduce Bootstrap or Boost mechanics are removed and delegated to the parent theme.

## Design tokens

Global tokens are defined in `src/styles/tailwind.css` and include:

- primary, secondary, accent and semantic colours;
- background, foreground, muted and border colours;
- spacing scale;
- radius scale;
- shadow scale;
- focus ring;
- hover and active overlays;
- disabled opacity;
- shell dimensions.

Client-configurable colour tokens are delivered through Moodle's cached CSS post-processing pipeline.

## Buttons

Boost owns button mechanics and grouping. `src/styles/design-system.css` applies Edvorya:

- minimum interactive height;
- radius and density;
- brand and semantic colours;
- focus treatment;
- hover/active feedback;
- reduced-motion handling.

## Forms

Boost owns Moodle form structure, advanced-field behavior, input groups, validation mechanics, autocomplete positioning and full-width form layout.

`src/styles/moodle-forms.css` retains only:

- label typography;
- control height, radius and colours;
- focus and hover treatment;
- readonly/disabled visual states;
- semantic valid/invalid colours;
- file-input button skin;
- autocomplete popup skin and viewport containment.

## File Picker and File Manager

Boost owns File Picker/File Manager structure and interaction mechanics.

`src/styles/filemanager.css` retains only:

- viewport-safe dialogue/content height constraints;
- Edvorya surface, border and active-state styling;
- thumbnail styling;
- mobile containment.

## Action Menu

Boost owns dropdown and Action Menu mechanics. `src/styles/action-menu.css` only refines trigger size, radius, active treatment, menu width containment and icon spacing.

## Cards, alerts, badges, tables and progress

Boost supplies component mechanics. Edvorya applies the product skin and density. Wide table containment remains explicit because it is covered by responsive regression tests and prevents page-level horizontal overflow.

## Accessibility

Accessibility rules remain evidence-driven. Current transversal requirements include:

- at least 40px tested height for primary buttons and form controls;
- visible focus treatment;
- accessible semantic solid colours;
- viewport-safe tables and dialogs;
- reduced-motion handling where Edvorya adds animation.

## Performance

Edvorya does not load a second frontend framework. Boost is already part of Moodle and acts as the parent compatibility layer. Edvorya ships focused CSS overrides compiled from the canonical source entrypoint plus small dedicated runtime sheets for the application shell, dashboard, administration and contextual navigation.

The maintenance rule is simple: do not duplicate a Boost contract unless a measured product or compatibility requirement justifies the override.
