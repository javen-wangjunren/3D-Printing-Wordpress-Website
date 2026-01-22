import os
import re

THEME_DIR = os.getcwd()
BLOCKS_DIR = os.path.join(THEME_DIR, 'blocks/global')

# Domains that should not be hardcoded
FORBIDDEN_DOMAINS = [
    '3d-printing.local',
    'localhost',
    '127.0.0.1',
    '.local'
]

def check_link_safety():
    print(f"{'File':<50} | {'Line':<5} | {'Issue Type':<20} | {'Content (Truncated)'}")
    print("-" * 120)
    
    # 1. Check Blocks
    for root, dirs, files in os.walk(BLOCKS_DIR):
        for file in files:
            if file == "render.php":
                file_path = os.path.join(root, file)
                block_name = os.path.basename(os.path.dirname(file_path))
                check_file(file_path, f"Block: {block_name}")

    # 2. Check Templates & Root Files
    for root, dirs, files in os.walk(THEME_DIR):
        if 'node_modules' in root or 'vendor' in root or '.git' in root:
            continue
        for file in files:
            if file.endswith('.php') and 'blocks/global' not in root:
                file_path = os.path.join(root, file)
                rel_path = os.path.relpath(file_path, THEME_DIR)
                check_file(file_path, rel_path)

def check_file(file_path, display_name):
    try:
        with open(file_path, 'r', encoding='utf-8') as f:
            lines = f.readlines()
            
        for i, line in enumerate(lines):
            # Check for Forbidden Domains
            for domain in FORBIDDEN_DOMAINS:
                if domain in line:
                    snippet = line.strip()[:50]
                    print(f"{display_name:<50} | {i+1:<5} | {'Hardcoded Domain':<20} | {snippet}")

            # Check for Unescaped Dynamic URLs in href
            # Pattern: href="<?php echo $var; ?>" (without esc_url)
            # We look for href=...<?php echo ...
            if 'href=' in line and '<?php' in line and 'echo' in line:
                # Check if esc_url is missing
                if 'esc_url' not in line and 'esc_attr' not in line:
                     # Ignore if it's echo home_url(...) as home_url is generally safe but esc_url is better
                     # We specifically want to catch raw variables like echo $link;
                     
                     # Simple heuristic: if it contains '$' and not 'esc_url'
                     if '$' in line:
                         snippet = line.strip()[:50]
                         print(f"{display_name:<50} | {i+1:<5} | {'Unescaped Href':<20} | {snippet}")

    except Exception as e:
        pass

if __name__ == "__main__":
    print("Link Security Audit Running...\n")
    check_link_safety()
