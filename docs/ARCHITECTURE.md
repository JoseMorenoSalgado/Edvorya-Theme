# Edvorya Theme Architecture

## Baseline

- Plugin component: `theme_edvorya`
- Moodle baseline: 5.2 (`2026042000`)
- Theme model: standalone (`$THEME->parents = []`)
- Visual framework: Edvorya Design System
- CSS workflow: Tailwind CSS as build tooling; Moodle consumes compiled CSS from `style/edvorya.css`
- JavaScript: Moodle AMD modules only where behaviour is required; avoid heavy client-side dependencies
- Templates: Mustache for layout and reusable presentation components
- Icons: optimized Lucide-style SVG assets stored locally; no React runtime

## Repository boundaries

### Moodle runtime

- `config.php`: theme capabilities and layout mapping
- `version.php`: plugin metadata and Moodle compatibility
- `settings.php`: administrator-facing theme settings
- `layout/`: PHP layout context preparation only
- `templates/`: Mustache presentation templates
- `style/`: compiled CSS delivered to Moodle
- `amd/src/`: source JavaScript modules
- `amd/build/`: Moodle-consumable compiled JavaScript
- `classes/output/`: renderers and output classes when Moodle output must be adapted
- `pix/`, `pix_core/`, `pix_plugins/`: theme and override icons/images

### Development source

- `src/styles/`: Tailwind entrypoint and design-system source
- `docs/`: architecture and implementation decisions

## Design system layers

1. Foundations: color, typography, spacing, radii, shadows, motion and focus states.
2. Primitives: buttons, links, inputs, selects, checkboxes, badges, alerts and tooltips.
3. Containers: cards, panels, tables, dialogs, drawers and dropdowns.
4. Navigation: topbar, sidebar, breadcrumbs, tabs and mobile navigation.
5. Moodle patterns: dashboard, course cards, activity rows, course index, blocks, forms, grades, calendar and administration.

## Compatibility rules

- Do not remove Moodle Core IDs, hooks, data attributes, form names, accessibility semantics or JavaScript integration points without validating their consumers.
- Prefer template overrides and renderers over Core modifications.
- Keep PHP responsible for data/context and Mustache responsible for presentation.
- Secondary data should be loaded asynchronously only when it reduces initial rendering cost without degrading accessibility.
- Avoid duplicating plugin markup unless an override is required for the Edvorya experience.

## Performance budget

- Keep the critical CSS small and purge unused Tailwind utilities during production builds.
- Add JavaScript only for interaction that cannot be achieved reliably with native HTML/CSS.
- Avoid layout-level database queries.
- Reuse Moodle caches and APIs instead of introducing parallel data layers.
- Treat mobile performance and low-powered devices as primary targets.

## Initial roadmap

1. Establish tokens and accessibility baseline.
2. Implement global shell: topbar, sidebar, mobile navigation and footer.
3. Integrate Moodle primary/secondary navigation and user menu.
4. Build dashboard and course-card components.
5. Style forms, tables, notifications and modal surfaces.
6. Cover course view, activities, grading, calendar, profile and administration.
7. Add targeted template overrides only after compatibility review.
8. Add automated lint/build checks and Moodle acceptance regression testing.
