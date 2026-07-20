# Edvorya Theme

Standalone Moodle theme for Edvorya LMS.

## Status

Foundation repository. Active development happens in feature branches and is merged through pull requests.

## Architecture goals

- Standalone Moodle theme: no dependency on Boost, Classic, RemUI, or other visual themes.
- Moodle 5.2 compatibility baseline.
- Own layouts, Mustache templates, renderers, CSS, and lightweight JavaScript modules.
- Tailwind CSS is used as a build tool; Moodle receives compiled, optimized CSS.
- Edvorya Design System for tokens and reusable UI components.
- Lucide-style SVG iconography without React runtime dependency.
- Accessibility, responsive design, performance, and Moodle/plugin compatibility as first-class requirements.

## Repository layout

The Moodle plugin root is this repository itself. Install by placing the repository contents in:

`theme/edvorya`

Development source files live under `src/`; compiled assets consumed by Moodle live under `style/` and `amd/build/` when generated.
