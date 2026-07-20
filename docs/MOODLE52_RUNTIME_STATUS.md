# Moodle 5.2 runtime validation status

The phase-one Edvorya Theme foundation was validated in an isolated Moodle runtime on 20 July 2026.

## Environment

- Moodle branch: `MOODLE_502_STABLE`
- Database: MariaDB 10.11
- PHP: 8.3
- Theme repository: `JoseMorenoSalgado/Edvorya-Theme`
- Theme ref tested: `feature/theme-foundation`
- Active theme: `theme_edvorya`
- Parent theme dependency: none
- Web binding used by the temporary runtime: `127.0.0.1:18052`
- Database port exposed to the host: no

The runtime was ephemeral and its containers and volumes were destroyed after the validation completed.

## Installation and activation

PASS:

- Moodle 5.2 database installation completed with `theme_edvorya` already present in the codebase.
- Moodle accepted the plugin dependency check.
- `theme_edvorya` was selected as the active theme.
- Caches were purged after activation.
- A runtime test course was created successfully.
- Login rendered successfully and an authenticated administrator session was established.

## Moodle page smoke tests

All returned HTTP 200 without detected Moodle/PHP fatal-error markers:

- Site home
- Dashboard
- My Courses
- Course index
- Course view
- User profile
- Calendar
- Grades overview
- Administration
- Messaging

## Layout contract smoke tests

All declared Edvorya layout types rendered successfully with HTTP 200:

- `base`
- `standard`
- `course`
- `coursecategory`
- `incourse`
- `frontpage`
- `admin`
- `mycourses`
- `mydashboard`
- `mypublic`
- `login`
- `popup`
- `frametop`
- `embedded`
- `maintenance`
- `print`
- `redirect`
- `report`
- `secure`

## Scope and remaining gates

This validation confirms that the phase-one foundation can install and activate on Moodle 5.2 as a standalone theme and that its current layout contracts render in the tested MariaDB/PHP environment.

It does not yet replace browser-level regression testing for:

- Assignment, Quiz, Forum, and H5P interaction flows
- File Picker
- TinyMCE and other editor surfaces
- Core modal interaction
- Blocks while editing
- Notifications and messaging interaction details
- Keyboard-only navigation
- Focus management
- Screen-reader smoke testing
- iPhone Safari
- Android Chrome
- Tablet responsive behaviour
- Third-party plugins

The original CI harness used to access the existing VPS runner was temporary, remained isolated from the Edvorya-LMS application database, and was removed from active development after validation. Runtime testing for this theme must remain operationally separate from the Edvorya-LMS Vercel development workflow.