<?php
/**
 * Template Name: Contact Us
 *
 * @package HimalayanHomestay
 */

get_header();

$banner_img  = get_theme_mod( 'hhb_contact_banner_image', 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=2940&auto=format&fit=crop' );
$heading     = get_theme_mod( 'hhb_contact_heading', 'Get in Touch' );
$subheading  = get_theme_mod( 'hhb_contact_subheading', 'Have a question or need help planning your stay? We\'re here for you.' );
$map_embed   = get_theme_mod( 'hhb_contact_map_embed', '' );

$contact_json = get_theme_mod( 'hhb_contact_cards', '[]' );
$contact_data = json_decode( $contact_json, true ) ?: [];
if ( empty( $contact_data ) ) {
    $contact_data = [
        [ 'q' => 'Our Location', 'a' => 'Village Jibhi, Tirthan Valley, Banjar, Himachal Pradesh 175143, India', 'icon' => 'location_on' ],
        [ 'q' => 'Call Us',      'a' => '+91 98765 43210', 'icon' => 'phone' ],
        [ 'q' => 'Email Us',     'a' => 'hello@himalayanhomestay.com', 'icon' => 'mail' ],
        [ 'q' => 'Working Hours','a' => "Mon–Sat: 9:00 AM – 7:00 PM IST\nSunday: 10:00 AM – 5:00 PM IST", 'icon' => 'schedule' ],
    ];
}

$faq_json = get_theme_mod( 'hhb_contact_faq_items', '[]' );
$faq_data = json_decode( $faq_json, true ) ?: [];
if ( empty( $faq_data ) ) {
    $faq_data = [
        [ 'q' => 'How do I book a homestay?', 'a' => 'Browse our listings, select your dates, and complete a quick booking request. Once the host confirms availability, you\'ll receive a secure payment link. Your booking is confirmed after payment.' ],
        [ 'q' => 'What is the cancellation policy?', 'a' => 'Free cancellation up to 7 days before check-in. After that, a 50% charge applies. No-shows are fully charged.' ],
        [ 'q' => 'Do you offer airport or bus stand transfers?', 'a' => 'Many of our hosts can arrange local pickup for an additional fee. Check the individual listing or contact the host after booking.' ],
        [ 'q' => 'Are your homestays pet-friendly?', 'a' => 'Some of our properties welcome pets. Filter by \'Pet Friendly\' on the search page or contact the host directly to confirm.' ],
        [ 'q' => 'What payment methods do you accept?', 'a' => 'We accept all major credit/debit cards, UPI, net banking, and bank transfers. International cards are also supported.' ],
    ];
}
?>
<style>
:root {
    --ct-primary: #cb491c;
    --ct-primary-dark: #a93102;
    --ct-text: #1a1c1c;
    --ct-muted: #6b7280;
    --ct-bg: #f5f4f2;
    --ct-white: #ffffff;
    --ct-border: #e8e4e0;
    --ct-radius: 16px;
    --ct-radius-sm: 10px;
}

/* ── Hero ───────────────────────────────────────────── */
.ct-hero {
    position: relative;
    min-height: 340px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    text-align: center;
}
.ct-hero-bg {
    position: absolute; inset: 0;
    background-size: cover;
    background-position: center 35%;
}
.ct-hero-overlay {
    position: absolute; inset: 0;
    background: rgba(0,0,0,0.52);
}
.ct-hero-content {
    position: relative; z-index: 2;
    padding: 60px 20px;
    max-width: 640px;
}
.ct-hero-title {
    font-size: clamp(40px, 7vw, 68px);
    font-weight: 900;
    letter-spacing: -0.03em;
    color: #fff;
    line-height: 1;
    margin-bottom: 18px;
}
.ct-hero-sub {
    font-size: 17px;
    color: rgba(255,255,255,0.82);
    line-height: 1.6;
}

/* ── Main section ───────────────────────────────────── */
.ct-section {
    background: var(--ct-bg);
    padding: 60px 0 80px;
}
.ct-layout {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 28px;
    align-items: start;
}
@media (max-width: 960px) {
    .ct-layout { grid-template-columns: 1fr; }
}

/* ── Form card ──────────────────────────────────────── */
.ct-form-card {
    background: var(--ct-white);
    border-radius: var(--ct-radius);
    padding: 44px 40px 48px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
}
.ct-form-heading {
    font-size: 22px;
    font-weight: 800;
    color: var(--ct-text);
    margin-bottom: 28px;
    letter-spacing: -0.02em;
}
.ct-row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
@media (max-width: 560px) {
    .ct-row-2 { grid-template-columns: 1fr; }
    .ct-form-card { padding: 28px 24px 32px; }
}
.ct-field { margin-bottom: 20px; }
.ct-label {
    display: block;
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.14em;
    color: var(--ct-muted);
    margin-bottom: 6px;
}
.ct-input {
    width: 100%;
    background: #f5f4f2;
    border: 1.5px solid transparent;
    border-radius: var(--ct-radius-sm);
    padding: 11px 14px;
    font-size: 15px;
    color: var(--ct-text);
    transition: border-color .2s, background .2s;
    box-sizing: border-box;
    font-weight: 500;
}
.ct-input::placeholder { color: #aaa; font-weight: 400; }
.ct-input:focus {
    outline: none;
    background: #fff;
    border-color: var(--ct-primary);
}
select.ct-input {
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23999' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    padding-right: 36px;
}
textarea.ct-input { resize: vertical; min-height: 110px; }

.ct-submit {
    width: 100%;
    padding: 15px 24px;
    background: linear-gradient(135deg, var(--ct-primary-dark), var(--ct-primary));
    color: #fff;
    font-size: 14px;
    font-weight: 800;
    letter-spacing: 0.04em;
    border: none;
    border-radius: var(--ct-radius-sm);
    cursor: pointer;
    transition: transform .2s, box-shadow .2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 4px;
}
.ct-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px -6px rgba(169,49,2,.5);
}
.ct-submit-note {
    text-align: center;
    font-size: 12px;
    color: var(--ct-muted);
    margin-top: 10px;
}

/* ── Info cards stack ───────────────────────────────── */
.ct-info-stack { display: flex; flex-direction: column; gap: 12px; }

.ct-info-card {
    background: var(--ct-white);
    border-radius: var(--ct-radius);
    padding: 20px 22px;
    display: flex;
    align-items: flex-start;
    gap: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    transition: box-shadow .2s;
}
.ct-info-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.08); }

.ct-info-icon {
    width: 42px;
    height: 42px;
    min-width: 42px;
    border-radius: 50%;
    background: #fdeee8;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--ct-primary);
}
.ct-info-icon .material-symbols-outlined { font-size: 20px; }

.ct-info-body {}
.ct-info-title {
    font-size: 13px;
    font-weight: 800;
    color: var(--ct-text);
    margin-bottom: 4px;
}
.ct-info-value {
    font-size: 14px;
    color: var(--ct-muted);
    line-height: 1.5;
}
.ct-whatsapp-link {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    margin-top: 6px;
    font-size: 13px;
    font-weight: 700;
    color: #16a34a;
    text-decoration: none;
    background: #dcfce7;
    padding: 3px 10px;
    border-radius: 20px;
}

/* ── FAQ section ────────────────────────────────────── */
.ct-faq-section { padding: 80px 0 100px; background: #fff; }
.ct-faq-head { text-align: center; margin-bottom: 56px; }
.ct-faq-head h2 {
    font-size: clamp(28px, 4vw, 44px);
    font-weight: 900;
    letter-spacing: -0.03em;
    color: var(--ct-text);
    margin-bottom: 10px;
}
.ct-faq-head p { font-size: 16px; color: var(--ct-muted); }
.ct-faq-head p a { color: var(--ct-primary); text-decoration: none; }

.ct-faq-list { max-width: 780px; margin: 0 auto; }

details.ct-faq-item {
    border-bottom: 1px solid var(--ct-border);
}
details.ct-faq-item summary { list-style: none; }
details.ct-faq-item summary::-webkit-details-marker { display: none; }

.ct-faq-summary {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    padding: 22px 0;
    cursor: pointer;
    user-select: none;
}
.ct-faq-q {
    font-size: 16px;
    font-weight: 700;
    color: var(--ct-text);
    line-height: 1.35;
}
.ct-faq-icon {
    font-size: 20px;
    color: var(--ct-primary);
    transition: transform .25s;
    flex-shrink: 0;
}
details[open].ct-faq-item .ct-faq-icon { transform: rotate(45deg); }
.ct-faq-a {
    font-size: 15px;
    color: var(--ct-muted);
    line-height: 1.75;
    padding-bottom: 20px;
    max-width: 660px;
}
</style>

<main>

    <!-- Hero -->
    <section class="ct-hero">
        <div class="ct-hero-bg" style="background-image: url('<?php echo esc_url( $banner_img ); ?>');"></div>
        <div class="ct-hero-overlay"></div>
        <div class="ct-hero-content">
            <h1 class="ct-hero-title"><?php echo esc_html( $heading ); ?></h1>
            <p class="ct-hero-sub"><?php echo esc_html( $subheading ); ?></p>
        </div>
    </section>

    <!-- Form + Info Cards -->
    <section class="ct-section">
        <div class="container mx-auto px-6">
            <div class="ct-layout">

                <!-- Form -->
                <div class="ct-form-card">
                    <h2 class="ct-form-heading">Send Us a Message</h2>
                    <form id="hhb-contact-form" method="post">
                        <?php wp_nonce_field( 'hhb_contact_form', 'hhb_contact_nonce' ); ?>

                        <div class="ct-row-2">
                            <div class="ct-field">
                                <label class="ct-label">Full Name</label>
                                <input type="text" name="fullname" class="ct-input" placeholder="Your full name" required />
                            </div>
                            <div class="ct-field">
                                <label class="ct-label">Email Address</label>
                                <input type="email" name="email" class="ct-input" placeholder="you@example.com" required />
                            </div>
                        </div>

                        <div class="ct-row-2">
                            <div class="ct-field">
                                <label class="ct-label">Phone Number</label>
                                <input type="tel" name="phone" class="ct-input" placeholder="+91 12345 67890" />
                            </div>
                            <div class="ct-field">
                                <label class="ct-label">Subject</label>
                                <select name="subject" class="ct-input" required>
                                    <option value="">Select a topic</option>
                                    <option value="general">General Inquiry</option>
                                    <option value="booking">Booking Help</option>
                                    <option value="partnership">Partnership</option>
                                    <option value="hosting">Become a Host</option>
                                    <option value="complaint">Feedback / Complaint</option>
                                </select>
                            </div>
                        </div>

                        <div class="ct-field">
                            <label class="ct-label">Message</label>
                            <textarea name="message" class="ct-input" placeholder="Tell us how we can help..." required></textarea>
                        </div>

                        <button type="submit" class="ct-submit" id="hhb-submit-btn">
                            <span class="material-symbols-outlined" style="font-size:18px;">send</span>
                            Send Message
                        </button>
                        <p class="ct-submit-note">We typically respond within 24 hours.</p>
                        <div id="hhb-form-msg" class="hidden" style="margin-top:12px;padding:12px 16px;border-radius:8px;font-size:14px;"></div>
                    </form>
                </div>

                <!-- Info Cards -->
                <div class="ct-info-stack">
                    <?php
                    $default_icons = [ 'location_on', 'phone', 'mail', 'schedule' ];
                    foreach ( $contact_data as $i => $item ) :
                        $icon = sanitize_text_field( $item['icon'] ?? ( $default_icons[ $i ] ?? 'info' ) );
                        $is_phone = ( $icon === 'phone' );
                    ?>
                    <div class="ct-info-card">
                        <div class="ct-info-icon">
                            <span class="material-symbols-outlined"><?php echo esc_html( $icon ); ?></span>
                        </div>
                        <div class="ct-info-body">
                            <div class="ct-info-title"><?php echo esc_html( $item['q'] ?? '' ); ?></div>
                            <div class="ct-info-value"><?php echo nl2br( esc_html( $item['a'] ?? '' ) ); ?></div>
                            <?php if ( $is_phone ) : ?>
                            <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $item['a'] ?? ''); ?>" class="ct-whatsapp-link" target="_blank" rel="noopener">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                WhatsApp
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>
    </section>

    <!-- FAQ -->
    <?php if ( ! empty( $faq_data ) ) : ?>
    <section class="ct-faq-section">
        <div class="container mx-auto px-6">
            <div class="ct-faq-head">
                <h2>Frequently Asked Questions</h2>
                <p><a href="#">Quick answers</a> to common questions</p>
            </div>
            <div class="ct-faq-list">
                <?php foreach ( $faq_data as $i => $faq ) : ?>
                <details class="ct-faq-item" <?php echo $i === 0 ? 'open' : ''; ?>>
                    <summary class="ct-faq-summary">
                        <span class="ct-faq-q"><?php echo esc_html( $faq['q'] ); ?></span>
                        <span class="material-symbols-outlined ct-faq-icon">add</span>
                    </summary>
                    <div class="ct-faq-a"><?php echo wp_kses_post( $faq['a'] ); ?></div>
                </details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('hhb-contact-form');
    if (!form) return;
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const btn = document.getElementById('hhb-submit-btn');
        const msg = document.getElementById('hhb-form-msg');
        btn.disabled = true;
        btn.querySelector('span:last-child') && (btn.lastChild.textContent = ' Sending…');
        const fd = new FormData(form);
        fd.append('action', 'hhb_contact_form_submit');
        fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(d => {
                msg.classList.remove('hidden');
                msg.style.cssText = d.success
                    ? 'background:#dcfce7;color:#15803d;margin-top:12px;padding:12px 16px;border-radius:8px;font-size:14px;'
                    : 'background:#fee2e2;color:#b91c1c;margin-top:12px;padding:12px 16px;border-radius:8px;font-size:14px;';
                msg.textContent = d.data || (d.success ? 'Thank you! We\'ll get back to you soon.' : 'Something went wrong. Please try again.');
                if (d.success) form.reset();
            })
            .catch(() => {
                msg.classList.remove('hidden');
                msg.style.cssText = 'background:#fee2e2;color:#b91c1c;margin-top:12px;padding:12px 16px;border-radius:8px;font-size:14px;';
                msg.textContent = 'Network error. Please try again.';
            })
            .finally(() => { btn.disabled = false; btn.innerHTML = '<span class="material-symbols-outlined" style="font-size:18px;">send</span> Send Message'; });
    });
});
</script>

<?php get_footer(); ?>
