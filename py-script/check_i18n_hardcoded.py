import os
import re

# Configuration
THEME_PATH = "/Users/javen/Local Sites/3d-printing/app/public/wp-content/themes/generatepress_child"
BLOCKS_DIR = os.path.join(THEME_PATH, "blocks/global")

# Regex to detect PHP tags
PHP_TAG_PATTERN = re.compile(r'<\?php.*?\?>', re.DOTALL)

# Regex to detect localization functions
I18N_FUNC_PATTERN = re.compile(r'\b(_e|__|esc_html_e|esc_html__|esc_attr_e|esc_attr__)\s*\(')

def is_suspicious_text(text):
    """
    Check if text contains alphanumeric characters and is NOT wrapped in PHP localization.
    """
    text = text.strip()
    if not text:
        return False
    
    # 1. Remove all PHP blocks to see what's left
    #    e.g. "View <?php echo $count; ?>" -> "View "
    text_no_php = PHP_TAG_PATTERN.sub('', text)
    
    # 2. If nothing significant remains, it's dynamic or empty
    #    Check for letters (English or Chinese)
    if not re.search(r'[a-zA-Z\u4e00-\u9fff]', text_no_php):
        return False
        
    # 3. If it contains PHP tags but they are NOT localization functions?
    #    Actually, if we stripped PHP and text remains, that text is hardcoded HTML text.
    #    e.g. "Name: <?php echo $name; ?>" -> "Name: " remains. -> Suspicious.
    
    return True

def is_suspicious_attr(attr_name, attr_value):
    """
    Check if attribute value is hardcoded text.
    """
    # Remove PHP blocks
    val_no_php = PHP_TAG_PATTERN.sub('', attr_value)
    
    # If text remains, it's hardcoded
    if re.search(r'[a-zA-Z\u4e00-\u9fff]', val_no_php):
        return True
        
    # If no text remains, it might be purely PHP. 
    # Check if that PHP uses localization?
    # e.g. "<?php echo $title; ?>" -> Not suspicious (dynamic)
    # e.g. "<?php _e('Search', 'domain'); ?>" -> Not suspicious
    # We assume purely dynamic PHP is OK for now (might be data from DB).
    return False

def check_i18n():
    print(f"{'Block Name':<30} | {'Line':<5} | {'Type':<10} | {'Content (Truncated)':<40} | {'Status':<10}")
    print("-" * 105)
    
    suspicious_count = 0

    for root, dirs, files in os.walk(BLOCKS_DIR):
        for file in files:
            if file == "render.php":
                file_path = os.path.join(root, file)
                block_name = os.path.basename(os.path.dirname(file_path))
                
                with open(file_path, 'r', encoding='utf-8') as f:
                    content = f.read()
                
                # Mask PHP content to avoid false positives with ?> or inside attributes
                # We replace PHP blocks with spaces to preserve line numbers
                content_masked = PHP_TAG_PATTERN.sub(lambda m: ' ' * len(m.group(0)), content)
                
                # 1. Check Text Content between tags: >CONTENT<
                # We look for > then anything not < then <
                matches_text = re.finditer(r'>([^<]+)<', content_masked)
                for match in matches_text:
                    text_content = match.group(1)
                    if is_suspicious_text(text_content):
                        # Find line number
                        start_pos = match.start(1)
                        line_num = content.count('\n', 0, start_pos) + 1
                        
                        display = text_content.strip().replace('\n', ' ')
                        if len(display) > 38: display = display[:35] + "..."
                        
                        print(f"{block_name:<30} | {line_num:<5} | {'Text':<10} | {display:<40} | ⚠️ Fix")
                        suspicious_count += 1

                # 2. Check Attributes (placeholder, aria-label, title, alt)
                matches_attr = re.finditer(r'\b(placeholder|aria-label|title|alt)\s*=\s*(["\'])(.*?)\2', content_masked)
                for match in matches_attr:
                    attr_name = match.group(1)
                    attr_val = match.group(3)
                    
                    if is_suspicious_text(attr_val): # Use same text check logic
                        # Find line number
                        start_pos = match.start(1)
                        line_num = content.count('\n', 0, start_pos) + 1
                        
                        display = f"{attr_name}='{attr_val}'".strip().replace('\n', ' ')
                        if len(display) > 38: display = display[:35] + "..."
                        
                        print(f"{block_name:<30} | {line_num:<5} | {'Attr':<10} | {display:<40} | ⚠️ Fix")
                        suspicious_count += 1

    print("-" * 105)
    if suspicious_count == 0:
        print("✅ No hardcoded text found.")
    else:
        print(f"⚠️ Found {suspicious_count} instances of hardcoded text.")

if __name__ == "__main__":
    check_i18n()
