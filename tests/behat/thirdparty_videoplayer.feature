@theme_edvorya_videoplayer @accessibility @javascript
Feature: Drive Resource works inside the standalone Edvorya theme
  In order to use a real third-party activity with Edvorya
  As a Moodle administrator
  I need Drive Resource to render responsively and accessibly without a parent theme

  Background:
    Given the following "courses" exist:
      | fullname                     | shortname | category |
      | Edvorya Plugin Compatibility | C1        | 0        |
    And I create an Edvorya Drive Resource named "Edvorya Drive Resource" in course "C1"
    And I log in as "admin"

  Scenario Outline: Drive Resource generic embed fits Edvorya at representative viewports
    Given I set the Edvorya viewport to "<viewport>"
    And I am on "Edvorya Plugin Compatibility" course homepage
    When I follow "Edvorya Drive Resource"
    Then ".mod-videoplayer-container" "css_element" should exist
    And ".mod-videoplayer-frame-wrapper iframe" "css_element" should exist
    And I should see "Protected resource"
    And the Edvorya element ".mod-videoplayer-container" should fit within the viewport horizontally
    And the page should meet accessibility standards

    Examples:
      | viewport |
      | 390x844  |
      | 1366x768 |
