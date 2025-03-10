<?php

namespace NewsChannelBD\Blocks\Variations;

class Btn_White_Color
{
	use \NewsChannelBD\Traits\Singleton; // Use the Singleton and PluginData trait.
	public function __construct()
	{

		register_block_style('core/button', array(
			'name'         => 'btn-white-color',
			'label'        => __('BTN White Color', 'newschannelbd'),
			'inline_style' => '.wp-block-button.is-style-btn-white-color .wp-block-button__link{
				background-color: #EFF2F6 !important;
				color: #272B2F !important;
				border-radius: 40px !important;
				padding: 16px 24px !important;
			}'
		));
	}

}
