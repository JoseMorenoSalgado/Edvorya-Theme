# Edvorya Theme for Moodle

`theme_edvorya` is a standalone Moodle theme designed for the Edvorya visual ecosystem.

## Current release

- Component: `theme_edvorya`
- Release: `0.1.0-alpha.3`
- Target baseline: Moodle 5.2
- Minimum Moodle version: `2026042000`
- Parent themes: none (`$THEME->parents = []`)
- Status: foundation alpha; static validation passed; isolated Moodle 5.2 + MariaDB 10.11 runtime smoke validation passed for the alpha.1 foundation; alpha.2 added responsive navigation and selective Moodle Core compatibility hardening; alpha.3 adds scoped Assignment, Quiz, Forum, and H5P compatibility hardening; browser-level acceptance work remains

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

6. Execute the remaining browser-level acceptance matrix documented in `docs/ARCHITECTURE.md` before using this alpha on a production site.

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

The entrypoint composes the Edvorya Design System stylesheet and selective theme-owned compatibility modules for Moodle Core and verified activity surfaces. The compatibility layer is intentionally evidence-driven and does not attempt to clone Bootstrap or Boost.

Compiled production artifact:

```text
style/edvorya.css
```

Tailwind Preflight is intentionally not imported.

## Architecture

The architectural contract, layout strategy, Design System boundaries, public experience plan, security rules, performance rules, responsive navigation strategy, Core compatibility policy, activity compatibility policy, and future `local_edvorya` integration are documented in:

```text
docs/ARCHITECTURE.md
docs/MOBILE_NAVIGATION.md
docs/CORE_COMPATIBILITY.md
docs/ACTIVITY_COMPATIBILITY.md
```

`theme_edvorya` owns presentation, layouts, visual identity, navigation composition, and branding.

The future optional `local_edvorya` plugin will own persistent structured content, business logic, Page Builder functionality, forms, and advanced public-site services.

## Validation status

Static checks are recorded in:

```text
docs/QUALITY_STATUS.md
```

The isolated Moodle runtime smoke-validation result for the alpha.1 foundation is recorded in:

```text
docs/MOODLE52_RUNTIME_STATUS.md
```

Alpha.2 and alpha.3 include additional Core, responsive, and activity compatibility changes made after that runtime smoke test. These changes must receive browser-level regression testing before the foundation is merged.

Passing static and HTTP/runtime smoke validation does not mean the theme has completed full Moodle 5.2 production acceptance. The foundation PR remains unmerged until browser-level functional, responsive, accessibility, editor, File Picker, activity, and representative plugin regression testing is completed.
