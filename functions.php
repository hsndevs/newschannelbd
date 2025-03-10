<?php

/**
 * Functions and definitions of the theme.
 *
 * @package wordpress-theme
 * @since 1.0
 */

if (!defined('ABSPATH')) {
	exit;
}

// Load Composer autoloader.
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
	require_once __DIR__ . '/vendor/autoload.php';
}

NewsChannelBD\Theme_Main::get_instance();


// This function will add fallback post thumbnail here for each post
function newschannelbd_post_thumbnail() {
	// Get the post thumbnail
	$post_thumbnail = get_the_post_thumbnail(null, 'medium');

	// Check if the post has a thumbnail
	if ($post_thumbnail == '' || !has_post_thumbnail()) {
		// Fallback image if no thumbnail
		$placeholder_image = 'https://placehold.co/600x400/ddd/999/svg?text=No+Image+Found';
		$post_thumbnail = '<img src="' . $placeholder_image . '" alt="no post image" />';
	}

	// Display the post thumbnail
	echo $post_thumbnail;
}
// action hook to add the function
add_action('newschannelbd_post_thumbnail', 'newschannelbd_post_thumbnail');


function my_custom_category_rewrite_rules($rules) {
	$new_rules = array();
	$categories = get_categories(array('hide_empty' => false));

	foreach ($categories as $category) {
		$new_rules['(' . $category->slug . ')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
		$new_rules['(' . $category->slug . ')/page/?([0-9]{1,})/?$'] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
		$new_rules['(' . $category->slug . ')/?$'] = 'index.php?category_name=$matches[1]';
	}

	return $new_rules + $rules;
}
add_filter('rewrite_rules_array', 'my_custom_category_rewrite_rules');

function loop_category_posts($child_category, $child_category_posts) {
	// Display child category name
	$html = '<h2 class="ncbd-block-title" style="text-decoration:underline;">' . $child_category->name . '</h2>';

	// Loop through each post but create a grid of 3 columns using flexbox
	$html .= '<div class="ncbd-block-posts">';
	foreach ($child_category_posts as $post) {

		$post_thumbnail = has_post_thumbnail($post) ? get_the_post_thumbnail($post, 'full', array('style' => '')) : '<span style="font-size: 1.5em; color: #333;">NewsChannelBD</span>';
		$post_title = get_the_title($post);
		$post_permalink = get_permalink($post);
		$post_excerpt = get_the_excerpt($post);
		$post_time_diff = human_time_diff(get_the_time('U', $post), current_time('timestamp'));
		$shareThis = sharethis_inline_buttons();

		$html .= <<<HTML
		<div class="ncbd-post">
			<div class="ncbd-post-thumb">
				<a href="$post_permalink" title="$post_title">
					{$post_thumbnail}
				</a>
			</div>
			<div class="ncbd-post-content">
				<h3 class="ncbd-post-title"><a href="{$post_permalink}" title="{$post_title}">{$post_title}</a></h3>
				<div style="flex: 1 1 100%;display:flex;justify-content: flex-end;flex-direction: column;">
					<p style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;margin:0;">{$post_excerpt}</p>
					<p style="margin:0;font-style:italic;color:#555;">{$post_time_diff} ago</p>
				</div>
			</div>
			{$shareThis}
		</div>
	HTML;
	}
	$html .= '</div>';

	echo $html;
}


function custom_excerpt_length($length) {
	return 20; // Set the number of words you want in the excerpt
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);


function custom_excerpt_more($more) {
	return '...'; // Custom "Read More" text
}
add_filter('excerpt_more', 'custom_excerpt_more');


/**
 * Custom walker class to display parent categories with child categories in a submenu.
 */
class Parent_Category_Walker extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		// Skip child categories (categories with a parent)
		if ($item->object == 'category' && $item->menu_item_parent != 0) {
			return;
		}

		// Check if the item is a category and has child categories
		if ($item->object == 'category') {
			$subcategories = get_categories([
				'taxonomy'   => 'category',
				'parent'     => $item->object_id,
				'hide_empty' => false,
			]);

			if (!empty($subcategories)) {

				$output .= '<li class="menu-item menu-item-type-taxonomy menu-item-object-category has-submenu">';
				$active_class = '';
				foreach ($subcategories as $subcategory) {
					if (is_category($subcategory->term_id)) {
						$active_class = ' current-item';
						break;
					}
				}
				$output .= '<button class="toggler' . $active_class . '">' . $item->title . ' <span class="material-symbols-outlined">keyboard_arrow_down</span></button>';
				$output .= '<ul class="sub-menu">';

				$output .= '<li class="menu-item menu-item-type-taxonomy menu-item-object-category">';
				$output .= '<a href="' . get_category_link($item->object_id) . '">' . $item->title . '</a>';
				$output .= '</li>';

				foreach ($subcategories as $subcategory) {
					$output .= '<li class="menu-item menu-item-type-taxonomy menu-item-object-category">';
					$output .= '<a href="' . get_category_link($subcategory->term_id) . '">' . $subcategory->name . '</a>';
					$output .= '</li>';
				}
				$output .= '</ul>';
				$output .= '</li>';
			} else {
				// Proceed with the default behavior for other items
				parent::start_el($output, $item, $depth, $args, $id);
			}
		} else {
			// Proceed with the default behavior for other items
			parent::start_el($output, $item, $depth, $args, $id);
		}
	}

	function end_el(&$output, $item, $depth = 0, $args = array()) {
		// Skip child categories (categories with a parent)
		if ($item->object == 'category' && $item->menu_item_parent != 0) {
			return;
		}

		// Proceed with the default behavior for other items
		parent::end_el($output, $item, $depth, $args);
	}

	function start_lvl(&$output, $depth = 0, $args = array()) {
		// Start a new submenu if the item is not a child category
		if ($depth >= 0) {
			$output .= '<ul class="sub-menu">';
		}
	}

	function end_lvl(&$output, $depth = 0, $args = array()) {
		// End the submenu if the item is not a child category
		if ($depth >= 0) {
			$output .= '</ul>';
		}
	}
}


function pr($data, $die = false) {
	echo '<pre>';
	print_r($data);
	echo '</pre>';
	if ($die) {
		die();
	}
}

function wpdocs_register_multiple_blocks() {
	$build_dir = __DIR__ . '/build/blocks';

	foreach (scandir($build_dir) as $result) {
		$block_location = $build_dir . '/' . $result;

		if (!is_dir($block_location) || '.' === $result || '..' === $result) {
			continue;
		}
		// echo '<br>'.$block_location;
		register_block_type($block_location);
	}
	// die;
}

add_action('init', 'wpdocs_register_multiple_blocks');



function create_pages_if_not_exist() {
	$pages = ['Home', 'About', 'Services', 'Clients', 'Works', 'Contact', 'Product Redesign', 'MVP', 'Team Extention', 'Case Study', 'Blog'];
	foreach ($pages as $slug) {
		$existing_page = get_page_by_path(strtolower($slug));
		if (!$existing_page) {
			wp_insert_post([
				'post_title'  => $slug,
				'post_status' => 'publish',
				'post_type'   => 'page',
			]);
		}
	}
}
add_action('after_switch_theme', 'create_pages_if_not_exist');

// Function to generate and print navigation HTML based on page titles and URLs
function generate_navigation_html() {
	// Define the array of page titles
	$pages = array(
		'Works',
		'Services',
		'About',
		'Blog',
		'Contact'
	);

	// Fetch URLs for the pages using array_map and inline function
	$page_urls = array_map(function ($title) {
		$page = get_posts(array(
			'post_type'   => 'page',
			'title'       => $title,
			'numberposts' => 1
		));
		return !empty($page) ? get_permalink($page[0]->ID) : null;
	}, $pages);

	// Start building the HTML output using heredoc
	$html = <<<HTML
<!-- wp:navigation {"className":"header-navigation"} -->
HTML;

	// Loop through pages and generate links
	foreach ($pages as $index => $label) {
		if (!empty($page_urls[$index])) {
			$html .= <<<HTML
<!-- wp:navigation-link {"label":"{$label}","url":"{$page_urls[$index]}"} /-->
HTML;
		}
	}

	// Close the navigation container
	$html .= <<<HTML
<!-- /wp:navigation -->
HTML;

	// Print the final HTML
	return $html;
}

function add_reset_filter_link($content) {
	$reset_link = '<li class="cat-item' . (is_home() ? ' current-cat' : '') . '"><a href="' . home_url('/blog') . '">All topics</a></li>';
	return $reset_link . $content;
}
add_filter('wp_list_categories', 'add_reset_filter_link');

function wpdocs_codex_case_studies_init() {
	$labels = array(
		'name'               => _x('Case Studies', 'Post type general name', 'newschannelbd'),
		'singular_name'      => _x('Case Study', 'Post type singular name', 'newschannelbd'),
		'menu_name'          => _x('Case Studies', 'Admin Menu text', 'newschannelbd'),
		'name_admin_bar'     => _x('New Case Study', 'Add New on Toolbar', 'newschannelbd'),
		'add_new'            => _x('Add New', 'case study', 'newschannelbd'),
		'add_new_item'       => __('Add New Case Study', 'newschannelbd'),
		'edit_item'          => __('Edit Case Study', 'newschannelbd'),
		'new_item'           => __('New Case Study', 'newschannelbd'),
		'view_item'          => __('View Case Study', 'newschannelbd'),
		'all_items'          => __('All Case Studies', 'newschannelbd'),
		'search_items'       => __('Search Case Studies', 'newschannelbd'),
		'not_found'          => __('No case studies found.', 'newschannelbd'),
		'not_found_in_trash' => __('No case studies found in Trash.', 'newschannelbd'),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array('slug' => 'case-studies'),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-analytics',
		'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
		'show_in_rest'       => true,
		'taxonomies'         => array('category', 'post_tag'),
	);

	register_post_type('case-studies', $args);
}
add_action('init', 'wpdocs_codex_case_studies_init');
function mytheme_add_editor_styles() {
	// Add support for wide and full-width blocks
	// add_theme_support( 'align-wide' );
}
add_action('after_setup_theme', 'mytheme_add_editor_styles');
function render_post_item($post, $signle = false) {
	$post_thumbnail = get_the_post_thumbnail($post->ID, '', ['style' => 'border-radius:8px;max-height:518px;object-fit:cover;width:100%']);
	if ($post_thumbnail == '' || !has_post_thumbnail($post->ID)) {
		// $placeholder_image = FOCOTIK_THEME_URI . 'assets/images/placeholder-images/380x150.png';
		$placeholder_image = 'https://placehold.co/600x400/ddd/999/svg?text=No+Image+Found';
		// Fallback image if no thumbnail
		$post_thumbnail = '<img src="' . $placeholder_image . '" alt="no post image" />';
	}
	// Get post categories
	$post_categories = wp_get_post_categories($post->ID);

	// Start building the output
	$output = '<div class="wp-block-group case-study-item">
    <a href="' . get_the_permalink($post->ID) . '">
        <figure class="wp-block-image size-full is-resized has-custom-border post-thumbnail">' . $post_thumbnail . '</figure>
    </a>
    <div class="flex gap8 wrap" style="margin-top:var(--wp--preset--spacing--40); margin-bottom:var(--wp--preset--spacing--40)">';

	// Loop through categories
	if (!empty($post_categories)) {
		foreach ($post_categories as $category) {
			$cat = get_category($category);
			$output .= '<div class="category-button"><a href="' . get_term_link($cat) . '">' . esc_html($cat->name) . '</a></div>';
		}
	}

	$output .= '</div>
        <div class="wp-block-heading">
            <a href="' . get_the_permalink($post->ID) . '">
                <span class="underline">' . esc_html($post->post_title) . '</span>
            </a>
        </div>
    </div>';

	return $output;
}




/* ====================== */
function render_testimonials_tabs($attributes, $content) {
	// Parse all the blocks inside the content to get child blocks
	$parsed_blocks = parse_blocks($content);

	// Initialize an array to hold navigation images
	$nav_items = [];

	// Loop through parsed blocks and filter for 'newschannelbd/testimonial-item'
	foreach ($parsed_blocks as $block) {
		if ('newschannelbd/testimonial-item' === $block['blockName'] && ! empty($block['attrs']['imageUrl'])) {
			$nav_items[] = $block['attrs']['imageUrl'];
		}
	}

	// Start rendering HTML
	ob_start();
?>
	<div class="newschannelbd-testimonials-tabs">
		<!-- Tab Navigation -->
		<div class="newschannelbd-testimonials-tab-nav">
			<?php foreach ($nav_items as $index => $image_url) : ?>
				<button class="tab-nav-item" data-tab-index="<?php echo esc_attr($index); ?>">
					<img
						src="<?php echo esc_url($image_url); ?>"
						alt="Tab <?php echo esc_attr($index + 1); ?>"
						style="width: 50px; height: 50px; object-fit: cover;" />
				</button>
			<?php endforeach; ?>
		</div>

		<!-- Tab Content -->
		<div class="newschannelbd-testimonials-tab-content">
			<?php echo $content; // Render inner blocks content
			?>
		</div>
	</div>
<?php

	return ob_get_clean();
}
