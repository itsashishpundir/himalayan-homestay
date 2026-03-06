<?php
/**
 * Archive Template (Author, Date, Custom Post Type fallback)
 *
 * Redesigned via Google Stitch — consistent with blog archive aesthetic.
 * WordPress Template Hierarchy: archive.php (used for author, date, CPT archives
 * that don't have a specific template. home.php overrides for posts index).
 *
 * @package HimalayanMart
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();

$archive_title = get_the_archive_title();
$archive_desc  = get_the_archive_description();
?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@400,0&display=swap" rel="stylesheet">

<style>
  :root { --brand:#e85e30; --brand-light:#fef1ec; --bg:#f8f6f6; --border:#e2e8f0; --text:#1a1a2e; --muted:#64748b; }
  .hhm-arch *:not(.material-symbols-outlined) { box-sizing:border-box; font-family:'Inter',sans-serif; }
  .hhm-arch * { box-sizing:border-box; }
  .hhm-arch { background:var(--bg); }
  .hhm-arch-hero { background:linear-gradient(135deg,#141414 0%,#1a1a2e 100%); padding:52px 24px; text-align:center; }
  .hhm-arch-hero h1 { font-size:clamp(24px,4vw,48px); font-weight:900; color:#fff; margin:0 0 10px; }
  .hhm-arch-hero p { color:rgba(255,255,255,0.7); font-size:16px; margin:0 0 16px; }
  .hhm-arch-breadcrumb { color:rgba(255,255,255,0.5); font-size:13px; }
  .hhm-arch-breadcrumb a { color:rgba(255,255,255,0.7); text-decoration:none; }
  .hhm-arch-body { max-width:1280px; margin:0 auto; padding:48px 24px 80px; display:grid; grid-template-columns:1fr 320px; gap:48px; align-items:start; }
  @media(max-width:960px) { .hhm-arch-body { grid-template-columns:1fr; } }
  .hhm-cards-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:24px; }
  @media(max-width:780px) { .hhm-cards-grid { grid-template-columns:repeat(2,1fr); } }
  @media(max-width:480px) { .hhm-cards-grid { grid-template-columns:1fr; } }
  .hhm-card { background:#fff; border-radius:16px; border:1px solid var(--border); overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,0.04); transition:all 0.3s; }
  .hhm-card:hover { transform:translateY(-5px); box-shadow:0 12px 36px rgba(0,0,0,0.1); }
  .hhm-card-img-wrap { position:relative; height:190px; overflow:hidden; }
  .hhm-card-img { width:100%; height:100%; object-fit:cover; transition:transform 0.5s; }
  .hhm-card:hover .hhm-card-img { transform:scale(1.06); }
  .hhm-card-cat { position:absolute; top:10px; left:10px; background:var(--brand); color:#fff; border-radius:6px; padding:3px 10px; font-size:11px; font-weight:700; text-transform:uppercase; }
  .hhm-card-body { padding:20px; }
  .hhm-card-title { font-size:16px; font-weight:700; color:var(--text); margin:0 0 8px; line-height:1.35; }
  .hhm-card-title a { color:inherit; text-decoration:none; }
  .hhm-card-title a:hover { color:var(--brand); }
  .hhm-card-meta { color:var(--muted); font-size:12px; margin-bottom:10px; }
  .hhm-card-excerpt { color:#374151; font-size:13px; line-height:1.65; margin-bottom:12px; display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden; }
  .hhm-card-link { color:var(--brand); font-weight:700; font-size:13px; text-decoration:none; }
  .hhm-card-link:hover { text-decoration:underline; }
  .hhm-sidebar-widget { background:#fff; border:1px solid var(--border); border-radius:16px; padding:24px; box-shadow:0 2px 10px rgba(0,0,0,0.04); margin-bottom:24px; }
  .hhm-widget-title { font-size:15px; font-weight:800; color:var(--text); margin:0 0 16px; padding-bottom:12px; border-bottom:2px solid var(--brand-light); display:flex; align-items:center; gap:8px; }
  .hhm-widget-title .material-symbols-outlined { color:var(--brand); font-size:18px; }
  .hhm-cat-list { list-style:none; padding:0; margin:0; }
  .hhm-cat-list li { display:flex; align-items:center; justify-content:space-between; padding:9px 0; border-bottom:1px solid var(--border); font-size:14px; }
  .hhm-cat-list li:last-child { border-bottom:none; }
  .hhm-cat-list a { color:var(--text); text-decoration:none; display:flex; align-items:center; gap:8px; font-weight:500; }
  .hhm-cat-list a:hover { color:var(--brand); }
  .hhm-cat-dot { width:8px; height:8px; border-radius:50%; background:var(--brand); }
  .hhm-cat-count { background:var(--bg); border-radius:50px; padding:2px 8px; font-size:11px; color:var(--muted); font-weight:600; }
  .hhm-tags-cloud { display:flex; flex-wrap:wrap; gap:7px; }
  .hhm-tag-pill { background:var(--brand-light); color:var(--brand); border:1px solid rgba(232,94,48,0.2); border-radius:50px; padding:4px 12px; font-size:12px; font-weight:600; text-decoration:none; transition:all 0.2s; }
  .hhm-tag-pill:hover { background:var(--brand); color:#fff; }
  .hhm-pagination { display:flex; justify-content:center; gap:8px; margin-top:40px; flex-wrap:wrap; }
  .hhm-pagination .page-numbers { display:flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:10px; border:1px solid var(--border); font-weight:600; font-size:14px; text-decoration:none; color:var(--text); background:#fff; transition:all 0.2s; }
  .hhm-pagination .current { background:var(--brand); color:#fff; border-color:var(--brand); }
  .hhm-pagination .page-numbers:hover:not(.current) { background:var(--brand-light); border-color:var(--brand); color:var(--brand); }
  .hhm-pagination .prev,.hhm-pagination .next { width:auto; padding:0 16px; }
</style>

<div class="hhm-arch">
  <div class="hhm-arch-hero">
    <h1><?php echo wp_kses_post($archive_title); ?></h1>
    <?php if ($archive_desc) : ?>
      <p><?php echo wp_kses_post($archive_desc); ?></p>
    <?php endif; ?>
    <div class="hhm-arch-breadcrumb">
      <a href="<?php echo home_url(); ?>">Home</a> ›
      <span><?php echo wp_strip_all_tags($archive_title); ?></span>
    </div>
  </div>

  <div class="hhm-arch-body">
    <main>
      <?php if (have_posts()) : ?>
        <div class="hhm-cards-grid">
          <?php while (have_posts()) : the_post();
            $thumb = get_the_post_thumbnail_url(null,'medium_large') ?: 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800&q=80';
            $cats  = get_the_category();
            $cat   = $cats ? $cats[0] : null;
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
                <h2 class="hhm-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <div class="hhm-card-meta"><?php the_author(); ?> · <?php echo get_the_date('M j, Y'); ?></div>
                <p class="hhm-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18); ?></p>
                <a href="<?php the_permalink(); ?>" class="hhm-card-link">Read More →</a>
              </div>
            </article>
          <?php endwhile; ?>
        </div>
        <div class="hhm-pagination">
          <?php echo paginate_links(['type'=>'list','prev_text'=>'← Prev','next_text'=>'Next →']); ?>
        </div>
      <?php else : ?>
        <div style="text-align:center;padding:60px;background:#fff;border-radius:16px;border:1px solid var(--border);">
          <span class="material-symbols-outlined" style="font-size:56px;color:#cbd5e1;">article</span>
          <h2>Nothing Found</h2>
          <p style="color:var(--muted);">No posts match this archive.</p>
        </div>
      <?php endif; ?>
    </main>

    <aside>
      <div class="hhm-sidebar-widget">
        <h3 class="hhm-widget-title"><span class="material-symbols-outlined">category</span>Categories</h3>
        <ul class="hhm-cat-list">
          <?php foreach (get_categories(['hide_empty'=>false,'number'=>8]) as $c) : ?>
            <li>
              <a href="<?php echo get_category_link($c->term_id); ?>">
                <span class="hhm-cat-dot"></span><?php echo esc_html($c->name); ?>
              </a>
              <span class="hhm-cat-count"><?php echo $c->count; ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="hhm-sidebar-widget">
        <h3 class="hhm-widget-title"><span class="material-symbols-outlined">label</span>Tags</h3>
        <div class="hhm-tags-cloud">
          <?php foreach (get_tags(['number'=>16,'orderby'=>'count','order'=>'DESC']) as $t) : ?>
            <a href="<?php echo get_tag_link($t->term_id); ?>" class="hhm-tag-pill"><?php echo esc_html($t->name); ?></a>
          <?php endforeach; ?>
        </div>
      </div>
    </aside>
  </div>
</div>

<?php get_footer(); ?>
