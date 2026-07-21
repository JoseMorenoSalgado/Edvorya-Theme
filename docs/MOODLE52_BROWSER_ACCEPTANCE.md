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

## Activity acceptance

Workflow run `29785856670` completed successfully.

Representative Moodle 5.2 scenarios executed with `theme_edvorya` forced as the active theme:

- Assignment — `Submit a file and update the submission with another file`: **PASS**.
- Quiz — `Review the quiz attempt`: **PASS**.
- Forum — `Confirm inpage replies work`: **PASS**.
- H5P — `Add an h5pactivity to a course`: **PASS**.

These flows cover representative file submission/editing, Quiz review, JavaScript in-page Forum reply, and nested H5P iframe rendering.

## Moodle bundled plugin compatibility

Dedicated bundled-plugin workflow run `29794095994` completed successfully with Moodle 5.2, PHP 8.3, MariaDB 10.11, Chrome/Selenium, and `theme_edvorya` active.

Fixtures were created with Moodle's own testing generators for the plugins shipped with Moodle Core. The compatibility matrix covered:

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

The test also validated that all of these bundled activities/resources remain visible on a `390x844` course page without horizontal overflow. Individual Moodle-owned plugin pages, except the external URL target, were opened at `1366x768` and verified to render inside the Edvorya application shell with `#region-main` contained within the viewport.

The URL resource was intentionally validated at course-page integration level rather than following the external destination, because the external target is not a theme-rendered Moodle surface.

SCORM and LTI are not marked as tested by this matrix. Meaningful SCORM acceptance requires an actual SCORM package, and meaningful LTI acceptance requires a real or deterministic LTI provider. Synthetic empty instances would not constitute trustworthy compatibility evidence.

## Google Drive plugin compatibility

The required third-party integration scope is the real repository `JoseMorenoSalgado/moodle-mod_videoplayer` (`mod_videoplayer`).

Dedicated compatibility workflow run `29792661235` completed successfully against tested plugin revision `37b26d9026de3a4e472c99fa0c604ac10b3a5d72`.

Coverage included:

- installing Moodle 5.2 with Edvorya and Drive Resource together: **PASS**;
- creating the activity through Moodle's module API: **PASS**;
- rendering the plugin container and resource iframe: **PASS**;
- `390x844` viewport: **PASS**;
- `1366x768` viewport: **PASS**;
- no horizontal container overflow: **PASS**;
- Axe on both representative plugin surfaces: **PASS**;
- ephemeral environment cleanup: **PASS**.

No plugin-specific Edvorya CSS override was required.

## Shared Core interaction acceptance

Workflow run `29786269521` completed successfully and re-ran the activity scenarios together with:

- blocks/editing mode — `Configuring the Text block with Javascript on`: **PASS**;
- TinyMCE image dialogue and nested File Picker: **PASS**;
- nested File Picker Escape/focus restoration: **PASS**;
- TinyMCE File Picker upload: **PASS**;
- single-value autocomplete selection/replacement/removal: **PASS**.

## Messaging and notification acceptance

Workflow run `29786702098` completed successfully and re-ran all preceding scenarios together with:

- private messaging conversation via Contacts: **PASS**;
- notification popover, unread counts, and preference-sensitive visibility: **PASS**.

## Responsive and keyboard acceptance

Dedicated responsive workflow run `29787985130` completed successfully.

A production issue discovered during responsive acceptance was the use of non-existent Moodle Core language identifiers for primary and secondary navigation landmark labels. The theme now owns localized strings `primarynavigationlabel` and `secondarynavigationlabel`. The fix was introduced in `0.1.0-alpha.4`.

Theme-specific Behat scenarios validate exact viewport sizes and keyboard activation of the native mobile navigation disclosure:

### Phone viewport — `390x844`

- mobile navigation visible: PASS;
- desktop primary navigation hidden: PASS;
- localized accessible control name: PASS;
- labelled primary navigation landmark: PASS;
- Enter opens the native `<details>` menu: PASS;
- Enter closes the menu: PASS.

### Tablet portrait — `820x1180`

- compact navigation contract active below `64rem`: PASS;
- desktop primary navigation hidden: PASS;
- Enter opens the mobile navigation: PASS.

### Desktop — `1366x768`

- mobile navigation hidden: PASS;
- sidebar primary navigation restored: PASS.

## Automated accessibility acceptance

Dedicated Axe workflow run `29788706252` completed successfully using Moodle's integrated accessibility Behat step.

Representative states:

- authenticated Site Home desktop: **PASS**;
- Dashboard desktop: **PASS**;
- phone navigation closed: **PASS**;
- phone navigation open: **PASS**;
- tablet navigation open: **PASS**.

This is automated Axe smoke testing and is not represented as a substitute for every assistive-technology or manual screen-reader test.

## Branding and CSP-oriented acceptance

Dedicated branding-security workflow run `29789505912` completed successfully.

The scenario configures the Edvorya primary colour as `#123456`, resets theme caches, loads the site through Chrome/Selenium, and verifies:

- `--edv-color-primary` resolves to `#123456` from the processed stylesheet: **PASS**;
- the former `#theme-edvorya-client-tokens` inline style element is absent from the DOM: **PASS**;
- ephemeral environment cleanup: **PASS**.

The theme now applies client colour overrides through Moodle's cached CSS post-processing callback. Administrator-uploaded branding SVG is no longer accepted by settings, and legacy uploaded SVG branding is rejected by the Edvorya pluginfile callback.

## Current gate result

- Moodle/MariaDB/Selenium startup: PASS
- PHP 8.3 verification: PASS
- MariaDB 10.11 verification: PASS
- `max_input_vars >= 5000`: PASS
- Behat environment initialization with Edvorya: PASS
- Assignment representative flow: PASS
- Quiz representative flow: PASS
- Forum representative flow: PASS
- H5P representative flow: PASS
- Moodle Book: PASS
- Moodle Page: PASS
- Moodle File / Resource: PASS
- Moodle Folder: PASS
- Moodle URL course integration: PASS
- Moodle Choice: PASS
- Moodle Database: PASS
- Moodle Glossary: PASS
- Moodle Lesson: PASS
- Moodle Wiki: PASS
- Moodle Workshop: PASS
- Moodle Feedback: PASS
- Google Drive `mod_videoplayer`: PASS
- Blocks/editing mode representative flow: PASS
- TinyMCE/File Picker dialogue: PASS
- Nested File Picker focus return: PASS
- TinyMCE File Picker upload: PASS
- Form autocomplete selection lifecycle: PASS
- Private messaging conversation: PASS
- Notification popover/preferences: PASS
- Phone responsive navigation: PASS
- Tablet responsive navigation: PASS
- Desktop sidebar navigation: PASS
- Keyboard Enter open/close of mobile navigation: PASS
- Localized navigation landmark labels: PASS
- Axe Site Home/Dashboard/mobile/tablet smoke tests: PASS
- Cached configurable branding CSS token: PASS
- Theme-owned inline client-token style removal: PASS
- Ephemeral environment cleanup: PASS

Overall result for the tested automated Chrome/Selenium surfaces: **PASS**.

## What remains environment-specific

The automated gates above are representative, not exhaustive proof for every possible Moodle configuration.

Remaining validation that cannot honestly be inferred from the current Linux Chrome/Selenium gates alone:

- true Safari/iPhone behavior in a Safari-capable environment;
- SCORM behavior with a representative real SCORM package;
- LTI behavior with a representative real or deterministic LTI provider.

The required Google Drive integration is already covered separately with the actual `mod_videoplayer` repository.

System-wide CSP compliance also depends on Moodle Core, installed plugins, and server policy. The Edvorya-specific inline client-token style has been removed, but this is not a claim of universal CSP compliance for an entire Moodle installation.
