<?php

/**
 * Plugin File: AM API
 * Description: This plugin will show related random posts under each post.
 *
 * @package wordpress-plugin
 * @since 1.0
 */

namespace NewsChannelBD;

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Plugin_Main Class
 */
final class Theme_Main {
	use Traits\Singleton, Traits\PluginData; // Use the Singleton and PluginData trait.

	/**
	 * Class constructor (private to enforce singleton pattern).
	 *
	 * @return void
	 */
	private function __construct() {
		// All the initialization tasks.
		$this->register_hooks();
	}

	/**
	 * Register hooks and do other setup tasks.
	 *
	 * @return void
	 */
	public function register_hooks() {
		// Defining plugin constants.
		add_action('after_setup_theme', array($this, 'init_plugin'));
		// Set up the theme.
		add_action('after_setup_theme', array($this, 'newschannelbd_setup'));
	}


	public function newschannelbd_setup() {
		// Make the theme available for translation.
		load_theme_textdomain('newschannelbd');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		// Let WordPress manage the document title.
		add_theme_support('title-tag');

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(array(
			'primary' => esc_html__('Primary', 'newschannelbd'),
		));

		// Switch search form, comment form, and comments to output valid HTML5.
		add_theme_support('html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		));

		// Set up the WordPress core custom background feature.
		add_theme_support('custom-background', apply_filters('newschannelbd_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		)));

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');
	}


	/**
	 * Initialize classes to the plugin.
	 * This method will run after the plugins_loaded action has been fired.
	 * This is a good place to include files and instantiate classes.
	 * This method is called by the register_hooks method.
	 *
	 * @return void
	 */
	public function init_plugin() {
		// Defining plugin constants.
		$this->define_constants();

		Blocks\Variations::get_instance();
		Enqueue::get_instance();
	}



	/**
	 * Function to define all constants.
	 */
	private function define_constants() {

		// It is defined as the plugin directory path without the trailing slash.
		if (!defined('FOCOTIK_THEME_PATH')) {
			// path from the theme root.
			define('FOCOTIK_THEME_PATH', trailingslashit(get_template_directory()));
		}

		// FOCOTIK_ASSETS_URI is the URL for the assets directory of the Learn Plugin.
		if (!defined('FOCOTIK_ASSETS_URI')) {
			define('FOCOTIK_ASSETS_URI', FOCOTIK_THEME_PATH . 'assets');
		}

		// FOCOTIK_THEME_URI is defined as the URL for the plugin directory.
		if (!defined('FOCOTIK_THEME_URI')) {
			define('FOCOTIK_THEME_URI', trailingslashit(get_template_directory_uri()));
		}
	}
}
