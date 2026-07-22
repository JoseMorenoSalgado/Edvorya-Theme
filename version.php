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
 * Alpha.30 restores Moodle Core site-administration category navigation on
 * phone/tablet layouts and refines the administration directory for real mobile
 * use. Core secondary navigation remains visible whenever Edvorya cannot safely
 * replace it with its compact context disclosure. Tablet topbar controls are
 * compacted without reducing touch targets, and administration category/link
 * surfaces now adapt through the full drawer breakpoint up to 1024px.
 *
 * @package    theme_edvorya
 * @copyright  2026 Elearning Cloud
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->component = 'theme_edvorya';
$plugin->version = 2026072130;
$plugin->requires = 2025041400; // Moodle 5.0.0.
$plugin->supported = [500, 502]; // Moodle 5.0 through Moodle 5.2, inclusive.
$plugin->maturity = MATURITY_ALPHA;
$plugin->release = '0.1.0-alpha.30';
