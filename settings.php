<?php
// This file is part of Moodle - http://moodle.org/

/**
 * Theme settings.
 *
 * @package    theme_edvorya
 * @copyright  2026 Elearning Cloud
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_heading(
        'theme_edvorya/generalheading',
        get_string('generalsettings', 'theme_edvorya'),
        get_string('generalsettings_desc', 'theme_edvorya')
    ));
}
