<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

/**
 * Embedded, popup, print, frame and redirect layout.
 *
 * @package    theme_edvorya
 * @copyright  2026 Elearning Cloud
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$branding = (new \theme_edvorya\output\branding())->export_for_template($OUTPUT);

$templatecontext = [
    'output' => $OUTPUT,
    'bodyattributes' => $OUTPUT->body_attributes(['edv-context-embedded']),
    'branding' => $branding,
    'maincontent' => $OUTPUT->main_content(),
];

echo $OUTPUT->render_from_template('theme_edvorya/layout/embedded', $templatecontext);
