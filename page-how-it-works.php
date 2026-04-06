<?php
/**
 * Template Name: How It Works
 *
 * Booking process explainer page with the "Mountain Ethereal" aesthetic.
 * Fully customizable via repeaters in the WordPress Customizer.
 *
 * @package HimalayanHomestay
 */

get_header();

// ── Customizer Values ──────────────────────────────────────────────
$hero_img   = get_theme_mod( 'hhb_howitworks_banner_image', 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=2940&auto=format&fit=crop' );
$heading    = get_theme_mod( 'hhb_howitworks_heading', 'How FuturaStays Works' );
$subheading = get_theme_mod( 'hhb_howitworks_subheading', "Your journey to the heart of the Himalayas begins with a single step. Here's how to find and book your perfect stay." );

// Steps Repeater
$steps_json = get_theme_mod( 'hhb_howitworks_steps', '[]' );
$steps_data = json_decode( $steps_json, true ) ?: [];

if ( empty( $steps_data ) ) {
    $steps_data = [
        [ 'title' => 'Search', 'desc' => 'Explore curated stays across the Himalayan region. Filter by location, property type, and amenities.', 'number' => '01' ],
        [ 'title' => 'Book',   'desc' => 'Send a booking request and connect with your local host. Secure your dates with a small deposit.', 'number' => '02' ],
        [ 'title' => 'Stay',   'desc' => 'Experience authentic Himalayan hospitality. Our hosts are dedicated to making your stay unforgettable.', 'number' => '03' ]
    ];
}

$cta_text = get_theme_mod( 'hhb_howitworks_cta_text', 'Ready to start your mountain adventure?' );
$cta_btn  = get_theme_mod( 'hhb_howitworks_cta_btn', 'Explore Stays' );
$cta_link = get_theme_mod( 'hhb_howitworks_cta_link', home_url('/stays/') );
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
.hiw-hero {
    position: relative;
    min-height: 500px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    color: white;
}
.hiw-hero-bg {
    position: absolute; inset: 0;
    background-size: cover;
    background-position: center;
}
.hiw-hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(180deg, rgba(0,0,0,0.2) 0%, rgba(249,249,249,1) 100%);
}
.hiw-hero-content {
    position: relative; z-index: 10;
    text-align: center;
    max-width: 800px;
    padding: 24px;
}
.hiw-title {
    font-size: clamp(48px, 8vw, 84px);
    font-weight: 900;
    line-height: 0.95;
    letter-spacing: -0.04em;
    color: var(--text-main);
    margin-bottom: 24px;
}
.hiw-sub {
    font-size: 20px;
    color: var(--text-muted);
    font-weight: 400;
}

/* ── Steps ────────────────────── */
.hiw-steps { padding: 120px 0; background: #f9f9f9; }
.steps-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 40px;
}
.step-card {
    background: var(--surface-glass);
    backdrop-filter: var(--surface-blur);
    padding: 60px;
    border-radius: 0;
    border: 1px solid rgba(0,0,0,0.05);
    transition: transform 0.3s;
    position: relative;
}
.step-card:hover { transform: translateY(-8px); }
.step-num {
    font-size: 64px;
    font-weight: 900;
    color: rgba(203, 73, 28, 0.1);
    position: absolute;
    top: 40px;
    right: 60px;
}
.step-label { font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.2em; color: #cb491c; margin-bottom: 24px; display: block; }
.step-title { font-size: 32px; font-weight: 900; margin-bottom: 24px; color: var(--text-main); }
.step-desc { font-size: 16px; color: var(--text-muted); line-height: 1.8; }

/* ── CTA ────────────────────── */
.hiw-cta { padding: 120px 0; text-align: center; background: white; }
.hiw-cta-text { font-size: 32px; font-weight: 900; margin-bottom: 40px; color: var(--text-main); }
.hiw-btn {
    display: inline-block;
    padding: 24px 64px;
    background: var(--primary-gradient);
    color: white;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 0.2em;
    border-radius: 0;
    transition: transform 0.3s, box-shadow 0.3s;
    text-decoration: none;
}
.hiw-btn:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(203, 73, 28, 0.2); }
</style>

<main>
    <!-- Hero -->
    <section class="hiw-hero">
        <div class="hiw-hero-bg" style="background-image: url('<?php echo esc_url( $hero_img ); ?>');"></div>
        <div class="hiw-hero-overlay"></div>
        <div class="hiw-hero-content">
            <h1 class="hiw-title"><?php echo esc_html( $heading ); ?></h1>
            <p class="hiw-sub"><?php echo esc_html( $subheading ); ?></p>
        </div>
    </section>

    <!-- Steps -->
    <section class="hiw-steps">
        <div class="container mx-auto px-6">
            <div class="steps-grid">
                <?php foreach ( $steps_data as $i => $step ) : ?>
                <div class="step-card">
                    <div class="step-num"><?php echo esc_html( $step['number'] ?? sprintf('%02d', $i + 1) ); ?></div>
                    <span class="step-label">Step <?php echo $i + 1; ?></span>
                    <h3 class="step-title"><?php echo esc_html( $step['title'] ?? '' ); ?></h3>
                    <p class="step-desc"><?php echo wp_kses_post( $step['desc'] ?? '' ); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="hiw-cta">
        <div class="container mx-auto px-6">
            <h2 class="hiw-cta-text"><?php echo esc_html( $cta_text ); ?></h2>
            <a href="<?php echo esc_url( $cta_link ); ?>" class="hiw-btn"><?php echo esc_html( $cta_btn ); ?></a>
        </div>
    </section>
</main>

<?php get_footer(); ?>
