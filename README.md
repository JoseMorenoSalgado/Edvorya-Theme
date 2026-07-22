# Edvorya Theme for Moodle

`theme_edvorya` is the Moodle presentation layer for the Edvorya visual ecosystem.

## Current release

- Component: `theme_edvorya`
- Release: `0.1.0-alpha.18`
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
```

Alpha.17 established the shared shell and Design System language. Alpha.18 propagates that identity across the main Moodle learning experiences.

Translated patterns include:

- 64px sticky translucent topbar;
- compact 36px ghost shell actions;
- 256px desktop sidebar and 18rem mobile drawer;
- bare 18px Lucide-style navigation icons;
- 40px navigation rows;
- two-level `Edvorya LMS + institution` brand lockup;
- white/slate neutral canvas with one institutional primary accent;
- restrained `shadow-sm` surfaces;
- 12-16px normal surface radii;
- plain PageShell-style headings with a quiet divider;
- compact student/teacher dashboard decision cards;
- Edvorya-aligned My Courses cards and course navigation;
- calendar and grade-report surfaces;
- compact profile and messaging presentation;
- unified login styling while Moodle Core retains authentication behavior.

## Compatibility boundary

The original standalone alpha duplicated Moodle Core presentation contracts that Boost already maintains. Alpha.15 moved those responsibilities to Boost. Alpha.16 performed a second surgical cleanup of the remaining transversal CSS.

Removed or delegated to Boost:

- generic Core utility replicas;
- modal/dropdown/popover mechanics;
- duplicate technical layouts for popup, embedded, maintenance, print, redirect and secure contexts;
- generic Bootstrap button/card/table/progress mechanics;
- Moodle form behavior and autocomplete mechanics;
- File Picker/File Manager structural layout rules already maintained by Boost;
- Action Menu/dropdown mechanics;
- obsolete standalone compatibility and accessibility sheets.

Retained by Edvorya because they define product identity or proven responsive behavior:

- custom application and login layouts;
- Edvorya shell and navigation;
- dashboard and page-specific experiences;
- Design System colors, radii, shadows, density and focus treatment;
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

Compiled production artifact:

```text
style/edvorya.css
```

The final compiled visual skin is defined by:

```text
src/styles/identity.css
```

Focused runtime sheets:

```text
style/edvorya-shell.css
style/edvorya-dashboard.css
style/edvorya-admin.css
style/edvorya-context-nav.css
```

`style/edvorya-shell.css` contains only Edvorya-owned shell refinements. Generic Moodle Core compatibility mechanics are inherited from Boost.

## Development CSS build

```bash
npm install --ignore-scripts --no-audit --no-fund
npm run build:css
```

The quality workflow rebuilds CSS from the canonical source and synchronizes the committed production artifact when source CSS changes.

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

Environment-specific acceptance still includes true Safari/iPhone validation, representative SCORM packages and a deterministic LTI provider.

## Project boundary

`theme_edvorya` owns presentation, layouts, visual identity, navigation composition, branding and the Edvorya Design System.

A future optional `local_edvorya` plugin will own persistent structured content, business logic, aggregated dashboard intelligence, Page Builder functionality and other features that do not belong in a theme.
