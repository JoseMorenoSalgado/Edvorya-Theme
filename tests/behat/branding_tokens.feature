# Security acceptance for cached theme colour tokens and inline-style removal.
@theme_edvorya_branding @javascript
Feature: Edvorya client branding colour tokens
  In order to support client branding under stricter content security policies
  As a Moodle administrator
  I need configured Edvorya colours to be delivered through Moodle's cached stylesheet

  Scenario: Configured primary colour is applied without an inline token style block
    Given I set the Edvorya primary colour to "#123456"
    And I log in as "admin"
    And I am on site homepage
    Then the Edvorya CSS variable "--edv-color-primary" should equal "#123456"
    And "#theme-edvorya-client-tokens" "css_element" should not exist
