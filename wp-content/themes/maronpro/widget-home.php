<?php
/**
 * This file adds the Home Page to the Maron Pro Theme.
 *
 * @author Appendipity
 * @package Maron Pro
 * @subpackage Customizations
 */
 
/*
Template Name: Home Page
*/

//* Add Body Class
function maron_pro_body_class( $classes ) {

	$classes[] = 'maronpro-home';
	return $classes;
	
}

/** Add Podcast Player **/
add_action('genesis_after_header', 'main_player_bar', 5);
function main_player_bar() {
	
	global $app_options;

	$showmp = $app_options[ 'showmp' ];
	
	if ( $showmp == 1 ) {
		include (CHILD_DIR . "/lib/widgets/player-bar.php");
	}
}

/** Featured Guest Placement **/
add_action( 'get_header', 'place_featured_guest_area' );
function place_featured_guest_area() {
	
	global $app_options;
	
	$fg_placement =  $app_options[ 'fg-placement' ];
	
	if ( $fg_placement == 2 ) {
		add_action( 'genesis_after_header', 'featured_guest_area', 10 );
	}
	
	if ( $fg_placement == 1 ) {
		add_action( 'genesis_after_header', 'featured_guest_area', 1 );
	}

}

/** Add Featured Guest **/
function featured_guest_area() {
	
	global $app_options;

	$showfg = $app_options[ 'showfg' ];
	
	if ( $showfg == 1 ) {
		include (CHILD_DIR . "/lib/widgets/guest-area.php");
	}
}

/** Remove Above Post Banner */
remove_action( 'genesis_before_loop', 'before_content_banner' );

add_action( 'genesis_meta', 'maron_pro_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function maron_pro_home_genesis_meta() {

	if ( is_active_sidebar( 'home-content' ) ) {
		
		// Add maron-pro-home body class
		add_filter( 'body_class', 'maron_pro_body_class' );

		// Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );
	
	}

	if ( is_active_sidebar( 'home-content' ) ) {
	
		// Add excerpt length filter
		//add_action( 'genesis_before_loop', 'maron_pro_top_excerpt_length' );
	
		// Add homepage widgets
		add_action( 'genesis_before_loop', 'maron_pro_homepage_content_widget' );		
		
		// Remove excerpt length filter
		//add_action( 'genesis_before_loop', 'maron_pro_remove_top_excerpt_length' );
		
	}
}

function maron_pro_homepage_content_widget() {

	genesis_widget_area( 'home-content', array(
		'before' => '<div class="home-content widget-area">',
		'after'  => '</div>',
	) );

}


add_action( 'genesis_meta', 'maron_pro_place_homepage_sidebar' );
function maron_pro_place_homepage_sidebar() {

	if( is_active_sidebar( 'home-sidebar' )) {
		
		remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
		add_action( 'genesis_sidebar', 'maron_pro_homepage_sidebar' );
		
		if( function_exists( 'ss_sidebars_init' ) ) {
			remove_action( 'genesis_sidebar', 'ss_do_sidebar' );
		}
		
	}

}

function maron_pro_homepage_sidebar() {

	genesis_widget_area( 'home-sidebar', array(
		'before' => '<div class="home-sidebar widget-area">',
		'after'  => '</div>',
	) );

}

//* Move Featured Image
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 8 );

genesis();
