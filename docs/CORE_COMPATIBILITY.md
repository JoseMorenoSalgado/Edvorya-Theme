# Moodle 5.2 Core compatibility surface

## Purpose

`theme_edvorya` is standalone and does not inherit Boost, Classic, or Bootstrap as its visual framework. Moodle Core and many plugins nevertheless emit stable class names that require a minimal presentation layer to remain usable.

Edvorya therefore maintains a selective compatibility surface based on observed Moodle 5.2 templates and frontend contracts. It does not attempt to clone Bootstrap or Boost wholesale.

## Current compatibility modules

### `src/styles/core-utilities.css`

Verified utility classes used by Moodle Core templates, including block markup and accessible skip links.

Current coverage includes:

- `visually-hidden-focusable`;
- `p-3`;
- `mt-3`;
- `mb-3`;
- `h5`;
- `btn-icon`;
- selected small layout helpers required by Core-generated markup.

### `src/styles/moodle-forms.css`

Covers structural behaviour needed by Moodle Forms:

- advanced element visibility;
- fieldset and legend structure;
- responsive form rows;
- selects and grouped inputs;
- validation states;
- readonly/disabled fields;
- autocomplete and tag suggestion surfaces;
- editor containers;
- full-width-label forms.

The module does not replace Moodle Forms JavaScript or renderers.

### `src/styles/filemanager.css`

Provides a minimal standalone presentation contract for:

- File Picker;
- File Manager;
- repository lists;
- picker toolbar/view/path bars;
- icon and table views;
- upload/login surfaces;
- selection panels;
- responsive viewport constraints.

The module intentionally preserves Moodle's existing JavaScript behaviour and data hooks.

### `src/styles/core-overlays.css`

Provides the structural styles required by Core overlay components:

- modal backdrop;
- modal dialog/content/header/body/footer;
- centered and scrollable modal variants;
- dropdown menu visibility and alignment;
- dropdown headers, dividers, active and disabled states.

JavaScript state remains owned by Moodle Core.

### `src/styles/tertiary-navigation.css`

Presents the Core tertiary navigation selector exported when secondary navigation overflows.

### `src/styles/mobile-navigation.css`

Owns the Edvorya presentation of Moodle Core `mobileprimarynav` data.

## Design rule

A new compatibility rule is added only when at least one of these conditions is met:

1. Moodle Core 5.2 emits the class or structure in an official template or renderer.
2. A supported activity/plugin demonstrates a concrete regression without the rule.
3. Runtime/browser testing demonstrates a functional or accessibility need.

The theme must not add a large generic framework compatibility layer speculatively.

## Performance rule

Compatibility modules are compiled into the single production artifact `style/edvorya.css`.

There is:

- no Bootstrap CSS runtime dependency;
- no Tailwind runtime dependency;
- no external stylesheet CDN;
- no additional HTTP request per compatibility module in production.

## Remaining browser validation

The current compatibility layer still requires real browser tests for:

- File Picker upload/select flows;
- TinyMCE and editor resizing;
- autocomplete and tags keyboard navigation;
- modal focus management;
- action menus and dropdown placement;
- block controls in editing mode;
- Assignment submission forms;
- Quiz editing/attempt surfaces;
- Forum forms;
- H5P embeds and fullscreen behaviour;
- iPhone Safari;
- Android Chrome;
- tablet layouts;
- representative third-party plugins.
