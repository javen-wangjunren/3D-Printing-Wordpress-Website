import os
import re

# Define the root directory for blocks
BLOCKS_DIR = '/Users/javen/Local Sites/3d-printing/app/public/wp-content/themes/generatepress_child/blocks/global'

# Regexes
Z_INDEX_REGEX = r'\bz-(\d+|auto)\b'
OVERFLOW_REGEX = r'\boverflow-hidden\b'
RELATIVE_REGEX = r'\brelative\b'
ABSOLUTE_REGEX = r'\babsolute\b'
TRANSFORM_REGEX = r'\b(scale-|translate-|rotate-|skew-)\w+'
SHADOW_REGEX = r'\bshadow(-[a-z]+)?\b'

def check_zindex_issues():
    print(f"{'Block Name':<30} | {'Risk Factors':<60} | {'Status'}")
    print("-" * 100)

    for block_name in sorted(os.listdir(BLOCKS_DIR)):
        block_path = os.path.join(BLOCKS_DIR, block_name)
        render_path = os.path.join(block_path, 'render.php')

        if not os.path.isdir(block_path) or not os.path.exists(render_path):
            continue

        with open(render_path, 'r', encoding='utf-8') as f:
            content = f.read()

        risks = []
        
        # Check for Z-Index
        z_matches = re.findall(Z_INDEX_REGEX, content)
        if z_matches:
            # Filter out small z-indices? No, list all for manual review.
            risks.append(f"Z-Index: {', '.join(z_matches)}")
            
        # Check for Overflow Hidden on potential containers
        # This is a bit heuristic. We look for 'overflow-hidden' and see if 'shadow' or 'absolute' is also present.
        has_overflow = bool(re.search(OVERFLOW_REGEX, content))
        has_shadow = bool(re.search(SHADOW_REGEX, content))
        has_transform = bool(re.search(TRANSFORM_REGEX, content))
        has_absolute = bool(re.search(ABSOLUTE_REGEX, content))
        
        if has_overflow:
            if has_shadow:
                risks.append("Overflow+Shadow (Clip Risk)")
            if has_transform:
                 risks.append("Overflow+Transform (Clip Risk)")
            if has_absolute:
                 risks.append("Overflow+Absolute")
        
        status = "✅ Low Risk"
        if "Clip Risk" in str(risks):
            status = "⚠️ Potential Clipping"
        if z_matches:
            # Check if any Z-Index is high (e.g. > 10) which might compete with header (z-40)
            high_z = any(int(z) >= 10 for z in z_matches if z.isdigit())
            if high_z:
                status = "⚠️ High Z-Index"
                
        if not risks:
            risks.append("None")

        print(f"{block_name:<30} | {', '.join(risks)[:60]:<60} | {status}")

if __name__ == "__main__":
    check_zindex_issues()
