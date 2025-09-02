<?php
/**
 * Report By Block Render Template
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 * @var array $attributes Block attributes
 * @var string $content Block default content
 * @var WP_Block $block Block instance
 */

// Get block attributes with defaults
$show_label = isset( $attributes['showLabel'] ) ? $attributes['showLabel'] : true;
$label_text = isset( $attributes['labelText'] ) ? $attributes['labelText'] : __( 'Report by: ', 'newschannelbd' );
$display_style = isset( $attributes['displayStyle'] ) ? $attributes['displayStyle'] : 'inline';
$show_links = isset( $attributes['showLinks'] ) ? $attributes['showLinks'] : false;
$max_terms = isset( $attributes['maxTerms'] ) ? (int) $attributes['maxTerms'] : 0;
$separator = isset( $attributes['separator'] ) ? $attributes['separator'] : ', ';
$hide_on_empty = isset( $attributes['hideOnEmpty'] ) ? $attributes['hideOnEmpty'] : true;

// Only render on single post pages or if we have a post context
$post_id = isset( $block->context['postId'] ) ? $block->context['postId'] : get_the_ID();
$post_type = isset( $block->context['postType'] ) ? $block->context['postType'] : get_post_type( $post_id );

// Check if we should display this block
if ( $post_type !== 'post' || ! $post_id ) {
	return;
}

// Get report-by terms
$report_by_terms = get_the_terms( $post_id, 'report_by' );

// Handle empty terms
if ( ! $report_by_terms || is_wp_error( $report_by_terms ) ) {
	if ( $hide_on_empty ) {
		return; // Don't render anything
	}
	$report_by_terms = array();
}

// Limit terms if specified
if ( $max_terms > 0 && count( $report_by_terms ) > $max_terms ) {
	$report_by_terms = array_slice( $report_by_terms, 0, $max_terms );
}

// Prepare block wrapper attributes
$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'report-by-block display-' . esc_attr( $display_style ),
	)
);

// Don't render if hiding on empty and no terms
if ( $hide_on_empty && empty( $report_by_terms ) ) {
	return;
}
?>

<div <?php echo $wrapper_attributes; ?>>
	<?php if ( ! empty( $report_by_terms ) ) : ?>
		<?php if ( $show_label ) : ?>
			<span class="report-by-label">
				<?php echo esc_html( $label_text ); ?>
			</span>
		<?php endif; ?>

		<span class="report-by-terms">
			<?php
			$term_links = array();
			foreach ( $report_by_terms as $term ) {
				if ( $show_links ) {
					$term_link = get_term_link( $term );
					if ( ! is_wp_error( $term_link ) ) {
						$term_links[] = sprintf(
							'<a href="%s" class="report-by-link" rel="tag">%s</a>',
							esc_url( $term_link ),
							esc_html( $term->name )
						);
					} else {
						$term_links[] = '<span class="report-by-term">' . esc_html( $term->name ) . '</span>';
					}
				} else {
					$term_links[] = '<span class="report-by-term">' . esc_html( $term->name ) . '</span>';
				}
			}

			echo implode( esc_html( $separator ), $term_links );
			?>
		</span>

		<?php
		// Add structured data for SEO
		if ( $show_links ) {
			foreach ( $report_by_terms as $term ) {
				echo '<meta itemprop="author" content="' . esc_attr( $term->name ) . '">';
			}
		}
		?>

	<?php else : ?>
		<span class="report-by-empty">
			<?php esc_html_e( 'No reporters assigned', 'newschannelbd' ); ?>
		</span>
	<?php endif; ?>
</div>
