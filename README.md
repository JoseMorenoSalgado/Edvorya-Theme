# Edvorya Theme for Moodle

`theme_edvorya` is a standalone Moodle theme designed for the Edvorya visual ecosystem.

## Current release

- Component: `theme_edvorya`
- Release: `0.1.0-alpha.1`
- Target baseline: Moodle 5.2
- Minimum Moodle version: `2026042000`
- Parent themes: none (`$THEME->parents = []`)
- Status: foundation alpha; static validation passed; Moodle 5.2 runtime acceptance matrix pending

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

The production CSS is committed at `style/edvorya.css`.

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

6. Execute the runtime acceptance matrix documented in `docs/ARCHITECTURE.md` before using this alpha on a production site.

## Development CSS build

Node.js is required only for developers rebuilding CSS.

```bash
npm install --ignore-scripts --no-audit --no-fund
npm run build:css
```

Source:

```text
src/styles/tailwind.css
```

Compiled production artifact:

```text
style/edvorya.css
```

Tailwind Preflight is intentionally not imported.

## Architecture

The architectural contract, layout strategy, Design System boundaries, public experience plan, security rules, performance rules, and future `local_edvorya` integration are documented in:

```text
docs/ARCHITECTURE.md
```

`theme_edvorya` owns presentation, layouts, visual identity, navigation composition, and branding.

The future optional `local_edvorya` plugin will own persistent structured content, business logic, Page Builder functionality, forms, and advanced public-site services.

## Validation status

Automated foundation checks are recorded in:

```text
docs/QUALITY_STATUS.md
```

Passing static validation does not mean the theme has completed Moodle 5.2 runtime compatibility testing. The foundation PR must remain unmerged until installation and functional regression testing have been completed on a clean Moodle 5.2 test environment.
