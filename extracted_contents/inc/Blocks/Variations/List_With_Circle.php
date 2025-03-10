<?php

namespace NewsChannelBD\Blocks\Variations;

class List_With_Circle
{
	use \NewsChannelBD\Traits\Singleton; // Use the Singleton and PluginData trait.
	public function __construct()
	{

		register_block_style('core/list', array(
			'name'         => 'list-with-circle',
			'label'        => __('Circle', 'newschannelbd'),
			'inline_style' => '
			.wp-block-list.is-style-list-with-circle {
				list-style: none;
				padding: 0;
				margin: 0;
			}

			.wp-block-list.is-style-list-with-circle li {
				display: flex;
				align-items: center;
			}

			.wp-block-list.is-style-list-with-circle li::before {
				content: "";
				width: 16px;
				height: 16px;
				background-image: url(' . FOCOTIK_THEME_URI . 'assets/images/svg-icons/circle.svg);
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
