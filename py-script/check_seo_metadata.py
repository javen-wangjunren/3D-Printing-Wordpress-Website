import os
import re

THEME_DIR = os.getcwd()
BLOCKS_DIR = os.path.join(THEME_DIR, 'blocks/global')

def check_h1_tags():
    print(f"{'File':<60} | {'Line':<5} | {'Content (Truncated)':<40} | {'Status'}")
    print("-" * 115)
    
    h1_pattern = re.compile(r'<h1\b[^>]*>(.*?)</h1>', re.IGNORECASE | re.DOTALL)
    
    # Scan Blocks
    for root, dirs, files in os.walk(BLOCKS_DIR):
        for file in files:
            if file == "render.php":
                file_path = os.path.join(root, file)
                block_name = os.path.basename(os.path.dirname(file_path))
                check_file_for_h1(file_path, f"Block: {block_name}")

    # Scan Templates
    for root, dirs, files in os.walk(THEME_DIR):
        if 'node_modules' in root or 'vendor' in root:
            continue
        for file in files:
            if file.endswith('.php') and 'blocks/global' not in root:
                file_path = os.path.join(root, file)
                rel_path = os.path.relpath(file_path, THEME_DIR)
                check_file_for_h1(file_path, rel_path)

def check_file_for_h1(file_path, display_name):
    try:
        with open(file_path, 'r', encoding='utf-8') as f:
            lines = f.readlines()
            
        content = "".join(lines)
        # Simple regex for single line H1 matches first for line numbers
        for i, line in enumerate(lines):
            if '<h1' in line:
                snippet = line.strip()[:40]
                status = "WARNING"
                if "hero" in display_name.lower() or "single" in display_name.lower():
                    status = "Likely OK"
                print(f"{display_name:<60} | {i+1:<5} | {snippet:<40} | {status}")
                
    except Exception as e:
        pass

def check_breadcrumbs():
    print("\n" + "="*50)
    print("Checking Breadcrumbs Logic")
    print("="*50)
    
    breadcrumb_pattern = re.compile(r'(breadcrumb|yoast_breadcrumb|rank_math_breadcrumb)')
    
    files_to_check = []
    for root, dirs, files in os.walk(THEME_DIR):
        if 'node_modules' in root: continue
        for file in files:
            if file.endswith('.php'):
                files_to_check.append(os.path.join(root, file))

    for file_path in files_to_check:
        try:
            with open(file_path, 'r', encoding='utf-8') as f:
                lines = f.readlines()
            for i, line in enumerate(lines):
                if breadcrumb_pattern.search(line):
                    rel_path = os.path.relpath(file_path, THEME_DIR)
                    print(f"Found in {rel_path}:{i+1}")
                    print(f"  > {line.strip()[:80]}")
        except:
            pass

def check_logo_responsive():
    print("\n" + "="*50)
    print("Checking Logo & Viewport Settings")
    print("="*50)
    
    # Check header.php for viewport
    header_path = os.path.join(THEME_DIR, 'header.php')
    if os.path.exists(header_path):
        with open(header_path, 'r') as f:
            content = f.read()
            if '<meta name="viewport"' in content:
                print("✅ Viewport meta tag found in header.php")
            else:
                print("❌ Viewport meta tag MISSING in header.php (Critical for mobile)")
    else:
         print("⚠️ header.php not found in child theme (using parent?)")

    # Check setup.php for logo support
    setup_path = os.path.join(THEME_DIR, 'inc/setup.php')
    if os.path.exists(setup_path):
        with open(setup_path, 'r') as f:
            content = f.read()
            if 'custom-logo' in content:
                 print("✅ 'custom-logo' theme support found in inc/setup.php")
    
    # Check CSS for logo constraints
    # This is a heuristic check
    print("\nScanning for potentially dangerous Logo CSS...")
    css_files = []
    for root, dirs, files in os.walk(THEME_DIR):
        if 'node_modules' in root: continue
        for file in files:
            if file.endswith('.css') or file.endswith('.php'): # inline css
                css_files.append(os.path.join(root, file))
                
    for file_path in css_files:
         try:
            with open(file_path, 'r', encoding='utf-8') as f:
                content = f.read()
            if '.site-logo' in content and ('width' in content or 'height' in content):
                 rel_path = os.path.relpath(file_path, THEME_DIR)
                 # print(f"ℹ️  Logo CSS found in {rel_path} (Manual check recommended)")
         except:
             pass

if __name__ == "__main__":
    print("SEO & Metadata Audit Running...\n")
    check_h1_tags()
    check_breadcrumbs()
    check_logo_responsive()
