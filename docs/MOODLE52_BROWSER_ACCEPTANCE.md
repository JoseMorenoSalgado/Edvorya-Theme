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

The automated gates above are representative, not exhaustive proof for every Moodle or third-party plugin surface.

Remaining validation that cannot honestly be inferred from Linux Chrome/Selenium alone:

- true Safari/iPhone behavior in a Safari-capable environment;
- representative third-party Moodle plugins using their actual repositories.

System-wide CSP compliance also depends on Moodle Core, installed plugins, and server policy. The Edvorya-specific inline client-token style has been removed, but this is not a claim of universal CSP compliance for an entire Moodle installation.
