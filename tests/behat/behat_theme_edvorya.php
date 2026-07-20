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
}
