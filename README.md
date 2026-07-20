# Edvorya Theme for Moodle

`theme_edvorya` is a standalone Moodle theme designed for the Edvorya visual ecosystem.

## Current release

- Component: `theme_edvorya`
- Release: `0.1.0-alpha.3`
- Target baseline: Moodle 5.2
- Minimum Moodle version: `2026042000`
- Parent themes: none (`$THEME->parents = []`)
- Status: foundation alpha; static validation passed; isolated Moodle 5.2 + MariaDB 10.11 runtime smoke validation passed; alpha.3 activity compatibility has passed representative Chrome/Selenium Behat flows for Assignment, Quiz, Forum, and H5P; shared Core interaction, responsive, accessibility, editor, and representative plugin acceptance work remains

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

The architectural contract, layout strategy, Design System boundaries, public experience plan, security rules, performance rules, responsive navigation strategy, Core compatibility policy, activity compatibility policy, browser acceptance status, and future `local_edvorya` integration are documented in:

```text
docs/ARCHITECTURE.md
docs/MOBILE_NAVIGATION.md
docs/CORE_COMPATIBILITY.md
docs/ACTIVITY_COMPATIBILITY.md
docs/MOODLE52_BROWSER_ACCEPTANCE.md
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

Representative browser activity acceptance for alpha.3 is recorded in:

```text
docs/MOODLE52_BROWSER_ACCEPTANCE.md
```

The alpha.3 browser gate uses a GitHub-hosted runner with Moodle 5.2, PHP 8.3, MariaDB 10.11, Moodle Docker, Selenium, and Chrome. Representative Assignment, Quiz, Forum, and H5P scenarios pass with `theme_edvorya` active.

Passing static, runtime smoke, and representative activity acceptance does not mean the theme has completed full Moodle 5.2 production acceptance. The foundation PR remains unmerged until the remaining shared Core interaction, responsive, accessibility, editor, and representative plugin regression testing is completed.
