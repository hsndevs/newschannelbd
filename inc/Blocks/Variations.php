<?php

/**
 * Block Variations
 *
 * @package wordpress-theme
 * @since 1.0
 */

namespace NewsChannelBD\Blocks;

use NewsChannelBD\Blocks\Variations\Btn_Orange_Color;
use NewsChannelBD\Blocks\Variations\Btn_White_Color;
use NewsChannelBD\Blocks\Variations\Case_Study_Query_Loop;
use NewsChannelBD\Blocks\Variations\Grid_Card;
use NewsChannelBD\Blocks\Variations\Grid_Gradient;
use NewsChannelBD\Blocks\Variations\List_With_Bullet;
use NewsChannelBD\Blocks\Variations\List_With_Circle;
use NewsChannelBD\Blocks\Variations\List_With_Gradient_Bullet;
use NewsChannelBD\Blocks\Variations\List_With_Right_Arrow;

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Block_Variations Class
 */
class Variations
{

	use \NewsChannelBD\Traits\Singleton; // Use the Singleton and PluginData trait.

	/**
	 * Class constructor
	 * (private to enforce singleton pattern).
	 */
	private function __construct()
	{
		// All the initialization tasks.
		$this->register_hooks();
	}


	public function register_hooks()
	{
		// Register block styles.
		add_action('enqueue_block_assets', array($this, 'newschannelbd_register_block_styles'));
	}

	/**
	 * Register block variations
	 */
	public function newschannelbd_register_block_styles()
	{
		// Register block variations.
		Btn_Orange_Color::get_instance();
		Btn_White_Color::get_instance();
		Case_Study_Query_Loop::get_instance();
		Grid_Gradient::get_instance();
		Grid_Card::get_instance();
		List_With_Bullet::get_instance();
		List_With_Gradient_Bullet::get_instance();
		List_With_Circle::get_instance();
		List_With_Right_Arrow::get_instance();
	}
}
