@theme_edvorya @javascript
Feature: Edvorya teacher course workspace
  In order to manage a course without changing the student presentation
  As an editing teacher
  I need Edvorya to apply teacher workspace presentation only when Moodle capabilities allow it

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email |
      | student1 | Elena | Student | student1@example.com |
      | teacher1 | Tomas | Teacher | teacher1@example.com |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Edvorya Teacher Workspace | ETW1 | 0 |
    And the following "course enrolments" exist:
      | user | course | role |
      | student1 | ETW1 | student |
      | teacher1 | ETW1 | editingteacher |

  Scenario: Editing teacher receives the course workspace context
    Given I log in as "teacher1"
    When I am on "Edvorya Teacher Workspace" course homepage
    Then "body.edv-course-role-teacher" "css_element" should exist
    And the Edvorya element "#page" should fit within the viewport horizontally

  Scenario: Student keeps the learning presentation without teacher workspace context
    Given I log in as "student1"
    When I am on "Edvorya Teacher Workspace" course homepage
    Then "body.edv-course-role-teacher" "css_element" should not exist
    And the Edvorya element "#page" should fit within the viewport horizontally
