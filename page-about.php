<?php
/**
 * Template Name: About Us
 *
 * About page template with the "Mountain Ethereal" aesthetic.
 * Fully customizable via repeaters in the WordPress Customizer.
 *
 * @package HimalayanHomestay
 */

get_header();

// ── Customizer Values ──────────────────────────────────────────────
$hero_img      = get_theme_mod( 'hhb_about_hero_img', 'https://images.unsplash.com/photo-1544256718-3b61a34ca536?q=80&w=2940&auto=format&fit=crop' );
$hero_head     = get_theme_mod( 'hhb_about_hero_head', 'About Himalayan Homestay' );
$hero_sub      = get_theme_mod( 'hhb_about_hero_sub', 'Connecting curious travelers with the heart of the mountains through local hospitality.' );

// Chapters Repeater
$story_title   = get_theme_mod( 'hhb_about_story_title', 'Where Tradition Meets Travel' );
$chapters_json = get_theme_mod( 'hhb_about_chapters', '[]' );
$chapters_data = json_decode( $chapters_json, true ) ?: [];

// Fallback Chapters
if ( empty( $chapters_data ) ) {
    $chapters_data = [
        [ 'title' => 'The Spark', 'desc' => 'How It All Started', 'text' => 'Founded in the heart of the peaks, Himalayan Homestay was born from a simple realization: the most beautiful parts of the mountains aren\'t the views, but the people who call them home.', 'image' => 'https://images.unsplash.com/photo-1516575150278-77136aed6920?q=80&w=2940&auto=format&fit=crop' ],
        [ 'title' => 'The Journey', 'desc' => 'Building the Bridge', 'text' => 'We bridge the gap between remote village communities and global travelers, ensuring that every stay supports local livelihoods while offering an unparalleled glimpse into ancient cultures.', 'image' => 'https://images.unsplash.com/photo-1533157497230-01dc481bb20f?q=80&w=2940&auto=format&fit=crop' ],
        [ 'title' => 'Today', 'desc' => 'A Growing Community', 'text' => 'Today, we work with over 500 hosts across 5 states, empowering local economies and providing travelers with unforgettable memories.', 'image' => 'https://images.unsplash.com/photo-1513271169004-9497e7f6dff4?q=80&w=2940&auto=format&fit=crop' ]
    ];
}

// Stats Repeater
$stats_json = get_theme_mod( 'hhb_about_stats', '[]' );
$stats_data = json_decode( $stats_json, true ) ?: [];
if ( empty( $stats_data ) ) {
    $stats_data = [
        [ 'q' => '500+', 'a' => 'Properties' ],
        [ 'q' => '50k+', 'a' => 'Happy Guests' ],
        [ 'q' => '4.9/5', 'a' => 'Average Rating' ]
    ];
}

// Values Repeater
$values_title = get_theme_mod( 'hhb_about_values_title', 'Our Core Values' );
$values_sub   = get_theme_mod( 'hhb_about_values_sub', 'Guided by the spirit of the mountains' );
$values_json  = get_theme_mod( 'hhb_about_values_list', '[]' );
$values_data  = json_decode( $values_json, true ) ?: [];
if ( empty( $values_data ) ) {
    $values_data = [
        [ 'q' => 'Authenticity', 'a' => 'Real homes, real families, and real experiences. No staged performances, just genuine Himalayan life.' ],
        [ 'q' => 'Sustainability', 'a' => 'Preserving the fragile mountain ecosystem and supporting slow travel that leaves a positive footprint.' ],
        [ 'q' => 'Community', 'a' => 'Empowering local hosts through fair trade and direct economic opportunities for remote villages.' ]
    ];
}

$quote    = get_theme_mod( 'hhb_about_quote', '"Our mission is to ensure that the majesty of the Himalayas is preserved through the wisdom of its people."' );
$cta_text = get_theme_mod( 'hhb_about_cta_text', 'Meet Our Hosts' );
$cta_link = get_theme_mod( 'hhb_about_cta_link', '/hosts' );
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
.about-hero {
    position: relative;
    min-height: 500px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    color: white;
}
.about-hero-bg {
    position: absolute; inset: 0;
    background-size: cover;
    background-position: center;
    transform: scale(1.05);
}
.about-hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(180deg, rgba(0,0,0,0.2) 0%, rgba(249,249,249,1) 100%);
}
.about-hero-content {
    position: relative; z-index: 10;
    text-align: center;
    max-width: 800px;
    padding: 24px;
}
.about-hero-title {
    font-size: clamp(48px, 8vw, 84px);
    font-weight: 900;
    line-height: 0.95;
    letter-spacing: -0.04em;
    color: var(--text-main);
    margin-bottom: 24px;
}
.about-hero-sub {
    font-size: 20px;
    color: var(--text-muted);
    font-weight: 400;
}

/* ── Narrative Chapters ────────────────────── */
.about-chapters { background: #f9f9f9; padding: 120px 0; }
.chapter-row { 
    display: grid; 
    grid-template-columns: 1fr 1fr; 
    gap: 80px; 
    align-items: center; 
    margin-bottom: 120px; 
}
.chapter-row:nth-child(even) { direction: rtl; }
.chapter-row:nth-child(even) .chapter-content { direction: ltr; }

.chapter-img-wrap { position: relative; }
.chapter-img { width: 100%; aspect-ratio: 4/5; object-fit: cover; border-radius: 0; }
.chapter-glass-float {
    position: absolute;
    bottom: -40px;
    right: -40px;
    background: var(--surface-glass);
    backdrop-filter: var(--surface-blur);
    padding: 40px;
    max-width: 320px;
    border-radius: 0;
    border: 1px solid rgba(255,255,255,0.4);
    box-shadow: 0 40px 100px -20px rgba(0,0,0,0.06);
}
@media (max-width: 1024px) {
    .chapter-row { grid-template-columns: 1fr; gap: 40px; }
    .chapter-glass-float { position: static; max-width: 100%; margin-top: 20px; }
}

.chapter-label { font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.2em; color: #cb491c; margin-bottom: 16px; display: block; }
.chapter-title { font-size: 32px; font-weight: 900; line-height: 1.1; margin-bottom: 24px; color: var(--text-main); }
.chapter-text { font-size: 16px; color: var(--text-muted); line-height: 1.8; }

/* ── Stats Strip ────────────────────── */
.about-stats { background: white; padding: 80px 0; border-top: 1px solid #eee; border-bottom: 1px solid #eee; }
.stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 40px; text-align: center; }
.stat-num { font-size: 56px; font-weight: 900; color: var(--text-main); line-height: 1; letter-spacing: -0.04em; }
.stat-label { font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin-top: 8px; }

/* ── Values ────────────────────── */
.about-values { padding: 120px 0; background: #fff; }
.values-head { text-align: center; margin-bottom: 80px; }
.values-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; }
.value-card { padding: 48px; background: #f3f3f3; border-radius: 0; }
.value-icon { font-size: 40px; color: #cb491c; margin-bottom: 24px; }
.value-title { font-size: 24px; font-weight: 800; margin-bottom: 16px; color: var(--text-main); }
.value-desc { font-size: 15px; color: var(--text-muted); line-height: 1.7; }

/* ── Quote ────────────────────── */
.about-quote { padding: 160px 0; text-align: center; position: relative; overflow: hidden; }
.quote-text { font-size: clamp(24px, 4vw, 44px); font-weight: 400; font-style: italic; max-width: 1000px; margin: 0 auto 60px; line-height: 1.3; color: var(--text-main); }
.about-cta-btn {
    display: inline-block;
    padding: 20px 48px;
    background: var(--primary-gradient);
    color: white;
    font-weight: 800;
    font-size: 16px;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    border-radius: 0;
    transition: transform 0.3s;
    text-decoration: none;
}
.about-cta-btn:hover { transform: scale(1.05); }
</style>

<main>
    <!-- Hero -->
    <section class="about-hero">
        <div class="about-hero-bg" style="background-image: url('<?php echo esc_url( $hero_img ); ?>');"></div>
        <div class="about-hero-overlay"></div>
        <div class="about-hero-content">
            <h1 class="about-hero-title"><?php echo esc_html( $hero_head ); ?></h1>
            <p class="about-hero-sub"><?php echo esc_html( $hero_sub ); ?></p>
        </div>
    </section>

    <!-- Stats Strip -->
    <section class="about-stats">
        <div class="container mx-auto px-6">
            <div class="stats-grid">
                <?php foreach ( $stats_data as $s ) : ?>
                <div class="stat-item">
                    <div class="stat-num"><?php echo esc_html( $s['q'] ?? '' ); ?></div>
                    <div class="stat-label"><?php echo esc_html( $s['a'] ?? '' ); ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Narrative -->
    <section class="about-chapters">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center mb-20">
                <h2 class="text-4xl md:text-5xl font-black tracking-tight mb-6"><?php echo esc_html( $story_title ); ?></h2>
            </div>

            <?php foreach ( $chapters_data as $c ) : ?>
            <div class="chapter-row">
                <div class="chapter-img-wrap">
                    <?php 
                    $c_img = $c['image'] ?? ($c['img_id'] ?? ''); 
                    $c_url = is_numeric($c_img) ? wp_get_attachment_url($c_img) : $c_img;
                    ?>
                    <img src="<?php echo esc_url( $c_url ?: 'https://images.unsplash.com/photo-1516575150278-77136aed6920?q=80&w=2940&auto=format&fit=crop' ); ?>" alt="" class="chapter-img" />
                    <div class="chapter-glass-float">
                        <span class="chapter-label"><?php echo esc_html( $c['title'] ?? '' ); ?></span>
                        <h3 class="chapter-title"><?php echo esc_html( $c['desc'] ?? '' ); ?></h3>
                    </div>
                </div>
                <div class="chapter-content">
                    <p class="chapter-text"><?php echo wp_kses_post( $c['text'] ?? '' ); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Values -->
    <section class="about-values">
        <div class="container mx-auto px-6">
            <div class="values-head">
                <h2 class="text-4xl md:text-5xl font-black mb-4"><?php echo esc_html( $values_title ); ?></h2>
                <p class="text-xl text-muted"><?php echo esc_html( $values_sub ); ?></p>
            </div>
            <div class="values-grid">
                <?php foreach ( $values_data as $v ) : ?>
                <div class="value-card">
                    <span class="material-symbols-outlined value-icon">verified</span>
                    <h4 class="value-title"><?php echo esc_html( $v['q'] ?? '' ); ?></h4>
                    <p class="value-desc"><?php echo esc_html( $v['a'] ?? '' ); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Quote -->
    <section class="about-quote">
        <div class="container mx-auto px-6">
            <p class="quote-text"><?php echo wp_kses_post( $quote ); ?></p>
            <a href="<?php echo esc_url( $cta_link ); ?>" class="about-cta-btn"><?php echo esc_html( $cta_text ); ?></a>
        </div>
    </section>
</main>

<?php get_footer(); ?>
-transform hover:-translate-y-1 text-lg">
                <?php echo esc_html( $cta_text ); ?>
            </a>
        <?php endif; ?>
    </section>

</div>

<?php get_footer(); ?>
