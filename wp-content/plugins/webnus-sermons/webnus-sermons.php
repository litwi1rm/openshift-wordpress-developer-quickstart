<?php

/*
Plugin Name: Webnus Sermons
Description: Webnus Sermons plugin is a wordpress plugin designed to create Sermons in to your wordpress website.
Version: 1.1
Author: Webnus
Author URI: http://webnus.net
License: GPL2
*/

define('SERMONS_DIR', dirname(__FILE__));
define('SERMONS_THEMES_DIR', SERMONS_DIR . "/themes");
define('SERMONS_URL', WP_PLUGIN_URL . "/" . basename(SERMONS_DIR));
define('W_SERMONS_VERSION', '1.1');

//Method And Action Are Call
add_filter('manage_edit-sermon_columns', 'w_add_new_sermon_columns');
add_action('manage_sermon_posts_custom_column', 'w_manage_sermon_columns', 5, 2);
add_action('init', 'w_sermon_register');

//Register Post Type
function w_sermon_register() {
    $labels = array(
        'name' => __('Sermons', 'webnus'),
        'all_items' => __('All Sermons', 'webnus'),
        'singular_name' => __('Sermon', 'webnus'),
        'add_new' => __('Add Sermon', 'webnus'),
        'add_new_item' => __('Add New Sermon', 'webnus'),
        'edit_item' => __('Edit Sermon', 'webnus'),
        'new_item' => __('New Sermon', 'webnus'),
        'view_item' => __('View Sermon', 'webnus'),
        'search_items' => __('Search Sermon', 'webnus'),
        'not_found' => __('No Sermon found', 'webnus'),
        'not_found_in_trash' => __('No Item found in Trash', 'webnus'),
        'parent_item_colon' => '',
        'menu_name' => __('Sermons', 'webnus')
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'rewrite' => array('slug' => 'sermon'),
        'supports' => array(
            'title',
            'thumbnail',
            'editor',
			'page-attributes',
			'excerpt',
			'comments',
        ),
        'menu_position' => 23,
        'menu_icon' => 'dashicons-money',
        'taxonomies' => array('sermon_category', 'webnus')
    );
    register_post_type('sermon', $args);
	w_sermon_register_taxonomies();
}

//Register Taxonomies
function w_sermon_register_taxonomies() {
    register_taxonomy('sermon_category', 'sermon', 
	array(
	'hierarchical' => true,
	'label' => 'Sermon Categories',
	'query_var' => true,
	'rewrite' => array('slug' => 'sermon-category')
	));

	$labels = array(
			'name'					=> __('Sermon Speakers', 'webnus'),
			'singular_name'			=> __('Sermon Speaker',  'webnus'),
			'search_items'			=> __('Search Sermon Speaker', 'webnus'),
			'popular_items'			=> __('Popular Sermons Speakers', 'webnus'),
			'all_items'				=> __('All Sermons Speakers', 'webnus'),
			'parent_item'			=> null,
			'parent_item_colon'		=> null,
			'edit_item'				=> __('Edit Sermons Speaker', 'webnus'),
			'update_item'			=> __('Update Sermons Speaker', 'webnus'),
			'add_new_item'			=> __('Add New Sermons Speaker', 'webnus'),
			'new_item_name'			=> __('New Sermons Speaker Name', 'webnus'),
			'add_or_remove_items'	=> __('Add or remove Sermons Speakers', 'webnus'),
			'choose_from_most_used' => __('Choose from the most used Sermons Speakers', 'webnus'),
			'separate_items_with_commas' => __('Separate Sermons Speakers with commas', 'webnus'),
		);
	register_taxonomy('sermon_speaker', 'sermon', 	
	array(
	'hierarchical' => true,
	'labels' => $labels,
	'query_var' => true,	'rewrite' => array('slug' => 'sermon-speaker')
	));
	
	}
	
//Admin Dashobord Listing Sermon Columns Title
function w_add_new_sermon_columns() {
	$columns['cb'] = '<input type="checkbox" />';
 	$columns['title'] = __('Title', 'webnus');
	$columns['sermon_category'] = __('Categories', 'webnus' );
	$columns['sermon_speaker'] = __('Speakers', 'webnus' );
	$columns['date'] = __('Date', 'webnus');
	return $columns; 
}

//Admin Dashobord Listing Sermon Columns Manage
function w_manage_sermon_columns($columns) {
	global $post;
	switch ($columns) {
 	case 'sermon_category':
		$terms = wp_get_post_terms($post->ID, 'sermon_category');  
		foreach ($terms as $term) {  
			echo $term->name .'&nbsp;&nbsp; ';  
		}  
	break;
	 	case 'sermon_speaker':
		$terms = wp_get_post_terms($post->ID, 'sermon_speaker');  
		foreach ($terms as $term) {  
			echo $term->name .'&nbsp;&nbsp; ';  
		}  
	break;
	}
}
?>