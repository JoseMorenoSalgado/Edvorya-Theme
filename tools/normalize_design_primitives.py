#!/usr/bin/env python3
"""Normalize ownership of reusable Edvorya visual primitives.

src/styles/design-system.css owns global buttons, cards and badges.
src/styles/identity.css owns page and product composition only. The normalizer
moves the current Edvorya LMS primitive values into the Design System and
removes later global overrides from the identity layer.
"""

from __future__ import annotations

import argparse
from pathlib import Path
import sys

ROOT = Path(__file__).resolve().parents[1]
DESIGN_SYSTEM = ROOT / "src/styles/design-system.css"
IDENTITY = ROOT / "src/styles/identity.css"


def replace_exact(text: str, old: str, new: str, label: str) -> str:
    """Replace one known legacy block, remaining idempotent after normalization."""
    if old in text:
        return text.replace(old, new, 1)
    if new in text:
        return text
    raise ValueError(f"Unable to locate legacy or normalized block: {label}")


def remove_exact(text: str, block: str, label: str) -> str:
    """Remove one known legacy block, remaining idempotent when already absent."""
    if block not in text:
        return text
    return text.replace(block, "", 1)


def normalize_design_system(text: str) -> str:
    replacements = [
        (
            """    .btn {
        min-width: 0;
        min-height: 2.5rem;
        border-radius: var(--edv-radius-sm);
        font-weight: 650;
        transition: background-color 120ms ease, border-color 120ms ease, color 120ms ease, box-shadow 120ms ease, transform 120ms ease;
    }
""",
            """    .btn {
        min-width: 0;
        min-height: 2.5rem;
        border-radius: var(--edv-radius-lg);
        font-size: 0.875rem;
        font-weight: 600;
        transition: background-color 120ms ease, border-color 120ms ease, color 120ms ease, box-shadow 120ms ease, transform 120ms ease;
    }
""",
            "button base",
        ),
        (
            """    .btn-primary {
        border-color: var(--edv-color-primary);
        background: var(--edv-color-primary);
        color: #ffffff;
    }

    .btn-primary:hover,
    .btn-primary:focus-visible {
        border-color: var(--edv-color-primary);
        background: color-mix(in srgb, var(--edv-color-primary) 88%, #000000);
        color: #ffffff;
    }
""",
            """    .btn-primary {
        border-color: var(--edv-color-button);
        background: var(--edv-color-button);
        color: #ffffff;
    }

    .btn-primary:hover,
    .btn-primary:focus-visible {
        border-color: var(--edv-color-button);
        background: color-mix(in srgb, var(--edv-color-button) 88%, #000000);
        color: #ffffff;
    }
""",
            "primary button colour token",
        ),
        (
            """    .btn-secondary {
        border-color: var(--edv-color-border);
        background: #ffffff;
        color: var(--edv-color-foreground);
        box-shadow: var(--edv-shadow-sm);
    }

    .btn-secondary:hover,
    .btn-secondary:focus-visible {
        border-color: var(--edv-color-primary);
        background: var(--edv-hover-overlay);
        color: var(--edv-color-primary);
    }
""",
            """    .btn-secondary {
        border-color: var(--edv-color-border);
        background: #ffffff;
        color: #334155;
        box-shadow: none;
    }

    .btn-secondary:hover,
    .btn-secondary:focus-visible {
        border-color: var(--edv-color-border);
        background: var(--edv-color-subtle);
        color: var(--edv-color-foreground);
    }
""",
            "secondary button",
        ),
        (
            """    .btn-outline-secondary {
        border-color: var(--edv-color-border);
        color: var(--edv-color-foreground);
    }

    .btn-outline-secondary:hover,
    .btn-outline-secondary:focus-visible {
        border-color: var(--edv-color-primary);
        background: var(--edv-hover-overlay);
        color: var(--edv-color-primary);
    }
""",
            """    .btn-outline-secondary {
        border-color: var(--edv-color-border);
        background: #ffffff;
        color: #334155;
        box-shadow: none;
    }

    .btn-outline-secondary:hover,
    .btn-outline-secondary:focus-visible {
        border-color: var(--edv-color-border);
        background: var(--edv-color-subtle);
        color: var(--edv-color-foreground);
    }
""",
            "outline secondary button",
        ),
        (
            """    .btn-sm {
        min-height: 2rem;
    }
""",
            """    .btn-sm {
        min-height: 2.25rem;
        border-radius: var(--edv-radius-md);
    }
""",
            "small button",
        ),
        (
            """    .card {
        min-width: 0;
        border-color: var(--edv-color-border);
        border-radius: var(--edv-radius-lg);
        background: #ffffff;
        color: var(--edv-color-foreground);
        box-shadow: var(--edv-shadow-sm);
    }

    .card-header,
    .card-footer {
        border-color: var(--edv-color-border);
        background: var(--edv-color-background);
    }
""",
            """    .card {
        min-width: 0;
        border-color: var(--edv-color-border);
        border-radius: var(--edv-radius-xl);
        background: var(--edv-color-surface);
        color: var(--edv-color-foreground);
        box-shadow: var(--edv-shadow-sm);
    }

    .card-header,
    .card-footer {
        border-color: var(--edv-color-border);
        background: var(--edv-color-surface);
    }
""",
            "card surface",
        ),
        (
            """    .badge {
        max-width: 100%;
        border-radius: var(--edv-radius-sm);
        font-weight: 700;
        white-space: normal;
        overflow-wrap: anywhere;
    }
""",
            """    .badge,
    .edv-info-pill {
        max-width: 100%;
        border-radius: var(--edv-radius-pill);
        font-size: 0.75rem;
        font-weight: 500;
        white-space: normal;
        overflow-wrap: anywhere;
    }
""",
            "badge and info pill",
        ),
    ]

    normalized = text
    for old, new, label in replacements:
        normalized = replace_exact(normalized, old, new, label)
    return normalized


def normalize_identity(text: str) -> str:
    normalized = replace_exact(
        text,
        """    /* Surfaces use the same quiet white + slate border contract as Edvorya LMS. */
    .card,
    .edv-layout-mydashboard #region-main > .block,
    .edv-layout-mycourses #region-main > .block,
    .edv-layout-course .course-content .course-section,
    .edv-layout-course .course-content li.section {
""",
        """    /* Page-specific surfaces use the shared Design System card contract. */
    .edv-layout-mydashboard #region-main > .block,
    .edv-layout-mycourses #region-main > .block,
    .edv-layout-course .course-content .course-section,
    .edv-layout-course .course-content li.section {
""",
        "identity page surface selector",
    )

    removals = [
        (
            """    .card-header,
    .card-footer {
        background: var(--edv-color-surface);
    }

""",
            "identity card header/footer override",
        ),
        (
            """    /* Moodle buttons keep Boost mechanics but use the compact Edvorya action scale. */
    .btn {
        min-height: 2.5rem;
        border-radius: var(--edv-radius-lg);
        font-size: 0.875rem;
        font-weight: 600;
    }

    .btn-sm {
        min-height: 2.25rem;
        border-radius: var(--edv-radius-md);
    }

    .btn-secondary,
    .btn-outline-secondary {
        border-color: var(--edv-color-border);
        background: #ffffff;
        color: #334155;
        box-shadow: none;
    }

    .btn-secondary:hover,
    .btn-outline-secondary:hover {
        border-color: var(--edv-color-border);
        background: var(--edv-color-subtle);
        color: var(--edv-color-foreground);
    }

""",
            "identity button primitive overrides",
        ),
        (
            """    /* Compact pills mirror metadata and status treatments used by the LMS. */
    .badge,
    .edv-info-pill {
        border-radius: var(--edv-radius-pill);
        font-size: 0.75rem;
        font-weight: 500;
    }

""",
            "identity badge primitive override",
        ),
    ]

    for block, label in removals:
        normalized = remove_exact(normalized, block, label)
    return normalized


def normalized_files() -> dict[Path, str]:
    return {
        DESIGN_SYSTEM: normalize_design_system(DESIGN_SYSTEM.read_text(encoding="utf-8")),
        IDENTITY: normalize_identity(IDENTITY.read_text(encoding="utf-8")),
    }


def main() -> int:
    parser = argparse.ArgumentParser()
    mode = parser.add_mutually_exclusive_group(required=True)
    mode.add_argument("--check", action="store_true", help="Fail when primitive ownership is not normalized.")
    mode.add_argument("--write", action="store_true", help="Write normalized primitive ownership to source files.")
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
        print("Design System primitive ownership is not normalized:", file=sys.stderr)
        for path in changed:
            print(f" - {path.relative_to(ROOT)}", file=sys.stderr)
        print("Run: python3 tools/normalize_design_primitives.py --write", file=sys.stderr)
        return 1

    if args.write and changed:
        for path in changed:
            print(f"Normalized {path.relative_to(ROOT)}")

    return 0


if __name__ == "__main__":
    raise SystemExit(main())
