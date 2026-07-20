# Moodle 5.2 browser acceptance status

## Environment

The browser acceptance gate runs independently from Edvorya-LMS and its Vercel deployment workflow.

- Moodle branch: `MOODLE_502_STABLE`
- Theme: `theme_edvorya`
- Theme release under test: `0.1.0-alpha.3`
- Database: MariaDB 10.11
- PHP: 8.3
- Browser: Chrome through Moodle Docker Selenium
- Runner: GitHub-hosted `ubuntu-latest`
- Moodle test framework: official Moodle Behat infrastructure
- VPS used: no
- Edvorya-LMS repository used: no
- Vercel deployment triggered by this test: no

The environment is ephemeral and destroyed after every workflow run.

## Activity acceptance

Workflow run `29785856670` completed successfully.

Representative Moodle 5.2 scenarios executed with `theme_edvorya` forced as the active theme:

### Assignment

Scenario: `Submit a file and update the submission with another file`

Coverage includes opening an Assignment as a student, adding/editing a submission, uploading/renaming/deleting files through Moodle File Manager, saving changes, and rendering submission/grading status.

Result: **PASS**.

### Quiz

Scenario: `Review the quiz attempt`

Coverage includes opening a Quiz as a teacher, navigating to an existing attempt review, rendering the attempt summary and question review output, and returning to the attempt list.

Result: **PASS**.

### Forum

Scenario: `Confirm inpage replies work`

Coverage includes loading a Forum, using the JavaScript in-page reply flow, submitting a reply, rendering the new post, reloading, and confirming persistence.

Result: **PASS**.

### H5P

Scenario: `Add an h5pactivity to a course`

Coverage includes loading an H5P activity, rendering its description, entering the H5P player/content iframe stack, and validating configured H5P action visibility.

Result: **PASS**.

## Shared Core interaction acceptance

Workflow run `29786269521` completed successfully and re-ran the activity scenarios above together with the following shared interaction surfaces.

### Blocks and editing mode

Scenario: `Configuring the Text block with Javascript on`

Coverage includes logging in as administrator, enabling editing mode, adding/configuring a Text block, saving changes, and rendering the configured block content.

Result: **PASS**.

### TinyMCE and File Picker dialogue

Scenario: `Browsing repositories in the TinyMCE editor opens the image dialog and shows the FilePicker`

Coverage includes opening the TinyMCE image dialogue and launching the nested Moodle File Picker.

Result: **PASS**.

### Nested File Picker focus management

Scenario: `Focus returns to the correct location after closing a nested FilePicker`

Coverage includes opening TinyMCE, opening the nested File Picker, closing it with Escape, and verifying that keyboard focus returns to the Browse repositories control.

Result: **PASS**.

### TinyMCE file upload

Scenario: `Browsing repositories in the TinyMCE editor shows the FilePicker and upload url image`

Coverage includes opening TinyMCE, launching File Picker, uploading an image fixture, and rendering the image preview.

Result: **PASS**.

### Form autocomplete

Scenario: `Use autocomplete element which accepts a single value`

Coverage includes opening the autocomplete suggestions list, selecting a value, replacing the value, removing the selection, and rendering the empty selection state.

Result: **PASS**.

## Messaging and notification acceptance

Workflow run `29786702098` completed successfully and re-ran all preceding scenarios together with the following communication surfaces.

### Private messaging conversation

Scenario: `Send a message to a private conversation via contact tab`

Coverage includes opening Moodle messaging, navigating through Contacts, selecting a private conversation, sending a message, and verifying the rendered conversation output.

Result: **PASS**.

### Notification popover and preference behavior

Scenario: `User can disable notification preferences`

Coverage includes generating Assignment submission notifications, validating unread notification counts, opening the notification popover, and confirming notification visibility or absence according to user preferences.

Result: **PASS**.

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
- Aggregate browser gate: PASS
- Ephemeral environment cleanup: PASS

Overall result: **PASS**.

## What this validates

The current standalone theme can coexist with representative JavaScript-heavy Moodle 5.2 activity, Core interaction, messaging, and notification flows without requiring Boost or another parent theme.

The tested paths now provide representative browser evidence for:

- activity rendering/interactions;
- editing mode and block configuration;
- File Picker/File Manager upload flows;
- TinyMCE dialogues;
- nested modal focus restoration;
- autocomplete selection interaction;
- Moodle messaging conversation interaction;
- notification popover rendering and preference-sensitive notification visibility.

These are representative acceptance tests, not exhaustive proof for every Moodle feature or third-party plugin.

## Remaining acceptance areas

The remaining pre-merge acceptance work is now concentrated on:

- broader keyboard-only navigation beyond the tested nested File Picker focus path;
- automated accessibility smoke testing where supported by Moodle's Behat accessibility tooling;
- responsive viewport testing for phone and tablet layouts in Chrome/Selenium;
- true Safari/iPhone validation, which cannot be honestly represented by Linux Chrome emulation alone;
- representative third-party plugins.
