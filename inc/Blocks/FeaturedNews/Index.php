<?php
/**
 * Featured News Block - Development Version
 */

namespace NewsChannelBD\Blocks\FeaturedNews;

class Index {

	use \NewsChannelBD\Traits\Singleton; // Use the Singleton and PluginData trait.

	/**
	 * Class constructor
	 * (private to enforce singleton pattern).
	 */
	private function __construct() {
		// All the initialization tasks.
		$this->register_hooks();
	}


	public function register_hooks() {
		// Register block styles.
		add_action( 'inc', array( $this, 'newschannelbd_featured_hooks' ) );
	}

	public function newschannelbd_featured_hooks() {
		// Featured News Block render callback. Render latest post layout from the
		// FeaturedNews Layouts class. We fetch a small set of recent posts and
		// delegate HTML generation to the Layouts::latest_post_layout method.
		$posts = get_posts(
			array(
				'post_type'      => 'post',
				'posts_per_page' => 6,
			)
		);
		echo wp_kses_post( Layouts::get_instance()->latest_post_layout( $posts ) );
	}
}
