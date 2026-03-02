<?php
/**
 * Customizer settings for Homepage and Contact Page.
 *
 * @package HimalayanHomestay
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ══════════════════════════════════════════════════════════════════
 * CUSTOMIZER PANELS & SETTINGS
 * ══════════════════════════════════════════════════════════════════ */
add_action( 'customize_register', function( $wp_customize ) {

    /* ── Panel: Front Page ──────────────────────────────────────── */
    $wp_customize->add_panel( 'hhb_frontpage_panel', [
        'title'    => '🏠 Homepage Sections',
        'priority' => 25,
    ] );

    // --- Hero Section ---
    $wp_customize->add_section( 'hhb_hero_section', [
        'title' => 'Hero Section',
        'panel' => 'hhb_frontpage_panel',
    ] );

    $wp_customize->add_setting( 'hhb_home_hero_image', [ 'default' => 'https://images.unsplash.com/photo-1516575150278-77136aed6920?q=80&w=2940&auto=format&fit=crop', 'sanitize_callback' => 'esc_url_raw' ] );
    $wp_customize->add_control( new \WP_Customize_Image_Control( $wp_customize, 'hhb_home_hero_image', [
        'label'   => 'Hero Background Image',
        'section' => 'hhb_hero_section',
    ] ) );

    $wp_customize->add_setting( 'hhb_home_hero_heading', [ 'default' => 'Stay in the Heart of the Himalayas', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'hhb_home_hero_heading', [ 'label' => 'Heading', 'section' => 'hhb_hero_section', 'type' => 'text' ] );

    $wp_customize->add_setting( 'hhb_home_hero_subheading', [ 'default' => 'Handpicked homestays with local hospitality — breathtaking views, warm hosts, unforgettable mornings.', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'hhb_home_hero_subheading', [ 'label' => 'Subheading', 'section' => 'hhb_hero_section', 'type' => 'textarea' ] );

    // --- Trust Section ---
    $wp_customize->add_section( 'hhb_trust_section', [
        'title' => 'Why Choose Us',
        'panel' => 'hhb_frontpage_panel',
    ] );

    $wp_customize->add_setting( 'hhb_trust_heading', [ 'default' => 'Why Book With Us', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'hhb_trust_heading', [ 'label' => 'Section Heading', 'section' => 'hhb_trust_section', 'type' => 'text' ] );

    $wp_customize->add_setting( 'hhb_trust_subheading', [ 'default' => 'We do things differently — no middlemen, no inflated prices, just honest mountain hospitality.', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'hhb_trust_subheading', [ 'label' => 'Section Subheading', 'section' => 'hhb_trust_section', 'type' => 'textarea' ] );

    $trust_defaults = [
        1 => [ 'Verified Properties',  'Every stay personally inspected by our team.' ],
        2 => [ 'Transparent Pricing',  'What you see is what you pay. No hidden fees.' ],
        3 => [ 'Direct Booking',       'Book directly with hosts. No middlemen, no commission markup.' ],
        4 => [ 'Local Support',        'Our team is based in the mountains, always reachable.' ],
        5 => [ 'Clean & Comfortable',  'Quality beds, hot water, clean linens — guaranteed.' ],
    ];
    foreach ( $trust_defaults as $n => $def ) {
        $wp_customize->add_setting( "hhb_trust_{$n}_title", [ 'default' => $def[0], 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( "hhb_trust_{$n}_title", [ 'label' => "Card {$n} Title", 'section' => 'hhb_trust_section', 'type' => 'text' ] );
        $wp_customize->add_setting( "hhb_trust_{$n}_desc", [ 'default' => $def[1], 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( "hhb_trust_{$n}_desc", [ 'label' => "Card {$n} Description", 'section' => 'hhb_trust_section', 'type' => 'textarea' ] );
    }

    // --- How It Works Section ---
    $wp_customize->add_section( 'hhb_steps_section', [
        'title' => 'How It Works',
        'panel' => 'hhb_frontpage_panel',
    ] );

    $step_defaults = [
        1 => [ 'Choose Your Stay',     'Browse our curated collection of verified mountain homestays.' ],
        2 => [ 'Confirm Availability',  'Pick your dates and check real-time availability.' ],
        3 => [ 'Secure Payment',        'Pay safely online. Your money is protected.' ],
        4 => [ 'Enjoy Your Trip',       'Pack your bags and enjoy authentic mountain living.' ],
    ];
    foreach ( $step_defaults as $n => $def ) {
        $wp_customize->add_setting( "hhb_step_{$n}_title", [ 'default' => $def[0], 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( "hhb_step_{$n}_title", [ 'label' => "Step {$n} Title", 'section' => 'hhb_steps_section', 'type' => 'text' ] );
        $wp_customize->add_setting( "hhb_step_{$n}_desc", [ 'default' => $def[1], 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( "hhb_step_{$n}_desc", [ 'label' => "Step {$n} Description", 'section' => 'hhb_steps_section', 'type' => 'textarea' ] );
    }

    /* ── Panel: Contact Page ────────────────────────────────────── */
    $wp_customize->add_panel( 'hhb_contact_panel', [
        'title'    => '📞 Contact Page',
        'priority' => 26,
    ] );

    // --- Banner ---
    $wp_customize->add_section( 'hhb_contact_banner_section', [
        'title' => 'Banner',
        'panel' => 'hhb_contact_panel',
    ] );

    $wp_customize->add_setting( 'hhb_contact_banner_image', [ 'default' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=2940&auto=format&fit=crop', 'sanitize_callback' => 'esc_url_raw' ] );
    $wp_customize->add_control( new \WP_Customize_Image_Control( $wp_customize, 'hhb_contact_banner_image', [
        'label'   => 'Banner Image',
        'section' => 'hhb_contact_banner_section',
    ] ) );

    $wp_customize->add_setting( 'hhb_contact_heading', [ 'default' => 'Get in Touch', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'hhb_contact_heading', [ 'label' => 'Heading', 'section' => 'hhb_contact_banner_section', 'type' => 'text' ] );

    $wp_customize->add_setting( 'hhb_contact_subheading', [ 'default' => "Have a question or need help planning your stay? We're here for you.", 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'hhb_contact_subheading', [ 'label' => 'Subheading', 'section' => 'hhb_contact_banner_section', 'type' => 'textarea' ] );

    // --- Contact Info ---
    $wp_customize->add_section( 'hhb_contact_info_section', [
        'title' => 'Contact Details',
        'panel' => 'hhb_contact_panel',
    ] );

    $info_fields = [
        'hhb_contact_address'   => [ 'Address',         'Village Jibhi, Tirthan Valley, Banjar, Himachal Pradesh 175143, India' ],
        'hhb_contact_phone_1'   => [ 'Phone 1',         '+91 98765 43210' ],
        'hhb_contact_phone_2'   => [ 'Phone 2',         '' ],
        'hhb_contact_email_1'   => [ 'Email 1',         'hello@himalayanhomestay.com' ],
        'hhb_contact_email_2'   => [ 'Email 2',         'bookings@himalayanhomestay.com' ],
        'hhb_contact_hours_1'   => [ 'Hours Line 1',    'Mon–Sat: 9:00 AM – 7:00 PM IST' ],
        'hhb_contact_hours_2'   => [ 'Hours Line 2',    'Sunday: 10:00 AM – 5:00 PM IST' ],
        'hhb_contact_whatsapp'  => [ 'WhatsApp Number',  '919876543210' ],
        'hhb_contact_map_embed' => [ 'Google Maps Embed URL', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d54000!2d77.35!3d31.6!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2sTirthan+Valley!5e0!3m2!1sen!2sin!4v1' ],
    ];
    foreach ( $info_fields as $key => $meta ) {
        $wp_customize->add_setting( $key, [ 'default' => $meta[1], 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( $key, [ 'label' => $meta[0], 'section' => 'hhb_contact_info_section', 'type' => 'text' ] );
    }

    // --- FAQs ---
    $wp_customize->add_section( 'hhb_contact_faq_section', [
        'title' => 'FAQ Section',
        'panel' => 'hhb_contact_panel',
    ] );

    $faq_defaults = [
        1 => [ 'How do I book a homestay?',                      'Browse our listings, select your dates, and complete a quick booking request. Once the host confirms availability, you\'ll receive a secure payment link. Your booking is confirmed after payment.' ],
        2 => [ 'What is the cancellation policy?',               'Free cancellation up to 7 days before check-in. For cancellations within 7 days, a 50% charge applies. No-shows are charged in full.' ],
        3 => [ 'Do you offer airport or bus stand transfers?',   'Yes! Most of our homestays can arrange pickup from the nearest bus stand or airport. Contact us after booking to arrange transfers at a nominal additional cost.' ],
        4 => [ 'Are your homestays pet-friendly?',               'Some of our properties welcome pets. Check individual property pages for pet-friendly badges, or contact us and we\'ll recommend the best options.' ],
        5 => [ 'What payment methods do you accept?',            'We accept UPI, credit/debit cards, net banking via Razorpay, and international cards via Stripe. All payments are secured with bank-grade encryption.' ],
    ];
    foreach ( $faq_defaults as $n => $def ) {
        $wp_customize->add_setting( "hhb_faq_{$n}_q", [ 'default' => $def[0], 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( "hhb_faq_{$n}_q", [ 'label' => "FAQ {$n} Question", 'section' => 'hhb_contact_faq_section', 'type' => 'text' ] );
        $wp_customize->add_setting( "hhb_faq_{$n}_a", [ 'default' => $def[1], 'sanitize_callback' => 'sanitize_textarea_field' ] );
        $wp_customize->add_control( "hhb_faq_{$n}_a", [ 'label' => "FAQ {$n} Answer", 'section' => 'hhb_contact_faq_section', 'type' => 'textarea' ] );
    }
} );


/* ══════════════════════════════════════════════════════════════════
 * CONTACT FORM AJAX HANDLER
 * ══════════════════════════════════════════════════════════════════ */
add_action( 'wp_ajax_hhb_contact_form_submit',        'hhb_handle_contact_form' );
add_action( 'wp_ajax_nopriv_hhb_contact_form_submit', 'hhb_handle_contact_form' );

function hhb_handle_contact_form() {
    if ( ! wp_verify_nonce( $_POST['hhb_contact_nonce'] ?? '', 'hhb_contact_form' ) ) {
        wp_send_json_error( 'Security check failed.' );
    }

    // Honeypot Trap
    if ( ! empty( $_POST['hhb_contact_website'] ) ) {
        wp_send_json_success( 'Thank you! Your message has been sent. We\'ll get back to you within 24 hours.' );
    }

    // Rate limiting: max 5 messages per IP per hour.
    $ip       = sanitize_text_field( $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0' );
    $rate_key = 'hhb_contact_rate_' . md5( $ip );
    $attempts = (int) get_transient( $rate_key );
    if ( $attempts >= 5 ) {
        wp_send_json_error( 'Too many messages sent recently. Please try again later.' );
    }
    set_transient( $rate_key, $attempts + 1, HOUR_IN_SECONDS );

    $name    = sanitize_text_field( $_POST['fullname'] ?? '' );
    $email   = sanitize_email( $_POST['email'] ?? '' );
    $phone   = sanitize_text_field( $_POST['phone'] ?? '' );
    $subject = sanitize_text_field( $_POST['subject'] ?? 'General Inquiry' );
    $message = sanitize_textarea_field( $_POST['message'] ?? '' );

    if ( empty( $name ) || empty( $email ) || empty( $message ) ) {
        wp_send_json_error( 'Please fill in all required fields.' );
    }

    $subject_map = [
        'general'     => 'General Inquiry',
        'booking'     => 'Booking Help',
        'partnership' => 'Partnership',
        'feedback'    => 'Feedback',
        'other'       => 'Other',
    ];
    $subject_label = $subject_map[ $subject ] ?? $subject;

    // Send email to admin
    $admin_email = get_option( 'admin_email' );
    $mail_subject = sprintf( '[Contact Form] %s from %s', $subject_label, $name );
    $mail_body = sprintf(
        "Name: %s\nEmail: %s\nPhone: %s\nSubject: %s\n\nMessage:\n%s",
        $name, $email, $phone ?: 'Not provided', $subject_label, $message
    );
    $headers = [
        'From: ' . $name . ' <' . $email . '>',
        'Reply-To: ' . $email,
    ];

    $sent = wp_mail( $admin_email, $mail_subject, $mail_body, $headers );

    if ( $sent ) {
        wp_send_json_success( 'Thank you! Your message has been sent. We\'ll get back to you within 24 hours.' );
    } else {
        wp_send_json_error( 'Something went wrong sending your message. Please try again or contact us directly.' );
    }
}

/* ══════════════════════════════════════════════════════════════════
 * LAZY LOAD REVIEWS AJAX HANDLER
 * ══════════════════════════════════════════════════════════════════ */
add_action( 'wp_ajax_hhb_load_reviews',        'hhb_ajax_load_reviews' );
add_action( 'wp_ajax_nopriv_hhb_load_reviews', 'hhb_ajax_load_reviews' );

function hhb_ajax_load_reviews() {
    global $wpdb;
    $reviews_table = $wpdb->prefix . 'hhb_reviews';
    $table_exists  = $wpdb->get_var( "SHOW TABLES LIKE '{$reviews_table}'" );
    
    if ( ! $table_exists ) {
        wp_send_json_error( 'Reviews table not found.' );
    }

    $reviews = $wpdb->get_results(
        "SELECT r.*, p.post_title AS homestay_name
         FROM {$reviews_table} r
         LEFT JOIN {$wpdb->posts} p ON r.homestay_id = p.ID
         WHERE r.status = 'approved'
         ORDER BY r.created_at DESC
         LIMIT 6"
    );

    if ( empty( $reviews ) ) {
        wp_send_json_error( 'No reviews found.' );
    }

    // Format output
    ob_start();
    foreach ( $reviews as $review ) : ?>
        <div class="hhb-review-card opacity-0 translate-y-4 transition-all duration-700 ease-out">
            <div class="hhb-review-stars mb-3">
                <?php for ( $s = 1; $s <= 5; $s++ ) : ?>
                    <span class="material-symbols-outlined text-base" style="font-variation-settings: 'FILL' <?php echo $s <= $review->rating ? '1' : '0'; ?>">star</span>
                <?php endfor; ?>
            </div>
            <p class="text-slate-600 text-sm italic leading-relaxed mb-5">
                "<?php echo esc_html( wp_trim_words( $review->comment, 30, '…' ) ); ?>"
            </p>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-black text-sm">
                    <?php echo esc_html( strtoupper( substr( $review->guest_name, 0, 1 ) ) ); ?>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-900"><?php echo esc_html( $review->guest_name ); ?></p>
                    <?php if ( ! empty( $review->homestay_name ) ) : ?>
                        <p class="text-[11px] text-slate-400"><?php echo esc_html( $review->homestay_name ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach;
    $html = ob_get_clean();

    wp_send_json_success( $html );
}
