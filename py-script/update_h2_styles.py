import os
import re

# Define the target directory
base_dir = "/Users/javen/Local Sites/3d-printing/app/public/wp-content/themes/generatepress_child/blocks/global"

# Regex pattern to match <h2 class="..."> and capture the entire tag
# It looks for <h2, followed by any characters until class="...", and ends with >
# We want to replace whatever is in class="..." with "text-heading"
# Or just replace the whole class attribute if it exists.
h2_pattern = re.compile(r'(<h2[^>]*?class=["\'])([^"\']*?)(["\'][^>]*?>)', re.IGNORECASE | re.DOTALL)

def process_file(file_path):
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()

    # Replacement function
    def replace_h2(match):
        prefix = match.group(1) # <h2...class="
        suffix = match.group(3) # ">
        return f'{prefix}text-heading{suffix}'

    new_content = h2_pattern.sub(replace_h2, content)

    if new_content != content:
        with open(file_path, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print(f"Updated: {file_path}")
        return True
    return False

def main():
    count = 0
    for root, dirs, files in os.walk(base_dir):
        for file in files:
            if file == "render.php":
                file_path = os.path.join(root, file)
                if process_file(file_path):
                    count += 1
    print(f"Total files updated: {count}")

if __name__ == "__main__":
    main()
