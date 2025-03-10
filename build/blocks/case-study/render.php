<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
$case_studies = get_posts(array("post_type" => 'case-studies', 'posts_per_page' => 5));
// print_r(count($case_studies));die;
?>
<div class="works case-study-wrapper" style="background-color:#e7e7e7;margin-top:0;margin-bottom:0">
	<!-- <div class="wp-block-group"> -->
	<div style="max-width:1170px;margin-right:auto;margin-left:auto;">

		<?php if ($case_studies): ?>
			<div class="posts-container">
			<?php
				$row_count = 0; // Counter to track the number of rows displayed
				$total_items = count($case_studies); // Total number of case studies

				for ($index = 0; $index < $total_items; $index++) {
					// Break the loop after 3 rows
					if ($row_count >= 3) {
						break;
					}

					// Determine if the current row is odd or even
					$is_odd_row = $row_count % 2 === 0; // Odd rows have 2 items
					$item_count = $is_odd_row ? 2 : 1;

					// Open the row container
					echo '<div class="wp-block-group' . ($is_odd_row ? ' gap32 grid-column-auto' : '') . '" style="margin-top:0;margin-bottom:0;display:grid;grid-template-columns: repeat(' . $item_count . ', minmax(0,1fr));">';

					// Render the current post
					echo render_post_item($case_studies[$index]);

					// For odd rows, render the second item if it exists
					if ($is_odd_row && isset($case_studies[$index + 1])) {
						echo render_post_item($case_studies[$index + 1]);
						$index++; // Increment index to skip the second post in the odd row
					}

					// Close the row container
					echo '</div>';

					// Add <hr> based on specific conditions:
					// - If there are more than 2 items, add <hr> only between rows 1 and 2
					// - Do not add <hr> after the last row
					if ($total_items > 2 && $row_count < 1) {
						echo '<hr style="margin-bottom:80px;border-color:#C6CBCE">';
					}

					// Increment row count after each row is rendered
					$row_count++;
				}
			?>

			</div>
		<?php endif; ?>
	</div>
</div>
