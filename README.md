# Edvorya Theme for Moodle

`theme_edvorya` is a standalone Moodle theme designed for the Edvorya visual ecosystem.

## Current release

- Component: `theme_edvorya`
- Release: `0.1.0-alpha.5`
- Target baseline: Moodle 5.2
- Minimum Moodle version: `2026042000`
- Parent themes: none (`$THEME->parents = []`)
- Status: foundation alpha; static validation passed; isolated Moodle 5.2 + MariaDB 10.11 runtime smoke validation passed; representative Chrome/Selenium Behat acceptance passes for Assignment, Quiz, Forum, H5P, blocks/editing mode, File Picker, TinyMCE, autocomplete, messaging, notifications, phone/tablet/desktop navigation, keyboard mobile navigation, and automated Axe accessibility smoke testing; client colour tokens now use Moodle's cached CSS post-processing pipeline instead of a theme-owned inline style block; administrator branding uploads are restricted to raster image types and legacy uploaded SVG branding is rejected at serving time

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

The entrypoint composes the Edvorya Design System stylesheet and selective theme-owned compatibility modules for Moodle Core and verified activity surfaces. The compatibility layer is intentionally evidence-driven and does not attempt to clone Bootstrap or Boost.

Client-configurable colour overrides are appended by Moodle's cached theme CSS post-processing callback after the compiled stylesheet is loaded. The theme does not emit its former page-level client-token `<style>` block.

Compiled production artifact:

```text
style/edvorya.css
```

Tailwind Preflight is intentionally not imported.

## Architecture and security

The architectural contract, layout strategy, Design System boundaries, public experience plan, security rules, performance rules, responsive navigation strategy, Core compatibility policy, activity compatibility policy, browser acceptance status, and future `local_edvorya` integration are documented in:

```text
docs/ARCHITECTURE.md
docs/MOBILE_NAVIGATION.md
docs/CORE_COMPATIBILITY.md
docs/ACTIVITY_COMPATIBILITY.md
docs/MOODLE52_BROWSER_ACCEPTANCE.md
docs/SECURITY.md
```

`theme_edvorya` owns presentation, layouts, visual identity, navigation composition, and branding.

The future optional `local_edvorya` plugin will own persistent structured content, business logic, Page Builder functionality, forms, and advanced public-site services.

## Validation status

Static checks are recorded in:

```text
docs/QUALITY_STATUS.md
```

The isolated Moodle runtime smoke-validation result is recorded in:

```text
docs/MOODLE52_RUNTIME_STATUS.md
```

Representative browser, responsive, keyboard, communication, and accessibility acceptance is recorded in:

```text
docs/MOODLE52_BROWSER_ACCEPTANCE.md
```

The current browser gates use GitHub-hosted runners with Moodle 5.2, PHP 8.3, MariaDB 10.11, Moodle Docker, Selenium, and Chrome. The tested activity/Core/communication flows pass with `theme_edvorya` active. Theme-specific responsive scenarios pass at 390x844, 820x1180, and 1366x768, including keyboard opening and closing of the native mobile navigation. Representative Site Home, Dashboard, phone navigation, and tablet navigation states also pass Moodle's Axe-based automated accessibility smoke checks.

A dedicated branding-security gate verifies that a configured client primary colour is delivered through Moodle's processed stylesheet and that the former `#theme-edvorya-client-tokens` inline style element is absent from the rendered DOM.

Passing static, runtime smoke, representative browser, responsive, keyboard, and automated accessibility acceptance does not constitute exhaustive validation of every Moodle or third-party plugin surface. True Safari/iPhone validation requires a real Safari-capable environment, and representative third-party plugin compatibility should be verified against actual plugin repositories before the foundation is considered production-ready.
