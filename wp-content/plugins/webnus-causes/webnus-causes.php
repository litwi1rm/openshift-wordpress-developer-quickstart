<?php
/*
Plugin Name: Webnus Causes
Description: Webnus Causes plugin is a wordpress plugin designed to create Causes in to your wordpress website.
Version: 1.0
Author: Webnus
Author URI: http://webnus.net
License: GPL2
*/

define('CAUSES_DIR', dirname(__FILE__));
define('CAUSES_THEMES_DIR', CAUSES_DIR . "/themes");
define('CAUSES_URL', WP_PLUGIN_URL . "/" . basename(CAUSES_DIR));
define('W_CAUSES_VERSION', '1.0');

//Method And Action Are Call
add_filter('manage_edit-cause_columns', 'w_add_new_cause_columns');
add_action('manage_cause_posts_custom_column', 'w_manage_cause_columns', 5, 2);
add_action('init', 'w_cause_register');

//Register Post Type
function w_cause_register() {
    $labels = array(
        'name' => __('Causes', 'webnus'),
        'all_items' => __('All Causes', 'webnus'),
        'singular_name' => __('Cause', 'webnus'),
        'add_new' => __('Add Cause', 'webnus'),
        'add_new_item' => __('Add New Cause', 'webnus'),
        'edit_item' => __('Edit Cause', 'webnus'),
        'new_item' => __('New Cause', 'webnus'),
        'view_item' => __('View Cause', 'webnus'),
        'search_items' => __('Search Cause', 'webnus'),
        'not_found' => __('No Cause found', 'webnus'),
        'not_found_in_trash' => __('No Item found in Trash', 'webnus'),
        'parent_item_colon' => '',
        'menu_name' => __('Causes', 'webnus')
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'rewrite' => array('slug' => 'cause'),
        'supports' => array(
            'title',
            'thumbnail',
            'editor',
			'page-attributes',
			'excerpt',
			'comments',
        ),
        'menu_position' => 23,
        'menu_icon' => 'dashicons-heart',
    );
    register_post_type('cause', $args);
	w_cause_register_taxonomies();
}
//Register Taxonomies
function w_cause_register_taxonomies() {
	$labels = array(
			'name'					=> __('Causes Categories', 'webnus'),
			'singular_name'			=> __('Cause Category',  'webnus'),
			'all_items'				=> __('All Causes Categories', 'webnus'),
	);
	register_taxonomy('cause_category', 'cause', 	
	array(
	'hierarchical' => true,
	'labels' => $labels,
	'query_var' => true,
	'rewrite' => array('slug' => 'cause-category')
	));
	
}
	
//Admin Dashobord Listing Cause Columns Title
function w_add_new_cause_columns() {
	$columns['cb'] = '<input type="checkbox" />';
 	$columns['title'] = __('Title', 'webnus');
	$columns['cause_category'] = __('Categories', 'webnus' );
	$columns['date'] = __('Date', 'webnus');
	$columns['received'] = __('Amount Received', 'webnus');
	$columns['amount'] = __('Amount Needed', 'webnus');
	$columns['end'] = __('End Date', 'webnus');
	return $columns; 
}

//Admin Dashobord Listing Cause Columns Manage
function w_manage_cause_columns($columns) {
	global $post;
	global $cause_meta;
	$cause_meta_w = $cause_meta->the_meta();
	switch ($columns) {
 	case 'cause_category':
		$terms = wp_get_post_terms($post->ID, 'cause_category');  
		foreach ($terms as $term) {  
			echo $term->name .'&nbsp;&nbsp; ';  
		}  
	break;
	case 'received':
	echo $cause_meta->the_value('cause_amount_received');
	break;
	case 'amount':
	echo $cause_meta->the_value('cause_amount');
	break;
	case 'end':
	echo $cause_meta->the_value('cause_end');
	break;
	}
}
?>