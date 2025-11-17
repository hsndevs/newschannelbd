<?php
/**
 * Marquee News Block - Development Version
 *
 * Displays latest news posts in a scrolling marquee for News Channel BD theme.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 * @package NewsChannelBD
 */

// Get latest news posts
$ncbd_news = get_posts(
	array(
		'post_type'      => 'post',
		'posts_per_page' => 3,
		'meta_query'     => array(
			array(
				'key'     => '_news_ticker',
				'value'   => 'yes',
				'compare' => '=',
			),
		),
	)
);

// If no posts match the ticker meta, return early to avoid rendering empty markup.
if ( empty( $ncbd_news ) ) {
	return '';
}
?>

<div <?php echo get_block_wrapper_attributes(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="marquee-wrapper">
		<div class="marquee-track">
			<?php foreach ( $ncbd_news as $case_study ) : ?>
				<div class="marquee-item">
					<a href="<?php echo esc_url( get_permalink( $case_study->ID ) ); ?>">
						<span><?php echo esc_html( $case_study->post_title ); ?></span>
					</a>
				</div>
				<div class="separator">✮</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
