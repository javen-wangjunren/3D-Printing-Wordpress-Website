import os
import re

def audit_images(directory):
    print(f"Starting audit in: {directory}\n")
    
    img_tag_pattern = re.compile(r'<img\s+([^>]+)>', re.IGNORECASE)
    width_pattern = re.compile(r'width=["\'](.*?)["\']', re.IGNORECASE)
    height_pattern = re.compile(r'height=["\'](.*?)["\']', re.IGNORECASE)
    php_dynamic_pattern = re.compile(r'(<\?php|\$|{{|:|echo)', re.IGNORECASE) # PHP tag, variable, Alpine :binding, or echo
    
    issues_found = []
    
    for root, dirs, files in os.walk(directory):
        for file in files:
            if file == 'render.php':
                file_path = os.path.join(root, file)
                relative_path = os.path.relpath(file_path, directory)
                
                with open(file_path, 'r', encoding='utf-8') as f:
                    content = f.read()
                    
                # Find all <img> tags
                img_matches = img_tag_pattern.finditer(content)
                
                for match in img_matches:
                    img_attrs = match.group(1)
                    full_tag = match.group(0)
                    
                    # Skip if it's an Alpine.js dynamic binding (e.g., :src) because dimensions might not be statically available
                    # But user wants to ensure we have width/height if possible, or at least check them.
                    
                    width_match = width_pattern.search(img_attrs)
                    height_match = height_pattern.search(img_attrs)
                    
                    width_val = width_match.group(1) if width_match else None
                    height_val = height_match.group(1) if height_match else None
                    
                    is_dynamic_width = width_val and php_dynamic_pattern.search(width_val)
                    is_dynamic_height = height_val and php_dynamic_pattern.search(height_val)
                    
                    # Check for :width and :height (Alpine bindings)
                    alpine_width = ':width' in img_attrs
                    alpine_height = ':height' in img_attrs
                    
                    has_width = width_val or alpine_width
                    has_height = height_val or alpine_height
                    
                    status = "OK"
                    details = []
                    
                    if not has_width:
                        details.append("Missing width")
                    elif width_val and not is_dynamic_width and not width_val.isdigit():
                         # It has a value, but it's not dynamic and not a simple number (maybe hardcoded px?)
                         # If it is a digit (e.g. width="100"), that is "hardcoded" but technically valid HTML.
                         # User wants "dynamic via PHP", so strictly speaking hardcoded numbers are "static".
                         details.append(f"Static width: {width_val}")
                    elif width_val and width_val.isdigit():
                         details.append(f"Hardcoded width: {width_val}")

                    if not has_height:
                        details.append("Missing height")
                    elif height_val and not is_dynamic_height and not height_val.isdigit():
                         details.append(f"Static height: {height_val}")
                    elif height_val and height_val.isdigit():
                         details.append(f"Hardcoded height: {height_val}")

                    if details:
                        issues_found.append({
                            'file': relative_path,
                            'tag': full_tag,
                            'issues': details
                        })

    if issues_found:
        print(f"Found {len(issues_found)} potential issues:\n")
        for issue in issues_found:
            print(f"File: {issue['file']}")
            print(f"Tag: {issue['tag'].strip()[:100]}...") # Truncate long tags
            print(f"Issues: {', '.join(issue['issues'])}")
            print("-" * 40)
    else:
        print("✅ No issues found. All <img> tags appear to have dynamic or missing (handled by CSS/Alpine) dimensions.")

if __name__ == "__main__":
    target_dir = "/Users/javen/Local Sites/3d-printing/app/public/wp-content/themes/generatepress_child/blocks/global"
    audit_images(target_dir)
