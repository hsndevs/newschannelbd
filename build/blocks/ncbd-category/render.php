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
		// Use the main query for pagination to work correctly with custom rewrite rules.
		global $wp_query;
		$current_page = max( 1, get_query_var( 'paged' ) );
		$category_posts = $wp_query->posts;

		loop_archive_posts( $current_category, $category_posts, $view_more_text, $heading_border_position, $heading_border_width );

		// Add pagination if there are multiple pages.
		if ( $wp_query->max_num_pages > 1 ) {
			echo '<div class="ncbd-pagination-wrapper">';
			echo wp_kses_post(
				paginate_links(
					array(
						'total' => $wp_query->max_num_pages,
						'current' => $current_page,
						'prev_text' => '&laquo; Previous',
						'next_text' => 'Next &raquo;',
						'mid_size' => 2,
						'end_size' => 1,
						'type' => 'plain',
					)
				)
			);
			echo '</div>';
		}
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
