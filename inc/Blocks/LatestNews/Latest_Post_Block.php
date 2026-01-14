<?php
/**
 * Latest News Block Handler
 *
 * @package NewsChannelBD
 */

namespace NewsChannelBD\Blocks\LatestNews;

use NewsChannelBD\Layouts;
/**
 * Latest Post Block Class
 */
class Latest_Post_Block {

	use \NewsChannelBD\Traits\Singleton;

	private function __construct() {
		$this->register_hooks();
	}

	public function register_hooks() {
		// Register any hooks if needed
	}

	/**
	 * Get posts marked as latest
	 */
	public static function get_latest_posts( $meta_key = '_latest_post', $meta_value = 'yes', $per_page = 5 ) {
		$args         = array(
			'post_type'      => 'post',
			'posts_per_page' => -1,
		);
		$latest_posts = new \WP_Query( $args );
		return $latest_posts->posts;
	}

	/**
	 * Render latest posts
	 */
	public static function render() {
		$posts = self::get_latest_posts();

		// Display child category name
		// $html = '<h2 class="ncbd-block-title">' . $category_name->name . '</h2>'; // Heading for dynamic category.

		// Loop through each post but create a 3-column layout with center post.
		ob_start();
		if ( count( $posts ) < 1 ) {
			$html  = '<div class="ncbd-block-posts"><div style="flex: 1; text-align: center;">No post found!</div></div>';
		} else {
			$html = Layouts::get_instance()->latest_post_layout( $posts );
		}
		$html .= ob_get_clean();
		wp_reset_postdata();
		echo wp_kses_post( $html );
	}
}
