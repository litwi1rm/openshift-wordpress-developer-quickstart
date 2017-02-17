<?php 

/**
 * Replace WP Audio Shortcode and Add Custom Shortcodes
 **/
 
/** New Audio Shortcode **/
remove_shortcode('audio', 'wp_audio_shortcode');
add_shortcode( 'app_audio', apply_filters( 'wp_audio_shortcode_handler_new', 'wp_audio_shortcode_new' ) );
function wp_audio_shortcode_new( $attr ) {
	$post_id = get_post() ? get_the_ID() : 0;

	static $instances = 0;
	$instances++;

	$audio = null;

	$default_types = wp_get_audio_extensions();
	$defaults_atts = array(
		'src'      => '',
		'loop'     => '',
		'autoplay' => '',
		'preload'  => 'none'
	);
	foreach ( $default_types as $type )
		$defaults_atts[$type] = '';

	$atts = shortcode_atts( $defaults_atts, $attr, 'app_audio' );
	extract( $atts );

	$primary = false;
	if ( ! empty( $src ) ) {
		$type = wp_check_filetype( $src, wp_get_mime_types() );
		if ( ! in_array( $type['ext'], $default_types ) )
			return sprintf( '<a class="wp-embedded-audio" href="%s">%s</a>', esc_url( $src ), esc_html( $src ) );
		$primary = true;
		array_unshift( $default_types, 'src' );
	} else {
		foreach ( $default_types as $ext ) {
			if ( ! empty( $$ext ) ) {
				$type = wp_check_filetype( $$ext, wp_get_mime_types() );
				if ( $type['ext'] === $ext )
					$primary = true;
			}
		}
	}

	if ( ! $primary ) {
		$audios = get_attached_media( 'app_audio', $post_id );
		if ( empty( $audios ) )
			return;

		$audio = reset( $audios );
		$src = wp_get_attachment_url( $audio->ID );
		if ( empty( $src ) )
			return;

		array_unshift( $default_types, 'src' );
	}

	$library = apply_filters( 'wp_audio_shortcode_library', 'mediaelement' );
	if ( 'mediaelement' === $library && did_action( 'init' ) ) {
		wp_enqueue_style( 'wp-mediaelement' );
		wp_enqueue_script( 'wp-mediaelement' );
	}

	$atts = array(
		'class'    => apply_filters( 'wp_audio_shortcode_class', 'wp-audio-shortcode' ),
		'id'       => sprintf( 'audio-%d-%d', $post_id, $instances ),
		'loop'     => $loop,
		'autoplay' => $autoplay,
		'preload'  => $preload,
		'style'    => 'width: 100%',
	);

	// These ones should just be omitted altogether if they are blank
	foreach ( array( 'loop', 'autoplay', 'preload' ) as $a ) {
		if ( empty( $atts[$a] ) )
			unset( $atts[$a] );
	}

	$attr_strings = array();
	foreach ( $atts as $k => $v ) {
		$attr_strings[] = $k . '="' . esc_attr( $v ) . '"';
	}

	$html = '';
	if ( 'mediaelement' === $library && 1 === $instances )
		$html .= "<!--[if lt IE 9]><script>document.createElement('audio');</script><![endif]-->\n";
	$html .= sprintf( '<audio %s controls="controls">', join( ' ', $attr_strings ) );

	$fileurl = '';
	$source = '<source type="%s" src="%s" />';
	foreach ( $default_types as $fallback ) {
		if ( ! empty( $$fallback ) ) {
			if ( empty( $fileurl ) )
				$fileurl = $$fallback;
			$type = wp_check_filetype( $$fallback, wp_get_mime_types() );
			$html .= sprintf( $source, $type['type'], esc_url( $$fallback ) );
		}
	}

	if ( 'mediaelement' === $library )
		$html .= wp_mediaelement_fallback( $fileurl );
	$html .= '</audio>';

	return apply_filters( 'wp_audio_shortcode_new', $html, $atts, $audio, $post_id, $library );
}
wp_embed_unregister_handler( 'audio', 9999 );
function wp_embed_handler_audio_new( $matches, $attr, $url, $rawattr ) {
	$audio = sprintf( '[app_audio src="%s" /]', esc_url( $url ) );
	return apply_filters( 'wp_embed_handler_audio_new', $audio, $attr, $url, $rawattr );
}

/** Add Buttons to TinyMCE **/
add_action('init', 'add_button');
function add_button() {  
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )  
   {  
     add_filter('mce_external_plugins', 'add_plugin');  
     add_filter('mce_buttons', 'register_button');  
   }  
}
function register_button($buttons) {  
	if( function_exists( 'powerpress_get_enclosure_data' ) ) {
		
		array_push($buttons, "shadowbox", "audio", "blubrry" );  
		return $buttons;
		
	} else {
		
		array_push($buttons, "shadowbox", "audio" );  
		return $buttons;
		
	}
}
function add_plugin($plugin_array) {  
   $plugin_array['appendipity'] = get_bloginfo('stylesheet_directory').'/js/custombutton.js';
   return $plugin_array;  
}
add_shortcode('shadowbox', 'shadow_box'); 
function shadow_box( $atts, $content = null ) {  
    return '<div class="shadowbox">'.$content.'</div>';  
}
/* add_shortcode('share', 'share_buttons'); 
function share_buttons( $atts, $content = null ) {

	$sharebtns = file_get_contents( CHILD_DIR . '/lib/admin/app-share.php' );
    	return '<div class="ip-share"><div class="share-text">'.$content.'</div><div class="post-share">' . $sharebtns . '</div></div>';     
} */