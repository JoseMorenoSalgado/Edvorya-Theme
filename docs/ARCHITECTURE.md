# Edvorya Theme Architecture

## 1. Baseline

- Plugin component: `theme_edvorya`
- Target baseline: Moodle 5.2 (`2026042000` minimum)
- Theme model: standalone (`$THEME->parents = []`)
- Core modifications: none
- Parent theme dependencies: none
- Visual framework: Edvorya Design System
- CSS workflow: Tailwind CSS is development/build tooling only
- Production CSS: compiled and committed at `style/edvorya.css`
- Templates: Mustache
- Data preparation: Moodle Output API and autoloaded output classes
- Icons: selected Lucide SVG assets stored locally in `pix/`
- Runtime React dependency: none
- Runtime Tailwind dependency: none
- Runtime Node.js dependency: none
- External font/CDN dependency: none

The repository root represents the contents of `theme/edvorya/` in a Moodle installation.

## 2. Architectural boundary

Edvorya for Moodle is designed as two conceptually separate plugins.

```text
Moodle Core
|
+-- theme_edvorya
|   +-- layouts and application shell
|   +-- design system and compiled CSS
|   +-- Mustache presentation
|   +-- output classes and targeted renderers
|   +-- navigation presentation
|   +-- branding presentation
|   +-- public experience presentation
|   +-- local Lucide icon assets
|
+-- local_edvorya (future, optional)
    +-- structured public content
    +-- page and homepage builder
    +-- dynamic sections
    +-- custom public pages
    +-- contact forms and submissions
    +-- testimonials and marketing records
    +-- advanced catalogue data
    +-- additional Edvorya business services
```

### `theme_edvorya` owns

- visual identity;
- layout composition;
- App Shell;
- presentation of Moodle navigation;
- design tokens;
- reusable visual components;
- branding assets and simple theme configuration;
- template overrides when a compatibility review justifies them;
- renderer overrides when Moodle output must be adapted visually;
- public-facing presentation that can be produced from existing Moodle data.

### `local_edvorya` will own

- database schema for Edvorya-specific structured content;
- business logic;
- Page Builder and Homepage Builder;
- persistent dynamic page sections;
- custom page routing/content management;
- form processing and submissions;
- marketing-specific course metadata not owned by Moodle Core;
- services whose data must survive a theme change.

`theme_edvorya` must remain fully functional when `local_edvorya` is not installed. Future integration must therefore be optional and capability-aware.

## 3. Phase-one repository tree

```text
theme/edvorya/
|-- .github/workflows/theme-build.yml
|-- classes/
|   `-- output/
|       `-- branding.php
|-- docs/
|   `-- ARCHITECTURE.md
|-- lang/
|   |-- en/theme_edvorya.php
|   `-- es/theme_edvorya.php
|-- layout/
|   |-- drawers.php
|   |-- embedded.php
|   |-- login.php
|   |-- maintenance.php
|   `-- secure.php
|-- pix/
|   `-- icons/
|       |-- chevron-down.svg
|       |-- external-link.svg
|       |-- menu.svg
|       `-- search.svg
|-- src/
|   `-- styles/
|       `-- tailwind.css
|-- style/
|   `-- edvorya.css
|-- templates/
|   |-- components/
|   |   |-- brand.mustache
|   |   `-- branding_head.mustache
|   `-- layout/
|       |-- drawers.mustache
|       |-- embedded.mustache
|       |-- login.mustache
|       |-- maintenance.mustache
|       `-- secure.mustache
|-- THIRD_PARTY_NOTICES.md
|-- config.php
|-- lib.php
|-- package.json
|-- settings.php
`-- version.php
```

Directories are added only when they contain an implementation used by this phase. JavaScript directories are intentionally absent until a real interaction requires JavaScript.

## 4. Layout strategy

The theme defines its own layout map and does not inherit layouts from another theme.

### Main application shell: `drawers.php`

Used for the normal authenticated and public Moodle application contexts that need global navigation, blocks, or administration integration.

The corresponding Mustache template preserves important Moodle integration points including:

- `#page-wrapper`;
- `#page`;
- `data-region="mainpage"`;
- `data-usertour="scroller"`;
- `#topofscroll`;
- `#page-content`;
- `#region-main-box`;
- `#region-main`;
- region-main settings output;
- course content header/footer;
- activity header;
- activity navigation;
- standard head/body/footer hooks;
- plugin navigation output;
- user menu;
- edit switch;
- primary and secondary navigation output.

Edvorya changes composition and presentation without rebuilding Moodle navigation data manually.

### Login: `login.php`

Moodle Core continues to own authentication forms and authentication logic. Edvorya owns only the surrounding presentation and optional login artwork.

### Embedded/popup/print/redirect/frame: `embedded.php`

A deliberately minimal content surface without global App Shell navigation. It preserves the main content IDs and standard Moodle output hooks required by embedded or auxiliary experiences.

### Secure: `secure.php`

Dedicated to secure/safe-browser contexts. It intentionally omits global navigation while preserving Moodle activity output and allowed block regions.

### Maintenance: `maintenance.php`

Installation-safe and intentionally isolated from client branding settings, custom output classes, blocks, navigation, database-backed theme content, and optional integrations.

## 5. Edvorya App Shell

The initial App Shell is intentionally functional rather than final-design complete.

```text
Edvorya App Shell
|-- Topbar
|   |-- institutional brand
|   |-- Moodle/plugin navbar output
|   |-- page heading actions
|   |-- editing switch
|   |-- language menu
|   `-- user menu
|-- Sidebar
|   |-- Moodle primary navigation
|   `-- Moodle block region
|-- Main Content
|   |-- full header
|   |-- secondary navigation
|   |-- region-main settings
|   |-- activity header
|   |-- Moodle main content
|   `-- activity navigation
`-- Footer
    |-- simple institutional data
    `-- Moodle standard footer output
```

No dashboard-specific business logic belongs in the App Shell.

## 6. Output API strategy

PHP layout files prepare context. Mustache templates render presentation.

Rules:

1. Prefer Moodle renderables/templatable output objects for reusable data presentation.
2. Use targeted renderer overrides only when the existing renderer output cannot be styled safely.
3. Do not perform direct SQL in layout files.
4. Do not reproduce Moodle navigation trees with custom SQL or custom permission logic.
5. Keep capability and context decisions in PHP/API layers, never in client-side presentation alone.
6. Escape normal Mustache values by default. Triple-brace output is restricted to trusted Moodle renderer output or strictly generated/validated markup.

`classes/output/branding.php` is the first output object. It centralizes theme branding data and validated design-token overrides.

## 7. Design System

### Token families

The base architecture includes tokens for:

- primary;
- secondary;
- accent;
- background;
- foreground;
- muted;
- border;
- success;
- warning;
- danger;
- info;
- sidebar;
- topbar;
- button;
- link;
- login background;
- spacing;
- radii;
- shadows;
- focus;
- hover;
- active;
- disabled.

### Component namespace

Reusable Edvorya components use the `edv-` namespace. The phase-one CSS reserves the following primitives:

- `edv-button`;
- `edv-card`;
- `edv-course-card`;
- `edv-sidebar`;
- `edv-topbar`;
- `edv-avatar`;
- `edv-badge`;
- `edv-progress`;
- `edv-tabs`;
- `edv-modal`;
- `edv-dropdown`;
- `edv-table`;
- `edv-empty-state`.

Components should be implemented once and composed rather than duplicated for each page.

## 8. Tailwind strategy

Tailwind is a build-time dependency only.

Source:

```text
src/styles/tailwind.css
```

Production artifact:

```text
style/edvorya.css
```

The build intentionally does not import Tailwind Preflight. A global reset is too risky for Moodle forms, editors, activity content, plugin markup, tables, file pickers, and third-party components.

The CSS architecture therefore uses:

1. central CSS custom properties;
2. Edvorya component classes;
3. a small explicit compatibility surface for common Moodle-generated classes;
4. Tailwind utilities only when detected in theme-owned source;
5. no Tailwind runtime or CDN.

The compatibility surface must grow only after regression testing demonstrates a real need. Edvorya must not attempt to clone an entire framework API merely to imitate another theme.

## 9. Branding

Theme settings provide simple client branding that belongs to presentation:

- institution name;
- primary logo;
- alternate logo;
- dark-background logo;
- favicon;
- primary/secondary/accent colours;
- page background/foreground/muted/border colours;
- sidebar/topbar colours;
- button/link colours;
- login background and login image;
- footer text;
- copyright;
- basic social URLs.

Uploaded assets are stored using Moodle theme setting file areas and served through `theme_edvorya_pluginfile()`.

Client colours are converted into one validated CSS Custom Properties block. The theme does not generate independent rule sets for every configured colour.

The maintenance layout deliberately bypasses this branding layer.

## 10. Lucide strategy

Lucide is used as a visual identity source, not as a runtime framework.

Rules:

- no React dependency;
- no `lucide-react`;
- no external icon CDN;
- selected SVGs are stored locally under `pix/icons/`;
- icons are added only when used by a real component;
- default stroke width remains consistent with Lucide (`2`);
- icon-only controls must always have an accessible name;
- decorative icons must be hidden from assistive technology at the point of use.

Third-party licensing is documented in `THIRD_PARTY_NOTICES.md`.

## 11. JavaScript strategy

No custom JavaScript is required by the phase-one shell yet.

When JavaScript is introduced:

- prefer Moodle 5.2-supported frontend module mechanisms;
- use modern ES modules where appropriate for the Moodle 5.2 build toolchain;
- use AMD only when compatibility with a Moodle API or existing integration specifically requires it;
- do not add a client framework for simple interactions;
- prefer native HTML/CSS for disclosure and layout where reliable;
- lazy-load secondary behaviour when it measurably improves initial render cost;
- preserve keyboard interaction and ARIA contracts.

## 12. Site Home architecture

Phase one keeps Moodle Site Home functional and does not replace it with a proprietary routing system.

The future Edvorya public homepage presentation may compose:

- Hero;
- title/subtitle;
- primary and secondary CTA;
- featured courses;
- categories;
- benefits;
- statistics;
- about section;
- testimonials;
- instructors;
- FAQ;
- partners;
- final CTA;
- public footer.

Responsibility split:

- `theme_edvorya`: layout, visual components, responsive presentation and rendering of data already provided by Moodle or an integration contract;
- `local_edvorya`: persistent structured homepage sections, Page Builder data, ordering, dynamic records and business rules.

The theme must distinguish guest/public presentation from authenticated presentation without disabling native Site Home courses, categories, blocks, content, or search.

## 13. Public pages architecture

Public pages such as About, Contact, Services, FAQ, Privacy, Terms and Support are presentation concerns only when their content already exists in Moodle or is supplied by another plugin.

The theme must not add arbitrary standalone PHP pages containing business logic.

Future structured/custom pages will be owned by `local_edvorya`; the theme will provide presentation templates or renderer surfaces for data supplied by that plugin.

## 14. Public course catalogue architecture

The catalogue must be built from Moodle APIs and renderer/output contracts rather than direct repeated database queries from Mustache or layouts.

Planned presentation capabilities:

- search;
- category navigation;
- filters;
- responsive course cards;
- course image;
- title and summary;
- instructor presentation where Moodle permissions/data allow it;
- modality, level and language when a defined data owner exists;
- enrolment status;
- price only when supplied by an installed enrolment/commerce integration.

Phase one does not invent marketing fields in the theme database.

Advanced marketing metadata and catalogue-specific structured data belong to `local_edvorya` or another explicit plugin integration.

## 15. Public course page architecture

The public course presentation and enrolled course experience are separate presentation contexts.

### Public course page may expose

Only information that Moodle permissions and enrolment visibility allow, such as:

- course image;
- title;
- public description/summary;
- category;
- public instructor information where permitted;
- enrolment options;
- explicitly public metadata supplied by a trusted plugin integration.

### Enrolled course experience

The internal course page remains Moodle's capability-controlled learning environment for:

- sections;
- activities;
- resources;
- completion;
- grades;
- restricted content.

The public presentation must never expose activity resources, files, documents, hidden sections, restricted completion data, or other protected content by bypassing Moodle capability/access APIs.

## 16. Future `local_edvorya` integration contract

The theme must not declare `local_edvorya` as a required dependency.

A future integration should follow these rules:

1. `local_edvorya` owns its database tables and business logic.
2. `local_edvorya` exposes data through stable Moodle plugin APIs/output objects.
3. `theme_edvorya` consumes only presentation-ready, permission-checked data.
4. If `local_edvorya` is absent, the theme falls back to native Moodle presentation.
5. Theme templates never query `local_edvorya` tables directly.
6. Changing theme must not delete or orphan `local_edvorya` content.
7. Public endpoints and forms remain owned by the local plugin, including sesskey/capability validation where applicable.

## 17. Performance rules

- no layout-level SQL;
- no N+1 course or user queries introduced by the theme;
- no external blocking fonts;
- no Tailwind/React runtime;
- local optimized SVG assets;
- compiled production CSS committed with the plugin;
- secondary data loaded only when useful;
- Moodle Cache API used only for genuinely expensive reusable data, with explicit cache definitions and invalidation owned by the plugin that owns the data;
- no cache is added merely because a value can be cached;
- client branding uses central token overrides rather than large generated stylesheets.

## 18. Security rules

- use Moodle APIs and contexts;
- preserve capability checks from Core and plugins;
- do not infer access from CSS visibility;
- use File API for stored files;
- validate configurable URLs and colour values;
- escape template values by default;
- keep `pluginfile` file areas allow-listed;
- avoid direct SQL in the theme;
- keep maintenance isolated from optional settings/data services;
- never expose enrolled-course resources through a public-course renderer without Moodle access checks.

## 19. Accessibility baseline

- visible keyboard focus;
- semantic landmarks;
- accessible names for icon-only controls;
- no removal of Moodle ARIA/data attributes without consumer analysis;
- responsive reflow without horizontal page scrolling where possible;
- tables remain horizontally scrollable when their semantics require a table;
- colour is not the sole carrier of state;
- contrast must be validated for client-configurable colours before final production hardening.

## 20. Compatibility strategy

Primary compatibility targets:

- Moodle Core;
- Assignment;
- Quiz;
- Forum;
- H5P;
- Calendar;
- Grades;
- Messaging;
- Notifications;
- Blocks;
- Moodle Forms;
- Tables;
- Modals;
- File Picker;
- Editors;
- Administration;
- third-party plugins that use Moodle APIs and documented frontend contracts.

A standalone theme has a larger compatibility surface because it does not inherit the styling of another theme. The initial CSS compatibility layer is therefore intentionally conservative and must be expanded based on test evidence rather than copied wholesale from Boost or Bootstrap.

## 21. Phase-one acceptance gates

Before merging the foundation PR:

1. PHP syntax checks pass for every PHP file.
2. Tailwind production build succeeds.
3. `style/edvorya.css` is generated from `src/styles/tailwind.css`.
4. Moodle 5.2 detects and installs the plugin.
5. The theme can be selected with `$THEME->parents = []`.
6. Login renders and authenticates.
7. Site Home renders for guest and authenticated users.
8. Dashboard and My Courses render.
9. A course renders.
10. At least Assignment, Quiz, Forum and H5P pages open without layout errors.
11. Blocks render and editing mode remains usable.
12. Profile, Calendar, Grades and Administration render.
13. Messaging and notification UI remains reachable.
14. File Picker and an editor open without fatal layout/style errors.
15. Popup, embedded, print, redirect, secure and maintenance layouts are exercised.
16. Keyboard navigation and visible focus receive a basic accessibility pass.
17. Mobile smoke tests cover iPhone/Safari-sized and Android/Chrome-sized viewports.

Passing static checks alone is not equivalent to passing this Moodle runtime matrix.
