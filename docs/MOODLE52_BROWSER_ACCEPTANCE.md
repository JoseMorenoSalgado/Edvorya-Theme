# Moodle 5.2 browser acceptance status

## Environment

The browser acceptance gates run independently from Edvorya-LMS and its Vercel deployment workflow.

- Moodle branch: `MOODLE_502_STABLE`
- Theme: `theme_edvorya`
- Current theme release: `0.1.0-alpha.5`
- Database: MariaDB 10.11
- PHP: 8.3
- Browser: Chrome through Moodle Docker Selenium
- Runner: GitHub-hosted `ubuntu-latest`
- Moodle test framework: official Moodle Behat infrastructure
- VPS used: no
- Edvorya-LMS repository used: no
- Vercel deployment triggered by these tests: no

The environments are ephemeral and destroyed after every workflow run.

## Current accepted checkpoint

The latest accepted checkpoint after the transversal Design System hardening is:

- Theme quality/PHP/reproducible CSS run `29800620084`: **PASS**;
- responsive/contextual/Design System run `29800620137`: **PASS**;
- browser functional run `29800620080`: **PASS**;
- Moodle bundled-plugin run `29800620102`: **PASS**;
- Google Drive compatibility run `29800620120`: **PASS**;
- Axe accessibility run `29800620089`: **PASS**;
- branding-security run `29800620096`: **PASS**.

The compiled `style/edvorya.css` is reproducible from the committed source styles and passed the repository quality gate.

## Transversal Edvorya Design System acceptance

The transversal Design System is implemented primarily in:

```text
src/styles/design-system.css
src/styles/moodle-forms.css
src/styles/core-overlays.css
src/styles/core-utilities.css
src/styles/action-menu.css
```

The browser-only deterministic fixture is defined through:

```text
tests/behat/design_system.feature
tests/behat/behat_theme_edvorya.php
```

The fixture is injected only into the Behat browser session and does not add a production route or endpoint.

### Buttons

Representative coverage:

- `.btn-primary`: **PASS**;
- `.btn-secondary`: **PASS**;
- `.btn-danger`: **PASS**;
- `.btn-outline-primary`: **PASS**;
- disabled state: **PASS**;
- tested minimum primary-button height of 40 px: **PASS**;
- phone and desktop containment: **PASS**.

The component layer also defines success, warning, info, link, size and button-group variants.

### Forms

Representative coverage:

- `.form-control`: **PASS**;
- `.form-select`: **PASS**;
- textarea: **PASS**;
- checkbox/form-check structure: **PASS**;
- invalid state and feedback: **PASS**;
- tested minimum control height of 40 px: **PASS**;
- phone and desktop containment: **PASS**.

Existing browser functional acceptance continues to validate TinyMCE, File Picker, nested File Picker focus restoration, upload, and autocomplete behavior after the form presentation changes.

### Cards, alerts, badges and progress

Representative coverage:

- `.card`: **PASS**;
- `.alert-success`: **PASS**;
- `.alert-warning`: **PASS**;
- semantic badges: **PASS**;
- `.progress` / `.progress-bar`: **PASS**;
- Axe on the combined Design System fixture: **PASS**.

Axe initially identified two issues during development:

1. the test fixture placed the accessible progress name on the outer progress container rather than on the element with `role="progressbar"`;
2. small white text on the original solid success token `#16a34a` produced insufficient contrast.

The fixture semantics were corrected, and solid success, warning and info component surfaces now use darker semantic variants for accessible white-text contrast. The final Axe workflow is green.

### Tables

Representative coverage:

- base `.table` presentation: **PASS**;
- striped and hover treatment available: **PASS**;
- `.table-responsive` viewport containment: **PASS**;
- wide phone table uses internal horizontal scrolling: **PASS**;
- document-level horizontal overflow remains absent: **PASS**.

This preserves readable table width rather than compressing dense Moodle data into unusable columns.

### Modals

The standalone modal contract is implemented in `src/styles/core-overlays.css` without replacing Moodle Core JavaScript behavior.

Representative coverage:

- visible `.modal.show`: **PASS**;
- `.modal-dialog` horizontal containment: **PASS**;
- `.modal-content` horizontal containment: **PASS**;
- `.btn-close` visible and tested at minimum 40 px height: **PASS**;
- primary/secondary modal actions visible: **PASS**;
- phone viewport containment: **PASS**;
- desktop viewport containment: **PASS**;
- page-level horizontal overflow absent: **PASS**.

Responsive acceptance exposed a real mobile modal geometry issue during development. The modal dialog initially exceeded the effective Chrome client viewport because the modal container contributed internal spacing. The final mobile contract reserves two rem of effective width and passes both dialog and content containment checks.

### Dropdowns and action menus

The standalone overlay layer defines hidden-by-default dropdown menus, `.show` state, item states, end alignment and viewport-safe maximum widths. Moodle Core remains responsible for controller state and behavior.

Existing action-menu/browser flows continue to pass after this hardening.

## Activity acceptance

Current browser workflow run `29800620080` completed successfully with `theme_edvorya` active.

Representative Moodle 5.2 scenarios:

- Assignment file submission/editing: **PASS**;
- Quiz attempt review: **PASS**;
- Forum inline reply: **PASS**;
- H5P activity iframe rendering: **PASS**;
- blocks/editing mode: **PASS**;
- TinyMCE File Picker dialogue: **PASS**;
- nested File Picker focus restoration: **PASS**;
- TinyMCE File Picker upload: **PASS**;
- autocomplete selection lifecycle: **PASS**;
- private messaging conversation: **PASS**;
- notification popover/preferences: **PASS**.

## Contextual page-experience acceptance

The responsive gate validates the contextual Edvorya page layers together with the Design System.

### Dashboard, My Courses and Course View

Implemented in `src/styles/page-experiences.css`.

Validated hooks:

- `edv-layout-mydashboard`;
- `edv-layout-mycourses`;
- `edv-layout-course`.

Coverage includes:

- Dashboard content header and Moodle `#region-main`: **PASS**;
- My Courses enrolled-course output and `[data-region="course-content"]`: **PASS**;
- Course View `.course-content` and representative activities: **PASS**;
- phone horizontal containment: **PASS**;
- desktop horizontal containment: **PASS**.

### Calendar, Grades and Profile

Implemented in `src/styles/learning-support-experiences.css`.

Validated hooks:

- `edv-pagetype-calendar-view`;
- `edv-pagetype-grade-report-user-index`;
- `edv-pagetype-user-profile`.

Coverage includes:

- real Calendar month view: **PASS**;
- `.calendarwrapper` and `.calendarmonth` preserved: **PASS**;
- dense Calendar table internal scrolling: **PASS**;
- real user Grade report: **PASS**;
- `.user-report-container` and `.user-grade` preserved: **PASS**;
- Grade report internal scrolling: **PASS**;
- real public Profile: **PASS**;
- `.userprofile` and `.profile_tree` preserved: **PASS**;
- phone and desktop containment: **PASS**.

### Administration, Messaging and Notifications

Implemented in `src/styles/operational-experiences.css`.

Coverage includes:

- Administration `edv-layout-admin`: **PASS**;
- Moodle `#region-main` preserved: **PASS**;
- real `/message/index.php`: **PASS**;
- `.message-app[data-region="message-index"]`: **PASS**;
- `.conversationcontainer`: **PASS**;
- real `/message/notificationpreferences.php`: **PASS**;
- `.preferences-page-container`: **PASS**;
- `.preference-table`: **PASS**;
- phone and desktop containment: **PASS**.

## Notification popover and standalone Core overlay contract

A previous cross-plugin regression exposed a missing standalone `core/popover_region` CSS contract. Without a parent theme, the notification panel could participate in normal topbar flow and intercept activity links.

The theme-owned compatibility fix remains validated:

- notification region initially collapsed: **PASS**;
- collapsed popover not visible: **PASS**;
- topbar contained: **PASS**;
- Core popover opens: **PASS**;
- opened popover stays in viewport: **PASS**;
- browser notification flow: **PASS**;
- Google Drive activity links remain clickable: **PASS**;
- bundled Moodle activity links remain clickable: **PASS**.

Moodle Core templates, AMD controllers, `data-region` attributes, ARIA state and plugin code are unchanged.

## Moodle bundled plugin compatibility

Current workflow run `29800620102`: **PASS**.

Validated Moodle-bundled activities/resources:

- Book (`mod_book`): **PASS**;
- Page (`mod_page`): **PASS**;
- File / Resource (`mod_resource`): **PASS**;
- Folder (`mod_folder`): **PASS**;
- URL (`mod_url`) course-page integration: **PASS**;
- Choice (`mod_choice`): **PASS**;
- Database (`mod_data`): **PASS**;
- Glossary (`mod_glossary`): **PASS**;
- Lesson (`mod_lesson`): **PASS**;
- Wiki (`mod_wiki`): **PASS**;
- Workshop (`mod_workshop`): **PASS**;
- Feedback (`mod_feedback`): **PASS**.

SCORM and LTI are not marked as tested by this matrix. Meaningful SCORM acceptance requires an actual SCORM package, and meaningful LTI acceptance requires a real or deterministic LTI provider.

## Google Drive plugin compatibility

The required third-party integration scope is the real repository `JoseMorenoSalgado/moodle-mod_videoplayer` (`mod_videoplayer`).

Current workflow run `29800620120`: **PASS**.

Coverage includes:

- joint Moodle 5.2 installation: **PASS**;
- activity creation through Moodle's module API: **PASS**;
- activity-link navigation: **PASS**;
- resource container and iframe rendering: **PASS**;
- phone viewport: **PASS**;
- desktop viewport: **PASS**;
- horizontal containment: **PASS**;
- Axe on representative plugin surfaces: **PASS**.

No plugin-specific Edvorya Design System override is required.

## Responsive and keyboard acceptance

Current workflow run `29800620137`: **PASS**.

### Phone viewport

Representative exact fixture viewport: `390x844`.

Validated:

- mobile navigation visible: **PASS**;
- desktop primary navigation hidden: **PASS**;
- localized accessible control: **PASS**;
- keyboard Enter open/close: **PASS**;
- contextual page containment: **PASS**;
- Design System fixture containment: **PASS**;
- wide table internal scrolling: **PASS**;
- standalone modal dialog containment: **PASS**;
- standalone modal content containment: **PASS**;
- page-level horizontal overflow prevention: **PASS**.

### Tablet portrait

Representative exact fixture viewport: `820x1180`.

- compact navigation contract: **PASS**;
- desktop primary navigation hidden: **PASS**;
- keyboard opening of mobile navigation: **PASS**.

### Desktop

Representative exact fixture viewport: `1366x768`.

- mobile navigation hidden: **PASS**;
- sidebar primary navigation restored: **PASS**;
- contextual surfaces contained: **PASS**;
- Design System fixture contained: **PASS**;
- modal dialog/content contained: **PASS**.

## Automated accessibility acceptance

Current Axe workflow run `29800620089`: **PASS**.

Representative states include:

- authenticated Site Home desktop: **PASS**;
- Dashboard desktop: **PASS**;
- phone navigation closed: **PASS**;
- phone navigation open: **PASS**;
- tablet navigation open: **PASS**;
- transversal Design System fixture: **PASS**.

This is automated Axe smoke testing and is not represented as a substitute for every assistive-technology or manual screen-reader test.

## Branding and CSP-oriented acceptance

Current branding-security workflow run `29800620096`: **PASS**.

The gate verifies:

- configurable client colour delivery through Moodle's processed stylesheet: **PASS**;
- former `#theme-edvorya-client-tokens` inline style element absent from the DOM: **PASS**;
- ephemeral environment cleanup: **PASS**.

## Current gate result

- Theme quality/PHP/CSS: PASS
- Moodle/MariaDB/Selenium startup: PASS
- PHP 8.3 verification: PASS
- MariaDB 10.11 verification: PASS
- `max_input_vars >= 5000`: PASS
- Transversal buttons: PASS
- Transversal forms: PASS
- Cards: PASS
- Alerts: PASS
- Badges and semantic contrast: PASS
- Responsive tables: PASS
- Progress semantics: PASS
- Standalone modal geometry: PASS
- Modal dialog/content phone containment: PASS
- Dropdown/action-menu regression coverage: PASS
- Dashboard/My Courses/Course View: PASS
- Calendar/Grades/Profile: PASS
- Administration/Messaging/Notifications: PASS
- Core popover region contract: PASS
- Assignment: PASS
- Quiz: PASS
- Forum: PASS
- H5P: PASS
- Moodle bundled-plugin matrix: PASS
- Google Drive `mod_videoplayer`: PASS
- Blocks/editing mode: PASS
- TinyMCE/File Picker: PASS
- Autocomplete: PASS
- Messaging: PASS
- Notification popover/preferences: PASS
- Phone responsive navigation: PASS
- Tablet responsive navigation: PASS
- Desktop sidebar navigation: PASS
- Axe representative smoke tests: PASS
- Branding-security gate: PASS
- Ephemeral environment cleanup: PASS

Overall result for the tested automated Chrome/Selenium surfaces: **PASS**.

## What remains environment-specific

The automated gates above are representative, not exhaustive proof for every possible Moodle configuration.

Remaining validation that cannot honestly be inferred from the current Linux Chrome/Selenium gates alone:

- true Safari/iPhone behavior in a Safari-capable environment;
- SCORM behavior with a representative real SCORM package;
- LTI behavior with a representative real or deterministic LTI provider.

System-wide CSP compliance also depends on Moodle Core, installed plugins and server policy. The Edvorya-specific inline client-token style has been removed, but this is not a claim of universal CSP compliance for an entire Moodle installation.
