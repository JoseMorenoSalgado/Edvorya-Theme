@theme_edvorya @javascript
Feature: Edvorya contextual page experiences
  In order to provide a coherent standalone learning experience
  As an authenticated learner
  I need key Moodle learning and support surfaces to remain responsive and functional

  Background:
    Given the following config values are set as admin:
      | enablemyhome    | 1 |
      | enablemycourses | 1 |
    And the following "users" exist:
      | username | firstname | lastname | email               |
      | student1 | Edvorya   | Learner  | learner@example.com |
    And the following "courses" exist:
      | fullname                  | shortname | category |
      | Edvorya Experience Course | C1        | 0        |
    And the following "course enrolments" exist:
      | user     | course | role    |
      | student1 | C1     | student |
    And the following "activities" exist:
      | activity | name              | intro                                | course | idnumber |
      | page     | Course welcome    | Edvorya course experience test page. | C1     | page1    |
      | assign   | Graded assignment | Edvorya grade report test activity.   | C1     | assign1  |

  Scenario Outline: Dashboard uses the contextual Edvorya experience without horizontal overflow
    Given I log in as "student1"
    And I am on site homepage
    When I click on "Dashboard" "link" in the ".edv-primary-nav" "css_element"
    And I set the Edvorya viewport to "<viewport>"
    Then "body.edv-layout-mydashboard" "css_element" should exist
    And ".edv-content-header" "css_element" should be visible
    And "#region-main" "css_element" should be visible
    And the Edvorya element ".edv-main__inner" should fit within the viewport horizontally

    Examples:
      | viewport |
      | 390x844  |
      | 1366x768 |

  Scenario Outline: My Courses renders the learner course overview inside the Edvorya experience
    Given I am on the "My courses" page logged in as "student1"
    And I set the Edvorya viewport to "<viewport>"
    Then "body.edv-layout-mycourses" "css_element" should exist
    And ".edv-content-header" "css_element" should be visible
    And I should see "Edvorya Experience Course"
    And "[data-region='course-content']" "css_element" should exist
    And the Edvorya element ".edv-main__inner" should fit within the viewport horizontally

    Examples:
      | viewport |
      | 390x844  |
      | 1366x768 |

  Scenario Outline: Course View keeps Moodle course content inside the contextual Edvorya shell
    Given I am on the "C1" "Course" page logged in as "student1"
    And I set the Edvorya viewport to "<viewport>"
    Then "body.edv-layout-course" "css_element" should exist
    And ".edv-content-header" "css_element" should be visible
    And ".course-content" "css_element" should exist
    And I should see "Course welcome"
    And I should see "Graded assignment"
    And the Edvorya element ".course-content" should fit within the viewport horizontally

    Examples:
      | viewport |
      | 390x844  |
      | 1366x768 |

  Scenario Outline: Calendar month view contains its dense grid without overflowing the Edvorya page
    Given I log in as "student1"
    When I visit the Edvorya Core path "/calendar/view.php?view=month"
    And I set the Edvorya viewport to "<viewport>"
    Then "body.edv-pagetype-calendar-view" "css_element" should exist
    And ".calendarwrapper" "css_element" should exist
    And ".calendarmonth" "css_element" should exist
    And the Edvorya element ".calendarwrapper" should fit within the viewport horizontally
    And the Edvorya element ".edv-main__inner" should fit within the viewport horizontally

    Examples:
      | viewport |
      | 390x844  |
      | 1366x768 |

  Scenario Outline: Grades keeps the Moodle user report readable inside a contained responsive surface
    Given I log in as "student1"
    When I visit Edvorya grades for course "C1"
    And I set the Edvorya viewport to "<viewport>"
    Then "body.edv-pagetype-grade-report-user-index" "css_element" should exist
    And ".user-report-container" "css_element" should exist
    And ".user-grade" "css_element" should exist
    And I should see "Graded assignment"
    And the Edvorya element ".user-report-container" should fit within the viewport horizontally
    And the Edvorya element ".edv-main__inner" should fit within the viewport horizontally

    Examples:
      | viewport |
      | 390x844  |
      | 1366x768 |

  Scenario Outline: Profile renders Moodle profile information as responsive Edvorya surfaces
    Given I am on the "Profile" page logged in as "student1"
    And I set the Edvorya viewport to "<viewport>"
    Then "body.edv-pagetype-user-profile" "css_element" should exist
    And ".userprofile" "css_element" should exist
    And ".profile_tree" "css_element" should exist
    And I should see "Edvorya Learner"
    And the Edvorya element ".userprofile" should fit within the viewport horizontally
    And the Edvorya element ".edv-main__inner" should fit within the viewport horizontally

    Examples:
      | viewport |
      | 390x844  |
      | 1366x768 |
