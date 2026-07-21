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
     * Inject representative Moodle-shaped markup for transversal Design System acceptance.
     *
     * This fixture exists only inside the Behat browser session. It does not add a production
     * route or renderer and deliberately uses classes emitted by Moodle Core.
     *
     * @Given /^I inject the Edvorya design system fixture$/
     */
    public function i_inject_the_edvorya_design_system_fixture(): void {
        if (!$this->running_javascript()) {
            throw new DriverException('Design System fixture injection requires a JavaScript-capable browser session.');
        }

        $script = <<<'JS'
(function() {
    const host = document.querySelector('#region-main') || document.querySelector('.edv-content') || document.body;
    const existing = document.querySelector('#edv-design-system-fixture');
    if (existing) {
        existing.remove();
    }

    const fixture = document.createElement('section');
    fixture.id = 'edv-design-system-fixture';
    fixture.setAttribute('aria-labelledby', 'edv-design-system-heading');
    fixture.innerHTML = `
        <div class="card">
            <div class="card-header">
                <h2 id="edv-design-system-heading" class="card-title">Edvorya Design System</h2>
            </div>
            <div class="card-body">
                <div id="edv-button-fixture">
                    <button type="button" class="btn btn-primary">Primary action</button>
                    <button type="button" class="btn btn-secondary">Secondary action</button>
                    <button type="button" class="btn btn-danger">Danger action</button>
                    <button type="button" class="btn btn-outline-primary">Outline action</button>
                    <button type="button" class="btn btn-secondary" disabled>Disabled action</button>
                </div>

                <div id="edv-form-fixture">
                    <label class="form-label" for="edv-test-name">Name</label>
                    <input id="edv-test-name" class="form-control" type="text" placeholder="Learner name">
                    <label class="form-label" for="edv-test-select">Course</label>
                    <select id="edv-test-select" class="form-select">
                        <option>Edvorya Course</option>
                    </select>
                    <label class="form-label" for="edv-test-notes">Notes</label>
                    <textarea id="edv-test-notes" class="form-control">Accessible fixture content</textarea>
                    <div class="form-check">
                        <input id="edv-test-check" class="form-check-input" type="checkbox">
                        <label class="form-check-label" for="edv-test-check">Enable learning reminder</label>
                    </div>
                    <label class="form-label" for="edv-test-invalid">Required field</label>
                    <input id="edv-test-invalid" class="form-control is-invalid" type="text" aria-invalid="true" aria-describedby="edv-test-invalid-feedback">
                    <div id="edv-test-invalid-feedback" class="invalid-feedback">This field is required.</div>
                </div>

                <div id="edv-status-fixture">
                    <div class="alert alert-success" role="status">Learning progress saved successfully.</div>
                    <div class="alert alert-warning" role="status">A due date is approaching.</div>
                    <span class="badge bg-primary">In progress</span>
                    <span class="badge bg-success rounded-pill">Completed</span>
                </div>

                <div class="table-responsive" id="edv-table-fixture">
                    <table class="table table-striped table-hover" style="min-width: 48rem">
                        <caption>Representative responsive Moodle table</caption>
                        <thead>
                            <tr><th scope="col">Course</th><th scope="col">Activity</th><th scope="col">Status</th><th scope="col">Due date</th><th scope="col">Grade</th><th scope="col">Feedback</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>Edvorya Course</td><td>Assignment</td><td>Submitted</td><td>2026-07-30</td><td>95</td><td>Excellent work</td></tr>
                        </tbody>
                    </table>
                </div>

                <div class="progress" id="edv-progress-fixture" aria-label="Course progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%"></div>
                </div>
            </div>
            <div class="card-footer">Reusable Moodle-compatible Edvorya surface</div>
        </div>`;

    host.prepend(fixture);
})();
JS;
        $this->getSession()->executeScript($script);
        $this->getSession()->wait(100);
    }

    /**
     * Inject a representative visible modal for standalone overlay acceptance.
     *
     * @Given /^I inject the Edvorya modal fixture$/
     */
    public function i_inject_the_edvorya_modal_fixture(): void {
        if (!$this->running_javascript()) {
            throw new DriverException('Modal fixture injection requires a JavaScript-capable browser session.');
        }

        $script = <<<'JS'
(function() {
    const existing = document.querySelector('#edv-modal-fixture');
    if (existing) {
        existing.remove();
    }

    const modal = document.createElement('div');
    modal.id = 'edv-modal-fixture';
    modal.className = 'modal show';
    modal.setAttribute('role', 'dialog');
    modal.setAttribute('aria-modal', 'true');
    modal.setAttribute('aria-labelledby', 'edv-modal-title');
    modal.innerHTML = `
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 id="edv-modal-title" class="modal-title">Edvorya modal</h2>
                    <button type="button" class="btn-close" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Representative Moodle modal content.</p>
                    <label class="form-label" for="edv-modal-input">Comment</label>
                    <input id="edv-modal-input" class="form-control" type="text">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary">Cancel</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>`;
    document.body.append(modal);
})();
JS;
        $this->getSession()->executeScript($script);
        $this->getSession()->wait(100);
    }

    /**
     * Assert that an element meets a minimum rendered height.
     *
     * @Then /^the Edvorya element "(?P<selector>[^"]+)" should have a minimum height of "(?P<height>\d+)" pixels$/
     * @param string $selector CSS selector.
     * @param int $height Minimum rendered height.
     */
    public function the_edvorya_element_should_have_a_minimum_height_of_pixels(string $selector, int $height): void {
        if (!$this->running_javascript()) {
            throw new DriverException('Rendered size assertions require a JavaScript-capable browser session.');
        }

        $script = sprintf(
            'const element = document.querySelector(%s); return element ? element.getBoundingClientRect().height : -1;',
            json_encode($selector, JSON_THROW_ON_ERROR)
        );
        $actual = (float) $this->getSession()->evaluateScript($script);

        if ($actual < $height) {
            throw new \RuntimeException(sprintf(
                'Expected element %s to have a minimum height of %d pixels, but found %.2f.',
                $selector,
                $height,
                $actual
            ));
        }
    }

    /**
     * Assert that an element contains horizontal overflow internally while staying viewport-safe.
     *
     * @Then /^the Edvorya element "(?P<selector>[^"]+)" should contain horizontal overflow internally$/
     * @param string $selector CSS selector.
     */
    public function the_edvorya_element_should_contain_horizontal_overflow_internally(string $selector): void {
        if (!$this->running_javascript()) {
            throw new DriverException('Overflow assertions require a JavaScript-capable browser session.');
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
    const contained = rect.left >= -1 && rect.right <= viewport + 1;
    const scrollable = element.scrollWidth > element.clientWidth + 1;
    return contained && scrollable ? 'ok' : `${rect.left},${rect.right},${viewport},${element.clientWidth},${element.scrollWidth}`;
})();
JS,
            json_encode($selector, JSON_THROW_ON_ERROR)
        );
        $result = (string) $this->getSession()->evaluateScript($script);

        if ($result !== 'ok') {
            throw new \RuntimeException(sprintf(
                'Expected element %s to contain horizontal overflow internally, geometry result: %s.',
                $selector,
                $result
            ));
        }
    }

    /**
     * Assert that the document itself has no horizontal overflow.
     *
     * @Then /^the Edvorya page should not have horizontal overflow$/
     */
    public function the_edvorya_page_should_not_have_horizontal_overflow(): void {
        if (!$this->running_javascript()) {
            throw new DriverException('Page overflow assertions require a JavaScript-capable browser session.');
        }

        $result = (string) $this->getSession()->evaluateScript(
            'return document.documentElement.scrollWidth <= document.documentElement.clientWidth + 1 ? "ok" : `${document.documentElement.clientWidth},${document.documentElement.scrollWidth}`;'
        );

        if ($result !== 'ok') {
            throw new \RuntimeException('Expected the Edvorya page to avoid horizontal overflow, geometry result: ' . $result . '.');
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
     * Create representative fixtures for activity/resource plugins bundled with Moodle 5.2.
     *
     * The fixtures use Moodle's own plugin testing generators. The URL resource is created so
     * its course-page integration can be asserted without navigating away from the test site.
     * SCORM and LTI are intentionally excluded because meaningful acceptance requires an actual
     * SCORM package or LTI provider rather than a synthetic empty instance.
     *
     * @Given /^I create Edvorya Moodle bundled activity fixtures in course "(?P<shortname>[^"]+)"$/
     * @param string $shortname Course shortname.
     */
    public function i_create_edvorya_moodle_bundled_activity_fixtures(string $shortname): void {
        global $DB, $USER;

        $course = $DB->get_record('course', ['shortname' => $shortname], '*', MUST_EXIST);
        $datagenerator = \testing_util::get_data_generator();
        $previoususer = $USER;
        $admin = get_admin();
        \core\session\manager::set_user($admin);

        try {
            $common = [
                'course' => $course->id,
                'section' => 1,
                'visible' => 1,
            ];

            $pagegenerator = $datagenerator->get_plugin_generator('mod_page');
            $pagegenerator->create_instance($common + [
                'name' => 'Moodle Page',
                'content' => '<p>Edvorya bundled Page compatibility content.</p>',
                'contentformat' => FORMAT_HTML,
            ]);

            $resourcegenerator = $datagenerator->get_plugin_generator('mod_resource');
            $resourcegenerator->create_instance($common + [
                'name' => 'Moodle File',
                'defaultfilename' => 'edvorya-moodle-file.txt',
                'display' => 1,
            ]);

            $foldergenerator = $datagenerator->get_plugin_generator('mod_folder');
            $foldergenerator->create_instance($common + [
                'name' => 'Moodle Folder',
                'showexpanded' => 1,
            ]);

            $urlgenerator = $datagenerator->get_plugin_generator('mod_url');
            $urlgenerator->create_instance($common + [
                'name' => 'Moodle URL',
                'externalurl' => 'https://moodle.org/',
            ]);

            $choicegenerator = $datagenerator->get_plugin_generator('mod_choice');
            $choicegenerator->create_instance($common + [
                'name' => 'Moodle Choice',
            ]);

            $databasenerator = $datagenerator->get_plugin_generator('mod_data');
            $databasenerator->create_instance($common + [
                'name' => 'Moodle Database',
            ]);

            $glossarygenerator = $datagenerator->get_plugin_generator('mod_glossary');
            $glossary = $glossarygenerator->create_instance($common + [
                'name' => 'Moodle Glossary',
            ]);
            $glossarygenerator->create_content($glossary, [
                'concept' => 'Edvorya',
                'definition' => 'Bundled Moodle Glossary compatibility entry.',
                'definitionformat' => FORMAT_HTML,
            ]);

            $lessongenerator = $datagenerator->get_plugin_generator('mod_lesson');
            $lessongenerator->create_instance($common + [
                'name' => 'Moodle Lesson',
            ]);

            $wikigenerator = $datagenerator->get_plugin_generator('mod_wiki');
            $wiki = $wikigenerator->create_instance($common + [
                'name' => 'Moodle Wiki',
                'firstpagetitle' => 'Edvorya Wiki Home',
            ]);
            $wikigenerator->create_first_page($wiki);

            $workshopgenerator = $datagenerator->get_plugin_generator('mod_workshop');
            $workshopgenerator->create_instance($common + [
                'name' => 'Moodle Workshop',
            ]);

            $feedbackgenerator = $datagenerator->get_plugin_generator('mod_feedback');
            $feedbackgenerator->create_instance($common + [
                'name' => 'Moodle Feedback',
            ]);

            $bookgenerator = $datagenerator->get_plugin_generator('mod_book');
            $book = $bookgenerator->create_instance($common + [
                'name' => 'Moodle Book',
            ]);
            $bookgenerator->create_content($book, [
                'title' => 'Edvorya Book Chapter',
                'content' => '<p>Bundled Moodle Book compatibility chapter.</p>',
                'contentformat' => FORMAT_HTML,
            ]);
        } finally {
            \core\session\manager::set_user($previoususer);
        }
    }

    /**
     * Visit a root-relative Moodle Core path without leaving the configured test origin.
     *
     * @When /^I visit the Edvorya Core path "(?P<path>\/[^"]*)"$/
     * @param string $path Root-relative Moodle path with optional query string.
     */
    public function i_visit_the_edvorya_core_path(string $path): void {
        if (!str_starts_with($path, '/') || str_starts_with($path, '//')) {
            throw new \InvalidArgumentException('Edvorya Core test paths must be root-relative Moodle paths.');
        }

        $parts = parse_url($path);
        if ($parts === false || empty($parts['path'])) {
            throw new \InvalidArgumentException('Invalid Edvorya Core test path.');
        }

        $params = [];
        if (!empty($parts['query'])) {
            parse_str($parts['query'], $params);
        }

        $url = new \moodle_url($parts['path'], $params);
        $this->getSession()->visit($url->out(false));
        if ($this->running_javascript()) {
            $this->getSession()->wait(self::get_timeout() * 1000, self::PAGE_READY_JS);
        }
    }

    /**
     * Visit the current user's Moodle grade report for a course identified by shortname.
     *
     * @When /^I visit Edvorya grades for course "(?P<shortname>[^"]+)"$/
     * @param string $shortname Course shortname.
     */
    public function i_visit_edvorya_grades_for_course(string $shortname): void {
        global $DB;

        $course = $DB->get_record('course', ['shortname' => $shortname], 'id', MUST_EXIST);
        $url = new \moodle_url('/grade/report/user/index.php', ['id' => $course->id]);
        $this->getSession()->visit($url->out(false));
        if ($this->running_javascript()) {
            $this->getSession()->wait(self::get_timeout() * 1000, self::PAGE_READY_JS);
        }
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
