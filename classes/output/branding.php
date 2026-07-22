<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

namespace theme_edvorya\output;

use renderable;
use renderer_base;
use templatable;
use theme_config;

/**
 * Exports client branding data for Edvorya templates.
 *
 * Colour-token settings are applied through Moodle's cached CSS post-processing
 * pipeline and are intentionally not exported as inline CSS.
 *
 * @package    theme_edvorya
 * @copyright  2026 Elearning Cloud
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class branding implements renderable, templatable {
    /**
     * Export branding data for Mustache templates.
     *
     * @param renderer_base $output Renderer instance.
     * @return array<string, mixed>
     */
    public function export_for_template(renderer_base $output): array {
        global $PAGE, $SITE;

        $institutionname = trim((string) get_config('theme_edvorya', 'institutionname'));
        if ($institutionname === '') {
            $institutionname = $SITE->shortname;
        }

        return [
            'institutionname' => format_string(
                $institutionname,
                true,
                ['context' => \context_course::instance(SITEID)]
            ),
            'homeurl' => (new \moodle_url('/'))->out(false),
            'logourl' => $this->get_setting_file_url($PAGE->theme, 'logo'),
            'logoalternateurl' => $this->get_setting_file_url($PAGE->theme, 'logoalternate'),
            'logodarkurl' => $this->get_setting_file_url($PAGE->theme, 'logodark'),
            'faviconurl' => $this->get_setting_file_url($PAGE->theme, 'favicon'),
            'loginimageurl' => $this->get_setting_file_url($PAGE->theme, 'loginimage'),
            'footertext' => trim((string) get_config('theme_edvorya', 'footertext')),
            'copyright' => trim((string) get_config('theme_edvorya', 'copyright')),
            'facebookurl' => $this->get_url_setting('facebookurl'),
            'instagramurl' => $this->get_url_setting('instagramurl'),
            'linkedinurl' => $this->get_url_setting('linkedinurl'),
            'youtubeurl' => $this->get_url_setting('youtubeurl'),
        ];
    }

    /**
     * Return a URL for a stored theme-setting file.
     *
     * @param theme_config $theme Active theme configuration.
     * @param string $filearea File area and setting name.
     * @return string|null
     */
    private function get_setting_file_url(theme_config $theme, string $filearea): ?string {
        $url = $theme->setting_file_url($filearea, $filearea);
        return $url ? $url->out(false) : null;
    }

    /**
     * Return a validated URL setting.
     *
     * @param string $name Setting name.
     * @return string|null
     */
    private function get_url_setting(string $name): ?string {
        $value = trim((string) get_config('theme_edvorya', $name));
        if ($value === '') {
            return null;
        }

        $clean = clean_param($value, PARAM_URL);
        return $clean !== '' ? $clean : null;
    }
}
