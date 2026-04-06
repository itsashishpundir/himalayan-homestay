<?php
/**
 * Template Name: Contact Us
 *
 * Contact page with the "Mountain Ethereal" aesthetic.
 * Fully customizable via repeaters in the WordPress Customizer.
 *
 * @package HimalayanHomestay
 */

get_header();

// ── Customizer Values ──────────────────────────────────────────────
$banner_img   = get_theme_mod( 'hhb_contact_banner_image', 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=2940&auto=format&fit=crop' );
$heading      = get_theme_mod( 'hhb_contact_heading', 'Get in Touch' );
$subheading   = get_theme_mod( 'hhb_contact_subheading', 'Have a question or need help planning your stay? We\'re here for you.' );
$map_embed    = get_theme_mod( 'hhb_contact_map_embed', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d54000!2d77.35!3d31.6!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2sTirthan+Valley!5e0!3m2!1sen!2sin!4v1' );

// Contact Details Repeater
$contact_json = get_theme_mod( 'hhb_contact_cards', '[]' );
$contact_data = json_decode( $contact_json, true ) ?: [];
if ( empty( $contact_data ) ) {
    $contact_data = [
        [ 'q' => 'Our Location', 'a' => 'Village Jibhi, Tirthan Valley, Banjar, Himachal Pradesh 175143, India' ],
        [ 'q' => 'Call Us',       'a' => '+91 98765 43210' ],
        [ 'q' => 'Email Us',      'a' => 'hello@himalayanhomestay.com' ]
    ];
}

// FAQs Repeater
$faq_json = get_theme_mod( 'hhb_contact_faq_items', '[]' );
$faq_data = json_decode( $faq_json, true ) ?: [];
if ( empty( $faq_data ) ) {
    $faq_data = [
        [ 'q' => 'How do I book a homestay?', 'a' => 'Browse our listings, select your dates, and complete a quick booking request.' ],
        [ 'q' => 'What is the cancellation policy?', 'a' => 'Free cancellation up to 7 days before check-in.' ]
    ];
}
?>

<style>
/* ── Design Tokens ────────────────────── */
:root {
    --primary-gradient: linear-gradient(135deg, #a93102 0%, #cb491c 100%);
    --surface-glass: rgba(255, 255, 255, 0.86);
    --surface-blur: blur(24px);
    --text-main: #1a1c1c;
    --text-muted: #59413a;
}

/* ── Hero ────────────────────── */
.contact-hero {
    position: relative;
    min-height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.contact-hero-bg {
    position: absolute; inset: 0;
    background-size: cover;
    background-position: center;
}
.contact-hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(249,249,249,1) 100%);
}
.contact-hero-content {
    position: relative; z-index: 10;
    text-align: center;
    max-width: 800px;
}
.contact-hero-title {
    font-size: clamp(48px, 8vw, 72px);
    font-weight: 900;
    letter-spacing: -0.04em;
    color: var(--text-main);
    margin-bottom: 24px;
}

/* ── Layout ────────────────────── */
.contact-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 60px;
    padding: 100px 0;
}
@media (max-width: 1024px) {
    .contact-grid { grid-template-columns: 1fr; }
}

/* ── Form ────────────────────── */
.contact-form-card {
    background: var(--surface-glass);
    backdrop-filter: var(--surface-blur);
    padding: 60px;
    border-radius: 0;
    border: 1px solid rgba(0,0,0,0.05);
}
.form-group { margin-bottom: 32px; }
.form-label { font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.15em; color: #cb491c; margin-bottom: 12px; display: block; }
.form-input {
    width: 100%;
    background: transparent;
    border: none;
    border-bottom: 2px solid #eee;
    padding: 12px 0;
    font-size: 18px;
    font-weight: 500;
    border-radius: 0;
    transition: border-color 0.3s;
}
.form-input:focus { outline: none; border-color: #cb491c; }
.submit-btn {
    width: 100%;
    padding: 24px;
    background: var(--primary-gradient);
    color: white;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 0.2em;
    border: none;
    cursor: pointer;
    border-radius: 0;
    transition: transform 0.3s;
}
.submit-btn:hover { transform: translateY(-4px); }

/* ── Info Cards ────────────────────── */
.contact-info-list { display: flex; flex-col; gap: 40px; }
.info-item { border-left: 4px solid #cb491c; padding-left: 32px; }
.info-title { font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.15em; color: #cb491c; margin-bottom: 12px; }
.info-value { font-size: 20px; font-weight: 700; color: var(--text-main); line-height: 1.4; }

/* ── Map ────────────────────── */
.contact-map-wrap { margin-top: 80px; filter: grayscale(1) contrast(1.1); border-radius: 0; overflow: hidden; }

/* ── FAQ ────────────────────── */
.contact-faq { padding: 120px 0; background: #fff; }
.faq-item { border-bottom: 1px solid #eee; }
.faq-summary { padding: 32px 0; cursor: pointer; display: flex; justify-content: space-between; align-items: center; }
.faq-q { font-size: 20px; font-weight: 800; color: var(--text-main); }
.faq-icon { color: #cb491c; transition: transform 0.3s; }
.faq-item[open] .faq-icon { transform: rotate(45deg); }
.faq-a { padding-bottom: 32px; font-size: 16px; color: var(--text-muted); line-height: 1.7; max-width: 800px; }
</style>

<main>
    <!-- Hero -->
    <section class="contact-hero">
        <div class="contact-hero-bg" style="background-image: url('<?php echo esc_url( $banner_img ); ?>');"></div>
        <div class="contact-hero-overlay"></div>
        <div class="contact-hero-content">
            <h1 class="contact-hero-title"><?php echo esc_html( $heading ); ?></h1>
            <p class="text-xl text-muted"><?php echo esc_html( $subheading ); ?></p>
        </div>
    </section>

    <div class="container mx-auto px-6">
        <div class="contact-grid">
            <!-- Form -->
            <div class="contact-form-section">
                <div class="contact-form-card">
                    <form id="hhb-contact-form" method="post">
                        <?php wp_nonce_field( 'hhb_contact_form', 'hhb_contact_nonce' ); ?>
                        
                        <div class="grid grid-cols-2 gap-8">
                            <div class="form-group">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="fullname" class="form-input" required />
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-input" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Subject</label>
                            <select name="subject" class="form-input" required>
                                <option value="general">General Inquiry</option>
                                <option value="booking">Booking Help</option>
                                <option value="partnership">Partnership</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-input" rows="4" required></textarea>
                        </div>

                        <button type="submit" class="submit-btn" id="hhb-submit-btn">Send Message</button>
                        <div id="hhb-form-msg" class="mt-4 p-4 text-sm hidden"></div>
                    </form>
                </div>
            </div>

            <!-- Info -->
            <div class="contact-info-section">
                <div class="contact-info-list">
                    <?php foreach ( $contact_data as $item ) : ?>
                    <div class="info-item">
                        <div class="info-title"><?php echo esc_html( $item['q'] ?? '' ); ?></div>
                        <div class="info-value"><?php echo esc_html( $item['a'] ?? '' ); ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <?php if ( $map_embed ) : ?>
                <div class="contact-map-wrap">
                    <iframe src="<?php echo esc_url( $map_embed ); ?>" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- FAQ -->
    <?php if ( ! empty( $faq_data ) ) : ?>
    <section class="contact-faq">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-black mb-12">Common Questions</h2>
            <div class="faq-list">
                <?php foreach ( $faq_data as $i => $faq ) : ?>
                <details class="faq-item" <?php echo $i === 0 ? 'open' : ''; ?>>
                    <summary class="faq-summary">
                        <span class="faq-q"><?php echo esc_html( $faq['q'] ); ?></span>
                        <span class="material-symbols-outlined faq-icon">add</span>
                    </summary>
                    <div class="faq-a"><?php echo wp_kses_post( $faq['a'] ); ?></div>
                </details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('hhb-contact-form');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('hhb-submit-btn');
        const msg = document.getElementById('hhb-form-msg');
        
        btn.disabled = true;
        btn.textContent = 'Sending...';
        msg.classList.add('hidden');

        const formData = new FormData(form);
        formData.append('action', 'hhb_contact_form_submit');

        fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            msg.classList.remove('hidden');
            if (data.success) {
                msg.className = 'mt-4 p-4 text-sm bg-green-50 text-green-700';
                msg.textContent = data.data || 'Thank you! We\'ll get back to you soon.';
                form.reset();
            } else {
                msg.className = 'mt-4 p-4 text-sm bg-red-50 text-red-700';
                msg.textContent = data.data || 'Something went wrong. Please try again.';
            }
        })
        .catch(() => {
            msg.classList.remove('hidden');
            msg.className = 'mt-4 p-4 text-sm bg-red-50 text-red-700';
            msg.textContent = 'Network error. Please try again.';
        })
        .finally(() => {
            btn.disabled = false;
            btn.textContent = 'Send Message';
        });
    });
});
</script>

<?php get_footer(); ?>
