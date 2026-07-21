# Edvorya Theme for Moodle

`theme_edvorya` is the Moodle presentation layer for the Edvorya visual ecosystem.

## Current release

- Component: `theme_edvorya`
- Release: `0.1.0-alpha.15`
- Supported Moodle branches: 5.0, 5.1 and 5.2
- Minimum Moodle version: `2025041400`
- Parent theme: Boost (`$THEME->parents = ['boost']`)
- Status: alpha / active compatibility and visual acceptance

## Architecture

Edvorya uses Boost only as the Moodle Core compatibility parent. Boost owns generic Moodle presentation contracts such as Bootstrap-based utilities, modal/dropdown/popover behavior and technical fallback layouts. Edvorya owns the product experience above that compatibility layer.

Edvorya remains responsible for:

- application shell, topbar, sidebar and mobile drawer;
- Edvorya Design System tokens and visual components;
- Lucide-style theme navigation iconography;
- Dashboard experiences for students and teachers;
- My Courses, Course View and learning-support experiences;
- Administration visual hierarchy;
- institutional branding, login experience and footer;
- responsive behavior specific to Edvorya.

The theme does not modify Moodle Core and does not depend on RemUI, Classic, Lambda or commercial themes.

## Compatibility boundary

The original standalone alpha duplicated Moodle Core presentation contracts that Boost already maintains. Alpha.15 removes that duplication and delegates generic compatibility to Boost.

Removed from the Edvorya compatibility surface:

- standalone Core utility replicas;
- standalone modal/dropdown/popover positioning contracts;
- duplicate technical layouts for popup, embedded, maintenance, print, redirect and secure contexts;
- obsolete standalone compatibility and accessibility sheets.

Retained by Edvorya because they define product identity:

- custom application layouts for primary Moodle experiences;
- custom login layout;
- Edvorya shell and navigation;
- dashboard and page-specific experiences;
- Design System visual overrides;
- branding settings and token pipeline.

## Runtime dependencies

Production does not require Node.js, npm, React, Tailwind runtime, a Tailwind CDN, or external icon/font CDNs.

Boost is shipped with Moodle and acts as the compatibility base. Bootstrap is not the primary visual language of Edvorya; Edvorya overrides the visible product experience through its own Design System.

## CSS architecture

Canonical build entrypoint:

```text
src/styles/index.css
```

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
```

`style/edvorya-shell.css` contains only Edvorya-owned shell refinements. Generic Moodle Core compatibility rules are inherited from Boost.

Tailwind is build-time only and Tailwind Preflight is intentionally not imported.

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

Always use the actual directory structure of the installed Moodle instance.

After updating the theme, complete the Moodle plugin upgrade and purge caches.

## Compatibility target

Automated compatibility is maintained for Moodle 5.0, 5.1 and 5.2 with PHP 8.3 and MariaDB 10.11 test runtimes, representative Moodle bundled activities/plugins, the required Google Drive `mod_videoplayer` integration, responsive Chrome/Selenium and Axe accessibility gates.

Environment-specific acceptance still includes true Safari/iPhone validation, representative SCORM packages and a deterministic LTI provider.

## Project boundary

`theme_edvorya` owns presentation, layouts, visual identity, navigation composition, branding and the Edvorya Design System.

A future optional `local_edvorya` plugin will own persistent structured content, business logic, aggregated dashboard intelligence, Page Builder functionality and other features that do not belong in a theme.
