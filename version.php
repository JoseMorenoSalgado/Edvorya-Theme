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
 * Alpha.21 refines the capability-aware teacher workflow introduced in
 * alpha.20. Teacher dashboard routing now distinguishes a single manageable
 * course from multiple courses with a bounded two-course lookup, avoiding an
 * arbitrary course being presented as the teacher's highest-priority target.
 * Moodle Core data, permissions and Boost interaction mechanics remain intact.
 *
 * @package    theme_edvorya
 * @copyright  2026 Elearning Cloud
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->component = 'theme_edvorya';
$plugin->version = 2026072121;
$plugin->requires = 2025041400; // Moodle 5.0.0.
$plugin->supported = [500, 502]; // Moodle 5.0 through Moodle 5.2, inclusive.
$plugin->maturity = MATURITY_ALPHA;
$plugin->release = '0.1.0-alpha.21';
