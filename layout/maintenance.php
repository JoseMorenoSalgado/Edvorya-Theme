<?php
// This file is part of Moodle - http://moodle.org/

/**
 * Maintenance layout.
 *
 * @package    theme_edvorya
 * @copyright  2026 Elearning Cloud
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$templatecontext = [
    'output' => $OUTPUT,
    'bodyattributes' => $OUTPUT->body_attributes(),
    'maincontent' => $OUTPUT->main_content(),
];

echo $OUTPUT->render_from_template('theme_edvorya/layout/maintenance', $templatecontext);
