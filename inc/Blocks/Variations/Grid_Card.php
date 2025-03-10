<?php

namespace NewsChannelBD\Blocks\Variations;

class Grid_Card
{
	use \NewsChannelBD\Traits\Singleton; // Use the Singleton and PluginData trait.
	public function __construct()
	{
		register_block_style('core/group', array(
			'name'         => 'grid-card',
			'label'        => __('Grid Card', 'newschannelbd'),
			'inline_style' => '
				.wp-block-post .wp-block-group is-style-grid-card {
					padding:10px!important;
				}
			'
		));
	}
}
