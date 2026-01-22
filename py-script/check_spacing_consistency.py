import os
import re

# Define the root directory for blocks
BLOCKS_DIR = '/Users/javen/Local Sites/3d-printing/app/public/wp-content/themes/generatepress_child/blocks/global'

# Regex to find padding classes
# Matches strings like 'py-16', 'lg:py-24', 'pt-[96px]', etc.
PADDING_REGEX = r'\b(lg:)?p[tby]-(\[[^\]]+\]|\w+)\b'

def check_spacing():
    print(f"{'Block Name':<30} | {'Padding Classes Found':<50} | {'Status'}")
    print("-" * 100)

    for block_name in sorted(os.listdir(BLOCKS_DIR)):
        block_path = os.path.join(BLOCKS_DIR, block_name)
        render_path = os.path.join(block_path, 'render.php')

        if not os.path.isdir(block_path) or not os.path.exists(render_path):
            continue

        with open(render_path, 'r', encoding='utf-8') as f:
            content = f.read()

        # Find all padding classes
        matches = re.finditer(PADDING_REGEX, content)
        found_classes = set()
        for match in matches:
            full_match = match.group(0)
            # Filter out small paddings that might be for internal elements (e.g., p-4, py-2)
            # We are interested in section spacing, usually 16, 20, 24, 32, or custom [].
            # Let's keep everything >= 8 or custom for visibility.
            parts = full_match.split('-')
            value = parts[-1]
            
            # Simple heuristic to ignore small utility paddings inside components
            if value.isdigit() and int(value) < 8:
                continue
            
            found_classes.add(full_match)

        # Analyze status
        # We expect combinations like 'py-16' AND 'lg:py-24', or 'pt-16' AND 'lg:pt-24'.
        # If we see 'py-16' without 'lg:py...', it's a potential issue.
        # If we see 'pt-[...]', it's a potential issue.
        
        status = "✅ OK"
        notes = []
        
        has_mobile_large = any(c for c in found_classes if not c.startswith('lg:') and (c.endswith('-16') or c.endswith('-20') or c.endswith('-24')))
        has_desktop_large = any(c for c in found_classes if c.startswith('lg:') and (c.endswith('-24') or c.endswith('-32')))
        has_arbitrary = any(c for c in found_classes if '[' in c)
        
        sorted_classes = sorted(list(found_classes))
        classes_str = ", ".join(sorted_classes)

        if has_arbitrary:
            status = "⚠️ Arbitrary Value"
        elif has_mobile_large and not has_desktop_large:
            # Check if it is dynamic logic (e.g. pt-0 is fine, but we are looking for the main spacing)
            # If we have py-16 but no lg:py-something, that's suspicious for a section.
            status = "⚠️ Missing Desktop?"
        elif not found_classes:
             status = "⚪ No Section Padding Found"

        # Special check for known standard
        # Standard: pt-16 lg:pt-24 AND pb-16 lg:pb-24 OR py-16 lg:py-24
        is_standard = False
        if 'py-16' in found_classes and 'lg:py-24' in found_classes:
            is_standard = True
        if 'pt-16' in found_classes and 'lg:pt-24' in found_classes and 'pb-16' in found_classes and 'lg:pb-24' in found_classes:
            is_standard = True
            
        if is_standard:
            status = "✅ Standard"
        else:
            if status == "✅ OK":
                status = "⚠️ Non-Standard"

        # Special case: pt-0 is dynamic logic, usually accompanied by standard classes
        if 'pt-0' in found_classes:
             notes.append("Has Dynamic PT")

        final_status = f"{status} {' '.join(notes)}"
        print(f"{block_name:<30} | {classes_str[:50]:<50} | {final_status}")

if __name__ == "__main__":
    check_spacing()
