<?php
/**
 * Featured News Block - Development Version
 *
 * @package NewsChannelBD
 */
namespace NewsChannelBD;

/**
 * Layouts Class
 */
class Layouts {
	use \NewsChannelBD\Traits\Singleton; // Use the Singleton and PluginData trait.

	/**
	 * Class constructor
	 *
	 * (private to enforce singleton pattern).
	 */
	private function __construct() {
		// All the initialization tasks.
		$this->register_hooks();
	}

	public function register_hooks() {
		// Register block styles.
		// add_action( 'inc', array( $this, 'newschannelbd_featured_hooks' ) );
	}

	public function featured_with_image_layout() {
		// Featured News Block render callback.
	}

	public function latest_post_layout( $posts, $paged = null, $posts_per_page = 8 ) {
		// Get current page from query parameter if not provided.
		if ( null === $paged ) {
			$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
		}

		// Calculate pagination.
		$total_posts = count( $posts );
		$total_pages = ceil( $total_posts / $posts_per_page );
		$paged       = max( 1, min( (int) $paged, $total_pages ) ); // Ensure paged is valid.
		$offset      = ( $paged - 1 ) * $posts_per_page;

		// Get posts for current page.
		$page_posts = array_slice( $posts, $offset, $posts_per_page );

		if ( empty( $page_posts ) ) {
			return '<div class="ncbd-no-posts">No posts found</div>';
		}

		$html = '<div class="ncbd-posts-container">';
		$html = '<div class="ncbd-block-posts">';

			// Display posts for current page.
		foreach ( $page_posts as $post ) {
			$post_title_item     = get_the_title( $post );
			$post_permalink_item = get_permalink( $post );
			$post_excerpt_item   = get_the_excerpt( $post );
			$post_time_diff_item = human_time_diff( get_the_time( 'U', $post ), current_time( 'timestamp' ) );
			$post_thumbnail      = has_post_thumbnail( $post ) ? get_the_post_thumbnail( $post, 'medium', array( 'style' => '' ) ) : '<div style="font-size: 1.5em; color: #333;">NCBD</div>';

			$html .= <<<HTML
				<div class="ncbd-post">
					<div class="ncbd-post-thumb">
						<a href="{$post_permalink_item}" title="{$post_title_item}">
							{$post_thumbnail}
						</a>
					</div>
					<div class="ncbd-post-content">
						<h3 class="ncbd-post-title"><a href="{$post_permalink_item}" title="{$post_title_item}">{$post_title_item}</a></h3>
						<p class="ncbd-post-excerpt">{$post_excerpt_item}</p>
						<p class="ncbd-post-time">{$post_time_diff_item} ago</p>
					</div>
				</div>
				HTML;
		}

		$html .= '</div>';

		// Add pagination if there are multiple pages.
		if ( $total_pages > 1 ) {
			$html .= '<div class="ncbd-pagination-wrapper">';
			$html .= wp_kses_post(
				paginate_links(
					array(
						'total'     => $total_pages,
						'current'   => $paged,
						'prev_text' => '&laquo; Previous',
						'next_text' => 'Next &raquo;',
						'mid_size'  => 2,
						'end_size'  => 1,
						'type'      => 'plain',
					)
				)
			);
			$html .= '</div>';
		}

		$html .= '</div>';
		return $html;
	}


	/**
	 * Featured Post Layout.
	 *
	 * @param mixed $posts Posts array.
	 *
	 * @return string HTML output.
	 */
	public function featured_post_layout( $posts ) {
		// Center column (main post with image).
		$main_post               = $posts[0]; // First post for center.
		$post_thumbnail_featured = has_post_thumbnail( $main_post ) ? get_the_post_thumbnail( $main_post, 'full', array( 'style' => '' ) ) : '<span style="font-size: 1.5em; color: #333;">NewsChannelBD</span>';
		$post_title              = get_the_title( $main_post );
		$post_permalink          = get_permalink( $main_post );
		$post_excerpt            = get_the_excerpt( $main_post );
		$post_time_diff          = human_time_diff( get_the_time( 'U', $main_post ), current_time( 'timestamp' ) );

		// Left column (posts without images).
		$html       = '<div class="ncbd-featured-left-column">';
		$left_posts = array_slice( $posts, 1, 3 ); // Get posts 2-4 for left column.
		foreach ( $left_posts as $post ) {
			$post_title_item     = get_the_title( $post );
			$post_permalink_item = get_permalink( $post );
			$post_excerpt_item   = get_the_excerpt( $post );
			// Use 250x150 thumbnail size as requested.
			// Use registered thumbnail size name so thumbnails are generated and cached.
			$post_time_diff_item = human_time_diff( get_the_time( 'U', $post ), current_time( 'timestamp' ) );
			$post_thumbnail      = has_post_thumbnail( $post ) ? get_the_post_thumbnail( $post, 'medium', array( 'style' => '' ) ) : '<div style="font-size: 1.5em; color: #333;">NCBD</div>';

			$html .= <<<HTML
			<div class="ncbd-post-item">
				<div class="ncbd-post-thumb">
					<a href="{$post_permalink_item}" title="{$post_title_item}">
						{$post_thumbnail}
					</a>
				</div>
				<div class="ncbd-post-content">
					<h4 class="ncbd-post-title"><a href="{$post_permalink_item}" title="{$post_title_item}">{$post_title_item}</a></h4>
					<p class="ncbd-post-excerpt">{$post_excerpt_item}</p>
					<p class="ncbd-post-time">{$post_time_diff_item} ago</p>
				</div>
			</div>
			HTML;
		}
		$html .= '</div>';

		// Center column (main post with image).
		$html .= <<<HTML
		<div class="ncbd-featured-center-column">
			<div class="ncbd-post">
				<div class="ncbd-post-thumb">
					<a href="$post_permalink" title="$post_title">
						{$post_thumbnail_featured}
					</a>
				</div>
				<div class="ncbd-post-content">
					<h4 class="ncbd-post-title"><a href="{$post_permalink}" title="{$post_title}">{$post_title}</a></h4>
					<p class="ncbd-post-excerpt">{$post_excerpt}</p>
					<p class="ncbd-post-time">{$post_time_diff} ago</p>
				</div>
			</div>
		</div>
		HTML;

		// Right column (posts without images).
		$html       .= '<div class="ncbd-featured-right-column">';
		$right_posts = array_slice( $posts, 4, 3 ); // Get posts 5-6 for right column.
		foreach ( $right_posts as $post ) {
			$post_title_item     = get_the_title( $post );
			$post_permalink_item = get_permalink( $post );
			$post_excerpt_item   = get_the_excerpt( $post );
			// Use 250x150 thumbnail size as requested.
			// Use registered thumbnail size name so thumbnails are generated and cached.
			$post_time_diff_item = human_time_diff( get_the_time( 'U', $post ), current_time( 'timestamp' ) );
			$post_thumbnail      = has_post_thumbnail( $post ) ? get_the_post_thumbnail( $post, 'medium', array( 'style' => '' ) ) : '<div style="font-size: 1.5em; color: #333;">NCBD</div>';

			$post_thumbnail_item = $post_thumbnail;

			$html .= <<<HTML
			<div class="ncbd-post-item">
				<div class="ncbd-post-thumb">
					<a href="{$post_permalink_item}" title="{$post_title_item}">
						{$post_thumbnail_item}
					</a>
				</div>
				<div class="ncbd-post-content">
					<h4 class="ncbd-post-title"><a href="{$post_permalink_item}" title="{$post_title_item}">{$post_title_item}</a></h4>
					<p class="ncbd-post-excerpt">{$post_excerpt_item}</p>
					<p class="ncbd-post-time">{$post_time_diff_item} ago</p>
				</div>
			</div>
			HTML;
		}
		$html .= '</div>';
		return $html;
	}
}
