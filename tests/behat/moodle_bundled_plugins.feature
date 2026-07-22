@theme_edvorya_bundled_plugins @javascript
Feature: Moodle bundled activity plugins work with the standalone Edvorya theme
  In order to use the plugins shipped with Moodle 5.2
  As a Moodle administrator
  I need representative bundled activities and resources to render inside Edvorya without parent-theme dependencies

  Background:
    Given the following "courses" exist:
      | fullname                     | shortname | category |
      | Edvorya Bundled Plugin Tests | C1        | 0        |
    And I create Edvorya Moodle bundled activity fixtures in course "C1"
    And I log in as "admin"

  Scenario: Moodle bundled plugins remain available on a narrow course page
    Given I set the Edvorya viewport to "390x844"
    And I am on "Edvorya Bundled Plugin Tests" course homepage
    Then I should see "Moodle Book"
    And I should see "Moodle Page"
    And I should see "Moodle File"
    And I should see "Moodle Folder"
    And I should see "Moodle URL"
    And I should see "Moodle Choice"
    And I should see "Moodle Database"
    And I should see "Moodle Glossary"
    And I should see "Moodle Lesson"
    And I should see "Moodle Wiki"
    And I should see "Moodle Workshop"
    And I should see "Moodle Feedback"
    And the Edvorya element "#region-main" should fit within the viewport horizontally

  Scenario Outline: Bundled Moodle plugin pages render in the Edvorya app shell
    Given I set the Edvorya viewport to "1366x768"
    And I am on "Edvorya Bundled Plugin Tests" course homepage
    When I follow "<activity>"
    Then ".edv-shell" "css_element" should exist
    And "#region-main" "css_element" should exist
    And the Edvorya element "#region-main" should fit within the viewport horizontally

    Examples:
      | activity        |
      | Moodle Book     |
      | Moodle Page     |
      | Moodle File     |
      | Moodle Folder   |
      | Moodle Choice   |
      | Moodle Database |
      | Moodle Glossary |
      | Moodle Lesson   |
      | Moodle Wiki     |
      | Moodle Workshop |
      | Moodle Feedback |
