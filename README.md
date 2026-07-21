# Edvorya Theme for Moodle

`theme_edvorya` is a standalone Moodle theme designed for the Edvorya visual ecosystem.

## Current release

- Component: `theme_edvorya`
- Release: `0.1.0-alpha.5`
- Target baseline: Moodle 5.2
- Minimum Moodle version: `2026042000`
- Parent themes: none (`$THEME->parents = []`)
- Status: foundation alpha; static validation and isolated Moodle 5.2 + MariaDB 10.11 runtime validation pass; contextual Edvorya experiences and the transversal Edvorya Design System pass representative Chrome/Selenium browser, responsive and Axe acceptance; Moodle bundled plugins and the required Google Drive `mod_videoplayer` integration remain compatible in the validated matrix

## Runtime dependencies

The production theme does not require:

- Node.js;
- npm;
- Tailwind CLI;
- React;
- Bootstrap as the Edvorya visual framework;
- an external Tailwind CDN;
- external icon or font CDNs;
- Boost, Classic, RemUI, or another parent theme.

The production CSS is committed at:

```text
style/edvorya.css
```

## Edvorya Design System

The transversal Design System is implemented through theme-owned CSS modules and selectively supports Moodle-shaped component classes without adopting Bootstrap as the visual framework.

Primary modules:

```text
src/styles/tailwind.css
src/styles/core-utilities.css
src/styles/design-system.css
src/styles/moodle-forms.css
src/styles/core-overlays.css
src/styles/action-menu.css
```

The transversal component layer currently covers:

- buttons and button groups;
- form controls, selects, input groups, checkboxes and validation states;
- cards;
- alerts and semantic status surfaces;
- badges;
- tables and responsive table containment;
- progress indicators;
- modals;
- dropdowns and action menus;
- Moodle Core popover-region presentation primitives.

`src/styles/design-system.css` is the reusable component layer for buttons, cards, alerts, badges, tables and progress indicators. `src/styles/moodle-forms.css` owns form presentation. `src/styles/core-overlays.css` owns the minimum standalone modal, dropdown and popover presentation contracts required by Moodle Core output.

Axe acceptance identified insufficient contrast for small white text on the original success token when used as a solid badge background. Solid success, warning and info components therefore use accessible darkened semantic variants while preserving the underlying semantic tokens for accents and non-solid treatments.

Responsive browser acceptance also hardened standalone modal geometry. Mobile modal dialogs reserve sufficient space for the effective modal container padding and are validated together with their `.modal-content` surface against horizontal viewport overflow.

Detailed Design System architecture and acceptance evidence is documented in:

```text
docs/DESIGN_SYSTEM.md
```

## Contextual Edvorya experiences

Edvorya adds presentation layers to Moodle's existing page contracts without replacing Core renderers or copying Core Mustache templates.

Stable theme-owned body hooks include:

```text
edv-layout-mydashboard
edv-layout-mycourses
edv-layout-course
edv-layout-admin
edv-pagetype-calendar-view
edv-pagetype-grade-report-user-index
edv-pagetype-user-profile
edv-pagetype-message-index
edv-pagetype-message-notificationpreferences
```

The contextual visual layers live in:

```text
src/styles/page-experiences.css
src/styles/learning-support-experiences.css
src/styles/operational-experiences.css
```

They provide:

- Dashboard content-header and block surface hierarchy;
- My Courses responsive course-card and summary-list treatment;
- course image, metadata, progress, and card-footer presentation;
- Course View section surfaces and activity-row treatment;
- scroll-safe secondary course navigation;
- Calendar month-grid containment with internal responsive scrolling;
- Grades report surfaces that preserve readable table width and contain horizontal scrolling;
- Profile information cards built around Moodle's existing `.userprofile` and `.profile_tree` output;
- Administration form and settings surfaces around Moodle's existing admin output;
- responsive full-page Messaging treatment around `.message-app[data-region="message-index"]`;
- Notification Preferences table containment;
- Notification Popover presentation while preserving Moodle's Core controller and data attributes;
- responsive spacing and horizontal containment.

Moodle continues to own navigation data, blocks, course-card markup, activity markup, Calendar behavior, grade data and calculations, profile data, administration logic, messaging state, notification state, progress data, completion data, editing behavior, and plugin integrations.

## Standalone Moodle Core compatibility primitives

Because Edvorya has no parent theme, it provides a small evidence-driven compatibility layer for presentation contracts that Moodle Core templates expect a theme to supply.

A browser regression discovered during Administration/Messaging/Notifications work exposed a missing `core/popover_region` CSS contract: the notification panel stayed in normal topbar flow and could cover activity links. The theme-owned fix is implemented in:

- `src/styles/core-overlays.css` — popover positioning, collapsed visibility, pointer events, z-index, scrolling and responsive containment;
- `src/styles/core-utilities.css` — stable base geometry for Moodle Core `.icon` pix icons.

Moodle's `data-region` attributes, ARIA state, templates, AMD controllers and plugin code remain unchanged.

The same evidence-driven approach is used for modal and dropdown presentation. Edvorya does not attempt to clone all of Bootstrap or Boost.

## Current validation checkpoint

Latest accepted automated checkpoint:

- Quality/PHP/reproducible CSS `29800620084`: **PASS**;
- responsive/contextual/Design System acceptance `29800620137`: **PASS**;
- browser functional acceptance `29800620080`: **PASS**;
- bundled Moodle plugins `29800620102`: **PASS**;
- Google Drive `mod_videoplayer` `29800620120`: **PASS**;
- Axe accessibility `29800620089`: **PASS**;
- branding security `29800620096`: **PASS**.

The responsive gate validates contextual page experiences and the transversal Design System at representative phone and desktop widths. The Design System fixture covers buttons, forms, cards, alerts, badges, progress, wide responsive tables and standalone modals. Wide tables use internal horizontal scrolling rather than page-level overflow. Buttons and primary form controls meet the tested minimum interactive height. Modal dialog and modal content surfaces remain horizontally contained.

The browser functional gate continues to pass representative Assignment, Quiz, Forum, H5P, blocks/editing mode, TinyMCE, File Picker, autocomplete, messaging and notification flows after the Design System changes.

The Moodle bundled-plugin matrix and the actual `JoseMorenoSalgado/moodle-mod_videoplayer` Google Drive plugin also pass on the same checkpoint, with no plugin-specific Design System workaround required.

## Installation for Moodle 5.2 testing

1. Copy the repository contents into:

   ```text
   <moodle-root>/theme/edvorya/
   ```

2. Confirm that the resulting plugin path contains:

   ```text
   <moodle-root>/theme/edvorya/version.php
   <moodle-root>/theme/edvorya/config.php
   ```

3. Sign in as a site administrator and complete the Moodle plugin upgrade process.

4. Purge Moodle caches after installation or theme code changes.

5. Select **Edvorya** from the Moodle theme selector.

6. Execute any remaining environment-specific acceptance matrix documented in `docs/ARCHITECTURE.md` before using this alpha on a production site.

## Development CSS build

Node.js is required only for developers rebuilding CSS.

```bash
npm install --ignore-scripts --no-audit --no-fund
npm run build:css
```

Build entrypoint:

```text
src/styles/index.css
```

The entrypoint composes the Edvorya Design System, contextual page-experience layers, and selective theme-owned compatibility modules for Moodle Core and verified activity surfaces.

Client-configurable colour overrides are appended by Moodle's cached theme CSS post-processing callback after the compiled stylesheet is loaded. The theme does not emit its former page-level client-token `<style>` block.

Compiled production artifact:

```text
style/edvorya.css
```

Tailwind Preflight is intentionally not imported.

## Architecture and security

Project documentation:

```text
docs/ARCHITECTURE.md
docs/DESIGN_SYSTEM.md
docs/MOBILE_NAVIGATION.md
docs/CORE_COMPATIBILITY.md
docs/ACTIVITY_COMPATIBILITY.md
docs/MOODLE52_BROWSER_ACCEPTANCE.md
docs/MOODLE52_RUNTIME_STATUS.md
docs/QUALITY_STATUS.md
docs/SECURITY.md
```

`theme_edvorya` owns presentation, layouts, visual identity, navigation composition, branding and the Edvorya Design System.

The future optional `local_edvorya` plugin will own persistent structured content, business logic, Page Builder functionality, forms, and advanced public-site services.

## Validation boundaries

The current browser gates use GitHub-hosted runners with Moodle 5.2, PHP 8.3, MariaDB 10.11, Moodle Docker, Selenium, and Chrome.

Passing static, runtime smoke, Design System, contextual page-experience, representative browser, bundled-plugin, Google Drive, responsive, keyboard and automated accessibility acceptance does not constitute exhaustive validation of every possible Moodle environment.

Still environment-specific:

- true Safari/iPhone validation requires a Safari-capable environment;
- SCORM requires a representative real SCORM package;
- LTI requires a real or deterministic LTI provider.
