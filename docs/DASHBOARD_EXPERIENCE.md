# Edvorya Dashboard Experience Contract

## Principle: less is more

The dashboard is an action surface, not a reporting wall. Above the fold, Edvorya must help the user decide what to do next with the least possible cognitive load.

The Moodle theme keeps Moodle Core as the source of truth. It may reorder and visually prioritise existing blocks, but it must not duplicate Moodle business logic, invent metrics, or execute expensive aggregate queries in the render path.

## Student dashboard

The Edvorya LMS student experience establishes these primary questions:

1. **Where do I continue?**
   - Moodle mapping: My courses / Course overview.
   - Primary native surface: `block_myoverview` and `/my/courses.php`.
   - Expected outcome: the learner can return to an active course with minimal navigation.

2. **What is pending?**
   - Moodle mapping: Timeline and upcoming calendar events.
   - Primary native surfaces: `block_timeline`, `block_calendar_upcoming`, `/calendar/view.php?view=upcoming`.
   - Expected outcome: due and upcoming work is visible before secondary information.

3. **How am I doing?**
   - Moodle mapping: course completion/progress exposed by Course overview and course completion UI.
   - Expected outcome: progress is visible in the context where Moodle already calculates it.

4. **What comes next?**
   - Moodle mapping today: timeline/calendar and the next available activity inside the course.
   - Future enhancement: `local_edvorya` may expose a cached next-best-action service when deterministic activity availability/completion rules can be resolved safely.

Edvorya LMS also contains summary concepts such as enrolled courses, average progress, pending activities, upcoming events and study streak. The theme must not fabricate or independently aggregate these values. Native Moodle values should be used when already available; cross-course aggregates and streak analytics belong in `local_edvorya` with caching and asynchronous loading.

## Teacher dashboard

The Edvorya LMS teacher experience establishes these primary questions:

1. **What should I review?**
   - Moodle mapping today: teacher courses and the relevant activity grading interfaces.
   - Theme action: prioritise access to My courses without inventing an aggregate grading count.
   - Future `local_edvorya`: cached cross-course review queue using Moodle activity APIs.

2. **Who needs follow-up?**
   - Moodle mapping today: course completion and activity completion within each course.
   - Future `local_edvorya`: intervention dashboard combining progress, inactivity and completion signals with explicit, documented risk rules.

3. **Is there anything to answer?**
   - Moodle mapping: messaging and forum/activity communication surfaces.
   - Theme action: direct access to Moodle messaging while preserving Core notification and message controllers.

Edvorya LMS also models assigned courses, submissions awaiting review, students at risk and forum questions requiring response. Only assigned-course access is suitable for the theme render path. Cross-course counts, risk detection and forum queues require `local_edvorya` or existing Moodle plugins and must be cached or loaded asynchronously.

## Persona detection

`theme_edvorya\output\dashboard_experience` uses Moodle Core capability data rather than role shortnames. A user is treated as a teacher persona when Core reports at least one course where the user has `moodle/course:manageactivities`.

The query is limited to one result because the theme only needs a boolean persona decision. Site administrators are not forced into either student or teacher dashboard guidance.

## Visual hierarchy

The dashboard follows these rules:

- One concise introductory statement.
- Exactly three intent links above the native dashboard content.
- The first intent is visually primary; the remaining two are secondary.
- No decorative metric row unless the values are real and cheaply available.
- Course overview, timeline and calendar are prioritised; no Core or third-party block is removed.
- Nested card treatments are reduced where the inner course cards already provide sufficient visual grouping.
- Mobile labels remain short; supporting descriptions may collapse on small screens.
- Keyboard focus, semantic links and Moodle-owned controllers remain intact.

## Architecture boundary

### `theme_edvorya`

Owns:

- visual hierarchy;
- role-aware presentation context;
- navigation prompts;
- ordering/presentation of existing Core blocks;
- responsive, accessible Design System treatment.

Does not own:

- cross-course learning analytics;
- grading queue aggregation;
- student risk scoring;
- streak calculation;
- recommendation engines;
- duplicated completion or availability logic.

### `local_edvorya` (future)

May own:

- cached cross-course student summary;
- cached teacher review queue;
- documented risk/intervention signals;
- next-best-action recommendations;
- asynchronous dashboard APIs;
- institutional dashboard configuration.

This separation keeps Edvorya Theme fast and standalone while allowing the full Edvorya LMS dashboard philosophy to evolve without turning theme rendering into a database bottleneck.
