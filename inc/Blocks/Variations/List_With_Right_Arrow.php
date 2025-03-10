<?php

namespace NewsChannelBD\Blocks\Variations;

class List_With_Right_Arrow
{
	use \NewsChannelBD\Traits\Singleton; // Use the Singleton and PluginData trait.
	public function __construct()
	{
		register_block_style('core/list', array(
			'name'         => 'list-with-right-arrow',
			'label'        => __('Right Arrow', 'newschannelbd'),
			'inline_style' => '
			.wp-block-list.is-style-list-with-right-arrow {
				list-style: none;
				padding: 0;
				margin: 0;
			}

			.wp-block-list.is-style-list-with-right-arrow li {
				display: flex;
				align-items: flex-start;
				margin-bottom: 20px;
			}

			.wp-block-list.is-style-list-with-right-arrow li::before {
				content: "";
				width: 24px;
				height: 24px;
				background-image: url(' . FOCOTIK_THEME_URI . 'assets/images/svg-icons/right-arrow-angle.svg);
				background-size: contain;
				background-repeat: no-repeat;
				margin-right: 12px;
				flex-shrink: 0;

			}'
		));
	}

}
