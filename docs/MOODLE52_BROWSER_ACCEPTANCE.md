# Moodle 5.2 browser acceptance status

## Environment

The activity acceptance gate runs independently from Edvorya-LMS and its Vercel deployment workflow.

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

The environment is ephemeral and destroyed after the workflow run.

## Activity acceptance result

Workflow run `29785856670` completed successfully after the Behat harness was corrected and the faildump volume was made writable.

Representative Moodle 5.2 scenarios executed with `theme_edvorya` forced as the active theme:

### Assignment

Scenario:

`Submit a file and update the submission with another file`

Coverage includes:

- opening an Assignment as a student;
- adding a submission;
- using the Moodle File Manager to upload a file;
- saving the submission;
- editing an existing submission;
- uploading an additional file;
- renaming an uploaded file through a Moodle dialogue;
- deleting an uploaded file;
- verifying submission and grading status output.

Result: **PASS**.

### Quiz

Scenario:

`Review the quiz attempt`

Coverage includes:

- opening a Quiz as a teacher;
- navigating to an existing attempt review;
- rendering the attempt summary table;
- rendering question review output;
- finishing the review and returning to the attempt list.

Result: **PASS**.

### Forum

Scenario:

`Confirm inpage replies work`

Coverage includes:

- loading a course containing a Forum;
- using the JavaScript in-page reply flow;
- submitting a reply;
- rendering the new post;
- reloading the page and confirming persistence.

Result: **PASS**.

### H5P

Scenario:

`Add an h5pactivity to a course`

Coverage includes:

- creating/loading an H5P activity;
- rendering the activity description;
- entering the H5P player iframe;
- entering the nested H5P content iframe;
- confirming H5P content is visible and interactive enough for Behat to traverse the iframe stack;
- validating configured H5P action visibility.

Result: **PASS**.

## Gate result

- Moodle/MariaDB/Selenium startup: PASS
- PHP 8.3 verification: PASS
- MariaDB 10.11 verification: PASS
- `max_input_vars >= 5000`: PASS
- Behat environment initialization with Edvorya: PASS
- Assignment representative flow: PASS
- Quiz representative flow: PASS
- Forum representative flow: PASS
- H5P representative flow: PASS
- Ephemeral environment cleanup: PASS

Overall result: **PASS**.

## What this validates

This gate demonstrates that the current standalone theme can coexist with representative JavaScript-heavy Moodle 5.2 activity flows without requiring Boost or another parent theme.

It specifically validates the tested paths only. It is not evidence that every feature of Assignment, Quiz, Forum, H5P, or every third-party plugin has been exhaustively tested.

## Remaining acceptance areas

The next browser-level acceptance block covers shared Moodle interaction surfaces that are broader than the four activity scenarios above:

- blocks with editing mode enabled;
- File Picker/File Manager outside the Assignment scenario;
- TinyMCE/editor interaction;
- autocomplete/tags keyboard interaction;
- Core modal/dropdown focus and placement;
- notifications and messaging;
- responsive/mobile and accessibility-specific testing;
- representative third-party plugins.
