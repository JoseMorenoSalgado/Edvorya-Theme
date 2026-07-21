# Edvorya Theme security hardening

## Scope

This document records security decisions owned by `theme_edvorya`. It does not claim to define or replace the security policy of Moodle Core, installed plugins, the web server, reverse proxy, or the hosting platform.

## Dynamic client colour tokens

Client-configurable colour settings are applied through Moodle's theme CSS post-processing pipeline.

`config.php` registers:

`theme_edvorya_css_post_process`

The callback is implemented in `lib.php` and receives the combined theme stylesheet before Moodle serves and caches it.

Security rules:

- only known Edvorya colour setting names are processed;
- only six-digit hexadecimal values matching `#[0-9a-fA-F]{6}` are accepted;
- invalid values are ignored;
- accepted values are normalized to lowercase;
- generated declarations are limited to Edvorya CSS custom properties;
- changing a theme setting resets theme caches through `theme_reset_all_caches()`.

The previous page-level `<style id="theme-edvorya-client-tokens">` block has been removed. Client colour overrides are no longer emitted by the Edvorya template as an inline style block.

This improves compatibility with stricter Content Security Policy configurations. It does not guarantee that an entire Moodle installation can use a particular strict CSP policy, because Moodle Core and third-party plugins may have their own frontend requirements.

## Branding uploads

Administrator-configurable branding files are intentionally limited to raster formats.

Accepted logo and login image types:

- PNG;
- JPEG/JPG;
- WebP.

Accepted favicon types:

- ICO;
- PNG.

SVG is not accepted by the current theme settings.

As a defence for sites upgraded from earlier Edvorya alpha versions, `theme_edvorya_pluginfile()` also refuses to serve uploaded files whose filename extension is `.svg` from Edvorya branding file areas.

This policy applies to administrator-uploaded branding assets. It does not prohibit trusted SVG files shipped as part of the theme source code, such as local Lucide-style icons under `pix/icons/`.

## Public branding files

Branding assets are public by design because they may be rendered on login and public-site pages.

The pluginfile callback:

- serves files only in `CONTEXT_SYSTEM`;
- serves only known Edvorya file areas;
- rejects uploaded SVG files;
- delegates actual file delivery to Moodle's theme setting file-serving API.

Known file areas:

- `logo`;
- `logoalternate`;
- `logodark`;
- `favicon`;
- `loginimage`.

## URLs and text settings

Social URL settings use Moodle `PARAM_URL` validation and are cleaned again before template export.

Institution name and footer/copyright settings use Moodle text parameter types. Institution display text is passed through `format_string()` before template export.

## Testing

Security-related acceptance must verify at minimum:

1. a configured Edvorya colour is visible as the expected CSS custom property in the browser;
2. `#theme-edvorya-client-tokens` is absent from the rendered DOM;
3. PHP syntax and CSS build gates pass;
4. browser, responsive, and automated accessibility gates remain green after security changes.

The branding-security browser gate runs in an ephemeral GitHub-hosted Moodle 5.2 environment with MariaDB 10.11 and Chrome/Selenium. It does not use Edvorya-LMS, Vercel, or the Edvorya VPS.

## Production boundary

A production security review must still consider:

- Moodle and plugin patch levels;
- web-server headers;
- CSP policy for the complete Moodle installation;
- reverse proxy/CDN behavior;
- upload limits and antivirus policy;
- trusted administrator access;
- third-party plugin frontend code.

The theme should not claim system-wide CSP compliance solely because its own client token style block has been removed.
