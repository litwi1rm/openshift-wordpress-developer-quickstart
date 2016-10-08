<?php

$categories = array();

$categories = get_categories();

$category_slug_array = array();
foreach($categories as $category)
{
	$category_slug_array[] = $category->slug;
}

vc_map( array(
        'name' =>'Category Box',
        'base' => 'categorybox',
		"description" => "Show Categorybox, By category filter",
        "icon" => "webnus_categorybox",
        'params'=>array(
					
					
				array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Category', 'webnus_framework' ),
						'param_name' => 'category',
						'value'=>$category_slug_array,
						'description' => esc_html__( 'Select specific category', 'webnus_framework')
				),
				array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Title', 'webnus_framework' ),
						'param_name' => 'title',
						'value'=> '',
						'description' => esc_html__( 'Set title', 'webnus_framework')
				),
				array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Show title', 'webnus_framework' ),
						'param_name' => 'show_title',
						'value'=>array('Show'=>'true','Hide'=>'false'),
						'description' => esc_html__( 'Show/Hide title', 'webnus_framework')
				),
				array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Posts count', 'webnus_framework' ),
						'param_name' => 'post_count',
						'value'=>'5',
						'description' => esc_html__( 'How many posts to dispaly?', 'webnus_framework')
				),
				array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Show date', 'webnus_framework' ),
						'param_name' => 'show_date',
						'value'=>array('Show'=>'true','Hide'=>'false'),
						'description' => esc_html__( 'Show/Hide date', 'webnus_framework')
				),
					
				array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Show category', 'webnus_framework' ),
						'param_name' => 'show_category',
						'value'=>array('Show'=>'true','Hide'=>'false'),
						'description' => esc_html__( 'Show/Hide category', 'webnus_framework')
				),
				array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Show author', 'webnus_framework' ),
						'param_name' => 'show_author',
						'value'=>array('Show'=>'true','Hide'=>'false'),
						'description' => esc_html__( 'Show/Hide author', 'webnus_framework')
				),
					

					
		),
		'category' => esc_html__( 'Webnus Shortcodes', 'webnus_framework' ),
        
    ) );
?>