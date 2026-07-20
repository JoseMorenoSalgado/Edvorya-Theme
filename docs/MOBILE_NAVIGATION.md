# Edvorya mobile navigation

## Scope

The phase-one App Shell uses Moodle's exported `mobileprimarynav` data and renders it through a theme-owned Mustache component.

Files:

- `layout/drawers.php`: obtains primary navigation from Moodle Core and exposes `mobileprimarynav` plus `hasmobileprimarynav` to the template.
- `templates/layout/drawers.mustache`: composes the mobile navigation into the Edvorya topbar.
- `templates/components/mobile_navigation.mustache`: renders the mobile navigation with native `details` and `summary` disclosure controls.
- `src/styles/mobile-navigation.css`: owns responsive presentation.
- `src/styles/index.css`: unified CSS build entrypoint.

## Design decisions

- No parent theme is required.
- No Bootstrap CSS is imported as the Edvorya visual framework.
- No custom JavaScript is required for the first mobile navigation implementation.
- Native `details` and `summary` preserve keyboard operation and progressive enhancement.
- Moodle Core remains the source of navigation data and active-state information.
- Lucide-style icons are served locally from `pix/icons/`.
- The desktop primary navigation remains in the sidebar.
- On small screens, the primary navigation moves to a topbar disclosure panel.
- Blocks are not discarded on mobile. The sidebar block region is visually placed after the main content while the navigation-only sidebar is suppressed.

## Responsive contract

Below `64rem`:

- mobile primary navigation is available from the topbar;
- desktop primary navigation is hidden;
- the main content is presented before the block region visually;
- navigation-only sidebars are hidden;
- the mobile menu panel is constrained to the remaining viewport height and scrolls independently when necessary.

At `64rem` and above:

- the mobile navigation control is hidden;
- the Edvorya sidebar is restored;
- the primary navigation is rendered in the sidebar;
- the two-column App Shell layout is restored.

## Accessibility

- The icon-only menu control has a localized accessible name.
- The primary navigation retains a navigation landmark and accessible label.
- Active links expose `aria-current="page"` where available.
- Disclosure controls remain keyboard operable without a JavaScript dependency.
- Reduced-motion preferences disable the chevron transition.

## Remaining validation

The implementation still requires browser-level testing on:

- iPhone Safari;
- Android Chrome;
- tablet widths;
- keyboard-only navigation;
- screen-reader smoke tests;
- Moodle pages with multiple blocks and editing mode enabled.
