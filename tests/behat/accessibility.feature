@theme_edvorya_accessibility @accessibility @javascript
Feature: Edvorya automated accessibility smoke testing
  In order to use Moodle with assistive technologies
  As a Moodle user
  I need representative Edvorya pages navigation states and common components to meet automated accessibility standards

  Scenario: Authenticated site home meets accessibility standards on desktop
    Given I log in as "admin"
    And I am on site homepage
    And I set the Edvorya viewport to "1366x768"
    Then the page should meet accessibility standards

  Scenario: Dashboard meets accessibility standards on desktop
    Given I log in as "admin"
    And I set the Edvorya viewport to "1366x768"
    Then the page should meet accessibility standards

  Scenario: Phone navigation meets accessibility standards while closed and open
    Given I log in as "admin"
    And I am on site homepage
    And I set the Edvorya viewport to "390x844"
    Then the page should meet accessibility standards
    When I toggle the Edvorya mobile navigation with the keyboard
    Then ".edv-mobile-nav[open]" "css_element" should exist
    And the page should meet accessibility standards

  Scenario: Tablet navigation meets accessibility standards while open
    Given I log in as "admin"
    And I am on site homepage
    And I set the Edvorya viewport to "820x1180"
    When I toggle the Edvorya mobile navigation with the keyboard
    Then ".edv-mobile-nav[open]" "css_element" should exist
    And the page should meet accessibility standards

  Scenario: Transversal Design System fixture meets accessibility standards
    Given I log in as "admin"
    And I am on site homepage
    And I set the Edvorya viewport to "1366x768"
    And I inject the Edvorya design system fixture
    Then the page should meet accessibility standards
