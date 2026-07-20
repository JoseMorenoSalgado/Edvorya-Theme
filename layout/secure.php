<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

/**
 * Secure and safe-browser layout.
 *
 * @package    theme_edvorya
 * @copyright  2026 Elearning Cloud
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$blockshtml = $OUTPUT->blocks('side-pre');
$hasblocks = strpos($blockshtml, 'data-block=') !== false;
$corerenderer = $PAGE->get_renderer('core');
$headercontent = $PAGE->activityheader->export_for_template($corerenderer);
$branding = (new \theme_edvorya\output\branding())->export_for_template($OUTPUT);

$templatecontext = [
    'output' => $OUTPUT,
    'bodyattributes' => $OUTPUT->body_attributes(['edv-context-secure']),
    'branding' => $branding,
    'fullheader' => $OUTPUT->full_header(),
    'maincontent' => $OUTPUT->main_content(),
    'sidepreblocks' => $blockshtml,
    'hasblocks' => $hasblocks,
    'headercontent' => $headercontent,
];

echo $OUTPUT->render_from_template('theme_edvorya/layout/secure', $templatecontext);
