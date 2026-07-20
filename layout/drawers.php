<?php
// This file is part of Moodle - http://moodle.org/

/**
 * Primary Edvorya layout.
 *
 * @package    theme_edvorya
 * @copyright  2026 Elearning Cloud
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$hasblocks = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);

$templatecontext = [
    'output' => $OUTPUT,
    'bodyattributes' => $OUTPUT->body_attributes(),
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID)]),
    'fullheader' => $OUTPUT->full_header(),
    'maincontent' => $OUTPUT->main_content(),
    'sidepreblocks' => $hasblocks ? $OUTPUT->blocks('side-pre') : '',
    'hasblocks' => $hasblocks,
];

echo $OUTPUT->render_from_template('theme_edvorya/layout/drawers', $templatecontext);
