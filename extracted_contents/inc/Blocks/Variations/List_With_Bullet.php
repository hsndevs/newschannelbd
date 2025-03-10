<?php

namespace NewsChannelBD\Blocks\Variations;

class List_With_Bullet
{
	use \NewsChannelBD\Traits\Singleton; // Use the Singleton and PluginData trait.
	public function __construct()
	{
		register_block_style('core/list', array(
			'name'         => 'list-with-bullet',
			'label'        => __('Bullet', 'newschannelbd'),
			'inline_style' => '
			.wp-block-list.is-style-list-with-bullet {
				list-style: none;
				padding: 0;
				margin: 0;
			}

			.wp-block-list.is-style-list-with-bullet li {
				display: flex;
				align-items: flex-start;
				margin-bottom: 12px;
				font-size:16px;
				font-wight:400;
				line-height:24px;
			}

			.wp-block-list.is-style-list-with-bullet li::before {
				content: "";
				width: 24px;
				height: 24px;
				background-image: url(' . FOCOTIK_THEME_URI . 'assets/images/svg-icons/bullet.svg);
				background-size: contain;
				background-repeat: no-repeat;
				margin-right: 12px;
				flex-shrink: 0;
			}'
		));
	}

}
