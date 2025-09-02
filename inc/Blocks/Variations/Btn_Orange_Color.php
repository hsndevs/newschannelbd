<?php

namespace NewsChannelBD\Blocks\Variations;

class Btn_Orange_Color
{
    use \NewsChannelBD\Traits\Singleton; // Use the Singleton and PluginData trait.
    public function __construct()
    {
        // Action to add register_block_style
        register_block_style('core/button', array(
            'name'         => 'btn-orange-color',
            'label'        => __('btn Orange Color', 'newschannelbd'),
            'inline_style' => '.wp-block-button.is-style-btn-orange-color {
				background-color: #EB6945;
				color: #EFF2F6;
				border-radius: 40px;
				padding: 16px 24px;
			}'
        ));
    }

}
