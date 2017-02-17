<?php
/**
 * This file adds the Landing template to the Maron Pro Theme.
 *
 * @author Appendipity
 * @package Maron Pro
 * @subpackage Customizations
 */

/*
Template Name: Landing
*/

// Add custom body class to the head
add_filter( 'body_class', 'news_add_body_class' );
function news_add_body_class( $classes ) {

   $classes[] = 'maronpro-landing';
   return $classes;
   
}

//* Force full width content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Remove Message Bar
remove_action( 'genesis_before', 'top_bar' );

/** Remove Before Post Banner **/
remove_action( 'genesis_before_loop', 'before_content_banner' );

//* Remove site header elements
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'app_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

/** Header Banner Placement **/
remove_action( 'get_header', 'place_header_banner' );

//* Remove navigation
remove_action( 'genesis_before_header', 'genesis_do_nav' );
remove_action( 'genesis_after_header', 'genesis_do_subnav' );

//* Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Remove site footer widgets
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

//* Remove Footer Optin
remove_action('genesis_before_footer', 'footer_optin_area');

//* Remove site footer elements
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

//* Run the Genesis loop
genesis();
