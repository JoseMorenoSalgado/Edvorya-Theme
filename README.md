# Edvorya Theme for Moodle

`theme_edvorya` is the Moodle presentation layer for the Edvorya visual ecosystem.

## Current release

- Component: `theme_edvorya`
- Release: `0.1.0-alpha.28`
- Supported Moodle branches: 5.0, 5.1 and 5.2
- Minimum Moodle version: `2025041400`
- Parent theme: Boost (`$THEME->parents = ['boost']`)
- Status: alpha / active compatibility and visual acceptance

## Architecture

Edvorya uses Boost only as the Moodle Core compatibility parent. Boost owns generic Moodle presentation mechanics such as Bootstrap component behavior, form structure, modal/dropdown/popover behavior, File Picker/File Manager mechanics, Action Menu mechanics and technical fallback layouts. Edvorya owns the product experience above that compatibility layer.

Edvorya remains responsible for the application shell, topbar, sidebar, mobile drawer, Design System, Lucide-style navigation iconography, student/teacher dashboard experience, learning pages, administration presentation, branding, login and responsive behavior.

The theme does not modify Moodle Core and does not depend on RemUI, Classic, Lambda or commercial themes.

## Visual identity

The current `Edvorya-LMS` product is the visual source of truth. Product decisions are translated into Moodle CSS, Mustache and PHP without importing React, shadcn, Radix or Tailwind runtime dependencies.

The visual and learning-experience contract is documented in:

```text
docs/VISUAL_IDENTITY.md
docs/DASHBOARD_EXPERIENCE.md
```

Evolution of the current foundation:

- Alpha.17–alpha.18 translated the Edvorya LMS shell and primary learning experiences into Moodle.
- Alpha.19 extended the identity to Assignment, Quiz, Forum and H5P.
- Alpha.20–alpha.22 introduced and refined the capability-aware teacher workspace.
- Alpha.23 restored type-safe student dashboard rendering across Moodle 5.0–5.2.
- Alpha.24 aligned persisted branding defaults with the current Edvorya LMS neutral palette.
- Alpha.25 consolidated canonical token ownership.
- Alpha.26 consolidated reusable Design System primitive ownership.
- Alpha.27 removed the historical first-generation page visual layer from `page-experiences.css`, leaving structure and containment there while `identity.css` remains the final visual composition layer.
- Alpha.28 makes branding configuration truthful: every exposed colour setting must have a cached CSS token, a canonical default and at least one semantic CSS consumer. The unused historical `accent` option is removed end-to-end.

Translated visual patterns include:

- 64px sticky translucent topbar;
- compact ghost shell actions;
- 256px desktop sidebar and 18rem mobile drawer;
- bare Lucide-style navigation icons;
- 40px navigation rows;
- two-level `Edvorya LMS + institution` brand lockup;
- white/slate neutral canvas with one institutional primary accent;
- restrained shadows and 12–16px normal surface radii;
- PageShell-style headings with quiet dividers;
- compact student/teacher dashboard decision surfaces;
- Edvorya-aligned My Courses, course, calendar, grades, profile, messaging and login experiences.

## Branding defaults and upgrades

Theme colour settings remain configurable per institution and are emitted through Moodle's cached CSS post-process callback.

Current configurable colour contract:

```text
primary
secondary
background
foreground
muted
border
sidebar
topbar
button
link
loginbackground
```

The historical `accent` setting was removed in alpha.28 because it had no semantic consumer in the current Edvorya LMS identity. `db/upgrade.php` removes that obsolete persisted configuration from earlier alpha installations.

Current neutral defaults include:

- background: `#ffffff`;
- foreground: `#020617`;
- sidebar: `#fafafa`;
- topbar base: `#ffffff`, rendered with the translucent Edvorya shell treatment.

Legacy alpha palette migration only rewrites exact historical defaults. Existing institutional colour customisations remain untouched. The separate `button` setting is consumed by `.btn-primary` and the `link` setting controls text-link colour.

## Teacher workspace

Edvorya identifies teacher presentation context with Moodle capabilities rather than role shortnames.

`moodle/grade:viewall` covers the default Moodle `teacher` and `editingteacher` archetypes. Non-editing teachers therefore receive the academic workspace presentation without gaining edit permissions.

The dashboard uses a bounded two-course capability lookup:

- exactly one teacher-visible course: direct course and Participants workspace links;
- multiple teacher-visible courses: My courses, avoiding an arbitrary theme-generated priority ranking.

Cross-course grading queues, risk scoring and recommendation logic remain outside the theme and belong in a future optional `local_edvorya` service layer.

## Compatibility boundary

The original standalone alpha duplicated Moodle Core presentation contracts that Boost already maintains. Those responsibilities have been progressively delegated or removed.

Boost owns mechanics for:

- generic Bootstrap behavior;
- Moodle form and autocomplete behavior;
- modal, dropdown and popover mechanics;
- File Picker and File Manager structure;
- Action Menu mechanics;
- technical fallback layouts.

Edvorya retains:

- custom application and login layouts;
- shell and navigation composition;
- Design System visual primitives and tokens;
- dashboard and page-specific experiences;
- minimum touch targets and responsive containment;
- branding settings and cached token pipeline.

Boost is a compatibility dependency, not the Edvorya visual framework.

## CSS ownership

Canonical build entrypoint:

```text
src/styles/index.css
```

Canonical Design System tokens:

```text
src/styles/tailwind.css
```

Reusable visual primitives:

```text
src/styles/design-system.css
```

Structural page contracts:

```text
src/styles/page-experiences.css
```

Final product composition:

```text
src/styles/identity.css
src/styles/teacher-experience.css
```

Focused runtime sheets:

```text
style/edvorya-shell.css
style/edvorya-dashboard.css
style/edvorya-admin.css
style/edvorya-context-nav.css
style/edvorya-interactions.css
```

Compiled production artifact:

```text
style/edvorya.css
```

Generic Moodle Core mechanics remain inherited from Boost.

## Automated ownership and branding audits

Development checks:

```bash
npm install --ignore-scripts --no-audit --no-fund
python3 tools/normalize_design_tokens.py --check
python3 tools/normalize_design_primitives.py --check
python3 tools/audit_branding_tokens.py --check
npm run build:css
```

The quality workflow verifies:

- canonical Design System token ownership;
- reusable primitive ownership;
- parity between configurable settings and cached CSS emission;
- canonical defaults for every configurable colour;
- at least one semantic CSS consumer for every exposed colour setting;
- PHP syntax;
- reproducible production CSS.

Generated `style/edvorya.css` is excluded as evidence of token usage so stale compiled output cannot hide an orphan setting.

## Runtime dependencies

Production does not require Node.js, npm, React, Tailwind runtime, a Tailwind CDN, or external icon/font CDNs. Tailwind is build-time only. Boost ships with Moodle and acts as the compatibility base.

## Moodle installation paths

Moodle 5.0 commonly uses:

```text
<moodle-root>/theme/edvorya/
```

Moodle 5.1 and 5.2 may use the public webroot structure:

```text
<moodle-root>/public/theme/edvorya/
```

Always use the actual directory structure of the installed Moodle instance. After updating the theme, complete the Moodle plugin upgrade and purge caches.

## Compatibility target

Automated compatibility is maintained for Moodle 5.0, 5.1 and 5.2 with PHP 8.3 and MariaDB 10.11 test runtimes, representative Moodle bundled activities/plugins, the required Google Drive `mod_videoplayer` integration, responsive Chrome/Selenium and Axe accessibility gates.

Alpha.28 must pass the same runtime gates plus the branding-consumer audit before the next phase is considered stable.

Environment-specific acceptance still includes true Safari/iPhone validation, representative SCORM packages and a deterministic LTI provider.

## Project boundary

`theme_edvorya` owns presentation, layouts, visual identity, navigation composition, branding and the Edvorya Design System.

A future optional `local_edvorya` plugin will own persistent structured content, business logic, aggregated dashboard intelligence, Page Builder functionality and other features that do not belong in a theme.
