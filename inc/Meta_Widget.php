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
            'custom_meta_box',
            'Custom Meta Field',
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

        $meta_value = get_post_meta( $post->ID, $this->meta_key, true );
        ?>
        <label for="custom_meta_value">Meta Value:</label>
        <input type="text" name="custom_meta_value" id="custom_meta_value" value="<?php echo esc_attr( $meta_value ); ?>" style="width: 100%;" />
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
    }
}
