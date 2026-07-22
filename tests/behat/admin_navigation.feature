@theme_edvorya @javascript
Feature: Edvorya responsive site administration navigation
  In order to administer Moodle from phone and tablet layouts
  As a site administrator
  I need Core administration categories to remain visible, functional, and keyboard compatible

  Scenario Outline: Site administration category tabs switch the matching Core settings panel
    Given I log in as "admin"
    When I visit the Edvorya Core path "/admin/search.php"
    And I set the Edvorya viewport to "<viewport>"
    Then "body.edv-pagetype-admin-search" "css_element" should exist
    And ".edv-admin-tabs" "css_element" should be visible
    And ".edv-admin-tabs__link" "css_element" should be visible
    And "[data-edv-admin-tab='users']" "css_element" should exist
    And ".tab-content" "css_element" should be visible
    And ".tab-content .container-fluid > .row" "css_element" should exist
    And the Edvorya element ".edv-admin-tabs" should fit within the viewport horizontally
    And the Edvorya element ".edv-main__inner" should fit within the viewport horizontally
    When I click on "[data-edv-admin-tab='users']" "css_element"
    Then "[data-edv-admin-tab='users'].active" "css_element" should exist
    And "#linkusers.tab-pane.active" "css_element" should exist
    And "#linkroot.tab-pane.active" "css_element" should not exist

    Examples:
      | viewport |
      | 390x844  |
      | 820x1180 |
