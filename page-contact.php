<?php
/**
 * Template Name: Contact Us
 *
 * Contact page with form, info cards, map, and FAQ.
 * All contact details customizable via WordPress Customizer.
 *
 * @package HimalayanHomestay
 */

get_header();

/* ── Customizer values ──────────────────────────────────────────── */
$banner_img   = get_theme_mod( 'hhb_contact_banner_image', 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=2940&auto=format&fit=crop' );
$heading      = get_theme_mod( 'hhb_contact_heading', 'Get in Touch' );
$subheading   = get_theme_mod( 'hhb_contact_subheading', 'Have a question or need help planning your stay? We\'re here for you.' );

$address      = get_theme_mod( 'hhb_contact_address', 'Village Jibhi, Tirthan Valley, Banjar, Himachal Pradesh 175143, India' );
$phone_1      = get_theme_mod( 'hhb_contact_phone_1', '+91 98765 43210' );
$phone_2      = get_theme_mod( 'hhb_contact_phone_2', '' );
$email_1      = get_theme_mod( 'hhb_contact_email_1', 'hello@himalayanhomestay.com' );
$email_2      = get_theme_mod( 'hhb_contact_email_2', 'bookings@himalayanhomestay.com' );
$hours_line1  = get_theme_mod( 'hhb_contact_hours_1', 'Mon–Sat: 9:00 AM – 7:00 PM IST' );
$hours_line2  = get_theme_mod( 'hhb_contact_hours_2', 'Sunday: 10:00 AM – 5:00 PM IST' );
$whatsapp     = get_theme_mod( 'hhb_contact_whatsapp', '919876543210' );
$map_embed    = get_theme_mod( 'hhb_contact_map_embed', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d54000!2d77.35!3d31.6!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2sTirthan+Valley!5e0!3m2!1sen!2sin!4v1' );

// FAQs
$faqs = [
    [ 'q' => get_theme_mod( 'hhb_faq_1_q', 'How do I book a homestay?' ),                       'a' => get_theme_mod( 'hhb_faq_1_a', 'Browse our listings, select your dates, and complete a quick booking request. Once the host confirms availability, you\'ll receive a secure payment link. Your booking is confirmed after payment.' ) ],
    [ 'q' => get_theme_mod( 'hhb_faq_2_q', 'What is the cancellation policy?' ),                'a' => get_theme_mod( 'hhb_faq_2_a', 'Free cancellation up to 7 days before check-in. For cancellations within 7 days, a 50% charge applies. No-shows are charged in full.' ) ],
    [ 'q' => get_theme_mod( 'hhb_faq_3_q', 'Do you offer airport or bus stand transfers?' ),    'a' => get_theme_mod( 'hhb_faq_3_a', 'Yes! Most of our homestays can arrange pickup from the nearest bus stand or airport. Contact us after booking to arrange transfers at a nominal additional cost.' ) ],
    [ 'q' => get_theme_mod( 'hhb_faq_4_q', 'Are your homestays pet-friendly?' ),                'a' => get_theme_mod( 'hhb_faq_4_a', 'Some of our properties welcome pets. Check individual property pages for pet-friendly badges, or contact us and we\'ll recommend the best options.' ) ],
    [ 'q' => get_theme_mod( 'hhb_faq_5_q', 'What payment methods do you accept?' ),             'a' => get_theme_mod( 'hhb_faq_5_a', 'We accept UPI, credit/debit cards, net banking via Razorpay, and international cards via Stripe. All payments are secured with bank-grade encryption.' ) ],
];
?>

<style>
/* ── Contact Page Scoped Styles ────────────────────────────────── */
.hhb-contact-hero {
    position: relative;
    min-height: 280px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.hhb-contact-hero-bg {
    position: absolute; inset: 0;
    background-size: cover;
    background-position: center;
}
.hhb-contact-hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.6) 100%);
}

.hhb-contact-info-card {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 20px;
    background: #fff;
    border: 1px solid #f1f1f1;
    border-radius: 14px;
    transition: all 0.3s;
}
.hhb-contact-info-card:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,0.06);
}
.hhb-contact-info-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fef3ee;
    color: #e85e30;
    font-size: 22px;
    flex-shrink: 0;
}

.hhb-contact-form input,
.hhb-contact-form select,
.hhb-contact-form textarea {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    font-size: 14px;
    font-family: inherit;
    transition: border-color 0.2s, box-shadow 0.2s;
    background: #fff;
}
.hhb-contact-form input:focus,
.hhb-contact-form select:focus,
.hhb-contact-form textarea:focus {
    outline: none;
    border-color: #e85e30;
    box-shadow: 0 0 0 3px rgb(232 94 48 / 0.1);
}

/* FAQ Accordion */
.hhb-faq-item {
    border: 1px solid #f1f1f1;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 8px;
    transition: box-shadow 0.3s;
}
.hhb-faq-item:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.04); }
.hhb-faq-item summary {
    padding: 18px 20px;
    cursor: pointer;
    font-weight: 700;
    font-size: 14px;
    color: #1e293b;
    list-style: none;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    background: #fff;
    user-select: none;
}
.hhb-faq-item summary::-webkit-details-marker { display: none; }
.hhb-faq-item summary::after {
    content: '+';
    font-size: 20px;
    font-weight: 300;
    color: #94a3b8;
    transition: transform 0.2s;
}
.hhb-faq-item[open] summary::after { content: '−'; color: #e85e30; }
.hhb-faq-answer {
    padding: 0 20px 18px;
    font-size: 13px;
    color: #64748b;
    line-height: 1.7;
}

.hhb-contact-form .hhb-submit-btn {
    display: block;
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 12px;
    background: #e85e30;
    color: #fff;
    font-weight: 800;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s;
}
.hhb-submit-btn:hover { filter: brightness(1.1); }
.hhb-submit-btn:active { transform: scale(0.98); }

/* Success / Error message */
.hhb-form-message {
    padding: 12px 16px;
    border-radius: 10px;
    margin-top: 12px;
    font-size: 13px;
    font-weight: 600;
    display: none;
}
.hhb-form-message.success { background: #ecfdf5; color: #059669; display: block; }
.hhb-form-message.error { background: #fef2f2; color: #dc2626; display: block; }
</style>


<!-- ═══════════════════════════════════════════════════════════════
     HEADER BANNER
     ═══════════════════════════════════════════════════════════════ -->
<section class="hhb-contact-hero">
    <div class="hhb-contact-hero-bg" style="background-image: url('<?php echo esc_url( $banner_img ); ?>')"></div>
    <div class="hhb-contact-hero-overlay"></div>
    <div class="relative z-10 text-center px-4 py-16">
        <h1 class="text-4xl md:text-5xl font-black text-white mb-3 drop-shadow-lg"><?php echo esc_html( $heading ); ?></h1>
        <p class="text-white/80 text-base md:text-lg max-w-xl mx-auto"><?php echo esc_html( $subheading ); ?></p>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════
     FORM + INFO CARDS
     ═══════════════════════════════════════════════════════════════ -->
<section class="py-16 px-6 bg-[#f8f6f4]">
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-5 gap-10">

        <!-- Left: Contact Form (3 cols) -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 md:p-10">
                <h2 class="text-xl font-black text-slate-900 mb-6">Send Us a Message</h2>

                <form class="hhb-contact-form" id="hhb-contact-form" method="post">
                    <?php wp_nonce_field( 'hhb_contact_form', 'hhb_contact_nonce' ); ?>

                    <!-- Honeypot Field -->
                    <div style="position: absolute; left: -5000px;" aria-hidden="true">
                        <input type="text" name="hhb_contact_website" tabindex="-1" value="">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Full Name</label>
                            <input type="text" name="fullname" placeholder="Your full name" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Email Address</label>
                            <input type="email" name="email" placeholder="you@example.com" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Phone Number</label>
                            <input type="tel" name="phone" placeholder="+91 12345 67890">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Subject</label>
                            <select name="subject" required>
                                <option value="">Select a topic</option>
                                <option value="general">General Inquiry</option>
                                <option value="booking">Booking Help</option>
                                <option value="partnership">Partnership</option>
                                <option value="feedback">Feedback</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Message</label>
                        <textarea name="message" rows="5" placeholder="Tell us how we can help…" required></textarea>
                    </div>

                    <button type="submit" class="hhb-submit-btn">
                        <span class="flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-lg">send</span>
                            Send Message
                        </span>
                    </button>

                    <div id="hhb-form-msg" class="hhb-form-message"></div>

                    <p class="text-[11px] text-slate-400 mt-3 text-center">We typically respond within 24 hours.</p>
                </form>
            </div>
        </div>

        <!-- Right: Info Cards (2 cols) -->
        <div class="lg:col-span-2 flex flex-col gap-4">
            <!-- Address -->
            <div class="hhb-contact-info-card">
                <div class="hhb-contact-info-icon">
                    <span class="material-symbols-outlined">location_on</span>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900 mb-1">Our Location</h3>
                    <p class="text-xs text-slate-500 leading-relaxed"><?php echo esc_html( $address ); ?></p>
                </div>
            </div>

            <!-- Phone -->
            <div class="hhb-contact-info-card">
                <div class="hhb-contact-info-icon">
                    <span class="material-symbols-outlined">call</span>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900 mb-1">Call Us</h3>
                    <p class="text-xs text-slate-500">
                        <a href="tel:<?php echo esc_attr( preg_replace('/\s+/', '', $phone_1) ); ?>" class="hover:text-primary transition"><?php echo esc_html( $phone_1 ); ?></a>
                        <?php if ( $phone_2 ) : ?>
                            <br>
                            <a href="tel:<?php echo esc_attr( preg_replace('/\s+/', '', $phone_2) ); ?>" class="hover:text-primary transition"><?php echo esc_html( $phone_2 ); ?></a>
                        <?php endif; ?>
                    </p>
                    <?php if ( $whatsapp ) : ?>
                        <a href="https://wa.me/<?php echo esc_attr( $whatsapp ); ?>" target="_blank" class="inline-flex items-center gap-1.5 mt-2 px-3 py-1.5 bg-green-50 text-green-700 rounded-lg text-[11px] font-bold hover:bg-green-100 transition">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.625.846 5.059 2.284 7.034L.789 23.492a.5.5 0 00.612.638l4.685-1.392A11.944 11.944 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-2.137 0-4.146-.617-5.847-1.682l-.42-.264-3.074.912.861-2.948-.283-.445A9.954 9.954 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                            WhatsApp
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Email -->
            <div class="hhb-contact-info-card">
                <div class="hhb-contact-info-icon">
                    <span class="material-symbols-outlined">mail</span>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900 mb-1">Email Us</h3>
                    <p class="text-xs text-slate-500">
                        <a href="mailto:<?php echo esc_attr( $email_1 ); ?>" class="hover:text-primary transition"><?php echo esc_html( $email_1 ); ?></a>
                        <?php if ( $email_2 ) : ?>
                            <br>
                            <a href="mailto:<?php echo esc_attr( $email_2 ); ?>" class="hover:text-primary transition"><?php echo esc_html( $email_2 ); ?></a>
                        <?php endif; ?>
                    </p>
                </div>
            </div>

            <!-- Hours -->
            <div class="hhb-contact-info-card">
                <div class="hhb-contact-info-icon">
                    <span class="material-symbols-outlined">schedule</span>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900 mb-1">Working Hours</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        <?php echo esc_html( $hours_line1 ); ?>
                        <?php if ( $hours_line2 ) : ?><br><?php echo esc_html( $hours_line2 ); ?><?php endif; ?>
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════
     MAP
     ═══════════════════════════════════════════════════════════════ -->
<?php if ( $map_embed ) : ?>
<section class="px-6 pb-16 bg-[#f8f6f4]">
    <div class="max-w-6xl mx-auto rounded-2xl overflow-hidden shadow-sm border border-slate-100">
        <iframe 
            src="<?php echo esc_url( $map_embed ); ?>" 
            width="100%" 
            height="400" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</section>
<?php endif; ?>


<!-- ═══════════════════════════════════════════════════════════════
     FAQ
     ═══════════════════════════════════════════════════════════════ -->
<section class="py-16 px-6">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-10">
            <h2 class="text-2xl md:text-3xl font-black text-slate-900 mb-2">Frequently Asked Questions</h2>
            <p class="text-slate-500 text-sm">Quick answers to common questions</p>
        </div>

        <div>
            <?php foreach ( $faqs as $i => $faq ) : ?>
                <details class="hhb-faq-item" <?php echo $i === 0 ? 'open' : ''; ?>>
                    <summary><?php echo esc_html( $faq['q'] ); ?></summary>
                    <div class="hhb-faq-answer"><?php echo esc_html( $faq['a'] ); ?></div>
                </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════
     FORM AJAX HANDLER
     ═══════════════════════════════════════════════════════════════ -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('hhb-contact-form');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = form.querySelector('.hhb-submit-btn');
        const msg = document.getElementById('hhb-form-msg');
        
        btn.disabled = true;
        btn.innerHTML = '<span class="flex items-center justify-center gap-2"><span class="material-symbols-outlined text-lg animate-spin">progress_activity</span> Sending…</span>';
        msg.className = 'hhb-form-message';
        msg.style.display = 'none';

        const formData = new FormData(form);
        formData.append('action', 'hhb_contact_form_submit');

        fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                msg.className = 'hhb-form-message success';
                msg.textContent = data.data || 'Thank you! We\'ll get back to you soon.';
                msg.style.display = 'block';
                form.reset();
            } else {
                msg.className = 'hhb-form-message error';
                msg.textContent = data.data || 'Something went wrong. Please try again.';
                msg.style.display = 'block';
            }
        })
        .catch(() => {
            msg.className = 'hhb-form-message error';
            msg.textContent = 'Network error. Please check your connection and try again.';
            msg.style.display = 'block';
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<span class="flex items-center justify-center gap-2"><span class="material-symbols-outlined text-lg">send</span> Send Message</span>';
        });
    });
});
</script>

<?php get_footer(); ?>
