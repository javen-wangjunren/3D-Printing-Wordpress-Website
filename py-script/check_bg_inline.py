import os
import re

blocks_dir = "/Users/javen/Local Sites/3d-printing/app/public/wp-content/themes/generatepress_child/blocks/global"

def check_block(block_name):
    render_path = os.path.join(blocks_dir, block_name, "render.php")
    if not os.path.exists(render_path):
        return "No render.php"

    with open(render_path, 'r', encoding='utf-8') as f:
        content = f.read()

    # Check for inline style usage
    has_inline_style = False
    if re.search(r'style=["\'].*?background-color:.*?\<\?php', content, re.DOTALL | re.IGNORECASE):
        has_inline_style = True
    elif 'style="background-color:' in content: # Simple string check
         has_inline_style = True

    # Check for class usage (potential old way)
    # Looking for class="..." containing $bg_color or bg-
    has_class_usage = False
    if re.search(r'class=["\'][^"\']*?\$bg_color[^"\']*?["\']', content):
        has_class_usage = True
    if re.search(r'class=["\'][^"\']*?bg-\<\?php', content):
        has_class_usage = True

    # Check if bg_color is fetched
    fetches_bg = False
    if "get_field_value" in content and ("background_color" in content or "bg_color" in content):
        fetches_bg = True
    elif "get_field" in content and ("background_color" in content or "bg_color" in content):
        fetches_bg = True
    
    status = "UNKNOWN"
    if has_inline_style:
        status = "✅ PASS (Inline Style)"
    elif has_class_usage:
        status = "❌ FAIL (Class Usage)"
    elif fetches_bg:
        status = "⚠️ WARNING (Fetches BG but no inline style found)"
    else:
        status = "⚪ NO BG LOGIC DETECTED"

    return status

print(f"{'Block Name':<30} | {'Status'}")
print("-" * 70)

dirs = sorted([d for d in os.listdir(blocks_dir) if os.path.isdir(os.path.join(blocks_dir, d))])

for d in dirs:
    status = check_block(d)
    print(f"{d:<30} | {status}")
