<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

/**
 * Behat steps specific to theme_edvorya.
 *
 * @package    theme_edvorya
 * @category   test
 * @copyright  2026 Elearning Cloud
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../lib/behat/behat_base.php');

use Behat\Mink\Exception\DriverException;

/**
 * Theme-specific browser acceptance steps.
 */
class behat_theme_edvorya extends behat_base {
    /**
     * Set an exact browser viewport size.
     *
     * @Given /^I set the Edvorya viewport to "(?P<width>\d+)x(?P<height>\d+)"$/
     * @param int $width Viewport width in CSS pixels.
     * @param int $height Viewport height in CSS pixels.
     */
    public function i_set_the_edvorya_viewport_to(int $width, int $height): void {
        if (!$this->running_javascript()) {
            throw new DriverException('Exact viewport sizing requires a JavaScript-capable browser session.');
        }

        $this->getSession()->resizeWindow($width, $height);
        $this->getSession()->wait(250);
    }

    /**
     * Toggle the native mobile navigation disclosure using the keyboard.
     *
     * @When /^I toggle the Edvorya mobile navigation with the keyboard$/
     */
    public function i_toggle_the_edvorya_mobile_navigation_with_the_keyboard(): void {
        if (!$this->running_javascript()) {
            throw new DriverException('Keyboard interaction requires a JavaScript-capable browser session.');
        }

        $toggle = $this->find('css', '.edv-mobile-nav__toggle');
        $this->execute_js_on_node($toggle, '{{ELEMENT}}.focus();');
        self::type_keys($this->getSession(), [behat_keys::ENTER]);
        $this->getSession()->wait(250);
    }

    /**
     * Configure the Edvorya primary colour and invalidate cached theme CSS.
     *
     * @Given /^I set the Edvorya primary colour to "(?P<colour>#[0-9a-fA-F]{6})"$/
     * @param string $colour Valid six-digit hexadecimal colour.
     */
    public function i_set_the_edvorya_primary_colour_to(string $colour): void {
        if (preg_match('/^#[0-9a-f]{6}$/i', $colour) !== 1) {
            throw new \InvalidArgumentException('Edvorya test colours must use six-digit hexadecimal notation.');
        }

        set_config('primary', strtolower($colour), 'theme_edvorya');
        theme_reset_all_caches();
    }

    /**
     * Assert a CSS custom property on the document root.
     *
     * @Then /^the Edvorya CSS variable "(?P<variable>--[a-z0-9-]+)" should equal "(?P<value>#[0-9a-fA-F]{6})"$/
     * @param string $variable CSS custom-property name.
     * @param string $value Expected six-digit hexadecimal colour.
     */
    public function the_edvorya_css_variable_should_equal(string $variable, string $value): void {
        if (!$this->running_javascript()) {
            throw new DriverException('CSS variable assertions require a JavaScript-capable browser session.');
        }

        $script = sprintf(
            'return window.getComputedStyle(document.documentElement).getPropertyValue(%s).trim();',
            json_encode($variable, JSON_THROW_ON_ERROR)
        );
        $actual = (string) $this->getSession()->evaluateScript($script);

        if (strtolower($actual) !== strtolower($value)) {
            throw new \RuntimeException(sprintf(
                'Expected CSS variable %s to equal %s, but found %s.',
                $variable,
                $value,
                $actual === '' ? '[empty]' : $actual
            ));
        }
    }

    /**
     * Create a deterministic Drive Resource fixture through Moodle's module creation API.
     *
     * Drive Resource does not currently ship tests/generator/lib.php, so this compatibility
     * fixture follows the same add_moduleinfo() path used by Moodle's generic module generator
     * while supplying the standard course-module defaults explicitly.
     *
     * @Given /^I create an Edvorya Drive Resource named "(?P<name>[^"]+)" in course "(?P<shortname>[^"]+)"$/
     * @param string $name Activity name.
     * @param string $shortname Course shortname.
     */
    public function i_create_an_edvorya_drive_resource_named_in_course(string $name, string $shortname): void {
        global $CFG, $DB;

        require_once($CFG->dirroot . '/course/modlib.php');

        if (!\core_component::get_component_directory('mod_videoplayer')) {
            throw new \RuntimeException('mod_videoplayer must be installed before creating the compatibility fixture.');
        }

        $course = $DB->get_record('course', ['shortname' => $shortname], '*', MUST_EXIST);
        $moduleid = $DB->get_field('modules', 'id', ['name' => 'videoplayer'], MUST_EXIST);

        $moduleinfo = (object) [
            'course' => $course->id,
            'modulename' => 'videoplayer',
            'module' => $moduleid,
            'section' => 1,
            'visible' => 1,
            'visibleoncoursepage' => 1,
            'cmidnumber' => '',
            'groupmode' => 0,
            'groupingid' => 0,
            'availability' => null,
            'completion' => 0,
            'completionview' => 0,
            'completionexpected' => 0,
            'completionpassgrade' => 0,
            'conditiongradegroup' => [],
            'conditionfieldgroup' => [],
            'conditioncompletiongroup' => [],
            'showdescription' => 0,
            'name' => $name,
            'intro' => 'Drive Resource compatibility fixture for the standalone Edvorya theme.',
            'introformat' => FORMAT_HTML,
            'source' => 'googledrive',
            'videourl' => 'https://drive.google.com/file/d/edvoryaThemeCompatibility123/view',
            'type' => 'file',
            'displaymode' => 'standard',
            'disabledownload' => 1,
            'disablecontextmenu' => 1,
            'enablewatermark' => 0,
            'enablegamification' => 0,
            'pointsperpage' => 1,
            'completionpercentage' => 80,
        ];

        add_moduleinfo($moduleinfo, $course);
    }

    /**
     * Assert that a rendered element does not overflow the horizontal viewport.
     *
     * @Then /^the Edvorya element "(?P<selector>[^"]+)" should fit within the viewport horizontally$/
     * @param string $selector CSS selector.
     */
    public function the_edvorya_element_should_fit_within_the_viewport_horizontally(string $selector): void {
        if (!$this->running_javascript()) {
            throw new DriverException('Viewport geometry assertions require a JavaScript-capable browser session.');
        }

        $script = sprintf(
            <<<'JS'
return (function() {
    const element = document.querySelector(%s);
    if (!element) {
        return 'missing';
    }
    const rect = element.getBoundingClientRect();
    const viewport = document.documentElement.clientWidth;
    if (rect.left >= -1 && rect.right <= viewport + 1) {
        return 'ok';
    }
    return `${rect.left},${rect.right},${viewport}`;
})();
JS,
            json_encode($selector, JSON_THROW_ON_ERROR)
        );
        $result = (string) $this->getSession()->evaluateScript($script);

        if ($result !== 'ok') {
            throw new \RuntimeException(sprintf(
                'Expected element %s to fit within the horizontal viewport, geometry result: %s.',
                $selector,
                $result
            ));
        }
    }
}
