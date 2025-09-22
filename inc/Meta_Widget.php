<?php
/**
 * Meta Widget Class
 *
 * Handles post meta fields for News Channel BD theme including news ticker,
 * latest post, and featured post functionality.
 *
 * @package NewsChannelBD
 * @since 1.0.0
 */

namespace NewsChannelBD;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Meta_Widget class for managing post meta fields.
 *
 * This class provides functionality to add meta boxes to posts for marking them
 * as news ticker, latest post, or featured post items.
 *
 * @since 1.0.0
 */
class Meta_Widget {
	use Traits\Singleton;
	use Traits\PluginData;

	/**
	 * Custom meta key for general meta data.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	private $meta_key = '_custom_meta_key';

	/**
	 * Meta key for news ticker posts.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	private $news_ticker_key = '_news_ticker';

	/**
	 * Meta key for latest posts.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	private $latest_post = '_latest_post';

	/**
	 * Meta key for featured posts.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	private $featured_post = '_featured_post';

	/**
	 * Class constructor (private to enforce singleton pattern).
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function __construct() {
		// All the initialization tasks.
		$this->init();
	}

	/**
	 * Initialize the Meta Widget functionality.
	 *
	 * Sets up WordPress action hooks for meta box registration and post saving.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function init() {
		add_action( 'add_meta_boxes', array( $this, 'register_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_meta_value' ) );
	}

	/**
	 * Register meta box for post editing screen.
	 *
	 * Adds a meta box to the post editing screen containing checkboxes for
	 * news ticker, latest post, and featured post options.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function register_meta_box() {
		add_meta_box(
			'post_meta_box',
			'News Meta',
			array( $this, 'render_meta_box' ),
			'post', // Post type.
			'side', // Right sidebar.
			'high'  // High priority for better visibility.
		);
	}

	/**
	 * Render the meta box content.
	 *
	 * Displays checkboxes for news ticker, latest post, and featured post options
	 * in the post editing screen sidebar.
	 *
	 * @since 1.0.0
	 * @param \WP_Post $post The current post object.
	 * @return void
	 */
	public function render_meta_box( $post ) {
		// Nonce field for security.
		wp_nonce_field( 'custom_meta_field_nonce', 'custom_meta_field_nonce' );

		$news_ticker_value = get_post_meta( $post->ID, $this->news_ticker_key, true );
		$latest_post_value = get_post_meta( $post->ID, $this->latest_post, true );
		$featured_post_value = get_post_meta( $post->ID, $this->featured_post, true );

		?>
		<p>
		<label for="news_ticker">
			<input type="checkbox" name="news_ticker" id="news_ticker" <?php checked( $news_ticker_value, 'yes' ); ?>> Add for news ticker
		</label>
		</p>
		<p>
		<label for="latest_post">
			<input type="checkbox" name="latest_post" id="latest_post" <?php checked( $latest_post_value, 'yes' ); ?>> Add for latest news
		</label>
		</p>
		<p>
		<label for="featured_post">
			<input type="checkbox" name="featured_post" id="featured_post" <?php checked( $featured_post_value, 'yes' ); ?>> Add for featured news
		</label>
		</p>
		<?php
	}

	/**
	 * Save meta field values when post is saved.
	 *
	 * Handles saving of news ticker, latest post, and featured post meta values
	 * with proper security checks and validation.
	 *
	 * @since 1.0.0
	 * @param int $post_id The post ID being saved.
	 * @return void
	 */
	public function save_meta_value( $post_id ) {
		// Security checks.
		if ( ! isset( $_POST['custom_meta_field_nonce'] ) ) {
			return;
		}
		$nonce = isset( $_POST['custom_meta_field_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['custom_meta_field_nonce'] ) ) : '';
		if ( ! wp_verify_nonce( $nonce, 'custom_meta_field_nonce' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Save or delete the meta value.
		if ( isset( $_POST['custom_meta_value'] ) ) {
			$meta_value = sanitize_text_field( wp_unslash( $_POST['custom_meta_value'] ) );
			update_post_meta( $post_id, $this->meta_key, $meta_value );
		} else {
			delete_post_meta( $post_id, $this->meta_key );
		}

		 // Save news ticker value.
		 $news_ticker_value = isset( $_POST['news_ticker'] ) ? 'yes' : 'no';
		 update_post_meta( $post_id, $this->news_ticker_key, $news_ticker_value );

		 // Save latest post value.
		 $latest_post_value = isset( $_POST['latest_post'] ) ? 'yes' : 'no';
		 update_post_meta( $post_id, $this->latest_post, $latest_post_value );

		 // Save featured post value.
		 $featured_post_value = isset( $_POST['featured_post'] ) ? 'yes' : 'no';
		 update_post_meta( $post_id, $this->featured_post, $featured_post_value );
	}
}
