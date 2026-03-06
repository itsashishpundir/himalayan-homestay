<?php
/**
 * Blog Home / Archive Template
 *
 * Redesigned via Google Stitch — premium travel magazine aesthetic.
 * Handles: Blog home (home.php), post archive (archive.php used as fallback).
 *
 * @package HimalayanMart
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

$current_page = max( 1, get_query_var( 'paged' ) );
?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@400,0&display=swap" rel="stylesheet">

<style>
  :root { --brand:#e85e30; --brand-light:#fef1ec; --bg:#f8f6f6; --border:#e2e8f0; --text:#1a1a2e; --muted:#64748b; }
  .hhm-blog *:not(.material-symbols-outlined) { box-sizing:border-box; font-family:'Inter',sans-serif; }
  .hhm-blog * { box-sizing:border-box; }
  .hhm-blog { background:var(--bg); }

  /* ── HERO ── */
  .hhm-blog-hero { position:relative; min-height:340px; display:flex; align-items:center; justify-content:center; overflow:hidden; }
  .hhm-blog-hero-bg { position:absolute; inset:0; background:url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1920&q=80') center/cover no-repeat; }
  .hhm-blog-hero-overlay { position:absolute; inset:0; background:linear-gradient(135deg,rgba(15,8,3,0.75) 0%,rgba(30,15,5,0.55) 60%,rgba(30,15,5,0.4) 100%); }
  .hhm-blog-hero-content { position:relative; z-index:1; text-align:center; padding:60px 24px 48px; }
  .hhm-blog-hero-badge { display:inline-flex; align-items:center; gap:6px; background:rgba(232,94,48,0.25); color:rgba(255,255,255,0.95); border:1px solid rgba(232,94,48,0.45); border-radius:50px; padding:5px 16px; font-size:11px; font-weight:700; letter-spacing:1.2px; text-transform:uppercase; margin-bottom:16px; backdrop-filter:blur(8px); }
  .hhm-blog-hero h1 { font-size:clamp(28px,4vw,52px); font-weight:900; color:#fff; line-height:1.1; margin:0 0 12px; letter-spacing:-0.5px; }
  .hhm-blog-hero p { font-size:16px; color:rgba(255,255,255,0.8); margin:0 0 20px; }
  .hhm-blog-breadcrumb { color:rgba(255,255,255,0.6); font-size:13px; }
  .hhm-blog-breadcrumb a { color:rgba(255,255,255,0.8); text-decoration:none; }
  .hhm-blog-breadcrumb a:hover { color:#fff; }

  /* ── LAYOUT ── */
  .hhm-blog-body { max-width:1280px; margin:0 auto; padding:48px 24px 80px; display:grid; grid-template-columns:1fr 340px; gap:48px; align-items:start; }
  @media(max-width:960px) { .hhm-blog-body { grid-template-columns:1fr; } }

  /* ── FEATURED POST ── */
  .hhm-featured { position:relative; border-radius:20px; overflow:hidden; margin-bottom:36px; box-shadow:0 8px 32px rgba(0,0,0,0.12); }
  .hhm-featured-img { width:100%; height:420px; object-fit:cover; display:block; }
  .hhm-featured-overlay { position:absolute; inset:0; background:linear-gradient(to top,rgba(0,0,0,0.85) 0%,rgba(0,0,0,0.1) 60%,transparent 100%); }
  .hhm-featured-body { position:absolute; bottom:0; left:0; right:0; padding:32px; }
  .hhm-featured-cat { display:inline-block; background:var(--brand); color:#fff; border-radius:6px; padding:4px 12px; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.8px; margin-bottom:12px; }
  .hhm-featured-title { font-size:clamp(20px,2.5vw,28px); font-weight:800; color:#fff; line-height:1.25; margin:0 0 10px; }
  .hhm-featured-title a { color:#fff; text-decoration:none; }
  .hhm-featured-title a:hover { text-decoration:underline; }
  .hhm-featured-meta { display:flex; align-items:center; gap:12px; color:rgba(255,255,255,0.75); font-size:13px; margin-bottom:14px; }
  .hhm-featured-meta img { width:28px; height:28px; border-radius:50%; object-fit:cover; border:2px solid rgba(255,255,255,0.4); }
  .hhm-featured-excerpt { color:rgba(255,255,255,0.85); font-size:14px; line-height:1.7; margin-bottom:18px; max-width:520px; }
  .hhm-featured-btn { display:inline-flex; align-items:center; gap:6px; background:var(--brand); color:#fff; border-radius:10px; padding:10px 20px; font-weight:700; font-size:14px; text-decoration:none; transition:all 0.2s; box-shadow:0 4px 12px rgba(232,94,48,0.4); }
  .hhm-featured-btn:hover { background:#c94d22; transform:translateY(-1px); }

  /* ── SECTION HEADER ── */
  .hhm-section-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; }
  .hhm-section-title { font-size:22px; font-weight:800; color:var(--text); margin:0; display:flex; align-items:center; gap:10px; }
  .hhm-count-badge { background:var(--brand-light); color:var(--brand); border-radius:50px; padding:3px 12px; font-size:13px; font-weight:700; border:1px solid rgba(232,94,48,0.2); }

  /* ── ARTICLE CARDS GRID ── */
  .hhm-cards-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:24px; }
  @media(max-width:700px) { .hhm-cards-grid { grid-template-columns:1fr; } }
  .hhm-card { background:#fff; border-radius:16px; border:1px solid var(--border); overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,0.04); transition:all 0.3s; }
  .hhm-card:hover { transform:translateY(-5px); box-shadow:0 12px 36px rgba(0,0,0,0.1); }
  .hhm-card-img-wrap { position:relative; height:190px; overflow:hidden; }
  .hhm-card-img { width:100%; height:100%; object-fit:cover; transition:transform 0.5s; }
  .hhm-card:hover .hhm-card-img { transform:scale(1.06); }
  .hhm-card-cat { position:absolute; top:12px; left:12px; background:var(--brand); color:#fff; border-radius:6px; padding:3px 10px; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.6px; }
  .hhm-card-body { padding:20px; }
  .hhm-card-title { font-size:17px; font-weight:700; color:var(--text); margin:0 0 8px; line-height:1.35; }
  .hhm-card-title a { color:inherit; text-decoration:none; }
  .hhm-card-title a:hover { color:var(--brand); }
  .hhm-card-meta { display:flex; align-items:center; gap:8px; color:var(--muted); font-size:12px; margin-bottom:10px; }
  .hhm-card-meta img { width:22px; height:22px; border-radius:50%; object-fit:cover; }
  .hhm-card-excerpt { color:#374151; font-size:13px; line-height:1.7; margin-bottom:14px; display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden; }
  .hhm-card-link { color:var(--brand); font-weight:700; font-size:13px; text-decoration:none; display:inline-flex; align-items:center; gap:4px; }
  .hhm-card-link:hover { gap:8px; }

  /* ── SIDEBAR ── */
  .hhm-sidebar { position:sticky; top:24px; }
  .hhm-sidebar-widget { background:#fff; border:1px solid var(--border); border-radius:16px; padding:24px; box-shadow:0 2px 10px rgba(0,0,0,0.04); margin-bottom:24px; }
  .hhm-widget-title { font-size:16px; font-weight:800; color:var(--text); margin:0 0 18px; padding-bottom:14px; border-bottom:2px solid var(--brand-light); display:flex; align-items:center; gap:8px; }
  .hhm-widget-title .material-symbols-outlined { color:var(--brand); font-size:20px; }
  .hhm-search-form { display:flex; gap:8px; }
  .hhm-search-input { flex:1; border:1px solid var(--border); border-radius:10px; padding:10px 14px; font-size:14px; font-family:'Inter',sans-serif; color:var(--text); outline:none; }
  .hhm-search-input:focus { border-color:var(--brand); box-shadow:0 0 0 3px rgba(232,94,48,0.1); }
  .hhm-search-btn { background:var(--brand); color:#fff; border:none; border-radius:10px; padding:10px 14px; cursor:pointer; display:flex; align-items:center; }
  .hhm-search-btn .material-symbols-outlined { font-size:20px; }
  .hhm-popular-post { display:flex; gap:12px; align-items:flex-start; margin-bottom:16px; padding-bottom:16px; border-bottom:1px solid var(--border); }
  .hhm-popular-post:last-child { margin-bottom:0; padding-bottom:0; border-bottom:none; }
  .hhm-popular-img { width:64px; height:56px; border-radius:8px; object-fit:cover; flex-shrink:0; }
  .hhm-popular-title { font-size:13px; font-weight:600; color:var(--text); margin:0 0 4px; line-height:1.4; }
  .hhm-popular-title a { color:inherit; text-decoration:none; }
  .hhm-popular-title a:hover { color:var(--brand); }
  .hhm-popular-meta { font-size:11px; color:var(--muted); }
  .hhm-cat-list { list-style:none; padding:0; margin:0; }
  .hhm-cat-list li { display:flex; align-items:center; justify-content:space-between; padding:9px 0; border-bottom:1px solid var(--border); font-size:14px; }
  .hhm-cat-list li:last-child { border-bottom:none; }
  .hhm-cat-list a { color:var(--text); text-decoration:none; display:flex; align-items:center; gap:9px; font-weight:500; }
  .hhm-cat-list a:hover { color:var(--brand); }
  .hhm-cat-dot { width:9px; height:9px; border-radius:50%; background:var(--brand); flex-shrink:0; }
  .hhm-cat-count { background:var(--bg); border-radius:50px; padding:2px 8px; font-size:12px; color:var(--muted); font-weight:600; }
  .hhm-tags-cloud { display:flex; flex-wrap:wrap; gap:8px; }
  .hhm-tag-pill { background:var(--brand-light); color:var(--brand); border:1px solid rgba(232,94,48,0.2); border-radius:50px; padding:5px 14px; font-size:12px; font-weight:600; text-decoration:none; transition:all 0.2s; }
  .hhm-tag-pill:hover { background:var(--brand); color:#fff; }

  /* ── PAGINATION ── */
  .hhm-pagination { display:flex; justify-content:center; gap:8px; margin-top:40px; flex-wrap:wrap; }
  .hhm-pagination .page-numbers { display:flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:10px; border:1px solid var(--border); font-weight:600; font-size:14px; text-decoration:none; color:var(--text); background:#fff; transition:all 0.2s; font-family:'Inter',sans-serif; }
  .hhm-pagination .current { background:var(--brand); color:#fff; border-color:var(--brand); }
  .hhm-pagination .page-numbers:hover:not(.current) { background:var(--brand-light); border-color:var(--brand); color:var(--brand); }
  .hhm-pagination .prev,.hhm-pagination .next { width:auto; padding:0 16px; }
</style>

<div class="hhm-blog">

  <!-- ── HERO ── -->
  <div class="hhm-blog-hero">
    <div class="hhm-blog-hero-bg"></div>
    <div class="hhm-blog-hero-overlay"></div>
    <div class="hhm-blog-hero-content">
      <div class="hhm-blog-hero-badge"><span class="material-symbols-outlined" style="font-size:13px;">edit_note</span>Blog &amp; Stories</div>
      <h1>Travel Stories &amp; Guides</h1>
      <p>Inspiration for your next Himalayan adventure</p>
      <div class="hhm-blog-breadcrumb">
        <a href="<?php echo home_url(); ?>">Home</a>
        <span> › </span>
        <span>Travel Stories</span>
      </div>
    </div>
  </div>

  <!-- ── BODY ── -->
  <div class="hhm-blog-body">

    <!-- MAIN CONTENT -->
    <main>
      <?php if ( have_posts() ) : ?>

        <!-- Featured Post (First) -->
        <?php the_post(); ?>
        <?php
          $feat_img    = get_the_post_thumbnail_url( null, 'large' ) ?: 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1200&q=80';
          $feat_cats   = get_the_category();
          $feat_cat    = $feat_cats ? $feat_cats[0] : null;
          $feat_avatar = get_avatar_url( get_the_author_meta('ID'), ['size'=>40] );
        ?>
        <div class="hhm-section-header">
          <h2 class="hhm-section-title">
            <span class="material-symbols-outlined" style="color:var(--brand);font-size:22px;">library_books</span>
            Latest Articles
          </h2>
          <span class="hhm-count-badge"><?php echo $wp_query->found_posts; ?> articles</span>
        </div>

        <div class="hhm-featured">
          <img class="hhm-featured-img" src="<?php echo esc_url($feat_img); ?>" alt="<?php the_title_attribute(); ?>">
          <div class="hhm-featured-overlay"></div>
          <div class="hhm-featured-body">
            <?php if ($feat_cat) : ?>
              <a href="<?php echo get_category_link($feat_cat->term_id); ?>" class="hhm-featured-cat"><?php echo esc_html($feat_cat->name); ?></a>
            <?php endif; ?>
            <h3 class="hhm-featured-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <div class="hhm-featured-meta">
              <img src="<?php echo esc_url($feat_avatar); ?>" alt="">
              <span><?php the_author(); ?></span>
              <span>·</span>
              <span><?php echo get_the_date(); ?></span>
              <span>·</span>
              <span><?php echo ceil( str_word_count( strip_tags( get_the_content() ) ) / 200 ); ?> min read</span>
            </div>
            <p class="hhm-featured-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 24 ); ?></p>
            <a href="<?php the_permalink(); ?>" class="hhm-featured-btn">
              Read Story <span class="material-symbols-outlined" style="font-size:16px;">arrow_forward</span>
            </a>
          </div>
        </div>

        <!-- Article Cards Grid -->
        <div class="hhm-cards-grid">
          <?php while( have_posts() ) : the_post();
            $thumb = get_the_post_thumbnail_url( null, 'medium_large' ) ?: 'https://images.unsplash.com/photo-1523482580672-f109ba8cb9be?w=800&q=80';
            $cats  = get_the_category();
            $cat   = $cats ? $cats[0] : null;
            $avt   = get_avatar_url( get_the_author_meta('ID'), ['size'=>28] );
          ?>
            <article class="hhm-card">
              <div class="hhm-card-img-wrap">
                <a href="<?php the_permalink(); ?>">
                  <img class="hhm-card-img" src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                </a>
                <?php if ($cat) : ?>
                  <a href="<?php echo get_category_link($cat->term_id); ?>" class="hhm-card-cat"><?php echo esc_html($cat->name); ?></a>
                <?php endif; ?>
              </div>
              <div class="hhm-card-body">
                <h3 class="hhm-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <div class="hhm-card-meta">
                  <img src="<?php echo esc_url($avt); ?>" alt="">
                  <span><?php the_author(); ?></span>
                  <span>·</span>
                  <span><?php echo get_the_date('M j, Y'); ?></span>
                </div>
                <p class="hhm-card-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 18 ); ?></p>
                <a href="<?php the_permalink(); ?>" class="hhm-card-link">Read More <span class="material-symbols-outlined" style="font-size:15px;">arrow_forward</span></a>
              </div>
            </article>
          <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <div class="hhm-pagination">
          <?php echo paginate_links(['type'=>'list','prev_text'=>'← Prev','next_text'=>'Next →']); ?>
        </div>

      <?php else : ?>
        <div style="text-align:center;padding:80px 24px;background:#fff;border-radius:20px;border:1px solid var(--border);">
          <span class="material-symbols-outlined" style="font-size:60px;color:#cbd5e1;">article</span>
          <h2 style="color:var(--text);margin:16px 0 8px;">No Posts Yet</h2>
          <p style="color:var(--muted);">Check back soon for travel stories and guides.</p>
        </div>
      <?php endif; ?>
    </main>

    <!-- SIDEBAR -->
    <aside class="hhm-sidebar">

      <!-- Search -->
      <div class="hhm-sidebar-widget">
        <h3 class="hhm-widget-title"><span class="material-symbols-outlined">search</span>Search</h3>
        <form role="search" method="get" action="<?php echo home_url('/'); ?>" class="hhm-search-form">
          <input type="text" class="hhm-search-input" name="s" placeholder="Search articles…" value="<?php echo get_search_query(); ?>">
          <button type="submit" class="hhm-search-btn"><span class="material-symbols-outlined">search</span></button>
        </form>
      </div>

      <!-- Popular Posts -->
      <div class="hhm-sidebar-widget">
        <h3 class="hhm-widget-title"><span class="material-symbols-outlined">trending_up</span>Popular Stories</h3>
        <?php
        $popular = new WP_Query(['post_type'=>'post','posts_per_page'=>5,'meta_key'=>'post_views_count','orderby'=>'meta_value_num','order'=>'DESC','post_status'=>'publish','ignore_sticky_posts'=>true]);
        if (!$popular->have_posts()) {
          wp_reset_query();
          $popular = new WP_Query(['post_type'=>'post','posts_per_page'=>5,'orderby'=>'comment_count','order'=>'DESC','post_status'=>'publish','ignore_sticky_posts'=>true]);
        }
        while ($popular->have_posts()) : $popular->the_post();
          $pt = get_the_post_thumbnail_url(null,'thumbnail') ?: 'https://images.unsplash.com/photo-1432408806534-c14a64d1bce9?w=120&q=80';
        ?>
          <div class="hhm-popular-post">
            <img class="hhm-popular-img" src="<?php echo esc_url($pt); ?>" alt="">
            <div>
              <p class="hhm-popular-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
              <div class="hhm-popular-meta"><?php echo get_the_date('M j, Y'); ?></div>
            </div>
          </div>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>

      <!-- Categories -->
      <div class="hhm-sidebar-widget">
        <h3 class="hhm-widget-title"><span class="material-symbols-outlined">category</span>Categories</h3>
        <ul class="hhm-cat-list">
          <?php $cats = get_categories(['hide_empty'=>false,'number'=>8]);
          foreach ($cats as $c) : ?>
            <li>
              <a href="<?php echo get_category_link($c->term_id); ?>">
                <span class="hhm-cat-dot" style="background:<?php echo sprintf('#%06x',crc32($c->name)&0xffffff); ?>"></span>
                <?php echo esc_html($c->name); ?>
              </a>
              <span class="hhm-cat-count"><?php echo $c->count; ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <!-- Tags -->
      <div class="hhm-sidebar-widget">
        <h3 class="hhm-widget-title"><span class="material-symbols-outlined">label</span>Tags</h3>
        <div class="hhm-tags-cloud">
          <?php $tags = get_tags(['number'=>20,'orderby'=>'count','order'=>'DESC']);
          foreach ($tags as $tag) : ?>
            <a href="<?php echo get_tag_link($tag->term_id); ?>" class="hhm-tag-pill"><?php echo esc_html($tag->name); ?></a>
          <?php endforeach; ?>
        </div>
      </div>

    </aside>
  </div>
</div>

<?php get_footer(); ?>
