<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

/**
 * Theme settings.
 *
 * @package    theme_edvorya
 * @copyright  2026 Elearning Cloud
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $addsetting = static function($setting) use ($settings): void {
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    };

    $settings->add(new admin_setting_heading(
        'theme_edvorya/generalheading',
        get_string('generalsettings', 'theme_edvorya'),
        get_string('generalsettings_desc', 'theme_edvorya')
    ));

    $settings->add(new admin_setting_heading(
        'theme_edvorya/brandingheading',
        get_string('brandingheading', 'theme_edvorya'),
        get_string('brandingheading_desc', 'theme_edvorya')
    ));

    $addsetting(new admin_setting_configtext(
        'theme_edvorya/institutionname',
        get_string('institutionname', 'theme_edvorya'),
        get_string('institutionname_desc', 'theme_edvorya'),
        '',
        PARAM_TEXT
    ));

    $imageoptions = [
        'accepted_types' => ['.png', '.jpg', '.jpeg', '.webp'],
        'maxfiles' => 1,
    ];

    foreach (['logo', 'logoalternate', 'logodark'] as $filearea) {
        $addsetting(new admin_setting_configstoredfile(
            'theme_edvorya/' . $filearea,
            get_string($filearea, 'theme_edvorya'),
            get_string($filearea . '_desc', 'theme_edvorya'),
            $filearea,
            0,
            $imageoptions
        ));
    }

    $faviconoptions = [
        'accepted_types' => ['.ico', '.png'],
        'maxfiles' => 1,
    ];
    $addsetting(new admin_setting_configstoredfile(
        'theme_edvorya/favicon',
        get_string('favicon', 'theme_edvorya'),
        get_string('favicon_desc', 'theme_edvorya'),
        'favicon',
        0,
        $faviconoptions
    ));

    $settings->add(new admin_setting_heading(
        'theme_edvorya/colorsheading',
        get_string('colorsheading', 'theme_edvorya'),
        get_string('colorsheading_desc', 'theme_edvorya')
    ));

    $colours = [
        'primary' => '#2563eb',
        'secondary' => '#0f172a',
        'accent' => '#06b6d4',
        'background' => '#f8fafc',
        'foreground' => '#0f172a',
        'muted' => '#64748b',
        'border' => '#e2e8f0',
        'sidebar' => '#ffffff',
        'topbar' => '#ffffff',
        'button' => '#2563eb',
        'link' => '#2563eb',
        'loginbackground' => '#f8fafc',
    ];

    foreach ($colours as $name => $default) {
        $addsetting(new admin_setting_configcolourpicker(
            'theme_edvorya/' . $name,
            get_string($name, 'theme_edvorya'),
            get_string($name . '_desc', 'theme_edvorya'),
            $default
        ));
    }

    $settings->add(new admin_setting_heading(
        'theme_edvorya/loginheading',
        get_string('loginheading', 'theme_edvorya'),
        get_string('loginheading_desc', 'theme_edvorya')
    ));

    $addsetting(new admin_setting_configstoredfile(
        'theme_edvorya/loginimage',
        get_string('loginimage', 'theme_edvorya'),
        get_string('loginimage_desc', 'theme_edvorya'),
        'loginimage',
        0,
        $imageoptions
    ));

    $settings->add(new admin_setting_heading(
        'theme_edvorya/footerheading',
        get_string('footerheading', 'theme_edvorya'),
        get_string('footerheading_desc', 'theme_edvorya')
    ));

    $addsetting(new admin_setting_configtextarea(
        'theme_edvorya/footertext',
        get_string('footertext', 'theme_edvorya'),
        get_string('footertext_desc', 'theme_edvorya'),
        '',
        PARAM_TEXT
    ));

    $addsetting(new admin_setting_configtext(
        'theme_edvorya/copyright',
        get_string('copyright', 'theme_edvorya'),
        get_string('copyright_desc', 'theme_edvorya'),
        '',
        PARAM_TEXT
    ));

    foreach (['facebookurl', 'instagramurl', 'linkedinurl', 'youtubeurl'] as $settingname) {
        $addsetting(new admin_setting_configtext(
            'theme_edvorya/' . $settingname,
            get_string($settingname, 'theme_edvorya'),
            get_string($settingname . '_desc', 'theme_edvorya'),
            '',
            PARAM_URL
        ));
    }
}
