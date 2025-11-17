<?php
/**
 * Featured News Block - Development Version
 *
 * Displays posts marked as featured using custom meta fields for News Channel BD theme.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 * @package NewsChannelBD
 */
?>
<div <?php echo get_block_wrapper_attributes(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php get_meta_filtered_posts( '_featured_post', 'yes' ); ?>
	<?php get_meta_filtered_posts( '_featured_post', 'yes', 'featured' ); ?>
</div>
