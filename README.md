# Edvorya Theme for Moodle

`theme_edvorya` is the Moodle presentation layer for the Edvorya visual ecosystem.

## Current release

- Component: `theme_edvorya`
- Release: `0.1.0-alpha.26`
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

Alpha.17 established the shared shell and Design System language. Alpha.18 propagated that identity across the main Moodle learning experiences. Alpha.19 extended it to Assignment, Quiz, Forum and H5P while closing responsive interaction regressions. Alpha.20–alpha.22 deepen the capability-aware teacher workspace and align it with Moodle's real course, Participants and Gradebook contracts. Alpha.23 restores type-safe student dashboard rendering across Moodle 5.0–5.2. Alpha.24 aligns persisted branding defaults with the current Edvorya LMS neutral palette. Alpha.25 consolidates canonical token ownership. Alpha.26 consolidates reusable primitive ownership so buttons, cards and badges no longer receive a second global override from the identity layer.

Translated patterns include:

- 64px sticky translucent topbar;
- compact 36px ghost shell actions;
- 256px desktop sidebar and 18rem mobile drawer;
- bare 18px Lucide-style navigation icons;
- 40px navigation rows;
- two-level `Edvorya LMS + institution` brand lockup;
- white/slate neutral canvas with one institutional primary accent;
- restrained `shadow-sm` surfaces;
- 12–16px normal surface radii;
- plain PageShell-style headings with a quiet divider;
- compact student/teacher dashboard decision cards;
- Edvorya-aligned My Courses cards and course navigation;
- calendar and grade-report surfaces;
- compact profile and messaging presentation;
- unified login styling while Moodle Core retains authentication behavior;
- capability-aware teacher presentation for course management, Participants, Gradebook and Assignment grading.

## Branding defaults and upgrades

Theme colour settings remain configurable per institution and are emitted through Moodle's cached CSS post-process callback.

Alpha.24 changes the default neutral identity to match the current Edvorya LMS product:

- background: `#ffffff`;
- foreground: `#020617`;
- sidebar: `#fafafa`;
- topbar base: `#ffffff`, rendered with the translucent Edvorya shell treatment.

`db/upgrade.php` migrates only values that exactly match the legacy alpha defaults. Existing institutional colour customisations are not rewritten.

The configurable `button` token is consumed by `.btn-primary`, so an institution may customize the primary action colour independently of the general primary accent.

## Teacher workspace

Edvorya identifies the teacher presentation context with Moodle capabilities, not role shortnames.

`moodle/grade:viewall` is used because Moodle Core grants it to both default `teacher` and `editingteacher` archetypes. This allows non-editing teachers to receive the academic workspace presentation without granting edit permissions.

The dashboard uses a bounded two-course capability lookup:

- exactly one teacher-visible course: direct course and Participants workspace links;
- multiple teacher-visible courses: My courses is used so the theme does not choose an arbitrary priority course.

Cross-course grading queues, risk scoring and recommendation logic remain outside the theme and belong in a future optional `local_edvorya` service layer.

## Compatibility boundary

The original standalone alpha duplicated Moodle Core presentation contracts that Boost already maintains. Alpha.15 moved those responsibilities to Boost. Alpha.16 performed a second surgical cleanup of the remaining transversal CSS.

Removed or delegated to Boost:

- generic Core utility replicas;
- modal/dropdown/popover mechanics;
- duplicate technical layouts for popup, embedded, maintenance, print, redirect and secure contexts;
- generic Bootstrap behavior already maintained by Boost;
- Moodle form behavior and autocomplete mechanics;
- File Picker/File Manager structural layout rules already maintained by Boost;
- Action Menu/dropdown mechanics;
- obsolete standalone compatibility and accessibility sheets.

Retained by Edvorya because they define product identity or proven responsive behavior:

- custom application and login layouts;
- Edvorya shell and navigation;
- dashboard and page-specific experiences;
- Design System visual primitives and tokens;
- minimum touch targets;
- table and File Picker viewport containment verified by browser tests;
- branding settings and token pipeline.

Boost is a compatibility dependency, not the Edvorya visual framework.

## Runtime dependencies

Production does not require Node.js, npm, React, Tailwind runtime, a Tailwind CDN, or external icon/font CDNs.

Boost is shipped with Moodle and acts as the compatibility base. Tailwind is build-time only.

## CSS architecture

Canonical build entrypoint:

```text
src/styles/index.css
```

Canonical Design System tokens:

```text
src/styles/tailwind.css
```

`src/styles/tailwind.css` owns default CSS custom properties, typography stack, spacing, radii, shadows, shell dimensions and the Bootstrap variable bridge used by Boost. Institution-configurable colour tokens may be overridden later by Moodle's cached CSS post-process callback.

Reusable Edvorya visual primitives:

```text
src/styles/design-system.css
```

`src/styles/design-system.css` owns global Edvorya skin for reusable buttons, cards, alerts, badges, tables and progress indicators. Boost continues to own their mechanics.

Visual composition and experience skin:

```text
src/styles/identity.css
src/styles/teacher-experience.css
```

`src/styles/identity.css` intentionally contains neither a root token contract nor competing global button/card/badge primitives. It consumes the Design System and translates the Edvorya LMS language onto specific Moodle surfaces and page experiences.

Compiled production artifact:

```text
style/edvorya.css
```

Focused runtime sheets:

```text
style/edvorya-shell.css
style/edvorya-dashboard.css
style/edvorya-admin.css
style/edvorya-context-nav.css
style/edvorya-interactions.css
```

`style/edvorya-shell.css` contains only Edvorya-owned shell refinements. `style/edvorya-interactions.css` contains narrow viewport/touch containment contracts. Generic Moodle Core compatibility mechanics are inherited from Boost.

## Development CSS build

```bash
npm install --ignore-scripts --no-audit --no-fund
python3 tools/normalize_design_tokens.py --check
python3 tools/normalize_design_primitives.py --check
npm run build:css
```

The quality workflow enforces canonical token and primitive ownership, rebuilds CSS from the canonical source and verifies that the committed production artifact is reproducible. Push builds may normalize source ownership before synchronizing generated CSS; pull requests fail if source files would require normalization.

## Moodle installation paths

Moodle 5.0 commonly uses:

```text
<moodle-root>/theme/edvorya/
```

Moodle 5.1 and 5.2 may use the new public webroot structure:

```text
<moodle-root>/public/theme/edvorya/
```

Always use the actual directory structure of the installed Moodle instance. After updating the theme, complete the Moodle plugin upgrade and purge caches.

## Compatibility target

Automated compatibility is maintained for Moodle 5.0, 5.1 and 5.2 with PHP 8.3 and MariaDB 10.11 test runtimes, representative Moodle bundled activities/plugins, the required Google Drive `mod_videoplayer` integration, responsive Chrome/Selenium and Axe accessibility gates.

Alpha.26 must pass the same gates after reusable Design System primitive consolidation before the next visual phase is considered stable.

Environment-specific acceptance still includes true Safari/iPhone validation, representative SCORM packages and a deterministic LTI provider.

## Project boundary

`theme_edvorya` owns presentation, layouts, visual identity, navigation composition, branding and the Edvorya Design System.

A future optional `local_edvorya` plugin will own persistent structured content, business logic, aggregated dashboard intelligence, Page Builder functionality and other features that do not belong in a theme.
