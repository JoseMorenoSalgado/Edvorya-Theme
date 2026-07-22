#!/usr/bin/env python3
"""Audit Edvorya configurable branding colours from setting to CSS consumer.

A configurable colour is valid only when it is present in all three contracts:
1. settings.php exposes it to administrators;
2. lib.php emits it through Moodle's cached CSS post-process callback;
3. src/styles/tailwind.css defines its canonical default.

Each configurable token must also have at least one semantic CSS consumer outside
its canonical declaration. Generated style/edvorya.css is intentionally ignored
so a stale or duplicated compiled artifact cannot make an orphan setting appear
used.
"""

from __future__ import annotations

import argparse
from pathlib import Path
import re
import sys

ROOT = Path(__file__).resolve().parents[1]
SETTINGS = ROOT / "settings.php"
LIB = ROOT / "lib.php"
TOKENS = ROOT / "src/styles/tailwind.css"

CSS_SOURCES = [
    *sorted((ROOT / "src/styles").glob("*.css")),
    *sorted((ROOT / "style").glob("edvorya-*.css")),
]


def extract_php_list(text: str, variable: str) -> set[str]:
    """Extract quoted keys/items from a small PHP array assigned to variable."""
    match = re.search(rf"\${re.escape(variable)}\s*=\s*\[(.*?)\];", text, re.S)
    if not match:
        raise ValueError(f"Unable to find ${variable} array")
    body = match.group(1)
    keyed = set(re.findall(r"['\"]([a-z0-9]+)['\"]\s*=>", body))
    if keyed:
        return keyed
    return set(re.findall(r"['\"]([a-z0-9]+)['\"]", body))


def canonical_tokens(text: str) -> set[str]:
    return set(re.findall(r"--edv-color-([a-z0-9]+)\s*:", text))


def semantic_consumers(token: str) -> list[str]:
    needle = f"var(--edv-color-{token})"
    consumers: list[str] = []
    for path in CSS_SOURCES:
        if path == TOKENS:
            # tailwind.css contains both declarations and legitimate shell/base
            # consumers. Count only occurrences after removing declarations.
            text = path.read_text(encoding="utf-8")
            text = re.sub(rf"--edv-color-{re.escape(token)}\s*:[^;]+;", "", text)
        else:
            text = path.read_text(encoding="utf-8")
        if needle in text:
            consumers.append(str(path.relative_to(ROOT)))
    return consumers


def audit() -> tuple[list[str], dict[str, list[str]]]:
    settings = extract_php_list(SETTINGS.read_text(encoding="utf-8"), "colours")
    emitted = extract_php_list(LIB.read_text(encoding="utf-8"), "settingnames")
    canonical = canonical_tokens(TOKENS.read_text(encoding="utf-8"))

    errors: list[str] = []
    if settings != emitted:
        errors.append(
            "settings.php and lib.php configurable colour sets differ: "
            f"settings-only={sorted(settings - emitted)}, lib-only={sorted(emitted - settings)}"
        )

    missing_defaults = settings - canonical
    if missing_defaults:
        errors.append(f"Configurable colours missing canonical defaults: {sorted(missing_defaults)}")

    consumers = {token: semantic_consumers(token) for token in sorted(settings)}
    orphaned = [token for token, paths in consumers.items() if not paths]
    if orphaned:
        errors.append(f"Configurable colours without semantic CSS consumers: {orphaned}")

    return errors, consumers


def main() -> int:
    parser = argparse.ArgumentParser()
    parser.add_argument("--check", action="store_true", help="Fail when the branding token contract is inconsistent.")
    parser.add_argument("--report", action="store_true", help="Print the consumer map without changing files.")
    args = parser.parse_args()

    if not args.check and not args.report:
        parser.error("one of --check or --report is required")

    errors, consumers = audit()

    if args.report:
        for token, paths in consumers.items():
            print(f"{token}: {', '.join(paths) if paths else '[orphan]'}")

    if errors:
        for error in errors:
            print(error, file=sys.stderr)
        return 1 if args.check else 0

    if args.check:
        print("Branding token settings, emitted variables, defaults and consumers are consistent.")

    return 0


if __name__ == "__main__":
    raise SystemExit(main())
