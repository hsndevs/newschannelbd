<?php

namespace NewsChannelBD\Blocks\Variations;

class Grid_Gradient
{
	use \NewsChannelBD\Traits\Singleton; // Use the Singleton and PluginData trait.
	public function __construct()
	{
		register_block_style('core/group', array(
			'name'         => 'gradient-border',
			'label'        => __('Gradient Border', 'newschannelbd'),
			'inline_style' => '
				.wp-block-group.is-style-gradient-border > .wp-block-group {
					background: linear-gradient(180deg, #737476 -158.33%, #272B2F 33.68%);
					border-radius: 12px;
					overflow: hidden;
					position: relative;
				}
				.wp-block-group.is-style-gradient-border > .wp-block-group:before {
					content: "";
					position: absolute;
					top: 0;
					left: 0;
					width: 2px;
					height: 100%;
					background: linear-gradient(180deg, #D6D8DC 32.5%, #737476 110%);
					z-index: 1;
				}
			'
		));
	}
}
