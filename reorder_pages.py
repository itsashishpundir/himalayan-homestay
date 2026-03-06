import os

filepath = r'c:\laragon\www\Himalyanmart\wp-content\themes\himalayan-homestay\inc\customizer-pages.php'
with open(filepath, 'r', encoding='utf-8') as f:
    text = f.read()

# Replace panels
text = text.replace("'hhb_frontpage_panel'", "'hhb_pages_panel'")
text = text.replace("'hhb_contact_panel'", "'hhb_pages_panel'")

# Remove the Contact Page Panel definition
contact_panel_pattern = """    /* ── Panel: Contact Page ────────────────────────────────────── */
    $wp_customize->add_panel( 'hhb_pages_panel', [
        'title'    => '📞 Contact Page',
        'priority' => 26,
    ] );"""

text = text.replace(contact_panel_pattern, "")

# Update the frontpage panel definition to be the new master pages panel
frontpage_panel_old = """    /* ── Panel: Front Page ──────────────────────────────────────── */
    $wp_customize->add_panel( 'hhb_pages_panel', [
        'title'    => '🏠 Homepage Sections',
        'priority' => 25,
    ] );"""

frontpage_panel_new = """    /* ── Panel: Page-Specific Settings ──────────────────────────────────────── */
    $wp_customize->add_panel( 'hhb_pages_panel', [
        'title'    => '📄 Page-Specific Settings',
        'priority' => 26,
    ] );"""

text = text.replace(frontpage_panel_old, frontpage_panel_new)

# Now, we need to inject the become_a_host_block just before `} );` which ends the customize_register action
with open('become_a_host_block.txt', 'r', encoding='utf-8') as f:
    become_a_host = f.read()

# The become a host block currently has 'panel' => 'himalayanmart_layouts_panel'
become_a_host = become_a_host.replace("'himalayanmart_layouts_panel'", "'hhb_pages_panel'")

# The block is currently just code that expects $wp_customize to be in scope.
# The customizer-pages.php wraps everything in add_action( 'customize_register', function( $wp_customize ) { ... } );
# So we insert it right before the closure ends.

end_closure_str = "    }\n} );"
insert_pos = text.find(end_closure_str)

if insert_pos != -1:
    new_text = text[:insert_pos] + "\n" + become_a_host + "\n" + text[insert_pos:]
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(new_text)
    print("Success: customizer-pages.php rewritten.")
else:
    print("Failed to find closure end in customizer-pages.php")
