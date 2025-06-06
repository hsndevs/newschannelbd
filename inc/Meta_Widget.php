<?php

/**
 * Plugin File: AM API
 * Description: This plugin will show related random posts under each post.
 *
 * @package wordpress-plugin
 * @since 1.0
 */

namespace NewsChannelBD;

if (!defined('ABSPATH')) {
    exit;
}

class Meta_Widget {
	use Traits\Singleton, Traits\PluginData; // Use the Singleton and PluginData trait.

    // Meta key
    private $meta_key = '_custom_meta_key';
    private $news_ticker_key = '_news_ticker';
    private $latest_post = '_latest_post';

    /**
	 * Class constructor (private to enforce singleton pattern).
	 *
	 * @return void
	 */
	private function __construct()
	{
		// All the initialization tasks.
		$this->init();
	}

	public function init()
	{
        add_action( 'add_meta_boxes', [ $this, 'register_meta_box' ] );
        add_action( 'save_post', [ $this, 'save_meta_value' ] );
	}

    public function register_meta_box() {
        add_meta_box(
            'post_meta_box',
            'News Meta',
            [ $this, 'render_meta_box' ],
            'post', // Change this to any post type (e.g., 'page', 'custom_post_type')
            'side', // Right Sidebar
            'high'  // High priority for better visibility
        );
    }



    // Render the meta box
    public function render_meta_box( $post ) {
        // Nonce field for security
        wp_nonce_field( 'custom_meta_field_nonce', 'custom_meta_field_nonce' );

        $news_ticker_value = get_post_meta($post->ID, $this->news_ticker_key, true);
        $latest_post_value = get_post_meta($post->ID, $this->latest_post, true);

        ?>
        <p>
        <label for="news_ticker">
            <input type="checkbox" name="news_ticker" id="news_ticker" <?php checked($news_ticker_value, 'yes'); ?>> Add for news ticker
        </label>
        </p>
        <p>
        <label for="latest_post">
            <input type="checkbox" name="latest_post" id="latest_post" <?php checked($latest_post_value, 'yes'); ?>> Add for latest news
        </label>
        </p>
        <?php
    }

    // Save the meta value
    public function save_meta_value( $post_id ) {
        // Security checks
        if ( ! isset( $_POST['custom_meta_field_nonce'] ) ) {
            return;
        }
        if ( ! wp_verify_nonce( $_POST['custom_meta_field_nonce'], 'custom_meta_field_nonce' ) ) {
            return;
        }
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        // Save or delete the meta value
        if ( isset( $_POST['custom_meta_value'] ) ) {
            $meta_value = sanitize_text_field( $_POST['custom_meta_value'] );
            update_post_meta( $post_id, $this->meta_key, $meta_value );
        } else {
            delete_post_meta( $post_id, $this->meta_key );
        }

         // Save news ticker value
         $news_ticker_value = isset($_POST['news_ticker']) ? 'yes' : 'no';
         update_post_meta($post_id, $this->news_ticker_key, $news_ticker_value);
         
         // Save news ticker value
         $latest_post_value = isset($_POST['latest_post']) ? 'yes' : 'no';
         update_post_meta($post_id, $this->latest_post, $latest_post_value);
    }
}
