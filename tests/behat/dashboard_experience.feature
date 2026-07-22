@theme_edvorya @javascript
Feature: Edvorya intent-first role dashboards
  In order to focus on the next meaningful action
  As a student or teacher
  I need the Moodle dashboard to expose a concise role-aware experience

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email |
      | student1 | Elena | Student | student1@example.com |
      | teacher1 | Tomas | Teacher | teacher1@example.com |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Edvorya Learning Course | ELC1 | 0 |
    And the following "course enrolments" exist:
      | user | course | role |
      | student1 | ELC1 | student |
      | teacher1 | ELC1 | editingteacher |

  Scenario: Student dashboard answers the three primary learning questions
    Given I log in as "student1"
    When I visit the Edvorya Core path "/my/"
    Then "body.edv-dashboard-persona-student" "css_element" should exist
    And ".edv-dashboard-focus--student" "css_element" should be visible
    And I should see "Where do I continue?" in the ".edv-dashboard-focus" "css_element"
    And I should see "What is pending?" in the ".edv-dashboard-focus" "css_element"
    And I should see "How am I doing?" in the ".edv-dashboard-focus" "css_element"
    And the Edvorya element ".edv-dashboard-focus" should fit within the viewport horizontally

  Scenario: Editing teacher with one course gets direct workspace destinations
    Given I log in as "teacher1"
    When I visit the Edvorya Core path "/my/"
    Then "body.edv-dashboard-persona-teacher" "css_element" should exist
    And ".edv-dashboard-focus--teacher" "css_element" should be visible
    And I should see "What should I review?" in the ".edv-dashboard-focus" "css_element"
    And I should see "Who needs follow-up?" in the ".edv-dashboard-focus" "css_element"
    And I should see "Is there anything to answer?" in the ".edv-dashboard-focus" "css_element"
    And ".edv-dashboard-focus--teacher a[href*='/course/view.php?id=']" "css_element" should exist
    And ".edv-dashboard-focus--teacher a[href*='/user/index.php?id=']" "css_element" should exist
    And the Edvorya element ".edv-dashboard-focus" should fit within the viewport horizontally

  Scenario: Editing teacher with multiple courses chooses the workspace instead of an arbitrary course
    Given the following "courses" exist:
      | fullname | shortname | category |
      | Edvorya Second Teaching Course | ELC2 | 0 |
    And the following "course enrolments" exist:
      | user | course | role |
      | teacher1 | ELC2 | editingteacher |
    And I log in as "teacher1"
    When I visit the Edvorya Core path "/my/"
    Then "body.edv-dashboard-persona-teacher" "css_element" should exist
    And ".edv-dashboard-focus--teacher a[href*='/course/view.php?id=']" "css_element" should not exist
    And ".edv-dashboard-focus--teacher a[href*='/user/index.php?id=']" "css_element" should not exist
    And ".edv-dashboard-focus--teacher a[href*='/my/courses.php']" "css_element" should exist
    And the Edvorya element ".edv-dashboard-focus" should fit within the viewport horizontally
