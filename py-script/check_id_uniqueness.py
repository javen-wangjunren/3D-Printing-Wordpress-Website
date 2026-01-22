import os
import re

# Configuration
THEME_PATH = "/Users/javen/Local Sites/3d-printing/app/public/wp-content/themes/generatepress_child"
BLOCKS_DIR = os.path.join(THEME_PATH, "blocks/global")
SUSPICIOUS_IDS = ['primary', 'main', 'content', 'site-navigation', 'masthead', 'colophon']

def check_ids():
    print(f"{'Block Name':<30} | {'ID Type':<15} | {'Value/Variable':<40} | {'Status':<10}")
    print("-" * 100)

    all_hardcoded_ids = {} # id -> list of files
    
    for root, dirs, files in os.walk(BLOCKS_DIR):
        for file in files:
            if file == "render.php":
                file_path = os.path.join(root, file)
                block_name = os.path.basename(os.path.dirname(file_path))
                
                with open(file_path, 'r', encoding='utf-8') as f:
                    content = f.read()
                    
                # Regex to find id attributes
                # Handles: id="value", id='value', id="<?php echo $var; ?>"
                # We try to capture the content inside the quotes
                matches = re.finditer(r'\bid\s*=\s*(["\'])(.*?)\1', content, re.DOTALL)
                
                found_section_id = False
                
                for match in matches:
                    full_match = match.group(0)
                    id_val = match.group(2)
                    
                    # Check if it looks like a PHP variable or echo
                    is_dynamic = '<?php' in id_val or '$' in id_val
                    
                    status = "✅ OK"
                    
                    if is_dynamic:
                        id_type = "Dynamic"
                        # Simple check if it likely uses the standard block_id variable
                        if '$block_id' in id_val or '$id' in id_val:
                            pass
                        else:
                            status = "ℹ️ Custom Var"
                    else:
                        id_type = "Hardcoded"
                        status = "⚠️ Static"
                        
                        # Check for suspicious IDs
                        if id_val in SUSPICIOUS_IDS:
                            status = "❌ FORBIDDEN"
                        
                        # Track for duplicates
                        if id_val not in all_hardcoded_ids:
                            all_hardcoded_ids[id_val] = []
                        all_hardcoded_ids[id_val].append(block_name)

                    # We are mostly interested in the main section ID
                    # Heuristic: The first ID in the file or one on a <section> tag
                    # For now, let's print all found IDs to be thorough, 
                    # but we can filter if it gets too noisy.
                    
                    # Clean up the value for display (remove newlines/excess whitespace)
                    display_val = ' '.join(id_val.split()).strip()
                    if len(display_val) > 35:
                        display_val = display_val[:32] + "..."
                        
                    print(f"{block_name:<30} | {id_type:<15} | {display_val:<40} | {status:<10}")

    print("\n" + "="*100)
    print("DUPLICATE HARDCODED ID REPORT")
    print("-" * 100)
    has_dupes = False
    for id_val, blocks in all_hardcoded_ids.items():
        if len(blocks) > 1:
            has_dupes = True
            print(f"❌ Duplicate ID '{id_val}' found in: {', '.join(blocks)}")
    
    if not has_dupes:
        print("✅ No duplicate hardcoded IDs found across blocks.")

if __name__ == "__main__":
    check_ids()
