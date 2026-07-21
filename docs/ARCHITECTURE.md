# Edvorya Theme Architecture

## 1. Baseline

- Plugin component: `theme_edvorya`
- Supported Moodle branches: 5.0, 5.1 and 5.2
- Minimum Moodle version: `2025041400`
- Compatibility parent: Boost (`$THEME->parents = ['boost']`)
- Moodle Core modifications: none
- Product visual system: Edvorya Design System
- CSS workflow: Tailwind CSS at build time only
- Production CSS: `style/edvorya.css`
- Templates: Mustache
- Data preparation: Moodle Output API and theme output classes
- Theme navigation icons: local Lucide-style SVG assets
- Runtime React/Tailwind/Node requirement: none

The repository root represents the contents of the `theme/edvorya/` plugin directory.

## 2. Architectural layers

```text
Moodle Core
    |
    v
Boost
(Core compatibility, Bootstrap contracts, technical layouts)
    |
    v
Edvorya Theme
(Product shell, Design System, visual experiences, branding)
    |
    +--> optional future local_edvorya
         (business logic, persistent structured data, advanced services)
```

Boost is not the Edvorya visual identity. It is the maintained compatibility substrate for Moodle Core and plugins.

### Boost owns

- generic Bootstrap utility and component behavior required by Moodle Core;
- modal, dropdown and popover contracts;
- generic Core form/file-picker compatibility;
- technical/minimal layouts where Edvorya adds no product value;
- compatibility behavior maintained by Moodle upstream.

### `theme_edvorya` owns

- App Shell;
- topbar, desktop sidebar and mobile drawer composition;
- Design System tokens;
- reusable Edvorya visual components;
- dashboard presentation for student and teacher personas;
- My Courses and Course View presentation;
- Calendar, Grades, Profile and Messaging presentation;
- Administration visual hierarchy;
- institutional branding and login presentation;
- theme-specific responsive behavior;
- local theme icon assets.

### `local_edvorya` will own

- persistent Edvorya-specific data;
- business logic;
- aggregated dashboard intelligence;
- Page Builder/Homepage Builder;
- custom public content management;
- form submissions;
- advanced catalogue metadata and services.

`theme_edvorya` must remain functional when `local_edvorya` is not installed.

## 3. Layout strategy

Edvorya overrides layouts only when the product experience benefits from a custom composition.

### Edvorya-owned layouts

`layout/drawers.php` is used for:

- base;
- standard;
- course;
- coursecategory;
- incourse;
- frontpage;
- admin;
- mycourses;
- mydashboard;
- mypublic;
- report.

`layout/login.php` owns the branded authentication shell while Moodle Core owns authentication forms and logic.

### Boost-delegated layouts

The following layouts explicitly use Boost because duplicating them adds maintenance cost without improving the Edvorya product experience:

- popup → `theme_boost/columns1.php`;
- frametop → `theme_boost/columns1.php`;
- embedded → `theme_boost/embedded.php`;
- maintenance → `theme_boost/maintenance.php`;
- print → `theme_boost/columns1.php`;
- redirect → `theme_boost/embedded.php`;
- secure → `theme_boost/secure.php`.

This mapping is explicit in `config.php` so Moodle 5.0 does not depend on later parent-layout inheritance behavior.

## 4. App Shell contract

The Edvorya application layout preserves Moodle integration points, including:

- `#page-wrapper`;
- `#page`;
- `data-region="mainpage"`;
- `data-usertour="scroller"`;
- `#topofscroll`;
- `#page-content`;
- `#region-main-box`;
- `#region-main`;
- course content header/footer;
- activity header/navigation;
- region-main settings output;
- plugin navbar output;
- user menu;
- edit switch;
- primary, secondary and tertiary navigation data.

Moodle Core owns navigation data, permissions, state and URLs. Edvorya owns presentation and composition.

## 5. CSS boundary

Canonical source entrypoint:

```text
src/styles/index.css
```

The compiled artifact is:

```text
style/edvorya.css
```

The main bundle contains Edvorya-owned tokens, Design System components and contextual experiences. It no longer imports the former standalone `core-utilities.css` or `core-overlays.css` compatibility modules.

Focused runtime layers:

```text
style/edvorya-shell.css
style/edvorya-dashboard.css
style/edvorya-admin.css
style/edvorya-context-nav.css
```

The former `style/edvorya-compat.css` and `style/edvorya-accessibility.css` were removed. Accessibility-critical mobile navigation state is consolidated into the shell layer.

## 6. Performance rules

1. Do not recreate functionality already maintained by Boost/Core.
2. Do not load React, Tailwind runtime or external icon libraries.
3. Keep JavaScript optional and interaction-specific.
4. Use Moodle APIs instead of direct SQL from layouts.
5. Avoid duplicate CSS contracts between Boost and Edvorya.
6. Keep dashboard aggregation/business intelligence outside the theme.
7. Preserve Moodle caching and theme CSS post-processing.
8. Test every structural change against Moodle 5.0, 5.1 and 5.2.

## 7. Output API rules

1. PHP layouts prepare template context.
2. Mustache templates render presentation.
3. Prefer Moodle renderables/templatable objects.
4. Override renderers only when styling existing output is insufficient.
5. Never reproduce Moodle capability or navigation logic in client-side code.
6. Triple-brace Mustache output is limited to trusted Moodle-rendered or validated markup.

## 8. Validation gates

Required automated gates include:

- PHP syntax and reproducible CSS build;
- Moodle 5.0/5.1/5.2 compatibility matrix;
- browser functional acceptance;
- responsive acceptance;
- Axe accessibility;
- bundled Moodle plugin compatibility;
- Google Drive `mod_videoplayer` compatibility;
- branding security acceptance.

Environment-specific acceptance remains required for true Safari/iPhone behavior, representative SCORM packages and a deterministic LTI provider.
