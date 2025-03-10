<?php

/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
	<?php
	// get current category
	$current_category = get_queried_object();

	// Get child categories and 5 posts from each child category
	$child_categories = get_categories(array(
		'parent' => $current_category->term_id,
		'hide_empty' => 0,
		'number' => 5,
		'orderby' => 'date',
	));

	$current_category_posts = get_posts(array(
		'category' => $current_category->term_id,
		'numberposts' => 6,
		'orderby' => 'date',
	));

	loop_category_posts($current_category, $current_category_posts);
	// if $chld_categories is empty, loop $child_category_posts view here.

	if (!empty($child_categories)) {
		// Loop through each child category
		foreach ($child_categories as $child_category) {
			// Get posts from each child category
			$child_category_posts = get_posts(array(
				'category' => $child_category->term_id,
				'numberposts' => 6,
				'orderby' => 'date',
			));

			loop_category_posts($child_category, $child_category_posts);
		}
	}

	?>
</div>
