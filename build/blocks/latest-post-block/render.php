<?php
/**
 * Latest Post Block - Development Version
 *
 * Displays posts marked as latest using custom meta fields for News Channel BD theme.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 * @package NewsChannelBD
 */

use NewsChannelBD\Blocks\LatestNews\Latest_Post_Block;

?>
<div <?php echo get_block_wrapper_attributes(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php
	echo wp_kses_post( Latest_Post_Block::render() );
	// get_meta_filtered_posts( '_latest_post', 'yes', 'latest' );

	?>
</div>
