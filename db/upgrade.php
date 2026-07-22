<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

/**
 * Upgrade steps for theme_edvorya.
 *
 * @package    theme_edvorya
 * @copyright  2026 Elearning Cloud
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Upgrade theme_edvorya.
 *
 * Legacy alpha installations may have persisted the original neutral palette
 * as explicit theme settings. Migrate only exact legacy defaults so real
 * institutional branding choices remain untouched.
 *
 * @param int $oldversion Installed plugin version.
 * @return bool
 */
function xmldb_theme_edvorya_upgrade($oldversion): bool {
    if ($oldversion < 2026072124) {
        $identitydefaults = [
            'background' => ['#f8fafc', '#ffffff'],
            'foreground' => ['#0f172a', '#020617'],
            'sidebar' => ['#ffffff', '#fafafa'],
        ];

        foreach ($identitydefaults as $name => [$legacy, $currentdefault]) {
            $current = get_config('theme_edvorya', $name);
            if (is_string($current) && strtolower(trim($current)) === $legacy) {
                set_config($name, $currentdefault, 'theme_edvorya');
            }
        }

        upgrade_plugin_savepoint(true, 2026072124, 'theme', 'edvorya');
    }

    return true;
}
