# Edvorya Design System

## Purpose

The Edvorya Design System is the transversal presentation layer for `theme_edvorya`. It gives Moodle Core output a coherent Edvorya visual language without introducing a parent-theme dependency or adopting Bootstrap as the primary visual framework.

Moodle continues to own component semantics, data, JavaScript controllers, forms, validation, navigation state, modal behavior, activity behavior, and plugin integration. Edvorya owns the visual presentation required by the standalone theme.

## Architecture

Primary source modules:

```text
src/styles/tailwind.css
src/styles/core-utilities.css
src/styles/design-system.css
src/styles/moodle-forms.css
src/styles/core-overlays.css
src/styles/action-menu.css
```

Unified build entrypoint:

```text
src/styles/index.css
```

Compiled production artifact:

```text
style/edvorya.css
```

Tailwind is used only as a development/build tool. Moodle production does not require Node.js, npm, Tailwind CLI, React, Bootstrap, or an external CDN.

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

`src/styles/design-system.css` provides Edvorya presentation for Moodle-shaped button classes:

- `.btn`;
- `.btn-primary`;
- `.btn-secondary`;
- `.btn-success`;
- `.btn-danger`;
- `.btn-warning`;
- `.btn-info`;
- `.btn-outline-*`;
- `.btn-link`;
- `.btn-sm`;
- `.btn-lg`;
- `.btn-group`.

The button layer includes:

- minimum interactive height;
- consistent radius and spacing;
- visible keyboard focus;
- disabled states;
- hover and active states;
- reduced-motion handling;
- semantic variants with accessible foreground/background contrast.

Success, warning and info solid surfaces use darkened semantic backgrounds for small white text. The underlying semantic colour tokens remain available for borders, accents and non-solid treatments.

## Forms

`src/styles/moodle-forms.css` provides the transversal form presentation layer for:

- `.form-control`;
- `.form-select`;
- `.form-label`;
- `.col-form-label`;
- `.form-text`;
- `.input-group`;
- `.input-group-text`;
- `.form-check`;
- `.form-check-input`;
- `.form-check-label`;
- valid and invalid states;
- file inputs;
- autocomplete and tags fields;
- editor containers;
- Moodle full-width forms.

The layer preserves Moodle form markup and JavaScript behavior while adding:

- consistent control height;
- responsive widths;
- focus rings;
- hover treatment;
- disabled and readonly states;
- validation feedback;
- checkbox/radio accent colour;
- mobile containment.

## Cards

The transversal card contract includes:

- `.card`;
- `.card-header`;
- `.card-body`;
- `.card-footer`;
- `.card-title`;
- `.card-subtitle`;
- `.card-text`;
- `.card-img` and `.card-img-top`.

Page-specific experience modules can refine cards in a scoped context, but the base card contract remains reusable across Moodle Core and compatible plugins.

## Alerts and status surfaces

Supported alert classes include:

- `.alert`;
- `.alert-success`;
- `.alert-info`;
- `.alert-warning`;
- `.alert-danger`;
- `.alert-error`;
- `.alert-secondary`;
- `.alert-dismissible`.

The base treatment provides readable spacing, semantic accent borders, light semantic surfaces and responsive text wrapping.

## Badges

Supported badge/status classes include:

- `.badge`;
- `.badge.bg-primary`;
- `.badge.bg-secondary`;
- `.badge.bg-success`;
- `.badge.bg-warning`;
- `.badge.bg-danger`;
- `.badge.bg-info`;
- `.rounded-pill`.

Axe acceptance identified insufficient contrast for small white text on the original success token `#16a34a`. The solid success, warning and info badge surfaces therefore use accessible darkened variants while preserving the semantic tokens elsewhere.

## Tables

The base table contract includes:

- `.table`;
- `.table-striped`;
- `.table-hover`;
- `.table-bordered`;
- `.table-sm`;
- `.table-responsive`.

Wide tables are not forced into unreadable compressed columns. `.table-responsive` contains horizontal scrolling inside the table surface so the document itself does not acquire page-level horizontal overflow.

This pattern is also used by contextual Gradebook and Notification Preferences experiences.

## Progress indicators

The Design System provides base presentation for:

- `.progress`;
- `.progress-bar`.

Moodle or plugin code remains responsible for progress values and semantics. Accessible progressbars must expose their accessible name and ARIA value attributes on the element with `role="progressbar"`.

## Modals

`src/styles/core-overlays.css` provides the standalone presentation contract for Moodle-shaped modal output:

- `.modal`;
- `.modal-dialog`;
- `.modal-dialog-centered`;
- `.modal-dialog-scrollable`;
- `.modal-content`;
- `.modal-header`;
- `.modal-title`;
- `.modal-body`;
- `.modal-footer`;
- `.modal-sm`, `.modal-lg`, `.modal-xl`;
- `.btn-close`;
- `.modal-backdrop`.

Moodle Core remains responsible for JavaScript behavior and dialog state.

Responsive acceptance exposed that modal geometry must reserve space for the effective modal container padding used in the browser environment. The final mobile contract uses a dialog width and maximum width of `calc(100% - 2rem)`, preventing dialog and modal-content overflow even when the modal container contributes internal spacing.

## Dropdowns and action menus

`src/styles/core-overlays.css` supplies the base standalone dropdown contract, while `src/styles/action-menu.css` handles Moodle action-menu refinements.

The base dropdown layer covers:

- hidden-by-default menu state;
- `.show` state;
- absolute positioning;
- menu surface, shadow and radius;
- dropdown items;
- disabled and active states;
- end alignment;
- mobile maximum width.

Moodle's JavaScript controllers and data attributes are preserved.

## Core popover regions

Because Edvorya has no parent theme, `src/styles/core-overlays.css` also implements the minimal CSS contract required by Moodle's `core/popover_region` template:

- relative popover anchor;
- absolute/fixed panel positioning;
- collapsed visibility;
- pointer-event control;
- z-index;
- scrolling;
- notification count geometry;
- mobile viewport containment.

This contract previously fixed a real regression where the notification popover expanded the topbar and intercepted activity links.

## Automated acceptance

The transversal Design System is tested by:

```text
tests/behat/design_system.feature
tests/behat/accessibility.feature
tests/behat/behat_theme_edvorya.php
```

The Behat fixture is injected only into the browser test session. It does not add a production page or endpoint.

Coverage includes:

- primary, secondary, danger and outline buttons;
- disabled button state;
- form controls and selects;
- textarea and checkbox;
- invalid form state;
- success and warning alerts;
- semantic badges;
- card structure;
- responsive wide tables;
- progressbar semantics;
- standalone modal geometry;
- minimum interactive/control heights;
- page-level horizontal overflow prevention;
- internal table scrolling;
- Axe accessibility acceptance.

## Latest accepted checkpoint

Validated against:

- Moodle `MOODLE_502_STABLE`;
- PHP 8.3;
- MariaDB 10.11;
- Chrome/Selenium through Moodle Docker;
- GitHub-hosted runners.

Accepted runs:

- Quality/PHP/reproducible CSS `29800620084`: **PASS**;
- responsive and Design System acceptance `29800620137`: **PASS**;
- browser functional acceptance `29800620080`: **PASS**;
- Moodle bundled-plugin compatibility `29800620102`: **PASS**;
- Google Drive `mod_videoplayer` compatibility `29800620120`: **PASS**;
- Axe accessibility `29800620089`: **PASS**;
- branding security `29800620096`: **PASS**.

The checkpoint confirms that the transversal component layer did not regress the previously validated activity, editor, File Picker, messaging, notification, Moodle bundled-plugin or Google Drive flows.

## Dependencies deliberately avoided

This Design System adds no runtime dependency on:

- Bootstrap;
- Boost;
- Classic;
- React;
- an icon CDN;
- a font CDN;
- Tailwind runtime/CDN;
- third-party JavaScript component libraries.

## Remaining acceptance boundaries

Passing these automated gates is not exhaustive proof for every Moodle environment.

Still environment-specific:

- true Safari/iPhone validation in a Safari-capable environment;
- representative real SCORM package validation;
- representative real or deterministic LTI provider validation.
