<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

/**
 * Installation-safe maintenance layout.
 *
 * @package    theme_edvorya
 * @copyright  2026 Elearning Cloud
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$templatecontext = [
    // Do not pass a context here. During installation database tables may not exist yet.
    'sitename' => format_string($SITE->shortname, true, ['escape' => false]),
    'output' => $OUTPUT,
];

echo $OUTPUT->render_from_template('theme_edvorya/layout/maintenance', $templatecontext);
