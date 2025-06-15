<?php

/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
	<?php
	// Render the report-by taxonomy if single post page.
	if (is_singular() && has_block('report-by/report-by')) {
		$report_by = get_the_terms(get_the_ID(), 'report_by');
		if ($report_by && ! is_wp_error($report_by)) {
			foreach ($report_by as $term) {
				echo '<span class="report-by-term">' . esc_html($term->name) . '</span>';
			}
		} else {
			echo '<span class="report-by-term">' . esc_html__('No report by available', 'text-domain') . '</span>';
		}
	}
	?>
</div>
