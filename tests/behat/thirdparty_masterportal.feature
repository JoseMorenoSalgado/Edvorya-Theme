@theme_edvorya_masterportal @accessibility @javascript
Feature: Master Portal works with the standalone Edvorya theme
  In order to preserve integrations from local Moodle plugins
  As a Moodle administrator
  I need Master Portal navigation and embedded pages to work with Edvorya

  Scenario: Master Portal navigation node remains visible in the desktop Edvorya app shell
    Given I log in as "admin"
    And I am on site homepage
    And I set the Edvorya viewport to "1366x768"
    Then I should see "Master Portal" in the ".edv-primary-nav" "css_element"

  Scenario Outline: Master Portal embedded dashboard fits Edvorya without global chrome interference
    Given I log in as "admin"
    And I set the Edvorya viewport to "<viewport>"
    When I visit the Edvorya path "/local/masterportal/dashboard.php"
    Then ".edv-embedded-shell" "css_element" should exist
    And ".mp-app" "css_element" should exist
    And "#mp-side" "css_element" should exist
    And ".mp-main" "css_element" should exist
    And ".edv-topbar" "css_element" should not exist
    And ".edv-sidebar" "css_element" should not exist
    And the Edvorya element ".mp-app" should fit within the viewport horizontally
    And the page should meet accessibility standards

    Examples:
      | viewport |
      | 390x844  |
      | 1366x768 |
