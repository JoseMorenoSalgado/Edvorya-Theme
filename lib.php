<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

/**
 * Library callbacks for theme_edvorya.
 *
 * Keep this file limited to Moodle callbacks. Theme implementation code belongs in autoloaded classes.
 *
 * @package    theme_edvorya
 * @copyright  2026 Elearning Cloud
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Post-process the compiled Edvorya stylesheet with validated client colour tokens.
 *
 * Moodle caches the processed stylesheet. Theme settings reset theme caches through
 * theme_reset_all_caches(), so client colour changes are reflected without emitting
 * page-level inline style blocks.
 *
 * @param string $css Combined theme CSS.
 * @param \core\output\theme_config $theme Active Edvorya theme configuration.
 * @return string Processed CSS.
 */
function theme_edvorya_css_post_process(string $css, \core\output\theme_config $theme): string {
    $settingnames = [
        'primary',
        'secondary',
        'accent',
        'background',
        'foreground',
        'muted',
        'border',
        'sidebar',
        'topbar',
        'button',
        'link',
        'loginbackground',
    ];

    $declarations = [];
    foreach ($settingnames as $name) {
        $value = $theme->settings->{$name} ?? get_config('theme_edvorya', $name);
        if (!is_string($value)) {
            continue;
        }

        $value = trim($value);
        if (preg_match('/^#[0-9a-f]{6}$/i', $value) !== 1) {
            continue;
        }

        $declarations[] = '--edv-color-' . $name . ':' . strtolower($value);
    }

    if ($declarations === []) {
        return $css;
    }

    return $css . "\n:root{" . implode('', $declarations) . "}\n";
}

/**
 * Serve files uploaded through Edvorya theme settings.
 *
 * Branding assets are intentionally public because they are used on login and public-site pages.
 * Only known system-context file areas owned by theme_edvorya are served. SVG uploads are rejected
 * at serving time as an additional defence for sites upgraded from earlier alpha versions.
 *
 * @param stdClass $course Course object supplied by pluginfile.php.
 * @param stdClass|null $cm Course module object, if any.
 * @param context $context File context.
 * @param string $filearea Requested file area.
 * @param array $args Remaining file path arguments.
 * @param bool $forcedownload Whether the file must be downloaded.
 * @param array $options Additional file serving options.
 * @return bool
 */
function theme_edvorya_pluginfile(
    $course,
    $cm,
    $context,
    $filearea,
    $args,
    $forcedownload,
    array $options = []
) {
    if ($context->contextlevel !== CONTEXT_SYSTEM) {
        return false;
    }

    $allowedareas = [
        'logo',
        'logoalternate',
        'logodark',
        'favicon',
        'loginimage',
    ];

    if (!in_array($filearea, $allowedareas, true)) {
        return false;
    }

    $filename = $args === [] ? '' : (string) end($args);
    if (strtolower(pathinfo($filename, PATHINFO_EXTENSION)) === 'svg') {
        return false;
    }

    $theme = theme_config::load('edvorya');
    return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
}
