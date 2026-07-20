# Moodle 5.2 activity compatibility

## Scope

This document records the theme-owned compatibility layer for the first activity regression block:

- Assignment (`mod_assign`);
- Quiz (`mod_quiz`);
- Forum (`mod_forum`);
- H5P/Core H5P embeds.

The activity plugins keep ownership of their own `styles.css`, templates, JavaScript, renderers, and behaviour. `theme_edvorya` does not copy those styles wholesale.

## Design rule

Edvorya adds activity CSS only when the standalone theme must supply one of the following:

1. a shared utility or CSS custom property normally provided by Bootstrap/Core theme styling;
2. a responsive correction for fixed-width activity markup on small screens;
3. a theme-level presentation correction that can be safely scoped to an activity path;
4. a compatibility rule required by an official Moodle 5.2 template.

## Shared activity compatibility

`src/styles/activity-common.css` currently provides:

- minimal Bootstrap-compatible CSS custom-property aliases used by Moodle/plugin CSS without importing Bootstrap;
- `justify-content-end` for Core H5P action rows;
- `d-inline-block` for activity markup that expects the utility;
- `text-primary` mapped to the Edvorya primary token;
- `border-0` for H5P embed iframes;
- touch-friendly horizontal overflow for activity table/no-overflow containers.

## Assignment

`src/styles/activity-assign.css` adds only responsive corrections around Moodle's own Assignment UI:

- grading/submission summary surfaces remain horizontally usable;
- fixed filter panels are constrained to the viewport;
- user-selector alignment stops forcing desktop widths on small screens;
- grading navigation floats are neutralized below tablet width;
- summary key columns stop forcing a fixed 15em width on narrow screens.

Assignment status colours, grading workflow, submission state logic, annotation UI, and JavaScript remain owned by `mod_assign`.

## Quiz

`src/styles/activity-quiz.css` adds:

- a larger minimum target size for question-navigation buttons;
- viewport-safe connection status banners;
- responsive review-options form layout;
- narrower report-cell constraints on small screens;
- safe maximum widths for review/report tables.

Quiz question rendering, attempt state, secure mode, timers, autosave, navigation logic, and reports remain owned by `mod_quiz` and Moodle question engine components.

## Forum

`src/styles/activity-forum.css` adds:

- Edvorya border/background treatment without replacing forum structure;
- safe wrapping for post content and attachments;
- narrow-screen removal of legacy float/margin assumptions in forum posts;
- responsive discussion controls;
- wrapping of last-post/reply/subscription controls on small screens.

Forum subscriptions, ratings, grading, post actions, discussion navigation, and JavaScript remain owned by `mod_forum`.

## H5P

Moodle Core renders H5P through `core_h5p/h5piframe` and `core_h5p/h5pembed` templates. The theme supplies only outer-page compatibility:

- iframe wrappers and players stay within the available content width;
- H5P iframes are block-level and borderless;
- Core utility classes used by the H5P action row are available without Bootstrap.

H5P content styling and interactive behaviour remain inside the H5P runtime/iframe and are not overridden by the theme.

## Performance

All activity compatibility modules compile into the single production artifact:

`style/edvorya.css`

No additional production HTTP requests or JavaScript dependencies are introduced.

## Validation contract

The repository quality gate must pass after every activity compatibility change:

- PHP syntax validation;
- Tailwind/CSS production rebuild;
- compiled CSS synchronization check.

Browser/runtime validation for each activity should exercise the real Moodle activity flow, but missing browser infrastructure must never be represented as a successful test.
