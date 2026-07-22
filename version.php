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
 * Alpha.27 removes historical visual duplication from page-experiences.css.
 * That module now owns layout, grid, scrolling and responsive containment for
 * Dashboard, My courses and Course pages, while identity.css remains the final
 * Edvorya LMS visual composition layer. The refactor removes 133 obsolete CSS
 * lines without changing Moodle Core mechanics or the final product identity.
 *
 * @package    theme_edvorya
 * @copyright  2026 Elearning Cloud
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->component = 'theme_edvorya';
$plugin->version = 2026072127;
$plugin->requires = 2025041400; // Moodle 5.0.0.
$plugin->supported = [500, 502]; // Moodle 5.0 through Moodle 5.2, inclusive.
$plugin->maturity = MATURITY_ALPHA;
$plugin->release = '0.1.0-alpha.27';
