<?php

namespace NewsChannelBD\Blocks\Variations;

class List_With_Gradient_Bullet
{
	use \NewsChannelBD\Traits\Singleton; // Use the Singleton and PluginData trait.
	public function __construct()
	{

		register_block_style('core/list', array(
			'name'         => 'list-with-gradient-bullet',
			'label'        => __('Gradient', 'newschannelbd'),
			'inline_style' => '
			.wp-block-list.is-style-list-with-gradient-bullet {
				list-style: none;
				padding: 0;
				margin: 0;
			}

			.wp-block-list.is-style-list-with-gradient-bullet li {
				display: flex;
				align-items: center;
			}

			.wp-block-list.is-style-list-with-gradient-bullet li::before {
				content: "";
				width: 16px;
				height: 16px;
				background-image: url(' . FOCOTIK_THEME_URI . 'assets/images/svg-icons/gradient-bullet.svg);
				background-size: contain;
				background-repeat: no-repeat;
				margin-right: 12px;
				flex-shrink: 0;
				display: inline-block;
				flex-shrink: 0;
				vertical-align: middle;

			}'
		));
	}

}
