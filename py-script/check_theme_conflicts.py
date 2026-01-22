import os
import re

# Define paths
THEME_DIR = os.getcwd()
BLOCKS_DIR = os.path.join(THEME_DIR, 'blocks/global')
SETUP_FILE = os.path.join(THEME_DIR, 'inc/setup.php')
TAILWIND_CONFIG = os.path.join(THEME_DIR, 'tailwind.config.js')

def check_theme_conflicts():
    print(f"{'Check Item':<30} | {'Status':<10} | {'Details':<50}")
    print("-" * 95)
    
    # 1. Check Global Container Width Override
    # We look for add_filter( 'generate_container_width', ... )
    has_container_filter = False
    container_filter_commented = False
    
    try:
        with open(SETUP_FILE, 'r', encoding='utf-8') as f:
            content = f.read()
            if "add_filter( 'generate_container_width'" in content or "add_filter('generate_container_width'" in content:
                # Check if it's commented out
                if re.search(r"//\s*add_filter\(\s*'generate_container_width'", content):
                    container_filter_commented = True
                else:
                    has_container_filter = True
    except FileNotFoundError:
        print(f"{'Container Filter':<30} | {'ERROR':<10} | {'inc/setup.php not found'}")

    if has_container_filter:
        print(f"{'Container Width Override':<30} | {'PASS':<10} | {'Filter found in setup.php'}")
    elif container_filter_commented:
        print(f"{'Container Width Override':<30} | {'WARNING':<10} | {'Filter exists but is commented out in setup.php'}")
    else:
        print(f"{'Container Width Override':<30} | {'FAIL':<10} | {'No filter found. Modules may be boxed by GP.'}")

    # 2. Check Tailwind Important Strategy
    # We look for 'important: true' or 'important:true'
    is_important_mode = False
    try:
        with open(TAILWIND_CONFIG, 'r', encoding='utf-8') as f:
            content = f.read()
            if "important:true" in content.replace(" ", ""):
                is_important_mode = True
    except FileNotFoundError:
        print(f"{'Tailwind Config':<30} | {'ERROR':<10} | {'tailwind.config.js not found'}")

    if is_important_mode:
        print(f"{'Tailwind Specificity':<30} | {'PASS':<10} | {'important: true enabled. Tailwind wins conflicts.'}")
    else:
        print(f"{'Tailwind Specificity':<30} | {'WARNING':<10} | {'important: false. GP styles may override Tailwind.'}")

    print("-" * 95)
    print("Scanning blocks for Header Typography (h1-h6) without Tailwind spacing classes...")
    print("(GP adds default bottom margins to headers. Without 'mb-0' or similar, layout may break)")
    print("-" * 95)

    # 3. Scan Blocks for Naked Headers
    # Regex to find <h1...class="...">...</h1>
    # We want to catch cases where class is missing OR class doesn't have spacing
    
    header_pattern = re.compile(r'<(h[1-6])([^>]*)>')
    
    # Spacing classes (simplified)
    # m-, p-, my-, py-, mb-, pb-, mt-, pt-, leading-
    spacing_regex = re.compile(r'\b(m|p|my|py|mx|px|mb|pb|mt|pt|leading)-')
    
    risky_headers = 0
    
    for root, dirs, files in os.walk(BLOCKS_DIR):
        for file in files:
            if file == "render.php":
                file_path = os.path.join(root, file)
                block_name = os.path.basename(os.path.dirname(file_path))
                
                try:
                    with open(file_path, 'r', encoding='utf-8') as f:
                        lines = f.readlines()
                except Exception as e:
                    continue
                
                for i, line in enumerate(lines):
                    line_num = i + 1
                    matches = header_pattern.findall(line)
                    
                    for tag, attrs in matches:
                        # Check if class attribute exists
                        class_match = re.search(r'class=["\']([^"\']*)["\']', attrs)
                        
                        is_risky = False
                        if not class_match:
                            is_risky = True # No class at all
                            details = "No class attribute"
                        else:
                            classes = class_match.group(1)
                            if not spacing_regex.search(classes):
                                is_risky = True
                                details = "No spacing/leading classes"
                        
                        if is_risky:
                            snippet = line.strip()[:60]
                            print(f"{block_name:<20} | {tag:<4} | {line_num:<5} | {details:<25} | {snippet}")
                            risky_headers += 1

    if risky_headers == 0:
        print("No risky headers found. All headers have Tailwind spacing classes.")
    else:
        print("-" * 95)
        print(f"Total Risky Headers: {risky_headers}")
        print("Action: Add 'mb-0', 'leading-tight', or specific spacing classes to override GP defaults.")

if __name__ == "__main__":
    check_theme_conflicts()
