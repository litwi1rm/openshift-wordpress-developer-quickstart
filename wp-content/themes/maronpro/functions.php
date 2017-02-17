<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Maron Pro Theme', 'maronpro' ) );
define( 'CHILD_THEME_URL', 'http://my.appendipity.com/maronpro/' );
define( 'CHILD_THEME_VERSION', '2.4' );

/** Load Custom Metaboxes **/
require_once( CHILD_DIR . '/lib/app-metaboxes.php');

/** Initialize the metabox class **/
add_action( 'init', 'app_initialize_cmb_meta_boxes', 9999 );
function app_initialize_cmb_meta_boxes() {
	if ( !class_exists( 'cmb_Meta_Box' ) ) {
		require_once( 'lib/metaboxes/init.php' );
	}
}

/** Initialize the update class **/
require_once( CHILD_DIR . '/lib/admin/update.php' );

/** Load Appendipity Settings **/
require_once( CHILD_DIR . '/lib/admin/admin-init.php');

/** Load Admin Scripts **/
include_once( CHILD_DIR . '/lib/admin/app-edit-styles.php');
require_once( CHILD_DIR . '/lib/admin/app-shortcodes.php');

/** Load Widgets **/
require_once( CHILD_DIR . '/lib/widgets/button.php' );
require_once( CHILD_DIR . '/lib/widgets/sidebar-optin.php' );
require_once( CHILD_DIR . '/lib/widgets/app-featured-post.php' );
require_once( CHILD_DIR . '/lib/widgets/leadpages-sticky.php' );

/** Add Support for Structural Wraps **/
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'inner', 'footer-widgets', 'footer' ) );

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Allow shortcodes in text widgets
add_filter( 'widget_text', 'do_shortcode' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

/** jQuery Scripts Enqueue **/
add_action( 'wp_enqueue_scripts', 'app_scripts' ); 
function app_scripts() {
	
	wp_enqueue_script( 'wp-mediaelement' );

	// Include this script to add social share buttons
	wp_register_script( 'app-share', trailingslashit( get_stylesheet_directory_uri() ) . 'js/rrssb.min.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_enqueue_script( 'app-share' );

	// Include this script to add social share button popup
	wp_register_script( 'app-popup', trailingslashit( get_stylesheet_directory_uri() ) . 'js/popupwindow.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_enqueue_script( 'app-popup' );
	
	// Include this script to make YouTube videos fluid
    wp_register_script('fluid-vids', trailingslashit( get_stylesheet_directory_uri() ) . 'js/fluidvids.js', array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'fluid-vids' );

	// Include this script for mobile menu
	wp_register_script( 'small-menu', trailingslashit( get_stylesheet_directory_uri() ) . 'js/small-menu.js', array( 'jquery' ), '20130130', true );
	wp_enqueue_script( 'small-menu' );

	// Include this script for sticky optin
	wp_register_script( 'fixto-js', trailingslashit( get_stylesheet_directory_uri() ) . 'js/fixto.min.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_enqueue_script( 'fixto-js' );
}

/** CSS Enqueue **/
add_action( 'wp_enqueue_scripts', 'app_styles' );
function app_styles() { 

    //wp_deregister_style('mediaelement');
    wp_deregister_style('wp-mediaelement');

	// Audio Player Styles
    wp_register_style( 'app-player', get_stylesheet_directory_uri() . '/js/skin/app-player.css', array(), '0.1', 'all' );  
    wp_enqueue_style( 'app-player' );

	// Media Element Styles
    wp_register_style( 'mediaelement-style', get_stylesheet_directory_uri() . '/js/skin/mediaelementplayer.css', array(), '0.1.6', 'all' );  
    wp_enqueue_style( 'mediaelement-style' );
	
	// Font Icons
    wp_register_style( 'app-icons', get_stylesheet_directory_uri() . '/lib/css/app-icon.css', array(), CHILD_THEME_VERSION, 'all' );  
    wp_enqueue_style( 'app-icons' );
	
	// Responsive Share Buttons
    wp_register_style( 'app-share', get_stylesheet_directory_uri() . '/lib/css/rrssb.css', array(), CHILD_THEME_VERSION, 'all' );  
    wp_enqueue_style( 'app-share' );
}

/* Widget Scripts */
add_action( 'admin_enqueue_scripts', 'widgets_scripts' );
function widgets_scripts( $hook ) {
    if ( 'widgets.php' != $hook ) {
        return;
    }
    wp_enqueue_style( 'wp-color-picker' );        
    wp_enqueue_script( 'wp-color-picker' ); 
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_script('upload_media_widget', get_stylesheet_directory_uri() . '/js/upload-media.js');
}

//* Add new image sizes
add_image_size( 'related', 100, 100, TRUE );
add_image_size( 'home-top', 740, 400, TRUE );
add_image_size( 'featured', 250, 250, TRUE );
add_image_size( 'home-left', 200, 200, TRUE );
add_image_size( 'sidebar', 375, 200, TRUE );

/** Add no-header body class to the head **/
add_filter( 'body_class', 'add_body_header_class' );
function add_body_header_class( $classes ) {
	
	global $app_options;
	
	$show_header 		= $app_options[ 'showheader' ];
	$showmb		 		= $app_options[ 'showmb' ];
	$mb_position 		= $app_options[ 'mb-position' ];
	$dark_btn	 		= $app_options[ 'colors' ];
	$show_spp_player 	= $app_options[ 'show_spp_player' ];
	
	if( $mb_position == 0 ) {
		$classes[] = 'mb-static';
	}
	if( $showmb == 0 ){
		$classes[] = 'no-mb';
	}
	if( $show_header == 0 ){
		$classes[] = 'no-header';
	}
	if( $dark_btn == 0 ){
		$classes[] = 'dark';
	}
	if( $show_spp_player == 1 ){
		$classes[] = 'app-spp';
	}
	
return $classes;
}

/** Custom CSS Output **/
add_action( 'wp_head', 'custom_css_output' );
function custom_css_output() {
	
	global $app_options;
	
	$custom_css = $app_options[ 'custom-css' ];
	
	if( $custom_css ) {
		
		echo '<style type="text/css">';
		echo $custom_css;
		echo '</style>';
	}
}

//* Category to show on Homepage
add_action( 'pre_get_posts', 'include_category_homepage' );
function include_category_homepage( $query ) {
	
 	global $app_options;

	// First, initialize how many posts to render per page
	$display_count = get_option('posts_per_page');
	// Next, get the current page
	$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
	// After that, calculate the offset
	$offset = (($page - 1) * $display_count) + 1;
	
	$hp_cat = $app_options[ 'mp-cat' ];
	$showmp = $app_options[ 'showmp' ];
	
    if ( is_home() && $query->is_main_query() ) {
        $query->set( 'cat', $hp_cat );
		if ( $showmp == 1 ) {
			$query->set( 'offset', $offset );
			$query->set( 'paged', $page );
			$query->set( 'posts_per_page', $display_count );
		}
		return;
    }
}

/** Remove Sub Navigation After Header **/
remove_action( 'genesis_after_header', 'genesis_do_subnav' );

/** Add Message Bar and Subnav **/
add_action( 'genesis_before', 'top_bar' );
function top_bar() { 

	global $post, $app_options;
	
		$mb 			= get_post_meta( $post->ID, '_cmb_message_bar', true );
		$message_bar 	= $app_options[ 'message-bar' ];
		$show_mb 		= $app_options[ 'showmb' ];
		
		if( $mb && !is_home() && ( $show_mb == 1 ) ){
		   echo '<div id="message_bar"><div class="wrap"><div id="message"><div class="textwidget">';
		   		echo wpautop($mb);
			   echo '</div></div>';
			   genesis_do_subnav();
			   echo '</div></div>';
		}
		else {
			
			if( $message_bar && ( $show_mb == 1 ) ){
				
			   echo '<div id="message_bar"><div class="wrap"><div id="message"><div class="textwidget">';
			   		echo wpautop( $app_options[ 'message-bar' ] );
			   echo '</div></div>';
			   genesis_do_subnav();
			   echo '</div></div>';
			   
			} elseif( empty( $message_bar ) && has_nav_menu( 'secondary' ) && ( $show_mb == 1 ) ){
				
			   echo '<div id="message_bar"><div class="wrap"><div id="message"><div class="textwidget">';
			   		echo '<p></p>';
			   echo '</div></div>';
			   genesis_do_subnav();
			   echo '</div></div>';
			   
			} else {
				
				echo '';
				
			}
		}
}

/** Header Image **/
remove_action( 'genesis_header', 'genesis_do_header' );
add_action( 'genesis_header', 'app_do_header' );
function app_do_header() {

	global $wp_registered_sidebars, $app_options;
	
	$header_img 	= $app_options[ 'header-img' ][ 'url' ];
	$header_width 	= $app_options[ 'header-img' ][ 'width' ];
	$header_height 	= $app_options[ 'header-img' ][ 'height' ];
	
	if( $header_img ) {

		echo '<div class="title-area header-image">';
		
				echo '<a href="' . trailingslashit( home_url() ) . '" title="' . get_bloginfo( 'name' ) . '" ><img alt="' . get_bloginfo( 'name' ) . '" src="' . $header_img . '" width="' . $header_width . '" height="' . $header_height . '" /></a>';
			
			echo '<h1 class="site-title" itemprop="headline">' . get_bloginfo( 'name' ) . '</h1>';
			
			do_action( 'genesis_site_description' );
	
		echo '</div>';
	
	} else {

		echo '<div class="title-area">';
			
			do_action( 'genesis_site_title' );
			do_action( 'genesis_site_description' );
	
		echo '</div>';
		
	}

	if ( ( isset( $wp_registered_sidebars['header-right'] ) && is_active_sidebar( 'header-right' ) ) || has_action( 'genesis_header_right' ) ) {
		
		echo '<aside class="widget-area header-widget-area">';

			do_action( 'genesis_header_right' );
			add_filter( 'wp_nav_menu_args', 'genesis_header_menu_args' );
			add_filter( 'wp_nav_menu', 'genesis_header_menu_wrap' );
			dynamic_sidebar( 'header-right' );
			remove_filter( 'wp_nav_menu_args', 'genesis_header_menu_args' );
			remove_filter( 'wp_nav_menu', 'genesis_header_menu_wrap' );

		echo '</aside>';

	}

}

/** Header Image **/
add_action( 'get_header', 'default_header_img' );
function default_header_img() {
	
	global $app_options;
	
	$header_img = $app_options[ 'header-img' ][ 'url' ];
	
	if( $header_img ) {
	
		add_theme_support( 'custom-header' );
	
	}

}

/** Header Banner Placement **/
add_action( 'get_header', 'place_header_banner' );
function place_header_banner() {
	
	global $app_options;
	
	$hb_placement 	=  $app_options[ 'hb-placement' ];
	$showhb 		=  $app_options[ 'showhb' ];
	
	if ( $showhb == 1 ) {
	
		if ( $hb_placement == 1 ) {
			add_action('genesis_before_header', 'header_banner', 10);
		}
		
		if ( $hb_placement == 2 ) {
			add_action('genesis_after_header', 'header_banner', 1);
		}
	
	}

}

/** Add Header Banner **/
function header_banner() {
	
	global $app_options;

	$h_banner = $app_options[ 'header-banner' ];
	
	if( $h_banner ){
	   echo '<div class="header-banner">';
		   echo '<div class="textwidget">';
		   		echo wpautop( $h_banner );
		   echo '</div>';
	   echo '</div>';
	}
	if( empty( $h_banner )){
		   echo '';
	}
}

/** Add Podcast Player **/
add_action( 'genesis_after_header', 'player_bar' );
function player_bar() {

	global $app_options, $post;

	$s_showsp = $app_options[ 'showsp' ];
	$hide_main_play = get_post_meta( get_the_ID(), '_cmb_hide_main_play', true );
	
	if ( is_single() && ( $s_showsp == 1 && empty( $hide_main_play ) ) ) {
		include_once( CHILD_DIR . "/lib/widgets/single-player-bar.php" );
	}
}

/** Add Before Post Banner **/
add_action('genesis_before_loop', 'before_content_banner');
function before_content_banner() {
	
	global $post, $app_options;
	
	$apb = get_post_meta( $post->ID, '_cmb_banner', true );
	$apb = wpautop( $apb );
	$apb = shortcode_unautop( $apb );
	$apb = do_shortcode( $apb );
	
	if( $apb && !is_home() ){
	   echo '<div id="before-content-banner">';
	   		echo $apb;
	   echo '</div>';
	}
	else {
		
	$showabp 	= $app_options[ 'showabp' ];
	$ap_banner 	= $app_options[ 'above-post-banner' ];
	$ap_banner 	= wpautop( $ap_banner );
	$ap_banner 	= shortcode_unautop( $ap_banner );
	$ap_banner 	= do_shortcode( $ap_banner );
	
	if( $ap_banner && ( $showabp == 1 ) ){
	   echo '<div id="before-content-banner">';
	   		echo $ap_banner;
	   echo '</div>';
	}
	if( empty( $ap_banner ) && ( $showabp == 0 ) ) {
		   echo '';
	}
}
}


// Allow iframes in TinyMCE
add_filter('tiny_mce_before_init', 'tinymce_init');

function tinymce_init( $init ) {
	
	if ( isset( $init['extended_valid_elements'] ) ) {
		$init['extended_valid_elements'] .= ', iframe[align|longdesc| name|width|height|frameborder|scrolling|marginheight| marginwidth|src]';
	}
    $init['verify_html'] = false;
    return $init;
}

/** Unregister Secondary Sidebar **/
unregister_sidebar( 'sidebar-alt' );

/** Unregister Layout Settings **/
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Reposition the secondary navigation
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav' );

/** Modify the comment says text */
add_filter( 'comment_author_says_text', 'custom_comment_author_says_text' );
function custom_comment_author_says_text() {
    return '';
}

/** Related Posts Placement **/
add_action( 'get_header', 'place_prev_next_post_nav' );
function place_prev_next_post_nav() {
	
	global $app_options;
	
	$pnp_placement =  $app_options[ 'pnp-placement' ];
	
	if ( $pnp_placement == 1 && is_single() ) {
		add_action( 'genesis_after_entry', 'genesis_post_navigation', 2 );
	}
	
	if ( $pnp_placement == 2 && is_single() ) {
		add_action( 'genesis_after_entry', 'genesis_post_navigation', 8 );
	}
	
	if ( $pnp_placement == 3 && is_single() ) {
		add_action( 'genesis_after_loop', 'genesis_post_navigation', 10 );
	}

}

function trim_next_title() {
	global $post;
	
	$next_title = get_next_post();
	$next_limit = "32";
	$next_pad	= "...";
	
	if( !empty( $next_title ) ) {
		
		if( strlen( $next_title->post_title ) <= $next_limit ) {
			
			return $next_title->post_title;
			
		} else {
			
			$next_title = substr($next_title->post_title, 0, $next_limit) . $next_pad;
			
			return $next_title;
			
		}
		
	}
	
}

function trim_prev_title() {
	global $post;
	
	$prev_title = get_previous_post();
	$prev_limit = "32";
	$prev_pad	= "...";
	
	if(strlen($prev_title->post_title) <= $prev_limit) {
		return $prev_title->post_title;
	} else {
		$prev_title = substr($prev_title->post_title, 0, $prev_limit) . $prev_pad;
		return $prev_title;
	}
}

/** Add Previous & Next Links in Single Post Page **/
function genesis_post_navigation() {
	
	global $app_options;
	
	$trunc_next_title 	= trim_next_title();
	$trunc_prev_title 	= trim_prev_title();
	$next_post			= get_next_post_link();
	$nav_title 			= $app_options[ 'showtitle' ];
	$cs_title 			= $app_options[ 'cs-title' ];
	$cs_size 			= $app_options[ 'cs-size' ];
	$cs_link 			= $app_options[ 'cs-link' ];
	$cs_new_win 		= $app_options[ 'cs-new-win' ];
	$prev_display_title = ( ($nav_title == 1 ) ? $trunc_prev_title : '<span class="big">Prev Post</span>' );
	$next_display_title = ( ($nav_title == 1 ) ? $trunc_next_title : '<span class="big">Next Post</span>' );
	
	if ( is_single ( ) && ( $app_options[ 'showpnp' ] == 1 ) ) {
		
		echo '<div id="prev-next">';
		echo get_previous_post_link( '%link', '<div class="previous">' . $prev_display_title . '</div><!--end .previous -->' );
			echo get_next_post_link( '%link', '<div class="next">' . $next_display_title . '</div><!--end .next -->' );
		if ( $next_post == '' ) {
				if ( $cs_link ) {
					echo '<a ' . (( $cs_new_win == 1 ) ? 'target="_blank"' : '') . ' rel="next" href="' . $cs_link . '" title="' . $cs_title . '"><div class="next"><span class="' . (( $cs_size == 1 ) ? 'big' : '' ) . '">' . $cs_title . '</span></div><!--end .next --></a>';
				} else {
					echo '<div class="next"><span class="' . (( $cs_size == 1 ) ? 'big' : '' ) . '">' . $cs_title . '</span></div><!--end .next -->';
				}
		}
		echo '</div><!--end #prev-next -->';
		
	}
}

/** Remove Post Info **/
add_action( 'get_header', 'post_info_remove' );
function post_info_remove() {
	
	global $app_options;
	
	$post_meta = $app_options[ 'post-meta' ];
	if ( $post_meta == 0 ) {
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
	}
}


/** Remove Post Meta **/
add_action( 'get_header', 'post_meta_remove' );
function post_meta_remove() {
	
	global $app_options;
	
	$post_cats = $app_options[ 'post-cats' ];
	if ( $post_cats == 0 || is_home() || is_category() || is_page_template( 'page_blog.php' ) ) {
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
	}
}

/** Social Share Buttons Placement **/
add_action( 'get_header', 'share_placement' );
function share_placement() {
	
	global $app_options;
	
	$sb_placement = $app_options[ 'sb-placement' ];
	if ( $sb_placement == 1 ) {
		add_action( 'genesis_entry_footer', 'post_meta_bottom', 15 );
		add_action( 'genesis_entry_footer', 'page_share', 15 );
	}
	if ( $sb_placement == 2 ) {
		add_action( 'genesis_entry_header', 'post_meta_bottom', 12 );
		add_action( 'genesis_entry_header', 'page_share', 12 );
	}
	if ( $sb_placement == 3 ) {
		add_action( 'genesis_entry_footer', 'post_meta_bottom', 15 );
		add_action( 'genesis_entry_header', 'post_meta_bottom', 12 );
		add_action( 'genesis_entry_footer', 'page_share', 15 );
		add_action( 'genesis_entry_header', 'page_share', 12 );
	}
}

/** Add Post Meta **/
function post_meta_bottom() {
if ( is_single() ) {
?>
<div class="entry-meta">
    <div class="post-share">
		<?php 
			include(CHILD_DIR . "/lib/admin/app-share-rrssb.php");
		?> 
	</div><!-- end .post-share -->
</div><!-- end #entry-meta -->
<div class="clearall"> </div>
<?php
}
}

/** Add Blog and Category Share Buttons **/
add_action( 'genesis_entry_footer', 'blog_cat_share', 15 );
function blog_cat_share() {
	
	if ( is_home() || is_category() ) {
		
		echo '<div class="share-icon"><i class="icon-share"></i></div>';
		echo '<div class="side-share">';
			include ( CHILD_DIR . "/lib/admin/app-share.php" );
		echo '</div>';
	
	}
}

/** Add Player to archive pages **/
add_action( 'genesis_entry_footer', 'archive_player', 15 );
function archive_player() {

	global $app_options;
	
	$showpwd_b 		= $app_options[ 'showpwd' ];
	$show_ba_player = $app_options[ 'show_ba_player' ];
	$show_spp_player 	= $app_options[ 'show_spp_player' ];
	
	if ( is_archive() || is_home() && ( $show_ba_player == 1 ) ) {				
		$podcast 		= get_post_meta(get_the_ID(), 'podcast', true);
		$podcast_embed 	= get_post_meta(get_the_ID(), '_cmb_podcast_embed', true);
	
		$p_file			= basename( $podcast );
		
		if( function_exists( 'powerpress_get_enclosure_data' ) ) {
			$ppdata = powerpress_get_enclosure_data( get_the_ID(), $feed_slug = 'podcast', $raw_data = false );
		} else {
			$ppdata = NULL;
		}
		
		if( function_exists( 'powerpress_get_enclosure_data' ) ) {
			$filetype = wp_check_filetype( $ppdata['url'] );
			if( $filetype['type'] == 'video/mp4' ) {
				$player_short = '<span style="padding-left: 30px;">Sorry, Maron Pro does not support video files. Please use embed code to display video.</span>';
			} else {
				$player_short = ( class_exists( 'SPP_Core' ) && ( $show_spp_player == 1 ) ) ? do_shortcode('[smart_track_player url="' . preg_replace( '/.mp3.*/', '.mp3', $ppdata['url'] ) . '" title="' . get_the_title() . '"]') : do_shortcode( '[app_audio src="' . preg_replace( '/.mp3.*/', '.mp3', $ppdata['url'] ) . '"]' );
			}
		}
	
		if ( class_exists( 'wp_simplepodcastpress' ) ) {
			$ap_spp_podcast = get_post_meta( get_the_ID(), '_audiourl', true );
		} else {
			$ap_spp_podcast = NULL;
		}
				//echo $ap_spp_podcast;
				
			if ( $podcast ) {
				
				echo '<div class="podcast-entry">';
					echo '<div class="player">';
						if ( class_exists( 'SPP_Core' ) && ( $show_spp_player == 1 ) ) { 
							echo do_shortcode('[smart_track_player url="' . preg_replace( '/.mp3.*/', '.mp3', $podcast ) . '" title="' . get_the_title() . '"]'); 
						} else { 
							echo do_shortcode('[app_audio src="' . preg_replace( '/.mp3.*/', '.mp3', $podcast ) . '"]'); 
						}
					echo '</div>';
            		if ( ( $showpwd_b == 1 ) && ( $show_spp_player != 1 ) ) {
                        echo '<div class="dnld-play">';
                            echo '<a class="play" target="_blank" href="' . $podcast . '" title="Play in New Window"><i class="icon-export"></i></a>';
                            echo '<a download="' . $p_file . '" href="' . $podcast . '" title="Download"><i class="icon-download"></i></a>';
                        echo '</div>';
					}
            	echo '</div>';
				
			} elseif ( $ppdata['url'] && empty( $ppdata['embed'] ) ) {
				
				echo '<div class="podcast-entry">';
					echo '<div class="player">';
						echo $player_short;
					echo '</div>';
            		if ( ( $showpwd_b == 1 ) && ( $filetype['type'] != 'video/mp4' ) && ( $show_spp_player != 1 ) ) {
                        echo '<div class="dnld-play">';
                            echo '<a class="play" target="_blank" href="' . $ppdata['url'] . '" title="Play in New Window"><i class="icon-export"></i></a>';
                            echo '<a download="' . basename( $ppdata['url'] ) . '" href="' . $ppdata['url'] . '" title="Download"><i class="icon-download"></i></a>';
                        echo '</div>';
					}
            	echo '</div>';
				
			} elseif ( $ap_spp_podcast ) {
				
				echo '<div class="podcast-entry">';
					echo '<div class="player">';
						if ( class_exists( 'SPP_Core' ) && ( $show_spp_player == 1 ) ) { 
							echo do_shortcode('[smart_track_player url="' . preg_replace( '/.mp3.*/', '.mp3', $ap_spp_podcast ) . '" title="' . get_the_title() . '"]'); 
						} else { 
							echo do_shortcode('[app_audio src="' . preg_replace( '/.mp3.*/', '.mp3', $ap_spp_podcast ) . '"]'); 
						}
					echo '</div>';
            		if ( ( $showpwd_b == 1 ) && ( $show_spp_player != 1 ) ) {
                        echo '<div class="dnld-play">';
                            echo '<a class="play" target="_blank" href="' . $ap_spp_podcast . '" title="Play in New Window"><i class="icon-export"></i></a>';
                            echo '<a download="' . basename( $ap_spp_podcast ) . '" href="' . $ap_spp_podcast . '" title="Download"><i class="icon-download"></i></a>';
                        echo '</div>';
					}
            	echo '</div>';
				
			} elseif ( $podcast_embed ) {
				
					echo '<div class="p-embed">' . $podcast_embed . '</div>';
					
			} elseif ( $ppdata['embed'] ) {
				
					echo '<div class="p-embed">' . $ppdata['embed'] . '</div>';
					
			} else {
				
				echo '';
				
			}
			
	}
}

/** Auto Embed Player Placement **/
add_action( 'get_header', 'auto_embed_placement' );
function auto_embed_placement() {
	
	global $app_options;
	
	$single_placement = $app_options[ 'single-placement' ];
	
	if ( $single_placement == 1 && is_single() ) {
		add_action( 'genesis_before_entry_content', 'auto_embed_player', 10 );
	}
	if ( $single_placement == 2 && is_single() ) {
		add_action( 'genesis_after_entry_content', 'auto_embed_player', 10 );
	}
}

/** Auto Embed Post Audio Player **/
function auto_embed_player() {

	global $app_options;
	
	$showpwd_b 			= $app_options[ 'showpwd' ];
	$show_single 		= $app_options[ 'show-single-embed' ];
	$a_show_spp_player 	= $app_options[ 'show_spp_player' ];
				
		$podcast 		= get_post_meta(get_the_ID(), 'podcast', true);
		$podcast_embed 	= get_post_meta(get_the_ID(), '_cmb_podcast_embed', true);
		
		if( function_exists( 'powerpress_get_enclosure_data' ) ) {
			$ppdata = powerpress_get_enclosure_data( get_the_ID(), $feed_slug = 'podcast', $raw_data = false );
		} else {
			$ppdata = NULL;
		}
	
		if ( class_exists( 'wp_simplepodcastpress' ) ) {
			$spp_podcast = get_post_meta( get_the_ID(), '_audiourl', true );
		} else {
			$spp_podcast = NULL;
		}
		
		if( has_post_thumbnail() ) {
			
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'stp' );
			
		} else {
			
			$thumb = NULL;
			
		}
	
		$p_file			= basename( $podcast );
				
		if ( $podcast && $show_single == 1 ) {
			
			echo '<div class="in-post">';
				if( class_exists( 'SPP_Core' ) && ( $a_show_spp_player == 1 ) ) {
					echo do_shortcode('[smart_track_player url="' . preg_replace( '/.mp3.*/', '.mp3', $podcast ) . '" title="' . get_the_title() . '"]');
				} else {
					echo do_shortcode( '[app_audio src="' . preg_replace( '/.mp3.*/', '.mp3', $podcast ) . '"]' );
				}
            	if ( ( $showpwd_b == 1 ) && ( $a_show_spp_player != 1 ) ) {
                	echo '<div class="dnld-play">';
                		echo '<a class="play" target="_blank" href="' . $podcast . '" title="Play in New Window"><i class="icon-export"></i></a>';
                		echo '<a download="' . $p_file . '" href="' . $podcast . '" title="Download"><i class="icon-download"></i></a>';
                	echo '</div>';
				}
            echo '</div>';
			
		} elseif ( $ppdata['url'] && $show_single == 1 ) {
			
			echo '<div class="in-post">';
				if( class_exists( 'SPP_Core' ) && ( $a_show_spp_player == 1 ) ) {
					echo do_shortcode('[smart_track_player url="' . preg_replace( '/.mp3.*/', '.mp3', $ppdata['url'] ) . '" title="' . get_the_title() . '"]');
				} else {
					echo do_shortcode( '[app_audio src="' . preg_replace( '/.mp3.*/', '.mp3', $ppdata['url'] ) . '"]' );
				}
            	if ( ( $showpwd_b == 1 ) && ( $a_show_spp_player != 1 ) ) {
                	echo '<div class="dnld-play">';
                		echo '<a class="play" target="_blank" href="' . $ppdata['url'] . '" title="Play in New Window"><i class="icon-export"></i></a>';
                		echo '<a download="' . basename( $ppdata['url'] ) . '" href="' . $ppdata['url'] . '" title="Download"><i class="icon-download"></i></a>';
                	echo '</div>';
				}
            echo '</div>';
			
		} elseif ( $spp_podcast && $show_single == 1 ) {
			
			echo '<div class="in-post">';
				if( class_exists( 'SPP_Core' ) && ( $a_show_spp_player == 1 ) ) {
					echo do_shortcode('[smart_track_player url="' . $spp_podcast . '" title="' . get_the_title() . '"]');
				} else {
					echo do_shortcode( '[app_audio src="' . preg_replace( '/.mp3.*/', '.mp3', $spp_podcast ) . '"]' );
				}
            	if ( ( $showpwd_b == 1 ) && ( $a_show_spp_player != 1 ) ) {
                	echo '<div class="dnld-play">';
                		echo '<a class="play" target="_blank" href="' . $spp_podcast . '" title="Play in New Window"><i class="icon-export"></i></a>';
                		echo '<a download="' . basename( $spp_podcast ) . '" href="' . $spp_podcast . '" title="Download"><i class="icon-download"></i></a>';
                	echo '</div>';
				}
            echo '</div>';
			
		} elseif ( $podcast_embed && $show_single == 1 ) {
				
			echo '<div class="p-embed">' . $podcast_embed . '</div>';
					
		} else {
			echo '';
		}
}

/** Disable SPP Player **/
add_action( 'init', 'disable_spp_players' );
function disable_spp_players() {
	
	if ( get_option('spp_disable_all_players') != '0' ) {
		update_option('spp_disable_all_players', 0);
	}
}

/** ------------------ Removed in v2.1 -------------------------- **/
 //* Replaced by - app_auto_add_enclosure_data()
/** ------------------ Added again in v2.3 -------------------------- **/
//Auto Add Enclosure custom field for podcast custom field 
add_action( 'admin_footer', 'auto_add_enclosure', 9999 );
function auto_add_enclosure() {
	
	$args = array(
			'post_type' => 'post',
		  	'posts_per_page' => 200,
		  	'post_status'    => 'publish',
			'meta_key' => 'podcast'
		);
	
	$the_query = new WP_Query( $args );
	
	while( $the_query->have_posts() ) : $the_query->the_post();
	
	$enclose 	= get_post_meta( get_the_ID(), 'enclosure', true );
	$app_pcast 	= get_post_meta( get_the_ID(), 'podcast', true );
	
	//echo 'Enclose: ' . $enclose;
	//echo '<br />Podcast: ' . $app_pcast;
	
	if ( empty( $enclose ) && !empty( $app_pcast ) ) {
		update_post_meta( get_the_ID(), 'enclosure', $app_pcast );
	}
	
	endwhile;
	wp_reset_postdata();
	
	$spp_args = array(
			'post_type' => 'post',
		  	'posts_per_page' => 200,
		  	'post_status'    => 'publish',
			'meta_key' => '_audiourl'
		);
	
	$spp_query = new WP_Query( $spp_args );
	
	while( $spp_query->have_posts() ) : $spp_query->the_post();
	
	$spp_enclose 	= get_post_meta( get_the_ID(), 'enclosure', true );
	$spp_pcast 		= get_post_meta( get_the_ID(), '_audiourl', true );
	
	if ( empty( $spp_enclose ) && !empty( $spp_pcast ) ) {
		update_post_meta( get_the_ID(), 'enclosure', $spp_pcast );
	}
	
	endwhile;
	wp_reset_postdata();
	
}

/** Add the Page Share Buttons **/
//add_filter( 'genesis_entry_footer', 'page_share' );
function page_share() { 
    if(is_page() && !is_front_page()){
?>
<div class="entry-meta">
    <div class="post-share">
		<?php 
			include (CHILD_DIR . "/lib/admin/app-share-rrssb.php");
		?> 
	</div><!-- end .post-share -->
</div><!-- end #entry-meta -->
<div class="clearall"> </div>
<?php }
}

//* Set default image for Pinterest Button
function pin_default_image() {

	global $app_options, $post;
	
	$pin_default 	= $app_options[ 'pin-default' ][ 'url' ];
	$url 			= wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
		
		if( has_post_thumbnail() ) {
			echo $url;
		} else {
			echo $pin_default;
		}
} 
	
//* Hook after entry widget after the entry content
add_action( 'genesis_after_entry', 'podcast_pro_after_entry', 1 );
function podcast_pro_after_entry() {
	
	if ( is_singular( 'post' ) )
		genesis_widget_area( 'after-entry', array(
			'before' => '<div class="after-entry" class="widget-area">',
			'after'  => '</div>',
		) );

}

/** Read More Link Changed to Continue Reading... **/
add_filter( 'the_content_more_link', 'custom_read_more_link' );
function custom_read_more_link() {
    return '<a class="more-link" href="' . get_permalink() . '" rel="nofollow">Continue Reading &#x2026;</a>';
}

/** Modify the size of the Author Box Gravatar **/
add_filter( 'genesis_author_box_gravatar_size', 'author_box_gravatar_size' );
function author_box_gravatar_size( $size ) {
	return '100';
}

/** Change size of Comment Author Gravatars **/
add_filter( 'genesis_comment_list_args', 'app_comment_author_size' );
function app_comment_author_size( $args ) {
		$args['avatar_size'] = 75;
	return $args;
}

/** Add a Custom Default Gravatar **/
if ( !function_exists('custom_gravatar') ) {
function custom_gravatar( $avatar_defaults ) {
	$myavatar = trailingslashit( get_stylesheet_directory_uri() ) . 'images/avatar-sc.png';

		$avatar_defaults[$myavatar] = 'SoundCloud';

	$myavatar2 = trailingslashit( get_stylesheet_directory_uri() ) . 'images/avatar-comment.png';

		$avatar_defaults[$myavatar2] = 'We Love Comments';

	return $avatar_defaults;
}
add_filter('avatar_defaults', 'custom_gravatar');
}

/** Modify Comment Form **/
add_filter('comment_form_default_fields', 'html5_commentform');
function html5_commentform() {

$fields =  array(
'author' => '<p>' . '<label for="author">' . __( 'Name' ) . '</label><input id="author" name="author" type="text" value="" size="30" /></p>',

'email'  => '<p><label for="email">' . __( 'Email' ) . '</label><input id="email" name="email" type="email" value="" size="30" /></p>',

'url'    => '<p><label for="url">' . __( 'Website' ) . '</label><input id="url" name="url" type="url" value="" size="30" /></p>'

);
return $fields;
}

/** Remove Comment Form Allowed Tags
------------------------------------- **/
add_action('after_setup_theme','remove_comment_form_allowed_tags');
function remove_comment_form_allowed_tags() {
add_filter('comment_form_defaults','wordpress_comment_form_defaults');
}

function wordpress_comment_form_defaults($default) {
	$default['comment_notes_after'] = '';
	$default['comment_notes_before'] = '';
return $default;
}

/** Force Comment Author URL to Open in New Window **/
add_filter('get_comment_author_link', 'comment_author_link_window');
function comment_author_link_window() {
	global $comment;
	$url    = get_comment_author_url();
	$author = get_comment_author();
 
	if ( empty( $url ) || 'http://' == $url )
		$return = $author;
	else
		$return = "<a href='$url' rel='external nofollow' target='_blank'>$author</a>";
	return $return;
}

/** Related Posts Placement **/
add_action( 'get_header', 'place_related_posts' );
function place_related_posts() {
	
	global $app_options;
	
	$rp_placement =  $app_options[ 'rp-placement' ];
	
	if ( $rp_placement == 1 ) {
		add_action( 'genesis_after_entry', 'app_related_posts', 5 );
	}
	
	if ( $rp_placement == 2 ) {
		add_action( 'genesis_after_entry', 'app_related_posts', 9 );
	}
	
	if ( $rp_placement == 3 ) {
		add_action( 'genesis_after_loop', 'app_related_posts', 5 );
	}

}

/** Related Posts with Thumbnail **/
function app_related_posts() {
	
	global $post, $app_options;
	
	$showrp 		= $app_options[ 'showrp' ] ;
	$showrp_thumb 	= $app_options[ 'showrp-thumb' ] ;
	$rpheadline 	= $app_options[ 'rp-headline' ];
	$rpnumber 		= $app_options[ 'rp-number' ];
	$rpthumb 		= $app_options[ 'rp-thumb' ][ 'url' ];
	$minusone 		= $rpnumber - 1;
	
    if ( is_single ( ) && ( $showrp == 1 ) ) {

        $count = 0;
        $postIDs = array( $post->ID );
        $related = '';
        $tags = wp_get_post_tags( $post->ID );
        $cats = wp_get_post_categories( $post->ID );
    	$t_showposts = $rpnumber;
        if ( $tags ) {
            foreach ( $tags as $tag ) {
                $tagID[] = $tag->term_id;
            }
            $args = array(
                'tag__in'               => $tagID,
                'post__not_in'          => $postIDs,
                'posts_per_page'        => $t_showposts,
                'ignore_sticky_posts'   => 1,
        		'orderby'       		=> 'rand',
                'tax_query'             => array(
                    array(
                                        'taxonomy'  => 'post_format',
                                        'field'     => 'slug',
                                        'terms'     => array( 
                                            'post-format-link', 
                                            'post-format-status', 
                                            'post-format-aside', 
                                            'post-format-quote'
                                            ),
                                        'operator'  => 'NOT IN'
                    )
                )
            );
            $tag_query = new WP_Query( $args );
            if ( $tag_query->have_posts() ) {
                while ( $tag_query->have_posts() ) {
                    $tag_query->the_post();
					
                    $img = genesis_get_image() ? genesis_get_image( array( 'size' => 'related', 'attr' => array ( 'class' => 'alignleft' ) ) ) : '<img class="alignleft" src="' . $rpthumb . '" alt="' . get_the_title() . '" width="100" height="100" />';
					
                    $related .= '<li><a href="' . get_permalink() . '" rel="bookmark" title="Permanent Link to' . get_the_title() . '">' . (( $showrp_thumb == 1 ) ? $img : '') . get_the_title() . '</a></li>';
					
                    $postIDs[] = $post->ID;
                    $count++;
                }
            }
        }
		
		//echo $count . ', ' . $t_showposts . ', ' . $rpnumber;
        if ( $count < $t_showposts ) {
            $catIDs = array( );
            foreach ( $cats as $cat ) {
                if ( $minusone == $cat )
                    continue;
                $catIDs[] = $cat;
            }
    		$c_showposts = $t_showposts - $count;
			
            $args = array(
                'category__in'          => $catIDs,
                'post__not_in'          => $postIDs,
                'posts_per_page'        => $c_showposts,
                'ignore_sticky_posts'   => 1,
                'orderby'               => 'rand',
                'tax_query'             => array(
                                    array(
                                        'taxonomy'  => 'post_format',
                                        'field'     => 'slug',
                                        'terms'     => array( 
                                            'post-format-link', 
                                            'post-format-status', 
                                            'post-format-aside', 
                                            'post-format-quote' ),
                                        'operator' => 'NOT IN'
                                    )
                )
            );
            $cat_query = new WP_Query( $args );
            if ( $cat_query->have_posts()  && ( $c_showposts != 0 ) ) {
                while ( $cat_query->have_posts() ) {
                    $cat_query->the_post();
					
                    $img = genesis_get_image() ? genesis_get_image( array( 'size' => 'related', 'attr' => array ( 'class' => 'alignleft' ) ) ) : '<img class="alignleft" src="' . $rpthumb . '" alt="' . get_the_title() . '" width="100" height="100" />';
					
                    $related .= '<li><a href="' . get_permalink() . '" rel="bookmark" title="Permanent Link to' . get_the_title() . '">' . (( $showrp_thumb == 1 ) ? $img : '') . get_the_title() . '</a></li>';
                }
            }
        }
		
        if ( $related && ( $showrp_thumb == 1 ) ) {
            printf( '<div class="related-posts"><h3 class="related-title">%s</h3><ul class="related-list thumbs">%s</ul></div>', $rpheadline, $related );
        }
        if ( $related && ( $showrp_thumb == 0 ) ) {
            printf( '<div class="related-posts"><h3 class="related-title">%s</h3><ul class="related-list">%s</ul></div>', $rpheadline, $related );
        }
        wp_reset_query();
    }
}

/** Change Excerpt Length **/
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
function custom_excerpt_length( $length ) {
	return 55;
}

/** Change Excerpt More Text **/
add_filter('excerpt_more', 'new_excerpt_more');
function new_excerpt_more( $more ) {
	return '...';
}

/** Remove eNews Widget **/
add_action( 'widgets_init', 'remove_genesis_widgets', 20 );
function remove_genesis_widgets() {
	unregister_widget( 'Genesis_eNews_Updates' );
	unregister_widget( 'Genesis_Featured_Post' );
}

/** Change Previous Next Post Navigation **/
add_filter( 'genesis_prev_link_text', 'app_prev_link_text' );
function app_prev_link_text() {
        $prevlink = 'Prev Page...';
        return $prevlink;
}
add_filter( 'genesis_next_link_text', 'app_next_link_text' );
function app_next_link_text() {
        $nextlink = '...Next Page';
        return $nextlink;
}

/** Customize Search Button Text **/
add_filter( 'genesis_search_button_text', 'custom_search_button_text' );
function custom_search_button_text($text) {
	return esc_attr('');
}

/** Add Footer Optin Area **/
add_action('genesis_before_footer', 'footer_optin_area');
function footer_optin_area() { 
	if ( is_active_sidebar( 'footer_optin_area' ) ) {
		echo '<div id="footer_optin_area"><div class="wrap"><div id="footer_optin_bg">';
			dynamic_sidebar( 'footer_optin_area' );
		echo '</div><!-- end #footer_optin_bg --></div><!-- end .wrap --></div><!-- end #footer_optin_area -->';
	}
}

/** JavaScript in Footer **/
add_action ( 'wp_footer', 'app_footer_scripts' );
function app_footer_scripts() { ?>
<script>
	jQuery(document).ready(function($) {
		if ($('#fb-root').length === 0) $('body').prepend('<div id="fb-root"></div>');
		$(".home-share").hide('fast');
			$(".click-share").click(function() {
				$(this).parent().children(".home-share").slideToggle(300);
			});
		$(".side-share").hide('fast');
			$(".share-icon").click(function() {
				$(this).parent().children(".side-share").slideToggle(300);
			});
			$('.mypopup').popupWindow({ 
				centerBrowser:1 
			});
	});
	jQuery(window).ready(function($) {
		var ih = $('.title-area').innerHeight();
		$('.site-header .wrap').find('.nav-header ul.genesis-nav-menu li a').css({height: ih, 'padding-top': (ih - 24)/2, 'padding-bottom': (ih - 24)/2});
		$(".nav-header ul.sub-menu li a").removeAttr("style");
	});
	jQuery(function ($) {
	  $('.lp-sticky').fixTo('body', {
		mind: '#message_bar',
		useNativeSticky: false
	  });
	});
</script>
<?php
}

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'hp_player_bar',
	'name'        => __( 'Homepage Main Player Widget Area', 'maronpro' ),
	'description' => __( 'This is the main player widget section on the homepage.', 'maronpro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'player_bar',
	'name'        => __( 'Single Post Main Player Widget Area', 'maronpro' ),
	'description' => __( 'This is the main player widget section on single posts.', 'maronpro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-sidebar',
	'name'        => __( 'Home - Sidebar', 'maronpro' ),
	'description' => __( 'This is the sidebar section of the homepage.', 'maronpro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-content',
	'name'        => __( 'Home Content', 'maronpro' ),
	'description' => __( 'This is the content section of the homepage.', 'maronpro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'after-entry',
	'name'        => __( 'After Post', 'maronpro' ),
	'description' => __( 'This is the after post section.', 'maronpro' ),
) );
genesis_register_sidebar( array(
	'id'				=> 'footer_optin_area',
	'name'			=> __( 'Footer Optin', 'maronpro' ),
	'description'	=> __( 'Only one Appendipity Optin can be used this widget area. Just drag the widget here and fill in the fields to activate it.', 'maronpro' ),
) );