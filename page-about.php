<?php
/**
 * Template Name: About Us
 *
 * @package HimalayanHomestay
 */

get_header();

// ── Values ──────────────────────────────────────────────────────────
$hero_img  = get_theme_mod( 'hhb_about_hero_img', '' );
$hero_head = get_theme_mod( 'hhb_about_hero_head', 'About Himalayan Homestay' );
$hero_sub  = get_theme_mod( 'hhb_about_hero_sub', 'Connecting curious travelers with the heart of the mountains through local hospitality.' );

$story_title   = get_theme_mod( 'hhb_about_story_title', 'Where Tradition Meets Travel' );
$chapters_json = get_theme_mod( 'hhb_about_chapters', '[]' );
$chapters_data = json_decode( $chapters_json, true ) ?: [];

if ( empty( $chapters_data ) ) {
    $chapters_data = [
        [
            'title' => 'The Spark',
            'desc'  => 'How It All Started',
            'text'  => 'Founded in the heart of the peaks, Himalayan Homestay was born from a simple realization: the most beautiful parts of the mountains aren\'t the views — they\'re the people who call them home.',
            'image' => 'https://images.unsplash.com/photo-1609183480561-c4f0e6ab6e92?w=900&auto=format&fit=crop&q=80',
        ],
        [
            'title' => 'The Journey',
            'desc'  => 'Building the Bridge',
            'text'  => 'We bridge the gap between remote village communities and global travelers, ensuring that every stay supports local livelihoods while offering an unparalleled glimpse into ancient cultures.',
            'image' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=900&auto=format&fit=crop&q=80',
        ],
        [
            'title' => 'Today',
            'desc'  => 'A Growing Community',
            'text'  => 'Today, we work with over 500 hosts across 5 states, empowering local economies and providing travelers with unforgettable memories that last a lifetime.',
            'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=900&auto=format&fit=crop&q=80',
        ],
    ];
}

$stats_json = get_theme_mod( 'hhb_about_stats', '[]' );
$stats_data = json_decode( $stats_json, true ) ?: [];
if ( empty( $stats_data ) ) {
    $stats_data = [
        [ 'q' => '500+', 'a' => 'Properties' ],
        [ 'q' => '50k+', 'a' => 'Happy Guests' ],
        [ 'q' => '4.9/5', 'a' => 'Average Rating' ],
    ];
}

$values_title = get_theme_mod( 'hhb_about_values_title', 'Our Core Values' );
$values_sub   = get_theme_mod( 'hhb_about_values_sub', 'Guided by the spirit of the mountains' );
$values_json  = get_theme_mod( 'hhb_about_values_list', '[]' );
$values_data  = json_decode( $values_json, true ) ?: [];
if ( empty( $values_data ) ) {
    $values_data = [
        [ 'q' => 'Authenticity',  'a' => 'Real homes, real families, and real experiences. No staged performances — just genuine Himalayan life.', 'icon' => 'verified' ],
        [ 'q' => 'Sustainability','a' => 'Preserving the fragile mountain ecosystem through slow travel that leaves a positive footprint.', 'icon' => 'eco' ],
        [ 'q' => 'Community',     'a' => 'Empowering local hosts through fair trade and direct economic opportunities for remote villages.', 'icon' => 'group' ],
    ];
}

$quote    = get_theme_mod( 'hhb_about_quote', '"Our mission is to ensure that the majesty of the Himalayas is preserved through the wisdom of its people."' );
$cta_text = get_theme_mod( 'hhb_about_cta_text', 'Meet Our Hosts' );
$cta_link = get_theme_mod( 'hhb_about_cta_link', '/homestays' );

// Resolve hero bg — fallback to a reliable mountain image
$hero_bg_url = $hero_img
    ?: 'https://images.unsplash.com/photo-1544894079-e81a9eb4a456?w=1800&auto=format&fit=crop&q=80';
?>

<style>
:root {
    --ab-primary: #cb491c;
    --ab-primary-dark: #a93102;
    --ab-text: #1a1c1c;
    --ab-muted: #59413a;
    --ab-bg: #f2f0ed;
    --ab-white: #ffffff;
}

/* ── Hero ──────────────────────────────────────── */
.ab-hero {
    position: relative;
    min-height: 420px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    overflow: hidden;
}
.ab-hero-bg {
    position: absolute; inset: 0;
    background-size: cover;
    background-position: center 40%;
}
.ab-hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(
        to bottom,
        rgba(0,0,0,0.38) 0%,
        rgba(0,0,0,0.55) 55%,
        #f2f0ed 100%
    );
}
.ab-hero-content {
    position: relative; z-index: 2;
    max-width: 740px;
    padding: 80px 24px 100px;
}
.ab-hero-title {
    font-size: clamp(44px, 8vw, 80px);
    font-weight: 900;
    letter-spacing: -0.04em;
    line-height: 0.95;
    color: #fff;
    margin-bottom: 20px;
}
.ab-hero-sub {
    font-size: 18px;
    color: rgba(255,255,255,0.82);
    line-height: 1.6;
}

/* ── Story section ─────────────────────────────── */
.ab-story {
    background: var(--ab-bg);
    padding: 80px 0 120px;
    position: relative;
    overflow: hidden;
}
.ab-story::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(203,73,28,0.2), transparent);
}

.ab-story-header {
    text-align: center;
    margin-bottom: 90px;
}
.ab-story-eyebrow {
    display: inline-block;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.22em;
    color: var(--ab-primary);
    background: rgba(203,73,28,0.08);
    border-radius: 100px;
    padding: 6px 18px;
    margin-bottom: 18px;
}
.ab-story-title {
    font-size: clamp(32px, 4.5vw, 52px);
    font-weight: 900;
    letter-spacing: -0.04em;
    color: var(--ab-text);
    line-height: 1.05;
    margin-bottom: 16px;
}
.ab-story-subtitle {
    font-size: 17px;
    color: var(--ab-muted);
    max-width: 520px;
    margin: 0 auto;
    line-height: 1.6;
}

/* ── Timeline container ─────────────────────────── */
.ab-timeline {
    position: relative;
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 24px;
}

/* Central vertical spine */
.ab-timeline::before {
    content: '';
    position: absolute;
    left: 50%;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, transparent 0%, rgba(203,73,28,0.25) 10%, rgba(203,73,28,0.25) 90%, transparent 100%);
    transform: translateX(-50%);
}

@media (max-width: 860px) {
    .ab-timeline::before { left: 24px; }
}

/* ── Chapter (timeline entry) ──────────────────── */
.ab-chapter {
    display: grid;
    grid-template-columns: 1fr 80px 1fr;
    gap: 0;
    align-items: center;
    margin-bottom: 80px;
    opacity: 0;
    transform: translateY(40px);
    transition: opacity 0.7s ease, transform 0.7s ease;
}
.ab-chapter.is-visible {
    opacity: 1;
    transform: translateY(0);
}
.ab-chapter:last-child { margin-bottom: 0; }

/* Even chapters flip: text left, image right */
.ab-chapter:nth-child(even) .ab-chapter-visual { order: 3; }
.ab-chapter:nth-child(even) .ab-chapter-text   { order: 1; }
.ab-chapter:nth-child(even) .ab-chapter-node   { order: 2; }

/* Odd chapters: image left, text right */
.ab-chapter:nth-child(odd) .ab-chapter-visual  { order: 1; }
.ab-chapter:nth-child(odd) .ab-chapter-node    { order: 2; }
.ab-chapter:nth-child(odd) .ab-chapter-text    { order: 3; }

@media (max-width: 860px) {
    .ab-timeline::before { left: 28px; transform: none; }
    .ab-chapter {
        grid-template-columns: 56px 1fr;
        grid-template-rows: auto auto;
        gap: 16px 0;
    }
    .ab-chapter:nth-child(even) .ab-chapter-visual,
    .ab-chapter:nth-child(even) .ab-chapter-text,
    .ab-chapter:nth-child(even) .ab-chapter-node,
    .ab-chapter:nth-child(odd) .ab-chapter-visual,
    .ab-chapter:nth-child(odd) .ab-chapter-node,
    .ab-chapter:nth-child(odd) .ab-chapter-text { order: unset; }
    .ab-chapter-node { grid-row: 1; grid-column: 1; }
    .ab-chapter-text { grid-row: 1; grid-column: 2; }
    .ab-chapter-visual { grid-row: 2; grid-column: 2; }
}

/* ── Timeline node (center dot) ────────────────── */
.ab-chapter-node {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: relative;
    z-index: 2;
}
.ab-chapter-dot {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--ab-primary-dark), var(--ab-primary));
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 900;
    font-size: 15px;
    letter-spacing: -0.02em;
    box-shadow: 0 4px 20px rgba(203,73,28,0.35);
    flex-shrink: 0;
}
@media (max-width: 860px) {
    .ab-chapter-dot { width: 40px; height: 40px; font-size: 13px; }
}

/* ── Image panel ───────────────────────────────── */
.ab-chapter-visual {
    position: relative;
    padding: 0 32px;
}
.ab-chapter:nth-child(odd) .ab-chapter-visual  { padding: 0 32px 0 0; }
.ab-chapter:nth-child(even) .ab-chapter-visual { padding: 0 0 0 32px; }

@media (max-width: 860px) {
    .ab-chapter-visual,
    .ab-chapter:nth-child(odd) .ab-chapter-visual,
    .ab-chapter:nth-child(even) .ab-chapter-visual { padding: 0 0 0 16px; }
}

.ab-chapter-img-wrap {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 24px 60px rgba(0,0,0,0.14);
}
.ab-chapter-img {
    width: 100%;
    aspect-ratio: 3 / 2;
    object-fit: cover;
    display: block;
    transition: transform 0.6s ease;
}
.ab-chapter-img-wrap:hover .ab-chapter-img {
    transform: scale(1.04);
}

/* Badge overlaid on image */
.ab-chapter-badge {
    position: absolute;
    bottom: 16px;
    left: 16px;
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(8px);
    border-radius: 100px;
    padding: 8px 16px 8px 8px;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
}
.ab-chapter-badge-dot {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--ab-primary-dark), var(--ab-primary));
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.ab-chapter-badge-dot svg {
    width: 14px; height: 14px;
    fill: none; stroke: #fff; stroke-width: 2.2; stroke-linecap: round;
}
.ab-chapter-badge-text {
    font-size: 12px;
    font-weight: 700;
    color: var(--ab-text);
    letter-spacing: -0.01em;
}

/* ── Text panel ────────────────────────────────── */
.ab-chapter-text {
    padding: 0 32px;
}
.ab-chapter:nth-child(odd) .ab-chapter-text  { padding: 0 0 0 32px; }
.ab-chapter:nth-child(even) .ab-chapter-text { padding: 0 32px 0 0; text-align: right; }

@media (max-width: 860px) {
    .ab-chapter-text,
    .ab-chapter:nth-child(odd) .ab-chapter-text,
    .ab-chapter:nth-child(even) .ab-chapter-text { padding: 0 0 0 16px; text-align: left; }
}

.ab-chapter-label {
    display: inline-block;
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.2em;
    color: var(--ab-primary);
    background: rgba(203,73,28,0.08);
    border-radius: 100px;
    padding: 5px 14px;
    margin-bottom: 16px;
}
.ab-chapter-heading {
    font-size: clamp(22px, 2.5vw, 32px);
    font-weight: 900;
    color: var(--ab-text);
    letter-spacing: -0.03em;
    line-height: 1.1;
    margin-bottom: 16px;
}
.ab-chapter-body {
    font-size: 16px;
    color: var(--ab-muted);
    line-height: 1.85;
}

/* ── Stats strip ───────────────────────────────── */
.ab-stats {
    background: var(--ab-white);
    padding: 80px 0;
    border-top: 1px solid #e8e4e0;
    border-bottom: 1px solid #e8e4e0;
}
.ab-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 40px;
    text-align: center;
}
.ab-stat-num {
    font-size: 60px;
    font-weight: 900;
    color: var(--ab-text);
    line-height: 1;
    letter-spacing: -0.04em;
}
.ab-stat-label {
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.14em;
    color: var(--ab-muted);
    margin-top: 10px;
}

/* ── Values ────────────────────────────────────── */
.ab-values { background: var(--ab-white); padding: 100px 0; }
.ab-values-head { text-align: center; margin-bottom: 72px; }
.ab-values-head h2 {
    font-size: clamp(28px, 4vw, 44px);
    font-weight: 900;
    letter-spacing: -0.03em;
    color: var(--ab-text);
    margin-bottom: 12px;
}
.ab-values-head p { font-size: 17px; color: var(--ab-muted); }

.ab-values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 28px;
}
.ab-value-card {
    background: var(--ab-bg);
    border-radius: 4px;
    padding: 44px 36px;
}
.ab-value-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: #fdeee8;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--ab-primary);
    margin-bottom: 24px;
}
.ab-value-icon .material-symbols-outlined { font-size: 26px; }
.ab-value-title {
    font-size: 20px;
    font-weight: 800;
    color: var(--ab-text);
    margin-bottom: 14px;
    letter-spacing: -0.01em;
}
.ab-value-desc {
    font-size: 15px;
    color: var(--ab-muted);
    line-height: 1.75;
}

/* ── Quote + CTA ───────────────────────────────── */
.ab-quote-section {
    background: var(--ab-bg);
    padding: 120px 0;
    text-align: center;
}
.ab-quote-text {
    font-size: clamp(22px, 3.5vw, 38px);
    font-weight: 400;
    font-style: italic;
    color: var(--ab-text);
    max-width: 860px;
    margin: 0 auto 56px;
    line-height: 1.35;
}
.ab-cta-btn {
    display: inline-block;
    padding: 18px 48px;
    background: linear-gradient(135deg, var(--ab-primary-dark), var(--ab-primary));
    color: #fff;
    font-weight: 800;
    font-size: 15px;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    border-radius: 100px;
    text-decoration: none;
    transition: transform .25s, box-shadow .25s;
}
.ab-cta-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 32px -8px rgba(169,49,2,.5);
    color: #fff;
    text-decoration: none;
}
</style>

<main>

    <!-- Hero -->
    <section class="ab-hero">
        <div class="ab-hero-bg" style="background-image:url('<?php echo esc_url( $hero_bg_url ); ?>');"></div>
        <div class="ab-hero-overlay"></div>
        <div class="ab-hero-content">
            <h1 class="ab-hero-title"><?php echo esc_html( $hero_head ); ?></h1>
            <p class="ab-hero-sub"><?php echo esc_html( $hero_sub ); ?></p>
        </div>
    </section>

    <!-- Story Chapters — Timeline -->
    <section class="ab-story">
        <div class="container mx-auto px-6">

            <div class="ab-story-header">
                <span class="ab-story-eyebrow">Our Story</span>
                <h2 class="ab-story-title"><?php echo esc_html( $story_title ); ?></h2>
                <p class="ab-story-subtitle">Three chapters that shaped how we connect travelers with the soul of the Himalayas.</p>
            </div>

            <div class="ab-timeline">
                <?php
                // Refined fallback images — reliable Unsplash URLs
                $fallback_imgs = [
                    'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=900&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=900&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=900&auto=format&fit=crop&q=80',
                ];
                $badge_icons = [
                    '<polyline points="20 6 9 17 4 12"></polyline>', // checkmark
                    '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle>', // community
                    '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>', // star
                ];
                foreach ( $chapters_data as $idx => $c ) :
                    $c_img = $c['image'] ?? ( $c['img_id'] ?? '' );
                    $c_url = is_numeric( $c_img )
                        ? wp_get_attachment_url( $c_img )
                        : $c_img;
                    if ( ! $c_url ) {
                        $c_url = $fallback_imgs[ $idx % count($fallback_imgs) ];
                    }
                    $num = str_pad( $idx + 1, 2, '0', STR_PAD_LEFT );
                ?>
                <div class="ab-chapter">

                    <!-- Image panel -->
                    <div class="ab-chapter-visual">
                        <div class="ab-chapter-img-wrap">
                            <img
                                src="<?php echo esc_url( $c_url ); ?>"
                                alt="<?php echo esc_attr( $c['desc'] ?? '' ); ?>"
                                class="ab-chapter-img"
                                loading="lazy"
                            />
                            <div class="ab-chapter-badge">
                                <div class="ab-chapter-badge-dot">
                                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <?php echo $badge_icons[ $idx % count($badge_icons) ]; ?>
                                    </svg>
                                </div>
                                <span class="ab-chapter-badge-text"><?php echo esc_html( $c['desc'] ?? '' ); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Center dot -->
                    <div class="ab-chapter-node">
                        <div class="ab-chapter-dot"><?php echo esc_html( $num ); ?></div>
                    </div>

                    <!-- Text panel -->
                    <div class="ab-chapter-text">
                        <span class="ab-chapter-label"><?php echo esc_html( $c['title'] ?? '' ); ?></span>
                        <h3 class="ab-chapter-heading"><?php echo esc_html( $c['desc'] ?? '' ); ?></h3>
                        <p class="ab-chapter-body"><?php echo wp_kses_post( $c['text'] ?? '' ); ?></p>
                    </div>

                </div>
                <?php endforeach; ?>
            </div><!-- /.ab-timeline -->

        </div>
    </section>

    <script>
    (function() {
        var chapters = document.querySelectorAll('.ab-chapter');
        if (!chapters.length) return;
        var io = new IntersectionObserver(function(entries) {
            entries.forEach(function(e, i) {
                if (e.isIntersecting) {
                    setTimeout(function() {
                        e.target.classList.add('is-visible');
                    }, i * 120);
                    io.unobserve(e.target);
                }
            });
        }, { threshold: 0.15 });
        chapters.forEach(function(el) { io.observe(el); });
    })();
    </script>

    <!-- Stats -->
    <section class="ab-stats">
        <div class="container mx-auto px-6">
            <div class="ab-stats-grid">
                <?php foreach ( $stats_data as $s ) : ?>
                <div>
                    <div class="ab-stat-num"><?php echo esc_html( $s['q'] ?? '' ); ?></div>
                    <div class="ab-stat-label"><?php echo esc_html( $s['a'] ?? '' ); ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Values -->
    <section class="ab-values">
        <div class="container mx-auto px-6">
            <div class="ab-values-head">
                <h2><?php echo esc_html( $values_title ); ?></h2>
                <p><?php echo esc_html( $values_sub ); ?></p>
            </div>
            <div class="ab-values-grid">
                <?php foreach ( $values_data as $v ) :
                    $icon = sanitize_text_field( $v['icon'] ?? 'verified' );
                ?>
                <div class="ab-value-card">
                    <div class="ab-value-icon">
                        <span class="material-symbols-outlined"><?php echo esc_html( $icon ); ?></span>
                    </div>
                    <h4 class="ab-value-title"><?php echo esc_html( $v['q'] ?? '' ); ?></h4>
                    <p class="ab-value-desc"><?php echo esc_html( $v['a'] ?? '' ); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Quote + CTA -->
    <section class="ab-quote-section">
        <div class="container mx-auto px-6">
            <p class="ab-quote-text"><?php echo wp_kses_post( $quote ); ?></p>
            <a href="<?php echo esc_url( $cta_link ); ?>" class="ab-cta-btn">
                <?php echo esc_html( $cta_text ); ?>
            </a>
        </div>
    </section>

</main>

<?php get_footer(); ?>
