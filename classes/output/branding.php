<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

namespace theme_edvorya\output;

use renderer_base;
use renderable;
use templatable;
use theme_config;

/**
 * Exports client branding and central design-token overrides for templates.
 *
 * @package    theme_edvorya
 * @copyright  2026 Elearning Cloud
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class branding implements renderable, templatable {
    /** @var array<string, string> Default Edvorya colour tokens. */
    private const DEFAULT_COLOURS = [
        'primary' => '#2563eb',
        'secondary' => '#0f172a',
        'accent' => '#06b6d4',
        'background' => '#f8fafc',
        'foreground' => '#0f172a',
        'muted' => '#64748b',
        'border' => '#e2e8f0',
        'success' => '#16a34a',
        'warning' => '#d97706',
        'danger' => '#dc2626',
        'info' => '#0284c7',
        'sidebar' => '#ffffff',
        'topbar' => '#ffffff',
        'button' => '#2563eb',
        'link' => '#2563eb',
        'loginbackground' => '#f8fafc',
    ];

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
            'tokenscss' => $this->build_token_css(),
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

    /**
     * Build the single CSS variable override block used by normal Edvorya layouts.
     *
     * Only validated hexadecimal colour values are interpolated into this CSS.
     *
     * @return string
     */
    private function build_token_css(): string {
        $declarations = [];

        foreach (self::DEFAULT_COLOURS as $name => $default) {
            $value = get_config('theme_edvorya', $name);
            $colour = $this->normalise_colour(is_string($value) ? $value : '', $default);
            $declarations[] = '--edv-color-' . $name . ':' . $colour;
        }

        return ':root{' . implode('', $declarations) . '}';
    }

    /**
     * Validate a configured colour and fall back to the Edvorya default.
     *
     * @param string $value Configured value.
     * @param string $default Default value.
     * @return string
     */
    private function normalise_colour(string $value, string $default): string {
        $value = trim($value);
        if (preg_match('/^#[0-9a-f]{6}$/i', $value) === 1) {
            return strtolower($value);
        }

        return $default;
    }
}
