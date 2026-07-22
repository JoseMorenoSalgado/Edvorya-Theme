# Edvorya mobile navigation

## Scope

The phase-one App Shell uses Moodle's exported `mobileprimarynav` data and renders it through a theme-owned Mustache component.

Files:

- `layout/drawers.php`: obtains primary navigation from Moodle Core and exposes `mobileprimarynav` plus `hasmobileprimarynav` to the template. It also exports Moodle secondary-navigation overflow data when available.
- `templates/layout/drawers.mustache`: composes the mobile navigation into the Edvorya topbar and renders the tertiary overflow selector inside the main region.
- `templates/components/mobile_navigation.mustache`: renders the mobile navigation with native `details` and `summary` disclosure controls.
- `src/styles/mobile-navigation.css`: owns responsive primary-navigation presentation.
- `src/styles/tertiary-navigation.css`: owns the responsive tertiary selector presentation.
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
- When Moodle reports overflow in secondary navigation, Edvorya renders the Core tertiary navigation selector rather than dropping inaccessible tabs.

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

When Moodle provides secondary-navigation overflow data:

- the normal secondary menu remains rendered through `core/moremenu`;
- the Core tertiary selector is rendered inside `#region-main`;
- the selector expands to the available width on narrow screens;
- the theme does not invent or duplicate navigation destinations.

## Accessibility

- The icon-only menu control has a localized accessible name.
- The primary navigation retains a navigation landmark and accessible label.
- Active links expose `aria-current="page"` where available.
- Disclosure controls remain keyboard operable without a JavaScript dependency.
- Reduced-motion preferences disable the chevron transition.
- The tertiary selector keeps the label and attributes supplied by Moodle's navigation API.

## Remaining validation

The implementation still requires browser-level testing on:

- iPhone Safari;
- Android Chrome;
- tablet widths;
- keyboard-only navigation;
- screen-reader smoke tests;
- Moodle pages with secondary navigation overflow;
- Moodle pages with multiple blocks and editing mode enabled.
