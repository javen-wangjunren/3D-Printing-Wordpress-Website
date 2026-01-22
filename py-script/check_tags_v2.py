import re
import sys

def check_tags(file_paths):
    for file_path in file_paths:
        print(f"Checking {file_path}...")
        try:
            with open(file_path, 'r', encoding='utf-8') as f:
                content = f.read()
        except Exception as e:
            print(f"Error reading {file_path}: {e}")
            continue

        # Remove PHP blocks to avoid confusion
        content_no_php = re.sub(r'<\?php.*?\?>', '', content, flags=re.DOTALL)
        
        # Remove HTML comments
        content_no_comments = re.sub(r'<!--.*?-->', '', content_no_php, flags=re.DOTALL)

        # Find all tags
        # We look for <div ...>, </div>, <section ...>, </section>
        # Case insensitive
        tag_pattern = re.compile(r'</?(div|section)\b[^>]*>', re.IGNORECASE | re.DOTALL)
        
        stack = []
        errors = []
        
        # We need line numbers, so we can't just finditer on the whole string without mapping back
        # But for structural correctness, we just need the sequence of tags.
        
        # Let's verify balance first.
        
        matches = list(tag_pattern.finditer(content_no_comments))
        
        for match in matches:
            tag_str = match.group(0)
            tag_name = re.match(r'</?(\w+)', tag_str).group(1).lower()
            is_closing = tag_str.startswith('</')
            
            if is_closing:
                if not stack:
                    errors.append(f"Unexpected closing tag </{tag_name}> around offset {match.start()}")
                else:
                    last_tag = stack.pop()
                    if last_tag != tag_name:
                        errors.append(f"Mismatched closing tag </{tag_name}> (expected </{last_tag}>) around offset {match.start()}")
            else:
                # Check for self-closing? Div and Section are usually not self-closing.
                stack.append(tag_name)
        
        if stack:
            errors.append(f"Unclosed tags remaining: {', '.join(stack)}")
            
        if errors:
            print("❌ Errors found:")
            for e in errors:
                print(e)
        else:
            print("✅ No tag errors found.")
        print("-" * 30)

if __name__ == "__main__":
    check_tags(sys.argv[1:])
