import re
import os

filepath = r'c:\laragon\www\Himalyanmart\wp-content\themes\himalayan-homestay\inc\customizer\header-footer.php'

with open(filepath, 'r', encoding='utf-8') as f:
    text = f.read()

# Define the markers
p_modern_footer = r"(\s*// ==============================================\s*// MODERN MULTI-COLUMN FOOTER SETTINGS\s*// ==============================================.*?)(?=\s*// --- QUICK ACCESS BUTTONS ---)"
p_quick_access = r"(\s*// --- QUICK ACCESS BUTTONS ---.*?)(?=\s*// ==============================================\s*// FUTURASTAYS GLASS HEADER SETTINGS)"
p_futura_header = r"(\s*// ==============================================\s*// FUTURASTAYS GLASS HEADER SETTINGS.*?)(?=\s*// ==============================================\s*// FUTURASTAYS NEWSLETTER FOOTER SETTINGS)"
p_futura_footer = r"(\s*// ==============================================\s*// FUTURASTAYS NEWSLETTER FOOTER SETTINGS.*?)(?=\s*// ==============================================\s*// BECOME-A-HOST PAGE SETTINGS)"
p_become_a_host = r"(\s*// ==============================================\s*// BECOME-A-HOST PAGE SETTINGS.*?\n}\n)"

# Find the blocks
modern_footer_match = re.search(p_modern_footer, text, re.DOTALL)
quick_access_match = re.search(p_quick_access, text, re.DOTALL)
futura_header_match = re.search(p_futura_header, text, re.DOTALL)
futura_footer_match = re.search(p_futura_footer, text, re.DOTALL)
become_a_host_match = re.search(p_become_a_host, text, re.DOTALL)

if modern_footer_match and quick_access_match and futura_header_match and futura_footer_match and become_a_host_match:
    modern_footer = modern_footer_match.group(1)
    quick_access = quick_access_match.group(1)
    futura_header = futura_header_match.group(1)
    futura_footer = futura_footer_match.group(1)
    become_a_host = become_a_host_match.group(1)

    # Save become a host to a side file to be injected into customizer-pages.php later
    with open('become_a_host_block.txt', 'w', encoding='utf-8') as f:
        f.write(become_a_host)
    
    # Text before modern_footer
    before_index = modern_footer_match.start()
    before_text = text[:before_index]
    
    # Construct new header-footer.php
    new_text = before_text + quick_access + futura_header + modern_footer + futura_footer + "\n}\n"
    
    # Replace panel title
    new_text = new_text.replace("'title'       => __('Header & Footer Layouts', 'himalayanmart'),", "'title'       => __('🎨 Header & Footer Settings', 'himalayanmart'),")

    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(new_text)
    print("Success: header-footer.php reorganized.")
else:
    print("Failed to find all blocks.")
