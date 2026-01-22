import os
import re

# Define directory to scan
BLOCKS_DIR = os.path.join(os.getcwd(), 'blocks/global')

# Regex patterns
# 1. Catch variable assignments from ACF functions
# Matches: $my_var = get_field('name'...) or $my_var = get_sub_field('name'...) or $my_var = get_field_value(...)
ASSIGNMENT_PATTERN = re.compile(r'\$([a-zA-Z0-9_]+)\s*=\s*(?:get_field|get_sub_field|get_field_value)\s*\(')

# 2. Catch array or property access
# We will generate this dynamically for each variable: \$VAR(\[|->)

def check_field_safety():
    print(f"{'Block Name':<30} | {'Variable':<20} | {'Line':<5} | {'Risky Access Pattern':<40}")
    print("-" * 105)
    
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

                # 1. Find all variables assigned by ACF functions in this file
                # We store them as a set of variable names
                acf_vars = set()
                
                # We also want to know *where* they were assigned to verify usage comes *after* assignment?
                # For simplicity, we just collect all such vars in the file first.
                # A better approach: scan line by line.
                
                # Let's do line by line scanning for assignments, and then look for usages?
                # No, variable might be used much later.
                
                # Pass 1: Find all ACF variables
                for line in lines:
                    matches = ASSIGNMENT_PATTERN.findall(line)
                    for var_name in matches:
                        acf_vars.add(var_name)
                
                if not acf_vars:
                    continue

                # Pass 2: Check for direct array/property access on these variables
                # We want to flag cases where $var['key'] or $var->key is used.
                # We can't easily check for "if ($var)" wrapping with regex, 
                # so we will flag ALL accesses and manually review/filter.
                
                for i, line in enumerate(lines):
                    line_num = i + 1
                    
                    # Skip commented lines (simple check)
                    if line.strip().startswith('//') or line.strip().startswith('*'):
                        continue
                        
                    for var in acf_vars:
                        # Regex for usage: $var[ or $var->
                        # We use \b to ensure we match whole variable name
                        usage_pattern = re.compile(rf'\${var}\s*(\[|->)')
                        match = usage_pattern.search(line)
                        
                        if match:
                            # Found a potential risky access
                            access_type = match.group(1) # '[' or '->'
                            
                            # Heuristic to reduce noise:
                            # If the line contains "if (", "isset(", "!empty(", or "?", it might be a check.
                            # We want to find the *unsafe* ones.
                            # The user specifically asked about "$link = ...; echo $link['url']" without check.
                            
                            is_guarded = False
                            stripped_line = line.strip()
                            
                            # Simple keywords that suggest a check on the SAME line
                            if 'isset(' in stripped_line or '!empty(' in stripped_line or '??' in stripped_line:
                                is_guarded = True
                            
                            # If it's inside an echo or direct usage without standard checks
                            # It's hard to know if it's inside an 'if' block from previous lines.
                            # So we will report it, but maybe mark "Likely Safe" if it looks like a check?
                            
                            if not is_guarded:
                                snippet = line.strip()[:40]
                                print(f"{block_name:<30} | ${var:<19} | {line_num:<5} | {snippet}")
                                risky_count += 1

    print("-" * 105)
    print(f"Total potential risky accesses found: {risky_count}")
    print("Note: This script flags direct array/object access. Manual review is required to verify if an enclosing 'if' check exists.")

if __name__ == "__main__":
    check_field_safety()
