<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package HimalayanMart
 */

get_header();
?>

<style>
    .hm-404-wrap {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #fef7f4 0%, #fff5f0 40%, #f0f4ff 100%);
        padding: 2rem 1rem;
    }

    /* Decorative floating shapes */
    .hm-404-wrap::before,
    .hm-404-wrap::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }
    .hm-404-wrap::before {
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(232, 94, 48, 0.08) 0%, transparent 70%);
        top: -120px;
        right: -80px;
    }
    .hm-404-wrap::after {
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.06) 0%, transparent 70%);
        bottom: -60px;
        left: -60px;
    }

    .hm-404-card {
        position: relative;
        z-index: 1;
        max-width: 560px;
        width: 100%;
        text-align: center;
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(232, 94, 48, 0.1);
        border-radius: 1.5rem;
        padding: 3.5rem 2.5rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.04), 0 0 0 1px rgba(255, 255, 255, 0.8) inset;
    }

    .hm-404-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        border-radius: 1.25rem;
        background: linear-gradient(135deg, #e85e30, #f0845c);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        box-shadow: 0 12px 32px rgba(232, 94, 48, 0.25);
        animation: hm-404-float 3s ease-in-out infinite;
    }
    .hm-404-icon .material-symbols-outlined {
        font-size: 40px;
    }

    @keyframes hm-404-float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    .hm-404-number {
        font-family: 'Inter', sans-serif;
        font-size: clamp(4.5rem, 12vw, 7rem);
        font-weight: 900;
        letter-spacing: -4px;
        background: linear-gradient(135deg, #e85e30 0%, #d44a1e 50%, #f0845c 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
        margin-bottom: 0.75rem;
    }

    .hm-404-title {
        font-family: 'Inter', sans-serif;
        font-size: 1.5rem;
        font-weight: 800;
        color: #1e293b;
        margin: 0 0 0.75rem;
        letter-spacing: -0.5px;
    }

    .hm-404-desc {
        font-family: 'Inter', sans-serif;
        font-size: 1rem;
        color: #64748b;
        line-height: 1.7;
        margin: 0 0 2rem;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    .hm-404-actions {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        align-items: center;
    }

    .hm-404-btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #e85e30, #d44a1e);
        color: #fff;
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 0.95rem;
        padding: 0.875rem 2rem;
        border-radius: 9999px;
        text-decoration: none;
        box-shadow: 0 8px 24px rgba(232, 94, 48, 0.3);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .hm-404-btn-primary:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 12px 32px rgba(232, 94, 48, 0.4);
        color: #fff;
        text-decoration: none;
    }
    .hm-404-btn-primary:active {
        transform: scale(0.98);
    }
    .hm-404-btn-primary .material-symbols-outlined {
        font-size: 20px;
    }

    .hm-404-btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: transparent;
        color: #64748b;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.875rem;
        padding: 0.625rem 1.5rem;
        border-radius: 9999px;
        text-decoration: none;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }
    .hm-404-btn-secondary:hover {
        background: #f8fafc;
        color: #e85e30;
        border-color: rgba(232, 94, 48, 0.3);
        text-decoration: none;
    }
    .hm-404-btn-secondary .material-symbols-outlined {
        font-size: 18px;
    }

    /* Search */
    .hm-404-search {
        margin-top: 1.5rem;
        position: relative;
        max-width: 380px;
        margin-left: auto;
        margin-right: auto;
    }
    .hm-404-search input {
        width: 100%;
        box-sizing: border-box;
        padding: 0.875rem 1rem 0.875rem 3rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        font-family: 'Inter', sans-serif;
        font-size: 0.9rem;
        background: rgba(255, 255, 255, 0.8);
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        color: #334155;
    }
    .hm-404-search input:focus {
        border-color: #e85e30;
        box-shadow: 0 0 0 3px rgba(232, 94, 48, 0.1);
    }
    .hm-404-search input::placeholder {
        color: #94a3b8;
    }
    .hm-404-search .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 20px;
        pointer-events: none;
    }

    /* Helpful links */
    .hm-404-links {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(0, 0, 0, 0.06);
    }
    .hm-404-links-label {
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #94a3b8;
        margin-bottom: 0.75rem;
    }
    .hm-404-links-list {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.5rem;
    }
    .hm-404-links-list a {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.875rem;
        border-radius: 9999px;
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        font-weight: 600;
        color: #475569;
        background: rgba(255, 255, 255, 0.7);
        border: 1px solid #e2e8f0;
        text-decoration: none;
        transition: all 0.2s;
    }
    .hm-404-links-list a:hover {
        color: #e85e30;
        border-color: rgba(232, 94, 48, 0.3);
        background: #fff;
    }
    .hm-404-links-list a .material-symbols-outlined {
        font-size: 16px;
    }

    @media (min-width: 640px) {
        .hm-404-actions {
            flex-direction: row;
            justify-content: center;
        }
    }
</style>

<div class="hm-404-wrap">
    <div class="hm-404-card">

        <!-- Floating icon -->
        <div class="hm-404-icon">
            <span class="material-symbols-outlined">explore_off</span>
        </div>

        <!-- 404 Number -->
        <div class="hm-404-number">404</div>

        <!-- Title & Description -->
        <h1 class="hm-404-title"><?php esc_html_e( 'Page not found', 'himalayanmart' ); ?></h1>
        <p class="hm-404-desc">
            <?php esc_html_e( "The page you're looking for doesn't exist or has been moved. Let's get you back on track.", 'himalayanmart' ); ?>
        </p>

        <!-- Actions -->
        <div class="hm-404-actions">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hm-404-btn-primary">
                <span class="material-symbols-outlined">home</span>
                <?php esc_html_e( 'Back to Home', 'himalayanmart' ); ?>
            </a>
            <a href="javascript:history.back()" class="hm-404-btn-secondary">
                <span class="material-symbols-outlined">arrow_back</span>
                <?php esc_html_e( 'Go Back', 'himalayanmart' ); ?>
            </a>
        </div>

        <!-- Search -->
        <div class="hm-404-search">
            <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <span class="material-symbols-outlined search-icon">search</span>
                <input type="search" name="s" placeholder="<?php esc_attr_e( 'Search for what you need...', 'himalayanmart' ); ?>" value="" />
            </form>
        </div>

        <!-- Helpful Links -->
        <div class="hm-404-links">
            <div class="hm-404-links-label"><?php esc_html_e( 'Popular pages', 'himalayanmart' ); ?></div>
            <div class="hm-404-links-list">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <span class="material-symbols-outlined">cottage</span>
                    <?php esc_html_e( 'Homestays', 'himalayanmart' ); ?>
                </a>
                <a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>">
                    <span class="material-symbols-outlined">storefront</span>
                    <?php esc_html_e( 'Shop', 'himalayanmart' ); ?>
                </a>
                <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">
                    <span class="material-symbols-outlined">article</span>
                    <?php esc_html_e( 'Blog', 'himalayanmart' ); ?>
                </a>
                <a href="<?php echo esc_url( home_url( '/my-account/' ) ); ?>">
                    <span class="material-symbols-outlined">person</span>
                    <?php esc_html_e( 'My Account', 'himalayanmart' ); ?>
                </a>
            </div>
        </div>

    </div>
</div>

<?php
get_footer();
