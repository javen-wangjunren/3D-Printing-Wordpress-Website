import argparse
import os
import re
from dataclasses import dataclass
from typing import List
 
 
@dataclass
class FileResult:
    path: str
    is_library: bool
    changed: bool
    replacements: int
    had_active: bool
 
 
def iter_php_files(root_dir: str) -> List[str]:
    php_files: List[str] = []
    for dirpath, _, filenames in os.walk(root_dir):
        for filename in filenames:
            if filename.lower().endswith(".php"):
                php_files.append(os.path.join(dirpath, filename))
    php_files.sort()
    return php_files
 
 
def process_file(path: str, apply_changes: bool) -> FileResult:
    with open(path, "r", encoding="utf-8") as f:
        original = f.read()
 
    if "__acf_library" not in original:
        return FileResult(path=path, is_library=False, changed=False, replacements=0, had_active=False)
 
    active_pattern = re.compile(r"(?P<prefix>['\"]active['\"]\s*=>\s*)(?P<value>true|TRUE|True|1)\b")
    had_active = bool(re.search(r"['\"]active['\"]\s*=>", original))
    updated, replacements = active_pattern.subn(r"\g<prefix>false", original)
 
    changed = updated != original
    if changed and apply_changes:
        with open(path, "w", encoding="utf-8") as f:
            f.write(updated)
 
    return FileResult(path=path, is_library=True, changed=changed, replacements=replacements, had_active=had_active)
 
 
def main() -> None:
    parser = argparse.ArgumentParser()
    parser.add_argument(
        "--theme-root",
        default=os.getcwd(),
        help="Theme root directory (default: current working directory)",
    )
    parser.add_argument(
        "--apply",
        action="store_true",
        help="Apply changes (default: dry-run)",
    )
    args = parser.parse_args()
 
    target_dir = os.path.join(args.theme_root, "inc", "acf", "field")
    if not os.path.isdir(target_dir):
        raise SystemExit(f"Directory not found: {target_dir}")
 
    php_files = iter_php_files(target_dir)
    results: List[FileResult] = []
    for path in php_files:
        r = process_file(path, apply_changes=args.apply)
        if r.is_library:
            results.append(r)
 
    changed = [r for r in results if r.changed]
    missing_active = [r for r in results if (not r.had_active)]
    total_replacements = sum(r.replacements for r in results)
 
    print(f"library_files: {len(results)}")
    print(f"changed_files: {len(changed)}")
    print(f"replacements: {total_replacements}")
    print(f"apply: {bool(args.apply)}")
 
    if changed:
        print("\nChanged:")
        for r in changed:
            print(f"- {r.path} (replacements={r.replacements})")
 
    if missing_active:
        print("\nMissing 'active' key (no change made):")
        for r in missing_active:
            print(f"- {r.path}")
 
 
if __name__ == "__main__":
    main()
