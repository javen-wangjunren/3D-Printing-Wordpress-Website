import argparse
import os
import re


RE_FIX_SIZES_OUTSIDE = re.compile(
    r"(<img\b(?:(?:\?>)|[^>])*?)(\s*/?>)\s*sizes=\"([^\"]+)\"\s*>",
    flags=re.IGNORECASE | re.MULTILINE,
)

RE_DROP_ATTR_TAIL = re.compile(
    r"(<img\b(?:(?:\?>)|[^>])*?>)\s*(?:sizes=\"[^\"]+\"\s*)?(?:width=\"[^\"]+\"\s*height=\"[^\"]+\"[^>]*>)",
    flags=re.IGNORECASE | re.MULTILINE,
)

RE_DROP_LONE_ATTRS = re.compile(
    r"(</?[^>]+>)\s*(?:sizes=\"[^\"]+\"|width=\"[^\"]+\"|height=\"[^\"]+\"|alt=\"[^\"]*\"|class=\"[^\"]*\"|loading=\"[^\"]+\")\s*>",
    flags=re.IGNORECASE | re.MULTILINE,
)


def process_text(text: str) -> tuple[str, int]:
    changed = 0
    new_text = RE_FIX_SIZES_OUTSIDE.sub(lambda m: f'{m.group(1)} sizes="{m.group(3)}"{m.group(2)}', text)
    if new_text != text:
        changed += 1
        text = new_text

    new_text = RE_DROP_ATTR_TAIL.sub(lambda m: m.group(1), text)
    if new_text != text:
        changed += 1
        text = new_text

    # Defensive: remove rare cases like `</div> sizes="...">`
    new_text = RE_DROP_LONE_ATTRS.sub(lambda m: m.group(1), text)
    if new_text != text:
        changed += 1
        text = new_text

    return text, changed


def process_file(path: str, dry_run: bool) -> int:
    with open(path, "r", encoding="utf-8") as f:
        original = f.read()
    updated, changed = process_text(original)
    if changed and not dry_run:
        with open(path, "w", encoding="utf-8") as f:
            f.write(updated)
    return changed


def main() -> None:
    ap = argparse.ArgumentParser()
    ap.add_argument("--root", default=".", help="project root")
    ap.add_argument("--dry-run", action="store_true")
    args = ap.parse_args()

    total_files = 0
    total_changes = 0

    for dirpath, _, filenames in os.walk(args.root):
        for fn in filenames:
            if not fn.endswith(".php"):
                continue
            p = os.path.join(dirpath, fn)
            try:
                changed = process_file(p, dry_run=args.dry_run)
            except Exception:
                continue
            if changed:
                total_files += 1
                total_changes += changed

    print(f"files_changed: {total_files}, change_passes: {total_changes}")


if __name__ == "__main__":
    main()
