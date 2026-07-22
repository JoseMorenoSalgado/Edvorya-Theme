#!/usr/bin/env python3
"""Normalize Edvorya Design System token ownership.

The canonical CSS custom-property defaults live in src/styles/tailwind.css.
src/styles/identity.css owns visual composition only and must not redefine the
root token contract. This script is intentionally deterministic so CI can both
normalize the working branch and reject pull requests that reintroduce drift.
"""

from __future__ import annotations

import argparse
from pathlib import Path
import sys

ROOT = Path(__file__).resolve().parents[1]
TAILWIND = ROOT / "src/styles/tailwind.css"
IDENTITY = ROOT / "src/styles/identity.css"

CANONICAL_ROOT = """    :root {
        color-scheme: light;

        /* Brand and semantic colours. Client settings may override the configurable tokens at runtime. */
        --edv-color-primary: #2563eb;
        --edv-color-secondary: #0f172a;
        --edv-color-accent: #06b6d4;
        --edv-color-background: #ffffff;
        --edv-color-surface: #ffffff;
        --edv-color-subtle: #f8fafc;
        --edv-color-foreground: #020617;
        --edv-color-muted: #64748b;
        --edv-color-border: #e2e8f0;
        --edv-color-success: #16a34a;
        --edv-color-warning: #d97706;
        --edv-color-danger: #dc2626;
        --edv-color-info: #0284c7;
        --edv-color-sidebar: #fafafa;
        --edv-color-topbar: #ffffff;
        --edv-color-button: #2563eb;
        --edv-color-link: #2563eb;
        --edv-color-loginbackground: #f8fafc;

        /* Typography and spacing. */
        --edv-font-sans: \"Geist\", \"Inter\", ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, \"Segoe UI\", sans-serif;
        --edv-space-1: 0.25rem;
        --edv-space-2: 0.5rem;
        --edv-space-3: 0.75rem;
        --edv-space-4: 1rem;
        --edv-space-6: 1.5rem;
        --edv-space-8: 2rem;

        /* Shape and elevation. */
        --edv-radius-sm: 0.5rem;
        --edv-radius-md: 0.625rem;
        --edv-radius-lg: 0.75rem;
        --edv-radius-xl: 1rem;
        --edv-radius-2xl: 1.5rem;
        --edv-radius-pill: 999px;
        --edv-shadow-sm: 0 1px 2px rgb(15 23 42 / 0.05);
        --edv-shadow-md: 0 2px 6px rgb(15 23 42 / 0.07);
        --edv-shadow-lg: 0 8px 24px rgb(15 23 42 / 0.10);

        /* Interaction and shell dimensions. */
        --edv-focus-ring: 0 0 0 3px var(--edv-color-primary);
        --edv-hover-overlay: var(--edv-color-primary);
        --edv-active-overlay: var(--edv-color-primary);
        --edv-disabled-opacity: 0.55;
        --edv-topbar-height: 4rem;
        --edv-sidebar-width: 16rem;
        --edv-content-max-width: 80rem;

        /* Bridge Edvorya tokens into Bootstrap 5 variables consumed by Boost. */
        --bs-primary: var(--edv-color-primary);
        --bs-body-bg: var(--edv-color-background);
        --bs-body-color: var(--edv-color-foreground);
        --bs-border-color: var(--edv-color-border);
    }"""

OLD_IDENTITY_HEADER = """ * This layer intentionally contains visual decisions only. Boost owns generic
 * Moodle mechanics; Edvorya experience modules own page structure. The values
 * below mirror the product language used by Edvorya LMS: neutral canvas,
 * white surfaces, slate hierarchy, restrained shadows, compact 40px actions,
 * 12-16px surface radii and one institutional primary accent.
"""

NEW_IDENTITY_HEADER = """ * This layer intentionally contains visual composition only. Boost owns generic
 * Moodle mechanics; Edvorya experience modules own page structure. Canonical
 * Design System tokens live in tailwind.css; the rules below translate the
 * Edvorya LMS product language onto Moodle surfaces and page experiences.
"""


def balanced_block(text: str, marker: str) -> tuple[int, int]:
    """Return the [start, end) range for the balanced CSS block at marker."""
    start = text.find(marker)
    if start < 0:
        raise ValueError(f"Marker not found: {marker}")

    brace = text.find("{", start)
    if brace < 0:
        raise ValueError(f"Opening brace not found for: {marker}")

    depth = 0
    for index in range(brace, len(text)):
        char = text[index]
        if char == "{":
            depth += 1
        elif char == "}":
            depth -= 1
            if depth == 0:
                return start, index + 1

    raise ValueError(f"Unbalanced CSS block for: {marker}")


def normalize_tailwind(text: str) -> str:
    start, end = balanced_block(text, "    :root {")
    return text[:start] + CANONICAL_ROOT + text[end:]


def normalize_identity(text: str) -> str:
    normalized = text.replace(OLD_IDENTITY_HEADER, NEW_IDENTITY_HEADER)
    marker = "@layer base {"
    if marker not in normalized:
        return normalized

    start, end = balanced_block(normalized, marker)
    before = normalized[:start].rstrip()
    after = normalized[end:].lstrip("\n")
    return before + "\n\n" + after


def normalized_files() -> dict[Path, str]:
    return {
        TAILWIND: normalize_tailwind(TAILWIND.read_text(encoding="utf-8")),
        IDENTITY: normalize_identity(IDENTITY.read_text(encoding="utf-8")),
    }


def main() -> int:
    parser = argparse.ArgumentParser()
    mode = parser.add_mutually_exclusive_group(required=True)
    mode.add_argument("--check", action="store_true", help="Fail when normalization would change tracked source files.")
    mode.add_argument("--write", action="store_true", help="Write the canonical token structure to source files.")
    args = parser.parse_args()

    changed: list[Path] = []
    for path, normalized in normalized_files().items():
        current = path.read_text(encoding="utf-8")
        if current == normalized:
            continue

        changed.append(path)
        if args.write:
            path.write_text(normalized, encoding="utf-8")

    if args.check and changed:
        print("Design System token ownership is not normalized:", file=sys.stderr)
        for path in changed:
            print(f" - {path.relative_to(ROOT)}", file=sys.stderr)
        print("Run: python3 tools/normalize_design_tokens.py --write", file=sys.stderr)
        return 1

    if args.write and changed:
        for path in changed:
            print(f"Normalized {path.relative_to(ROOT)}")

    return 0


if __name__ == "__main__":
    raise SystemExit(main())
