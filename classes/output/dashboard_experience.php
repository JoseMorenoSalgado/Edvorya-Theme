<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

namespace theme_edvorya\output;

use moodle_url;
use renderable;
use renderer_base;
use templatable;

/**
 * Exports a lightweight role-aware dashboard experience.
 *
 * The theme deliberately does not calculate aggregate learning analytics. It
 * identifies whether the current user can manage activities in at least one
 * course and then exposes a small set of intent-based navigation prompts. Core
 * Moodle blocks remain the source of course, timeline, calendar and progress
 * data. Rich aggregate teacher analytics belong in local_edvorya.
 *
 * @package    theme_edvorya
 * @copyright  2026 Elearning Cloud
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class dashboard_experience implements renderable, templatable {
    /**
     * Export dashboard experience data for Mustache.
     *
     * @param renderer_base $output Renderer instance.
     * @return array<string, mixed>
     */
    public function export_for_template(renderer_base $output): array {
        global $PAGE, $USER;

        if ($PAGE->pagelayout !== 'mydashboard' || !isloggedin() || isguestuser() || is_siteadmin()) {
            return [];
        }

        // Ask Core for at most one course where the user can manage activities.
        // This avoids role-name assumptions and prevents an unbounded course query.
        $teachercourses = get_user_capability_course(
            'moodle/course:manageactivities',
            $USER->id,
            false,
            '',
            '',
            1
        );
        $isteacher = !empty($teachercourses);
        $persona = $isteacher ? 'teacher' : 'student';

        $questions = $isteacher
            ? $this->teacher_questions($output)
            : $this->student_questions($output);

        return [
            'persona' => $persona,
            'isstudent' => !$isteacher,
            'isteacher' => $isteacher,
            'eyebrow' => get_string('dashboard' . $persona . 'eyebrow', 'theme_edvorya'),
            'title' => get_string('dashboard' . $persona . 'title', 'theme_edvorya'),
            'description' => get_string('dashboard' . $persona . 'description', 'theme_edvorya'),
            'questions' => $questions,
        ];
    }

    /**
     * Student dashboard intents, ordered by learning priority.
     *
     * @param renderer_base $output Renderer instance.
     * @return array<int, array<string, mixed>>
     */
    private function student_questions(renderer_base $output): array {
        return [
            $this->question(
                $output,
                'dashboardstudentcontinue',
                'dashboardstudentcontinue_desc',
                new moodle_url('/my/courses.php'),
                'book-open',
                true
            ),
            $this->question(
                $output,
                'dashboardstudentpending',
                'dashboardstudentpending_desc',
                new moodle_url('/calendar/view.php', ['view' => 'upcoming']),
                'layout-dashboard'
            ),
            $this->question(
                $output,
                'dashboardstudentprogress',
                'dashboardstudentprogress_desc',
                new moodle_url('/my/courses.php'),
                'link'
            ),
        ];
    }

    /**
     * Teacher dashboard intents, ordered by intervention priority.
     *
     * @param renderer_base $output Renderer instance.
     * @return array<int, array<string, mixed>>
     */
    private function teacher_questions(renderer_base $output): array {
        return [
            $this->question(
                $output,
                'dashboardteacherreview',
                'dashboardteacherreview_desc',
                new moodle_url('/my/courses.php'),
                'book-open',
                true
            ),
            $this->question(
                $output,
                'dashboardteacherfollowup',
                'dashboardteacherfollowup_desc',
                new moodle_url('/my/courses.php'),
                'layout-dashboard'
            ),
            $this->question(
                $output,
                'dashboardteachercommunication',
                'dashboardteachercommunication_desc',
                new moodle_url('/message/index.php'),
                'link'
            ),
        ];
    }

    /**
     * Build one compact intent link.
     *
     * @param renderer_base $output Renderer instance.
     * @param string $titlekey Language string key for the question.
     * @param string $descriptionkey Language string key for the supporting text.
     * @param moodle_url $url Destination URL.
     * @param string $icon Edvorya pix icon name.
     * @param bool $primary Whether this is the single primary action.
     * @return array<string, mixed>
     */
    private function question(
        renderer_base $output,
        string $titlekey,
        string $descriptionkey,
        moodle_url $url,
        string $icon,
        bool $primary = false
    ): array {
        return [
            'title' => get_string($titlekey, 'theme_edvorya'),
            'description' => get_string($descriptionkey, 'theme_edvorya'),
            'url' => $url->out(false),
            'iconhtml' => $output->pix_icon(
                'icons/' . $icon,
                '',
                'theme_edvorya',
                ['class' => 'edv-dashboard-focus__icon-svg']
            ),
            'primary' => $primary,
        ];
    }
}
