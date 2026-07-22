@theme_edvorya @javascript
Feature: Edvorya responsive site administration navigation
  In order to administer Moodle from phone and tablet layouts
  As a site administrator
  I need Core administration categories to remain visible, functional, and keyboard compatible

  Scenario Outline: Site administration Core tabs switch the matching settings panel
    Given I log in as "admin"
    When I visit the Edvorya Core path "/admin/search.php"
    And I set the Edvorya viewport to "<viewport>"
    Then "body.edv-pagetype-admin-search" "css_element" should exist
    And ".edv-secondary-nav--admin" "css_element" should be visible
    And ".edv-secondary-nav--admin [data-key='users'] .nav-link" "css_element" should be visible
    And ".tab-content" "css_element" should be visible
    And ".tab-content .container-fluid > .row" "css_element" should exist
    And the Edvorya element ".edv-secondary-nav--admin" should fit within the viewport horizontally
    And the Edvorya element ".edv-main__inner" should fit within the viewport horizontally
    When I click on ".edv-secondary-nav--admin [data-key='users'] .nav-link" "css_element"
    Then ".edv-secondary-nav--admin [data-key='users'] .nav-link.active" "css_element" should exist
    And "#linkusers.tab-pane.active" "css_element" should exist
    And "#linkroot.tab-pane.active" "css_element" should not exist

    Examples:
      | viewport |
      | 390x844  |
      | 820x1180 |
