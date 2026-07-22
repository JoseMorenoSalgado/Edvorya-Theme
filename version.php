<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

/**
 * Version details for theme_edvorya.
 *
 * Alpha.23 fixes the student dashboard render regression found by the Moodle
 * 5.0-5.2 compatibility matrix. Moodle Core may return false from
 * get_user_capability_course() when no matching teacher capability course
 * exists; the result is now normalised before count()/reset(). Alpha.22's
 * teacher workspace and Participants page-type corrections remain intact.
 *
 * @package    theme_edvorya
 * @copyright  2026 Elearning Cloud
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->component = 'theme_edvorya';
$plugin->version = 2026072123;
$plugin->requires = 2025041400; // Moodle 5.0.0.
$plugin->supported = [500, 502]; // Moodle 5.0 through Moodle 5.2, inclusive.
$plugin->maturity = MATURITY_ALPHA;
$plugin->release = '0.1.0-alpha.23';
