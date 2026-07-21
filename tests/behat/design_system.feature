@theme_edvorya @javascript
Feature: Edvorya transversal Design System
  In order to keep Moodle visually coherent without a parent theme
  As a Moodle user
  I need common Core component classes to render as responsive Edvorya components

  Scenario Outline: Buttons forms cards alerts badges tables and progress remain usable and contained
    Given I log in as "admin"
    And I am on site homepage
    And I set the Edvorya viewport to "<viewport>"
    And I inject the Edvorya design system fixture
    Then "#edv-design-system-fixture .card" "css_element" should be visible
    And "#edv-design-system-fixture .btn-primary" "css_element" should be visible
    And "#edv-design-system-fixture .btn-secondary" "css_element" should be visible
    And "#edv-design-system-fixture .btn-danger" "css_element" should be visible
    And "#edv-design-system-fixture .form-control" "css_element" should be visible
    And "#edv-design-system-fixture .form-select" "css_element" should be visible
    And "#edv-design-system-fixture .alert-success" "css_element" should be visible
    And "#edv-design-system-fixture .badge" "css_element" should be visible
    And "#edv-design-system-fixture .progress" "css_element" should be visible
    And the Edvorya element "#edv-design-system-fixture .btn-primary" should have a minimum height of "40" pixels
    And the Edvorya element "#edv-design-system-fixture .form-control" should have a minimum height of "40" pixels
    And the Edvorya element "#edv-design-system-fixture .form-select" should have a minimum height of "40" pixels
    And the Edvorya element "#edv-design-system-fixture" should fit within the viewport horizontally
    And the Edvorya element "#edv-table-fixture" should fit within the viewport horizontally
    And the Edvorya page should not have horizontal overflow

    Examples:
      | viewport |
      | 390x844  |
      | 1366x768 |

  Scenario: Wide Moodle tables use internal scrolling instead of expanding the phone viewport
    Given I log in as "admin"
    And I am on site homepage
    And I set the Edvorya viewport to "390x844"
    And I inject the Edvorya design system fixture
    Then the Edvorya element "#edv-table-fixture" should contain horizontal overflow internally
    And the Edvorya page should not have horizontal overflow

  Scenario Outline: Standalone Moodle modals remain viewport safe and preserve usable actions
    Given I log in as "admin"
    And I am on site homepage
    And I set the Edvorya viewport to "<viewport>"
    And I inject the Edvorya modal fixture
    Then "#edv-modal-fixture.modal.show" "css_element" should be visible
    And "#edv-modal-fixture .modal-content" "css_element" should be visible
    And "#edv-modal-fixture .btn-close" "css_element" should be visible
    And "#edv-modal-fixture .btn-primary" "css_element" should be visible
    And the Edvorya element "#edv-modal-fixture .modal-dialog" should fit within the viewport horizontally
    And the Edvorya element "#edv-modal-fixture .modal-content" should fit within the viewport horizontally
    And the Edvorya element "#edv-modal-fixture .btn-close" should have a minimum height of "40" pixels
    And the Edvorya page should not have horizontal overflow

    Examples:
      | viewport |
      | 390x844  |
      | 1366x768 |
