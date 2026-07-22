@theme_edvorya @javascript
Feature: Edvorya responsive primary navigation
  In order to navigate Moodle on different device sizes
  As an authenticated user
  I need the Edvorya primary navigation to adapt without losing keyboard access

  Background:
    Given I log in as "admin"
    And I am on site homepage

  Scenario: Phone viewport exposes keyboard-operable Edvorya drawer navigation
    Given I set the Edvorya viewport to "390x844"
    Then ".edv-mobile-nav" "css_element" should be visible
    And ".edv-desktop-nav" "css_element" should not be visible
    And I should see "Open main navigation" in the ".edv-mobile-nav__toggle" "css_element"
    And ".edv-mobile-nav__content[aria-label]" "css_element" should exist
    When I toggle the Edvorya mobile navigation with the keyboard
    Then ".edv-mobile-nav[open]" "css_element" should exist
    And ".edv-mobile-nav__panel" "css_element" should be visible
    And ".edv-mobile-nav__panel-header" "css_element" should be visible
    And ".edv-mobile-nav__item-icon" "css_element" should be visible
    And "[data-edv-nav-key]" "css_element" should exist
    And the Edvorya element ".edv-mobile-nav__panel" should fit within the viewport horizontally
    When I toggle the Edvorya mobile navigation with the keyboard
    Then ".edv-mobile-nav[open]" "css_element" should not exist

  Scenario: Tablet portrait keeps the Edvorya drawer contract
    Given I set the Edvorya viewport to "820x1180"
    Then ".edv-mobile-nav" "css_element" should be visible
    And ".edv-desktop-nav" "css_element" should not be visible
    When I toggle the Edvorya mobile navigation with the keyboard
    Then ".edv-mobile-nav[open]" "css_element" should exist
    And ".edv-mobile-nav__panel" "css_element" should be visible
    And ".edv-mobile-nav__panel-header" "css_element" should be visible
    And ".edv-mobile-nav__item-icon" "css_element" should be visible
    And the Edvorya element ".edv-mobile-nav__panel" should fit within the viewport horizontally

  Scenario: Desktop viewport restores sidebar primary navigation
    Given I set the Edvorya viewport to "1366x768"
    Then ".edv-mobile-nav" "css_element" should not be visible
    And ".edv-desktop-nav" "css_element" should be visible
