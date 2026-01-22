
import glob
import re
import os

def check_render_files():
    render_files = glob.glob('/Users/javen/Local Sites/3d-printing/app/public/wp-content/themes/generatepress_child/blocks/global/*/render.php')
    
    issues = []
    
    img_tag_pattern = re.compile(r'<img\s+([^>]+)>', re.IGNORECASE)
    
    for file_path in render_files:
        with open(file_path, 'r') as f:
            content = f.read()
            
        # Find all img tags
        matches = img_tag_pattern.finditer(content)
        
        for match in matches:
            attrs = match.group(1)
            
            # Check for width and height attributes (dynamic or static)
            has_width = 'width=' in attrs or ':width=' in attrs or 'width="<?php' in attrs
            has_height = 'height=' in attrs or ':height=' in attrs or 'height="<?php' in attrs
            
            if not (has_width and has_height):
                # Check if it is using wp_get_attachment_image (which renders an img tag, but not visible in the source code as <img ...>)
                # Wait, this script only checks literal <img ...> tags in the PHP source.
                
                # Check if it's a dynamic echo that might output attributes?
                # e.g. <img <?php echo $attrs; ?>>
                # But usually we see <img src="..." ...>
                
                issues.append({
                    'file': os.path.basename(os.path.dirname(file_path)) + '/render.php',
                    'tag': match.group(0),
                    'missing': [] + (['width'] if not has_width else []) + (['height'] if not has_height else [])
                })

    return issues

if __name__ == "__main__":
    issues = check_render_files()
    if issues:
        print(f"Found {len(issues)} issues:")
        for issue in issues:
            print(f"- {issue['file']}: Missing {', '.join(issue['missing'])}")
            print(f"  Tag: {issue['tag'][:100]}...")
    else:
        print("All manual <img> tags have width and height attributes.")
