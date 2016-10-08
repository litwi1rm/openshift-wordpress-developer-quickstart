<?php
$categories = array();
$categories = get_categories();
$category_slug_array = array('');
foreach($categories as $category)
{
	$category_slug_array[] = $category->slug;
}


vc_map( array(
        'name' =>'Latest From Blog',
        'base' => 'latestfromblog',
        "icon" => "webnus_latestfromblog",
		"description" => "Recent posts",
        'category' => esc_html__( 'Webnus Shortcodes', 'webnus_framework' ),
        'params' => array(
						array(
							"type" => "dropdown",
							"heading" => esc_html__( "Type", 'webnus_framework' ),
							"param_name" => "type",
							"value" => array(
								"One"=>"one",
								"Two"=>"two",
								"Three"=>"three",
								"Four"=>"four",										
								"Five"=>"five",										
								"Six"=>"six",
								"Seven"=>"seven",
							),
							"description" => esc_html__( "Type", 'webnus_framework')
						),
						array(
							'type' => 'dropdown',
							'heading' => esc_html__( 'Category', 'webnus_framework' ),
							'param_name' => 'category',
							'value'=>$category_slug_array,
							'description' => esc_html__( 'Select specific category, leave blank to show all categories.', 'webnus_framework')
						),
					),    
		) );
?>