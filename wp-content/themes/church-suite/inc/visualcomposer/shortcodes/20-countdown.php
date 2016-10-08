<?php
vc_map( array(
        'name' =>'Event Countdown',
        'base' => 'countdown',
        "icon" => "icon-wpb-countdown",
		"description" => "Upcoming Event Countdown",
        'category' => esc_html__( 'Webnus Shortcodes', 'webnus_framework' ),
        'params' => array(
						array(
							"type" => "dropdown",
							"heading" => esc_html__( "Type", 'webnus_framework' ),
							"param_name" => "type",
							"value" => array(
								"Modern"=>"modern",
								"Standard"=>"standard",
								"Minimal"=>"minimal",
							),
							"description" => esc_html__( "Select style type", 'webnus_framework')
						),						
        ),
        
    ) );

?>