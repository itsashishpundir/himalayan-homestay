<?php
/**
 * Template Name: Become a Host
 *
 * Premium host application page with the "Mountain Ethereal" aesthetic.
 * Glassmorphic form, editorial typography, and high-conversion flow.
 *
 * @package HimalayanHomestay
 */

get_header();

// ── Customizer Values ──────────────────────────────────────────────
$hero_img      = get_theme_mod( 'hhb_hostpage_banner_image', 'https://images.unsplash.com/photo-1470770841497-7b3200e37531?w=1920&q=80' );
$hero_badge    = get_theme_mod( 'hhb_hostpage_badge', 'Host the Future' );
$hero_head     = get_theme_mod( 'hhb_hostpage_heading', 'Share Your World.<br>Become a <span class="text-primary-light">Host.</span>' );
$hero_sub      = get_theme_mod( 'hhb_hostpage_subheading', 'Join our exclusive community of premium mountain retreats. List your sanctuary on the Himalayan region\'s leading hospitality platform.' );

$hero_bg_url = is_numeric($hero_img) ? wp_get_attachment_url( $hero_img ) : $hero_img;

// Repeaters
$steps_json    = get_theme_mod( 'hhb_hostpage_steps', '[]' );
$steps_data    = json_decode( $steps_json, true ) ?: [];

$benefits_json = get_theme_mod( 'hhb_hostpage_benefits', '[]' );
$benefits_data = json_decode( $benefits_json, true ) ?: [];

// Fallback steps if empty
if ( empty( $steps_data ) ) {
    $steps_data = [
        [ 'title' => 'Apply Online', 'desc' => 'Submit your property details and high-resolution photos.' ],
        [ 'title' => 'Review & Verify', 'desc' => 'Our curation team reviews every sanctuary to ensure ethereal standards.' ],
        [ 'title' => 'Live Your Dream', 'desc' => 'Go live, welcome travelers, and share the magic of the mountains.' ]
    ];
}

// Fallback benefits if empty
if ( empty( $benefits_data ) ) {
    $benefits_data = [
        [ 'q' => 'Global Reach', 'a' => 'Global Reach to Verified Travelers' ],
        [ 'q' => 'Concierge Support', 'a' => 'Concierge Host Support' ],
        [ 'q' => 'Ethereal Brand', 'a' => 'Ethereal Brand Authority' ]
    ];
}
?>

<style>
/* ── Reset and Variables ────────────────────── */
:root {
    --primary-gradient: linear-gradient(135deg, #a93102 0%, #cb491c 100%);
    --surface-glass: rgba(255, 255, 255, 0.8);
    --surface-blur: blur(20px);
}

/* ── Hero Section ────────────────────── */
.host-hero {
    position: relative;
    min-height: 600px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    color: white;
}
.host-hero-bg {
    position: absolute; inset: 0;
    background-size: cover;
    background-position: center;
    transform: scale(1.02);
}
.host-hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(180deg, rgba(0,0,0,0.2) 0%, rgba(249,249,249,1) 100%);
}
.host-hero-content {
    position: relative; z-index: 10;
    max-width: 900px;
    padding: 0 24px;
    text-align: center;
}
.host-badge {
    display: inline-block;
    padding: 8px 20px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: var(--surface-blur);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 9999px;
    font-size: 11px;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    font-weight: 800;
    margin-bottom: 32px;
}
.host-hero-title {
    font-size: clamp(40px, 8vw, 84px);
    font-weight: 900;
    line-height: 0.95;
    letter-spacing: -0.04em;
    margin-bottom: 32px;
    color: #1a1c1c;
}
.host-hero-title span.text-primary-light { color: #e85e30; }
.host-hero-sub {
    font-size: 20px;
    color: #59413a;
    max-width: 600px;
    margin: 0 auto;
    font-weight: 400;
}

/* ── Content Grid ────────────────────── */
.host-main {
    background: #f9f9f9;
    padding-bottom: 120px;
}
.host-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 60px;
    margin-top: -80px;
    position: relative;
    z-index: 20;
}
@media (max-width: 1024px) {
    .host-grid { grid-template-columns: 1fr; gap: 40px; margin-top: -40px; }
}

/* ── Glassmorphic Form ────────────────────── */
.host-form-container {
    background: var(--surface-glass);
    backdrop-filter: var(--surface-blur);
    -webkit-backdrop-filter: var(--surface-blur);
    border: 1px solid rgba(255, 255, 255, 0.4);
    padding: 60px;
    border-radius: 0; /* Design rule: border-radius 0 */
    box-shadow: 0 40px 100px -20px rgba(0,0,0,0.06);
}
@media (max-width: 768px) { .host-form-container { padding: 32px; } }

.host-form-title { font-size: 32px; font-weight: 800; margin-bottom: 8px; color: #1a1c1c; }
.host-form-sub { font-size: 16px; color: #59413a; margin-bottom: 48px; }

.host-input-group { margin-bottom: 32px; }
.host-label {
    display: block;
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #1a1c1c;
    margin-bottom: 12px;
}
.host-input {
    width: 100%;
    background: #f3f3f3;
    border: none; /* No borders for sectioning */
    padding: 20px 24px;
    font-size: 16px;
    color: #1a1c1c;
    transition: background 0.3s;
}
.host-input:focus { background: #e2e2e2; outline: none; }

.host-btn-submit {
    width: 100%;
    padding: 20px;
    background: var(--primary-gradient);
    color: white;
    font-weight: 800;
    font-size: 18px;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    border: none;
    cursor: pointer;
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.host-btn-submit:hover { transform: scale(1.02); }

/* ── Sidebar ────────────────────── */
.host-sidebar-box {
    background: white;
    padding: 40px;
    margin-bottom: 32px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.03);
}
.sidebar-title { font-size: 20px; font-weight: 800; margin-bottom: 32px; color: #1a1c1c; }

.process-step { display: flex; gap: 24px; margin-bottom: 40px; align-items: start; }
.process-num {
    size: 40px; width: 40px; height: 40px;
    display: flex; align-items: center; justify-content: center;
    background: #f3f3f3; color: #1a1c1c;
    font-weight: 800; font-size: 14px; flex-shrink: 0;
}
.process-title { font-weight: 800; font-size: 16px; margin-bottom: 4px; }
.process-desc { font-size: 14px; color: #59413a; line-height: 1.6; }

.benefits-box {
    background: var(--primary-gradient);
    color: white;
    padding: 40px;
    position: relative;
    overflow: hidden;
}
.benefits-box h4 { font-size: 24px; font-weight: 800; margin-bottom: 24px; position: relative; z-index: 2; }
.benefit-item { display: flex; gap: 16px; align-items: center; margin-bottom: 16px; position: relative; z-index: 2; }
.benefit-icon { color: rgba(255,255,255,0.7); font-size: 20px; }
.benefit-text { font-size: 14px; font-weight: 600; opacity: 0.9; }

.benefits-bg-icon {
    position: absolute; right: -40px; bottom: -40px;
    font-size: 200px; color: rgba(255,255,255,0.05); font-variation-settings: 'FILL' 1;
}

/* Success State */
.host-success { text-align: center; display: none; padding: 100px 20px; }
.host-success h3 { font-size: 48px; font-weight: 900; line-height: 1; margin-bottom: 24px; }
</style>

<main class="host-main">
    <!-- Hero -->
    <section class="host-hero">
        <div class="host-hero-bg" style="background-image: url('<?php echo esc_url( $hero_bg_url ); ?>');"></div>
        <div class="host-hero-overlay"></div>
        <div class="host-hero-content">
            <?php if ( $hero_badge ) : ?>
            <span class="host-badge"><?php echo esc_html( $hero_badge ); ?></span>
            <?php endif; ?>
            <h1 class="host-hero-title"><?php echo wp_kses_post( $hero_head ); ?></h1>
            <p class="host-hero-sub"><?php echo esc_html( $hero_sub ); ?></p>
        </div>
    </section>

    <div class="container mx-auto px-6">
        <div class="host-grid">
            
            <!-- Application Zone -->
            <div class="host-form-area">
                <div class="host-form-container">
                    <div id="application-form-wrap">
                        <h2 class="host-form-title"><?php esc_html_e( 'Curation Application', 'himalayanmart' ); ?></h2>
                        <p class="host-form-sub"><?php esc_html_e( 'Nominate your sanctuary for the Ethereal Collection.', 'himalayanmart' ); ?></p>

                        <form id="hm-host-application-form" method="post" enctype="multipart/form-data">
                            <?php wp_nonce_field( 'hm_host_application', 'hm_host_nonce' ); ?>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8">
                                <div class="host-input-group">
                                    <label class="host-label"><?php esc_html_e( 'Legal Full Name', 'himalayanmart' ); ?></label>
                                    <input type="text" name="host_name" class="host-input" placeholder="e.g. Tenzing Norgay" required />
                                </div>
                                <div class="host-input-group">
                                    <label class="host-label"><?php esc_html_e( 'Contact Email', 'himalayanmart' ); ?></label>
                                    <input type="email" name="host_email" class="host-input" placeholder="you@resort.com" required />
                                </div>
                                <div class="host-input-group">
                                    <label class="host-label"><?php esc_html_e( 'Phone (WhatsApp-linked)', 'himalayanmart' ); ?></label>
                                    <input type="tel" name="host_phone" class="host-input" placeholder="+91 98XXX XXXXX" required />
                                </div>
                                <div class="host-input-group">
                                    <label class="host-label"><?php esc_html_e( 'Property Category', 'himalayanmart' ); ?></label>
                                    <select name="property_type" class="host-input">
                                        <option value="cottage">Cottage</option>
                                        <option value="villa">Luxury Villa</option>
                                        <option value="eco">Eco-Stay</option>
                                        <option value="homestay">Village Homestay</option>
                                    </select>
                                </div>
                            </div>

                            <div class="host-input-group">
                                <label class="host-label"><?php esc_html_e( 'A Brief Vision of Your Space', 'himalayanmart' ); ?></label>
                                <textarea name="host_vision" class="host-input" rows="4" placeholder="Tell us what makes your stay ethereal..."></textarea>
                            </div>

                            <button type="submit" class="host-btn-submit">
                                <?php esc_html_e( 'Nominate Sanctuary', 'himalayanmart' ); ?>
                            </button>
                        </form>
                    </div>

                    <div id="hm-host-success" class="host-success">
                        <span class="material-symbols-outlined text-primary text-8xl mb-6">verified_user</span>
                        <h3><?php esc_html_e( 'Sanctuary Nominated', 'himalayanmart' ); ?></h3>
                        <p class="text-xl text-slate-500"><?php esc_html_e( 'Our curation team will reach out to schedule a virtual tour within 48 hours.', 'himalayanmart' ); ?></p>
                    </div>
                </div>
            </div>

            <!-- Perks / Process Sidebar -->
            <div class="host-sidebar">
                <div class="host-sidebar-box">
                    <h4 class="sidebar-title"><?php esc_html_e( 'Our Curation Path', 'himalayanmart' ); ?></h4>
                    
                    <?php if ( ! empty( $steps_data ) ) : 
                        $i = 1;
                        foreach ( $steps_data as $s ) : ?>
                        <div class="process-step">
                            <div class="process-num"><?php echo str_pad($i++, 2, '0', STR_PAD_LEFT); ?></div>
                            <div>
                                <p class="process-title"><?php echo esc_html( $s['title'] ?? '' ); ?></p>
                                <p class="process-desc"><?php echo esc_html( $s['desc'] ?? '' ); ?></p>
                            </div>
                        </div>
                    <?php endforeach; endif; ?>
                </div>

                <div class="benefits-box">
                    <span class="material-symbols-outlined benefits-bg-icon">mountain_flag</span>
                    <h4><?php esc_html_e( 'Host Excellence', 'himalayanmart' ); ?></h4>
                    
                    <?php if ( ! empty( $benefits_data ) ) : 
                        foreach ( $benefits_data as $b ) : ?>
                        <div class="benefit-item">
                            <span class="material-symbols-outlined benefit-icon">verified</span>
                            <span class="benefit-text"><?php echo esc_html( $b['a'] ?? '' ); ?></span>
                        </div>
                    <?php endforeach; endif; ?>
                </div>
            </div>

        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('hm-host-application-form');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const btn = form.querySelector('button[type="submit"]');
        const originalText = btn.textContent;
        btn.textContent = '<?php echo esc_js( __( 'Curating...', 'himalayanmart' ) ); ?>';
        btn.disabled = true;

        const formData = new FormData(form);
        formData.append('action', 'hhb_host_application');

        fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', {
            method: 'POST',
            body: formData,
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                document.getElementById('application-form-wrap').style.display = 'none';
                document.getElementById('hm-host-success').style.display = 'block';
                window.scrollTo({ top: document.querySelector('.host-form-container').offsetTop - 100, behavior: 'smooth' });
            } else {
                alert(data.data || 'Error');
                btn.textContent = originalText;
                btn.disabled = false;
            }
        });
    });
});
</script>

<?php get_footer(); ?>
