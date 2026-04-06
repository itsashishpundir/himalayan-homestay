<?php
/**
 * Template Name: About Us
 *
 * About page template, fully customizable via WordPress Customizer.
 * Designed with Stitch MCP.
 *
 * @package HimalayanHomestay
 */

get_header();

// ── Customizer Values ──────────────────────────────────────────────
$hero_img      = get_theme_mod( 'hhb_about_hero_img', 'https://images.unsplash.com/photo-1544256718-3b61a34ca536?q=80&w=2940&auto=format&fit=crop' );
$hero_head     = get_theme_mod( 'hhb_about_hero_head', 'About Himalayan Homestay' );
$hero_sub      = get_theme_mod( 'hhb_about_hero_sub', 'Connecting curious travelers with the heart of the mountains through local hospitality.' );

// Story Narrative Chapters
$story_title   = get_theme_mod( 'hhb_about_story_title', 'Where Tradition Meets Travel' );

$chapters = [
    1 => [
        'subtitle' => get_theme_mod( 'hhb_about_chap_1_sub', 'The Spark' ),
        'title'    => get_theme_mod( 'hhb_about_chap_1_title', 'How It All Started' ),
        'text'     => get_theme_mod( 'hhb_about_chap_1_text', 'Founded in the heart of the peaks, Himalayan Homestay was born from a simple realization: the most beautiful parts of the mountains aren\'t the views, but the people who call them home.' ),
        'image'    => get_theme_mod( 'hhb_about_chap_1_img', 'https://images.unsplash.com/photo-1516575150278-77136aed6920?q=80&w=2940&auto=format&fit=crop' ),
    ],
    2 => [
        'subtitle' => get_theme_mod( 'hhb_about_chap_2_sub', 'The Journey' ),
        'title'    => get_theme_mod( 'hhb_about_chap_2_title', 'Building the Bridge' ),
        'text'     => get_theme_mod( 'hhb_about_chap_2_text', 'We bridge the gap between remote village communities and global travelers, ensuring that every stay supports local livelihoods while offering an unparalleled glimpse into ancient cultures.' ),
        'image'    => get_theme_mod( 'hhb_about_chap_2_img', 'https://images.unsplash.com/photo-1533157497230-01dc481bb20f?q=80&w=2940&auto=format&fit=crop' ),
    ],
    3 => [
        'subtitle' => get_theme_mod( 'hhb_about_chap_3_sub', 'Today' ),
        'title'    => get_theme_mod( 'hhb_about_chap_3_title', 'A Growing Community' ),
        'text'     => get_theme_mod( 'hhb_about_chap_3_text', 'Today, we work with over 500 hosts across 5 states, empowering local economies and providing travelers with unforgettable memories.' ),
        'image'    => get_theme_mod( 'hhb_about_chap_3_img', 'https://images.unsplash.com/photo-1513271169004-9497e7f6dff4?q=80&w=2940&auto=format&fit=crop' ),
    ]
];

$stat1_num     = get_theme_mod( 'hhb_about_stat_1_num', '500+' );
$stat1_label   = get_theme_mod( 'hhb_about_stat_1_label', 'Properties' );
$stat2_num     = get_theme_mod( 'hhb_about_stat_2_num', '50k+' );
$stat2_label   = get_theme_mod( 'hhb_about_stat_2_label', 'Happy Guests' );
$stat3_num     = get_theme_mod( 'hhb_about_stat_3_num', '4.9/5' );
$stat3_label   = get_theme_mod( 'hhb_about_stat_3_label', 'Average Rating' );

$values_title  = get_theme_mod( 'hhb_about_values_title', 'Our Core Values' );
$values_sub    = get_theme_mod( 'hhb_about_values_sub', 'Guided by the spirit of the mountains' );

$v1_icon       = get_theme_mod( 'hhb_about_v1_icon', 'verified_user' );
$v1_title      = get_theme_mod( 'hhb_about_v1_title', 'Authenticity' );
$v1_desc       = get_theme_mod( 'hhb_about_v1_desc', 'Real homes, real families, and real experiences. No staged performances, just genuine Himalayan life.' );

$v2_icon       = get_theme_mod( 'hhb_about_v2_icon', 'eco' );
$v2_title      = get_theme_mod( 'hhb_about_v2_title', 'Sustainability' );
$v2_desc       = get_theme_mod( 'hhb_about_v2_desc', 'Preserving the fragile mountain ecosystem and supporting slow travel that leaves a positive footprint.' );

$v3_icon       = get_theme_mod( 'hhb_about_v3_icon', 'groups' );
$v3_title      = get_theme_mod( 'hhb_about_v3_title', 'Community' );
$v3_desc       = get_theme_mod( 'hhb_about_v3_desc', 'Empowering local hosts through fair trade and direct economic opportunities for remote villages.' );

$quote         = get_theme_mod( 'hhb_about_quote', '"Our mission is to ensure that the majesty of the Himalayas is preserved through the wisdom of its people."' );
$cta_text      = get_theme_mod( 'hhb_about_cta_text', 'Meet Our Hosts' );
$cta_link      = get_theme_mod( 'hhb_about_cta_link', '/hosts' );
?>

<style>
/* ── Shared Hero Styles (from Contact Page) ────────────────────── */
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

/* ── Overlapping Chapter Styles ────────────────────── */
.hhb-timeline {
    position: relative;
}
.hhb-glass-card {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    box-shadow: 0 20px 40px -10px rgba(0,0,0,0.1);
}
</style>

<div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">

    <!-- Hero Section -->
    <section class="hhb-contact-hero">
        <div class="hhb-contact-hero-bg" style="background-image: url('<?php echo esc_url( $hero_img ); ?>')"></div>
        <div class="hhb-contact-hero-overlay"></div>
        <div class="relative z-10 text-center px-4 py-16">
            <h1 class="text-4xl md:text-5xl font-black text-white mb-3 drop-shadow-lg"><?php echo esc_html( $hero_head ); ?></h1>
            <p class="text-white/80 text-base md:text-lg max-w-xl mx-auto"><?php echo esc_html( $hero_sub ); ?></p>
        </div>
    </section>

    <!-- Narrative Story Timeline -->
    <section class="container mx-auto px-4 lg:px-6 py-20 md:py-32">
        <div class="text-center mb-16 md:mb-24">
            <h2 class="font-serif text-3xl md:text-5xl font-bold text-slate-900 dark:text-slate-100 leading-tight"><?php echo esc_html( $story_title ); ?></h2>
            <div class="w-20 h-1.5 bg-primary rounded-full mx-auto mt-6"></div>
        </div>

        <div class="hhb-timeline space-y-20 lg:space-y-32 max-w-5xl mx-auto">
            <?php foreach ( $chapters as $i => $chap ) : 
                if ( empty( $chap['title'] ) ) continue; 
                
                // Determine orientation based on completely alternating logic
                $is_even = ($i % 2 === 0);
                $flex_dir   = $is_even ? 'lg:flex-row' : 'lg:flex-row-reverse';
                $overlap_m  = $is_even ? 'lg:-ml-16' : 'lg:-mr-16';
            ?>
            <div class="relative flex flex-col items-center <?php echo esc_attr( $flex_dir ); ?>">
                
                <!-- Image Layer -->
                <div class="w-full lg:w-7/12 rounded-[2rem] overflow-hidden shadow-2xl relative aspect-[4/3] bg-slate-200">
                    <img src="<?php echo esc_url( $chap['image'] ); ?>" alt="<?php echo esc_attr( $chap['title'] ); ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 hover:scale-105">
                </div>
                
                <!-- Glass Text Panel -->
                <div class="w-11/12 lg:w-6/12 relative z-10 -mt-16 lg:mt-0 <?php echo esc_attr( $overlap_m ); ?>">
                    <div class="hhb-glass-card rounded-[2rem] p-8 md:p-12 space-y-5">
                        <?php if ( $chap['subtitle'] ) : ?>
                            <span class="inline-block px-4 py-1.5 bg-primary/10 text-primary text-xs font-bold uppercase tracking-widest rounded-full mb-2 border border-primary/20">
                                <?php echo esc_html( $chap['subtitle'] ); ?>
                            </span>
                        <?php endif; ?>
                        
                        <h3 class="font-serif text-3xl md:text-4xl font-bold text-slate-900 leading-tight">
                            <?php echo esc_html( $chap['title'] ); ?>
                        </h3>
                        
                        <div class="text-slate-600 text-base md:text-lg leading-relaxed">
                            <?php echo wp_kses_post( wpautop( $chap['text'] ) ); ?>
                        </div>
                    </div>
                </div>
                
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Company Stats Section (New!) -->
    <section class="container mx-auto px-4 lg:px-6 pb-20 md:pb-32 -mt-10 relative z-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-3xl p-8 text-center shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(232,94,48,0.1)] border border-primary/5 transition-all duration-300 hover:-translate-y-2">
                <div class="text-5xl md:text-6xl font-black text-primary mb-2"><?php echo esc_html( $stat1_num ); ?></div>
                <div class="text-sm md:text-base font-bold text-slate-500 uppercase tracking-widest"><?php echo esc_html( $stat1_label ); ?></div>
            </div>
            <div class="bg-white rounded-3xl p-8 text-center shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(232,94,48,0.1)] border border-primary/5 transition-all duration-300 hover:-translate-y-2">
                <div class="text-5xl md:text-6xl font-black text-primary mb-2"><?php echo esc_html( $stat2_num ); ?></div>
                <div class="text-sm md:text-base font-bold text-slate-500 uppercase tracking-widest"><?php echo esc_html( $stat2_label ); ?></div>
            </div>
            <div class="bg-white rounded-3xl p-8 text-center shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(232,94,48,0.1)] border border-primary/5 transition-all duration-300 hover:-translate-y-2">
                <div class="text-5xl md:text-6xl font-black text-primary mb-2"><?php echo esc_html( $stat3_num ); ?></div>
                <div class="text-sm md:text-base font-bold text-slate-500 uppercase tracking-widest"><?php echo esc_html( $stat3_label ); ?></div>
            </div>
        </div>
    </section>

    <!-- Core Values Section -->
    <section class="bg-primary/5 px-4 lg:px-6 py-24">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-16">
                <h3 class="font-serif text-3xl md:text-4xl font-bold mb-4 text-slate-900 dark:text-slate-100"><?php echo esc_html( $values_title ); ?></h3>
                <p class="text-slate-500 md:text-lg font-medium tracking-wide"><?php echo esc_html( $values_sub ); ?></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Value 1 -->
                <div class="bg-white p-8 md:p-10 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(232,94,48,0.1)] border border-primary/5 transition-all duration-300 hover:-translate-y-2">
                    <div class="flex size-16 items-center justify-center bg-primary/10 text-primary rounded-2xl mb-6">
                        <span class="material-symbols-outlined text-3xl"><?php echo esc_attr( $v1_icon ); ?></span>
                    </div>
                    <h4 class="font-bold text-xl md:text-2xl mb-4 text-slate-900"><?php echo esc_html( $v1_title ); ?></h4>
                    <p class="text-base text-slate-600 leading-relaxed"><?php echo esc_html( $v1_desc ); ?></p>
                </div>

                <!-- Value 2 -->
                <div class="bg-white p-8 md:p-10 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(232,94,48,0.1)] border border-primary/5 transition-all duration-300 hover:-translate-y-2">
                    <div class="flex size-16 items-center justify-center bg-primary/10 text-primary rounded-2xl mb-6">
                        <span class="material-symbols-outlined text-3xl"><?php echo esc_attr( $v2_icon ); ?></span>
                    </div>
                    <h4 class="font-bold text-xl md:text-2xl mb-4 text-slate-900"><?php echo esc_html( $v2_title ); ?></h4>
                    <p class="text-base text-slate-600 leading-relaxed"><?php echo esc_html( $v2_desc ); ?></p>
                </div>

                <!-- Value 3 -->
                <div class="bg-white p-8 md:p-10 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(232,94,48,0.1)] border border-primary/5 transition-all duration-300 hover:-translate-y-2">
                    <div class="flex size-16 items-center justify-center bg-primary/10 text-primary rounded-2xl mb-6">
                        <span class="material-symbols-outlined text-3xl"><?php echo esc_attr( $v3_icon ); ?></span>
                    </div>
                    <h4 class="font-bold text-xl md:text-2xl mb-4 text-slate-900"><?php echo esc_html( $v3_title ); ?></h4>
                    <p class="text-base text-slate-600 leading-relaxed"><?php echo esc_html( $v3_desc ); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA/Quote -->
    <section class="container mx-auto px-4 lg:px-6 py-24 md:py-32 text-center max-w-4xl">
        <span class="material-symbols-outlined text-primary/20 text-[80px] leading-none block mb-8">format_quote</span>
        <p class="font-serif text-2xl md:text-4xl italic text-slate-800 leading-snug mb-12">
            <?php echo wp_kses_post( $quote ); ?>
        </p>
        <?php if ( $cta_text && $cta_link ) : ?>
            <a href="<?php echo esc_url( $cta_link ); ?>" class="inline-block bg-primary hover:bg-primary/90 text-white hover:text-white px-10 py-5 rounded-full font-bold shadow-xl shadow-primary/30 transition-transform hover:-translate-y-1 text-lg">
                <?php echo esc_html( $cta_text ); ?>
            </a>
        <?php endif; ?>
    </section>

</div>

<?php get_footer(); ?>
