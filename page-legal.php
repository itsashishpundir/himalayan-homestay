<?php
/**
 * Template Name: Legal Document
 *
 * A clean, text-focused template for Privacy Policy, Terms & Conditions, etc.
 * Features a simple grey hero and relies on the standard WordPress content editor.
 *
 * @package HimalayanHomestay
 */

get_header();
?>

<style>
/* ── Basic Scoped Styling for Legal Content ────────────────────── */
.hhb-legal-content {
    color: #334155;
    font-size: 1rem;
    line-height: 1.8;
}
.hhb-legal-content h1, 
.hhb-legal-content h2, 
.hhb-legal-content h3, 
.hhb-legal-content h4, 
.hhb-legal-content h5, 
.hhb-legal-content h6 {
    color: #0f172a;
    font-weight: 700;
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-family: "Playfair Display", serif;
}
.hhb-legal-content h2 { font-size: 1.75rem; }
.hhb-legal-content h3 { font-size: 1.5rem; }
.hhb-legal-content p {
    margin-bottom: 1.25rem;
}
.hhb-legal-content ul, 
.hhb-legal-content ol {
    margin-left: 1.5rem;
    margin-bottom: 1.5rem;
}
.hhb-legal-content ul { list-style-type: disc; }
.hhb-legal-content ol { list-style-type: decimal; }
.hhb-legal-content li { margin-bottom: 0.5rem; }
.hhb-legal-content a {
    color: #e85e30;
    text-decoration: underline;
    text-underline-offset: 4px;
}
.hhb-legal-content a:hover { color: #d04a20; }
.hhb-legal-content blockquote {
    border-left: 4px solid #cbd5e1;
    padding-left: 1rem;
    font-style: italic;
    color: #64748b;
    margin-bottom: 1.5rem;
}
</style>

<div class="relative flex min-h-screen w-full flex-col overflow-x-hidden bg-white">

    <!-- Plain Text-Focused Hero Section -->
    <section class="bg-slate-50 py-16 md:py-20 border-b border-slate-200">
        <div class="container mx-auto px-4 lg:px-6 max-w-4xl text-center">
            <h1 class="font-serif text-3xl md:text-5xl font-bold text-slate-900 mb-4 leading-tight italic"><?php the_title(); ?></h1>
            <p class="text-slate-500 text-sm font-medium italic">
                <a href="<?php echo esc_url( home_url('/') ); ?>" class="hover:text-primary transition-colors">Home</a> / 
                <span class="text-slate-800"><?php the_title(); ?></span>
            </p>
        </div>
    </section>

    <!-- Main Content Area -->
    <section class="container mx-auto px-4 lg:px-6 py-16 md:py-24 max-w-4xl">
        <div class="hhb-legal-content bg-white p-6 md:p-10 rounded-2xl border border-slate-100 shadow-sm">
            <?php
            while ( have_posts() ) :
                the_post();
                
                // If the post has no content, show a placeholder for the admin.
                if ( empty( get_the_content() ) && current_user_can( 'edit_posts' ) ) {
                    echo '<p class="text-slate-400 italic">No content found. Please edit this page in the WordPress dashboard to add your policy text.</p>';
                } else {
                    the_content();
                }

            endwhile;
            ?>
        </div>
    </section>

</div>

<?php get_footer(); ?>
