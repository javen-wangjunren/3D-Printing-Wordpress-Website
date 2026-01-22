import os
import re

# Define directory to scan
BLOCKS_DIR = os.path.join(os.getcwd(), 'blocks/global')

# Regex to catch dynamic class construction
# 1. Concatenation: 'something-' . $var
# 2. Interpolation: "something-{$var}" or "something-$var"
# 3. We focus on common Tailwind prefixes or generic patterns
# Common prefixes: p, m, w, h, text, bg, border, grid, flex, gap, rounded, shadow, ring...
# To be broad, we look for: (quote)(any-word-char)-(quote) . $var OR (quote)(any-word-char)-{$var}

# Pattern 1: Concatenation with dot
# Matches: 'text-' . $color or "bg-" . $bg
CONCAT_PATTERN = re.compile(r'[\'"]([a-zA-Z0-9:-]+-)[\'"]\s*\.\s*\$([a-zA-Z0-9_]+)')

# Pattern 2: Double quote interpolation
# Matches: "text-$color" or "bg-{$bg}"
INTERPOLATION_PATTERN = re.compile(r'"([a-zA-Z0-9:-]+-)(\$|\{\$)([a-zA-Z0-9_]+)')

def check_tailwind_safelist():
    print(f"{'Block Name':<25} | {'Line':<5} | {'Risky Pattern':<40} | {'Status':<10}")
    print("-" * 90)
    
    risky_count = 0
    
    for root, dirs, files in os.walk(BLOCKS_DIR):
        for file in files:
            if file == "render.php":
                file_path = os.path.join(root, file)
                block_name = os.path.basename(os.path.dirname(file_path))
                
                try:
                    with open(file_path, 'r', encoding='utf-8') as f:
                        lines = f.readlines()
                except Exception as e:
                    print(f"Error reading {file_path}: {e}")
                    continue

                for i, line in enumerate(lines):
                    line_num = i + 1
                    
                    # Check for Concatenation
                    concat_matches = CONCAT_PATTERN.findall(line)
                    for prefix, var in concat_matches:
                        # Filter out common false positives if any
                        # e.g. maybe 'prefix-' . $pfx is for ID generation, not class?
                        # If prefix ends with '-', it's suspicious for Tailwind
                        
                        full_match = f"'{prefix}' . ${var}"
                        print(f"{block_name:<25} | {line_num:<5} | {full_match:<40} | Risky")
                        risky_count += 1
                        
                    # Check for Interpolation
                    interp_matches = INTERPOLATION_PATTERN.findall(line)
                    for prefix, sep, var in interp_matches:
                        full_match = f"\"{prefix}{sep}{var}\""
                        print(f"{block_name:<25} | {line_num:<5} | {full_match:<40} | Risky")
                        risky_count += 1

    if risky_count == 0:
        print("No risky dynamic class constructions found. All classes seem to be full strings.")
    else:
        print("-" * 90)
        print(f"Found {risky_count} potential dynamic class constructions.")
        print("Tailwind scanner cannot detect these classes. They will be purged in production.")
        print("Recommendation: Use full class strings mapping or inline styles.")

if __name__ == "__main__":
    check_tailwind_safelist()
