<?php
/**
 * Custom helper functions for this theme
 *
 * @package HimalayanMart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'himalayanmart_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function himalayanmart_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		echo '<span class="posted-on">' . $time_string . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'himalayanmart_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function himalayanmart_posted_by() {
		echo '<span class="byline"><span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span></span>';
	}
endif;

if ( ! function_exists( 'himalayanmart_entry_categories' ) ) :
	/**
	 * Prints HTML with category links.
	 */
	function himalayanmart_entry_categories() {
		if ( 'post' === get_post_type() ) {
			$categories_list = get_the_category_list( ', ' );
			if ( $categories_list ) {
				echo '<span class="cat-links">' . $categories_list . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
	}
endif;

if ( ! function_exists( 'himalayanmart_entry_tags' ) ) :
	/**
	 * Prints HTML with tag links.
	 */
	function himalayanmart_entry_tags() {
		if ( 'post' === get_post_type() ) {
			$tags_list = get_the_tag_list( '', ', ' );
			if ( $tags_list ) {
				echo '<span class="tags-links">' . $tags_list . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
	}
endif;

if ( ! function_exists( 'himalayanmart_reading_time' ) ) :
	/**
	 * Calculate and display reading time.
	 */
	function himalayanmart_reading_time() {
		$content = get_post_field( 'post_content', get_the_ID() );
		$word_count = str_word_count( strip_tags( $content ) );
		$reading_time = ceil( $word_count / 200 ); // Average reading speed: 200 words per minute

		if ( $reading_time < 1 ) {
			$reading_time = 1;
		}

		echo '<span class="reading-time">' . sprintf( esc_html__( '%d min read', 'himalayanmart' ), $reading_time ) . '</span>';
	}
endif;

if ( ! function_exists( 'himalayanmart_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 */
	function himalayanmart_post_thumbnail( $size = 'large' ) {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>
			<div class="post-thumbnail">
				<?php the_post_thumbnail( $size ); ?>
			</div>
			<?php
		else :
			?>
			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php the_post_thumbnail( $size, array( 'alt' => the_title_attribute( array( 'echo' => false ) ) ) ); ?>
			</a>
			<?php
		endif;
	}
endif;

if ( ! function_exists( 'himalayanmart_author_box' ) ) :
	/**
	 * Display author box.
	 */
	function himalayanmart_author_box() {
		$author_id = get_the_author_meta( 'ID' );
		$author_name = get_the_author();
		$author_bio = get_the_author_meta( 'description' );
		$author_url = get_author_posts_url( $author_id );
		?>
		<div class="author-box">
			<div class="author-avatar">
				<?php echo get_avatar( $author_id, 100 ); ?>
			</div>
			<div class="author-info">
				<span class="author-label"><?php esc_html_e( 'Written by', 'himalayanmart' ); ?></span>
				<h4 class="author-name">
					<a href="<?php echo esc_url( $author_url ); ?>"><?php echo esc_html( $author_name ); ?></a>
				</h4>
				<?php if ( $author_bio ) : ?>
					<p class="author-bio"><?php echo esc_html( $author_bio ); ?></p>
				<?php endif; ?>
				<a href="<?php echo esc_url( $author_url ); ?>" class="author-posts-link">
					<?php esc_html_e( 'View all posts', 'himalayanmart' ); ?>
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
						<path d="M5 12h14M12 5l7 7-7 7"/>
					</svg>
				</a>
			</div>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'himalayanmart_comments_count' ) ) :
	/**
	 * Display comments count.
	 */
	function himalayanmart_comments_count() {
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				esc_html__( '0 Comments', 'himalayanmart' ),
				esc_html__( '1 Comment', 'himalayanmart' ),
				esc_html__( '% Comments', 'himalayanmart' )
			);
			echo '</span>';
		}
	}
endif;
