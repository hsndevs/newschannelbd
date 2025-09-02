<?php

/**
 * NCB Navigation Block - Development Version
 *
 * Renders a mobile navigation sidebar with search and menu items for News Channel BD theme.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 * @package NewsChannelBD
 */

$wrapper_attributes = get_block_wrapper_attributes(['class' => 'ncbd-toggler-wrapper']);
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="ncbd-navigation">
		<button class="nav-close">&times;</button>
		<?php get_search_form(); ?>
		<?php
		wp_nav_menu(array(
			'theme_location' => 'primary',
			'menu_class'     => 'ncbd-sidebar-menu',
			'walker'         => new Parent_Category_Walker(),
		));
		?>
	</div>
</div>
