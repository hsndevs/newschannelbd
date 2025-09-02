<?php

/**
 * NCBD Category Block - Development Version
 *
 * Renders category posts with child categories for News Channel BD theme.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

// Get the view more text from block attributes.
$view_more_text = $attributes['viewMoreText'] ?? 'View All';
$heading_border_position = $attributes['headingBorderPosition'] ?? 'left';
$heading_border_width = $attributes['headingBorderWidth'] ?? 5;
?>
<div <?php echo get_block_wrapper_attributes(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php
	// Get current category.
	$current_category = get_queried_object();

	// Get child categories and 5 posts from each child category.
	$child_categories = get_categories(
		array(
			'parent' => $current_category->term_id ?? 0,
			'hide_empty' => 0,
			'number' => 5,
			'orderby' => 'date',
		)
	);

	// Merge current category and child categories together.
	$all_categories = array();

	// Add current category first if it exists.
	if ( $current_category && isset( $current_category->term_id ) ) {
		$all_categories[] = $current_category;
	}

	// Add child categories.
	if ( ! empty( $child_categories ) ) {
		$all_categories = array_merge( $all_categories, $child_categories );
	}


	// if $chld_categories is empty, loop $child_category_posts view here.
	if ( is_archive() ) {
		// Loop through all categories (current + children).
		$category_posts = get_posts(
			array(
				'category' => $current_category->term_id ?? 0,
				'numberposts' => -1,
				'orderby' => 'date',
			)
		);

		loop_archive_posts( $current_category, $category_posts, $view_more_text, $heading_border_position, $heading_border_width );
	} else {
		foreach ( $all_categories as $category ) {
			$category_posts = get_posts(
				array(
					'category' => $category->term_id ?? 0,
					'numberposts' => 6,
					'orderby' => 'date',
				)
			);

			loop_category_posts(
				$category,
				$category_posts,
				$view_more_text,
				$heading_border_position,
				$heading_border_width
			);
		}
	}
	?>
</div>
