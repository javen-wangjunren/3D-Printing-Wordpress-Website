import argparse
import os
import re
from typing import Tuple, List


ASSIGN_RE = re.compile(
    r"\$([A-Za-z_][A-Za-z0-9_]*)\s*=\s*wp_get_attachment_image_url\(\s*(?P<id>[^,]+)\s*,\s*'(?P<size>[^']+)'\s*\)\s*;",
    re.MULTILINE,
)

SRC_VAR_RE = re.compile(
    r'src\s*=\s*"\s*<\?php\s+echo\s+esc_url\(\s*(\$\w+)\s*\)\s*;\s*\?>\s*"',
    re.IGNORECASE,
)

IMG_TAG_START_RE = re.compile(r"<img\b", re.IGNORECASE)


def find_img_tag_end(s: str) -> int:
    in_php = False
    i = 0
    while i < len(s):
        if not in_php and s.startswith("<?", i):
            in_php = True
            i += 2
            continue
        if in_php and s.startswith("?>", i):
            in_php = False
            i += 2
            continue
        if not in_php and s[i] == ">":
            return i
        i += 1
    return -1


def find_assignment(lines: List[str], start_idx: int, var_name: str, window: int = 60) -> Tuple[str, str]:
    lo = max(0, start_idx - window)
    snippet = "".join(lines[lo:start_idx])
    for m in ASSIGN_RE.finditer(snippet):
        v = m.group(1)
        if v == var_name.lstrip("$"):
            return m.group("id").strip(), m.group("size").strip()
    return "", ""


def read_img_block(lines: List[str], idx: int) -> Tuple[str, int]:
    buf = []
    i = idx
    while i < len(lines):
        line = lines[i]
        if i == idx and not IMG_TAG_START_RE.search(line):
            return "", idx
        buf.append(line)
        if find_img_tag_end("".join(buf)) != -1:
            break
        i += 1
    return "".join(buf), i


def ensure_loading_sizes(img_html: str, default_sizes: str) -> str:
    end = find_img_tag_end(img_html)
    if end == -1:
        return img_html

    tag = img_html[: end + 1]
    tail = img_html[end + 1 :]

    needs_loading = re.search(r"\bloading\s*=", tag) is None
    needs_sizes = re.search(r"\bsizes\s*=", tag) is None

    if not needs_loading and not needs_sizes:
        return img_html

    is_self_closing = tag.rstrip().endswith("/>")
    tag_body = tag[:-2] if is_self_closing else tag[:-1]

    if needs_loading:
        tag_body += ' loading="lazy"'
    if needs_sizes:
        tag_body += f' sizes="{default_sizes}"'

    tag = tag_body + (" />" if is_self_closing else ">")
    return tag + tail


def to_wp_get_attachment_image(id_expr: str, size: str, img_html: str, indent: str, default_sizes: str) -> str:
    cls_match = re.search(r'class\s*=\s*"([^"]*)"', img_html)
    alt_match = re.search(r'alt\s*=\s*"([^"]*)"', img_html)
    cls = cls_match.group(1) if cls_match else ""
    alt = alt_match.group(1) if alt_match else ""
    attrs = []
    if cls:
        attrs.append(f"'class' => '{cls}'")
    if alt:
        attrs.append(f"'alt' => '{alt}'")
    attrs.append("'loading' => 'lazy'")
    attrs.append(f"'sizes' => '{default_sizes}'")
    attrs_str = "array( " + ", ".join(attrs) + " )"
    return f"{indent}<?php echo wp_get_attachment_image( {id_expr}, '{size}', false, {attrs_str} ); ?>\n"


def process_file(path: str, default_sizes: str, dry_run: bool = False) -> int:
    with open(path, "r", encoding="utf-8") as f:
        original = f.read()
    lines = original.splitlines(keepends=True)
    changed = 0
    i = 0
    while i < len(lines):
        line = lines[i]
        if IMG_TAG_START_RE.search(line):
            block, end_i = read_img_block(lines, i)
            if block:
                m = SRC_VAR_RE.search(block)
                if m:
                    var = m.group(1)
                    id_expr, size = find_assignment(lines, i, var)
                    if id_expr and size:
                        indent = re.match(r"\s*", lines[i]).group(0)
                        replacement = to_wp_get_attachment_image(id_expr, size, block, indent, default_sizes)
                        lines[i : end_i + 1] = [replacement]
                        changed += 1
                        i = i
                        continue
                new_block = ensure_loading_sizes(block, default_sizes)
                if new_block != block:
                    lines[i : end_i + 1] = [new_block]
                    changed += 1
                    i = i
                    continue
        i += 1
    if changed and not dry_run:
        with open(path, "w", encoding="utf-8") as f:
            f.write("".join(lines))
    return changed


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--root", default=".", help="project root")
    ap.add_argument("--dry-run", action="store_true")
    ap.add_argument("--sizes", default="(min-width: 1024px) 800px, 100vw")
    args = ap.parse_args()
    total = 0
    for dirpath, _, filenames in os.walk(args.root):
        for fn in filenames:
            if fn.endswith(".php"):
                p = os.path.join(dirpath, fn)
                try:
                    total += process_file(p, args.sizes, dry_run=args.dry_run)
                except Exception:
                    pass
    print(f"changed: {total}")


if __name__ == "__main__":
    main()
