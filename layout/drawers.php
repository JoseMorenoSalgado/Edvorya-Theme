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

// Decorate Moodle-owned navigation data with lightweight Edvorya presentation metadata.
// Keys come from Core navigation nodes, so icon selection remains stable across languages.
$decoratemobilenav = function(array $items) use (&$decoratemobilenav, $OUTPUT): array {
    foreach ($items as &$item) {
        if (is_object($item)) {
            $item = (array) $item;
        }

        if (!empty($item['divider'])) {
            continue;
        }

        $key = strtolower((string) ($item['key'] ?? ''));
        $icon = 'link';

        if ($key === 'myhome' || str_contains($key, 'dashboard')) {
            $icon = 'layout-dashboard';
        } else if ($key === 'home' || str_contains($key, 'sitehome')) {
            $icon = 'home';
        } else if ($key === 'mycourses' || str_contains($key, 'course')) {
            $icon = 'book-open';
        } else if ($key === 'siteadminnode' || str_contains($key, 'admin') || str_contains($key, 'setting')) {
            $icon = 'settings';
        }

        $item['edvkey'] = preg_replace('/[^a-z0-9_-]+/', '-', $key ?: 'custom');
        $item['edviconhtml'] = $OUTPUT->pix_icon(
            'icons/' . $icon,
            '',
            'theme_edvorya',
            ['class' => 'edv-mobile-nav__item-icon-svg']
        );

        if (!empty($item['children']) && is_array($item['children'])) {
            $item['children'] = $decoratemobilenav($item['children']);
        }
    }
    unset($item);

    return $items;
};

if (is_array($mobileprimarynav) && !empty($mobileprimarynav)) {
    $mobileprimarynav = $decoratemobilenav($mobileprimarynav);
}

// The same Moodle-owned navigation model powers the desktop sidebar. This avoids a
// second navigation query and keeps mobile/desktop URLs and active states identical.
$desktopprimarynav = is_array($mobileprimarynav) ? $mobileprimarynav : [];

$isadminsearch = $PAGE->pagetype === 'admin-search';
$secondarynavigation = false;
$contextnavigationitems = [];
$contextnavigationcurrent = '';
$adminnavigationitems = [];
$overflow = false;

if ($PAGE->has_secondary_navigation()) {
    $tablistnav = $PAGE->has_tablist_secondary_navigation();
    $moremenu = new \core\navigation\output\more_menu($PAGE->secondarynav, 'nav-tabs', true, $tablistnav);
    $secondarynavigation = $moremenu->export_for_template($OUTPUT);

    // Build a lightweight mobile representation from the same Core navigation tree.
    // On small screens this replaces the full horizontal tab bar with one compact
    // disclosure, preventing primary and secondary navigation from competing visually.
    foreach ($PAGE->secondarynav->children as $node) {
        if (isset($node->display) && !$node->display) {
            continue;
        }

        $action = $node->action();
        if (empty($action)) {
            continue;
        }

        $url = $action instanceof \moodle_url ? $action->out(false) : (string) $action;
        if ($url === '') {
            continue;
        }

        $text = (string) $node->get_title();
        $isactive = !empty($node->isactive);
        $contextnavigationitems[] = [
            'text' => $text,
            'url' => $url,
            'isactive' => $isactive,
        ];

        if ($isactive) {
            $contextnavigationcurrent = $text;
        }
    }

    if ($contextnavigationcurrent === '' && !empty($contextnavigationitems)) {
        $contextnavigationcurrent = $contextnavigationitems[0]['text'];
    }

    // Moodle's site-administration landing page is a special tab contract. Core
    // intentionally gives these nodes an anchor target instead of a URL and expects
    // Bootstrap's tab plugin to switch the matching #link... panel without reloading.
    // Export that contract explicitly so Edvorya can style it without replacing it.
    if ($isadminsearch && $tablistnav) {
        $hasactiveadmintab = false;

        foreach ($PAGE->secondarynav->children as $node) {
            if (isset($node->display) && !$node->display) {
                continue;
            }

            $tab = isset($node->tab) ? (string) $node->tab : '';
            if ($tab === '' || !str_starts_with($tab, '#link')) {
                continue;
            }

            $key = strtolower((string) ($node->key ?? 'admin'));
            $icon = 'settings';

            if (str_contains($key, 'user')) {
                $icon = 'users';
            } else if (str_contains($key, 'course')) {
                $icon = 'book-open';
            } else if (str_contains($key, 'grade')) {
                $icon = 'graduation-cap';
            } else if (str_contains($key, 'plugin')) {
                $icon = 'link';
            } else if (str_contains($key, 'appearance')) {
                $icon = 'palette';
            } else if (str_contains($key, 'server')) {
                $icon = 'server';
            } else if (str_contains($key, 'report')) {
                $icon = 'chart-column';
            } else if (str_contains($key, 'develop')) {
                $icon = 'code-2';
            }

            $isactive = !empty($node->isactive) && !$hasactiveadmintab;
            if ($isactive) {
                $hasactiveadmintab = true;
            }

            $adminnavigationitems[] = [
                'key' => preg_replace('/[^a-z0-9_-]+/', '-', $key ?: 'admin'),
                'text' => (string) $node->get_title(),
                'tab' => $tab,
                'panelid' => ltrim($tab, '#'),
                'isactive' => $isactive,
                'edviconhtml' => $OUTPUT->pix_icon(
                    'icons/' . $icon,
                    '',
                    'theme_edvorya',
                    ['class' => 'edv-admin-tabs__icon-svg']
                ),
            ];
        }

        // Core's settings_link_page marks the first panel active on initial render.
        // Mirror that state if the navigation tree does not expose an active tab yet.
        if (!$hasactiveadmintab && !empty($adminnavigationitems)) {
            $adminnavigationitems[0]['isactive'] = true;
        }
    }

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

// Add stable Edvorya-owned context classes without depending on Core body-class naming conventions.
// These classes are presentation hooks only and do not replace Moodle's own page layout or page type data.
$layoutclass = preg_replace('/[^a-z0-9_-]+/', '-', strtolower((string) $PAGE->pagelayout));
if ($layoutclass !== '') {
    $bodyclasses[] = 'edv-layout-' . trim($layoutclass, '-');
}

$pagetypeclass = preg_replace('/[^a-z0-9_-]+/', '-', strtolower((string) $PAGE->pagetype));
if ($pagetypeclass !== '') {
    $bodyclasses[] = 'edv-pagetype-' . trim($pagetypeclass, '-');
}

// Expose a presentation-only teacher workspace context for the current course.
// Core grants moodle/grade:viewall to both teacher and editingteacher archetypes, so
// this capability represents the broader teaching workspace without giving the user
// editing privileges they do not already possess. No custom SQL or analytics are added.
if ($authenticated && !empty($PAGE->course->id) && (int) $PAGE->course->id !== SITEID) {
    $coursecontext = \context_course::instance((int) $PAGE->course->id, IGNORE_MISSING);
    if ($coursecontext && has_capability('moodle/grade:viewall', $coursecontext)) {
        $bodyclasses[] = 'edv-course-role-teacher';
    }
}

// The dashboard focus layer adds intent and hierarchy only. Moodle Core remains
// responsible for all actual course, completion, timeline and calendar data.
$dashboardexperience = [];
if ($authenticated && $PAGE->pagelayout === 'mydashboard') {
    $dashboardexperience = (new \theme_edvorya\output\dashboard_experience())->export_for_template($OUTPUT);
    if (!empty($dashboardexperience['persona'])) {
        $bodyclasses[] = 'edv-dashboard-persona-' . $dashboardexperience['persona'];
    }
}

$hasadminnavigation = !empty($adminnavigationitems);

// Site administration uses the dedicated Core-compatible tab representation above.
// Other phone/tablet contexts may use the compact disclosure when real URLs exist.
$hascontextnavigation = !$isadminsearch && count($contextnavigationitems) > 1;

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
    'desktopprimarynav' => $desktopprimarynav,
    'hasdesktopprimarynav' => !empty($desktopprimarynav),
    'langmenu' => $primarymenu['lang'] ?? false,
    'usermenu' => $OUTPUT->user_menu(),
    'navbarpluginoutput' => $OUTPUT->navbar_plugin_output(),
    'editswitch' => $OUTPUT->edit_switch(),
    'pageheadingmenu' => $OUTPUT->page_heading_menu(),
    'secondarymoremenu' => $secondarynavigation,
    'contextnavigationitems' => $contextnavigationitems,
    'contextnavigationcurrent' => $contextnavigationcurrent,
    'hascontextnavigation' => $hascontextnavigation,
    'adminnavigationitems' => $adminnavigationitems,
    'hasadminnavigation' => $hasadminnavigation,
    'isadminsearch' => $isadminsearch,
    'overflow' => $overflow,
    'regionmainsettingsmenu' => $regionmainsettingsmenu,
    'hasregionmainsettingsmenu' => !empty($regionmainsettingsmenu),
    'headercontent' => $headercontent,
    'authenticated' => $authenticated,
    'dashboardexperience' => $dashboardexperience,
];

echo $OUTPUT->render_from_template('theme_edvorya/layout/drawers', $templatecontext);
