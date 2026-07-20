<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

/**
 * Primary Edvorya application layout.
 *
 * @package    theme_edvorya
 * @copyright  2026 Elearning Cloud
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$blockshtml = $OUTPUT->blocks('side-pre');
$addblockbutton = $OUTPUT->addblockbutton();
$hasblocks = strpos($blockshtml, 'data-block=') !== false || !empty($addblockbutton);

$corerenderer = $PAGE->get_renderer('core');
$primary = new \core\navigation\output\primary($PAGE);
$primarymenu = $primary->export_for_template($corerenderer);
$mobileprimarynav = $primarymenu['mobileprimarynav'] ?? false;

$secondarynavigation = false;
$overflow = false;
if ($PAGE->has_secondary_navigation()) {
    $tablistnav = $PAGE->has_tablist_secondary_navigation();
    $moremenu = new \core\navigation\output\more_menu($PAGE->secondarynav, 'nav-tabs', true, $tablistnav);
    $secondarynavigation = $moremenu->export_for_template($OUTPUT);

    $overflowdata = $PAGE->secondarynav->get_overflow_menu_data();
    if (!is_null($overflowdata)) {
        $selectmenu = new \core\output\select_menu(
            'tertiarynavigation',
            $overflowdata->urls,
            $overflowdata->selected,
        );
        $selectmenu->set_label($overflowdata->label, $overflowdata->labelattributes);
        $overflow = $selectmenu->export_for_template($OUTPUT);
    }
}

$buildregionmainsettings = !$PAGE->include_region_main_settings_in_header_actions()
    && !$PAGE->has_secondary_navigation();
$regionmainsettingsmenu = $buildregionmainsettings ? $OUTPUT->region_main_settings_menu() : false;
$headercontent = $PAGE->activityheader->export_for_template($corerenderer);
$branding = (new \theme_edvorya\output\branding())->export_for_template($OUTPUT);

$authenticated = isloggedin() && !isguestuser();
$bodyclasses = [$authenticated ? 'edv-context-authenticated' : 'edv-context-public'];

$templatecontext = [
    'output' => $OUTPUT,
    'bodyattributes' => $OUTPUT->body_attributes($bodyclasses),
    'branding' => $branding,
    'fullheader' => $OUTPUT->full_header(),
    'maincontent' => $OUTPUT->main_content(),
    'sidepreblocks' => $blockshtml,
    'hasblocks' => $hasblocks,
    'addblockbutton' => $addblockbutton,
    'primarymoremenu' => $primarymenu['moremenu'] ?? false,
    'mobileprimarynav' => $mobileprimarynav,
    'hasmobileprimarynav' => !empty($mobileprimarynav),
    'langmenu' => $primarymenu['lang'] ?? false,
    'usermenu' => $OUTPUT->user_menu(),
    'navbarpluginoutput' => $OUTPUT->navbar_plugin_output(),
    'editswitch' => $OUTPUT->edit_switch(),
    'pageheadingmenu' => $OUTPUT->page_heading_menu(),
    'secondarymoremenu' => $secondarynavigation,
    'overflow' => $overflow,
    'regionmainsettingsmenu' => $regionmainsettingsmenu,
    'hasregionmainsettingsmenu' => !empty($regionmainsettingsmenu),
    'headercontent' => $headercontent,
    'authenticated' => $authenticated,
];

echo $OUTPUT->render_from_template('theme_edvorya/layout/drawers', $templatecontext);
