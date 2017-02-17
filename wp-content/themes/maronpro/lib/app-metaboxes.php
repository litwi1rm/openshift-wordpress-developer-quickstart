<?php
/** Load Custom Meta Boxes **/
add_filter( 'cmb_meta_boxes', 'app_custom_metaboxes' );
function app_custom_metaboxes( $meta_boxes ) {
	$prefix = '_cmb_'; // Prefix for all fields
	$meta_boxes['app_metabox'] = array(
		'id' => 'app_metabox',
		'title' => 'Appendipity Custom Settings',
		'pages' => array('post', 'page'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Message Bar',
				'desc' => 'Place your post specific message here. It will override the Message Bar set in the Theme Settings for this post only.',
				'id' => $prefix . 'message_bar',
				'type' => 'wysiwyg',
				'options' => array( 'textarea_rows' => 5, 'teeny' => true, ),
			),
			array(
				'name' => 'Above Post Banner',
				'desc' => 'Place your post specific Banner here. It overrides the Above Post Banner set in the Theme Settings for this post only.',
				'id'   => $prefix . 'banner',
				'sanitization_cb' => false,
        		'wpautop' => false,
				'type' => 'wysiwyg',
				'options' => array( 'textarea_rows' => 10, 'wpautop' => false, ),
			),
		),
	);
	$meta_boxes['podcast_metabox'] = array(
		'id' => 'podcast_metabox',
		'title' => 'Appendipity Podcast Settings',
		'pages' => array('post'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Hide Main Player',
				'desc' => 'Check box to disable main player on this post only. Single Post Main Player must be enabled in Appendipity Settings for this feature to work.',
				'id'   => $prefix . 'hide_main_play',
				'type' => 'checkbox',
			),
			array(
				'name' => 'Podcast mp3',
				'desc' => 'Place your Podcast mp3 link here. Only use this field',
				'id'   => 'podcast',
				'type' => 'text'
			),
			array(
				'name' => 'Podcast iframe',
				'desc' => 'Place your Podcast embed code here.',
				'id'   => $prefix . 'podcast_embed',
				'type' => 'textarea_code'
			),
		),
	);

	return $meta_boxes;
}