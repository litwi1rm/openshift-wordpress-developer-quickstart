<?php
/**/
// TEMP: Enable update check on every request. Normally you don't need this! This is for testing only!
//set_site_transient('update_themes', null);

// NOTE: All variables and functions will need to be prefixed properly to allow multiple plugins to be updated

/******************Change this*******************/
$app_api_url = 'http://www.appendipity.com/api/';
/************************************************/

/*******************Child Theme******************/
//Use this section to provide updates for a child theme
//If using on child theme be sure to prefix all functions properly to avoid 
//function exists errors
if(function_exists('wp_get_theme')){
    $theme_data = wp_get_theme(get_option('stylesheet'));
    $theme_version = $theme_data->Version;  
} else {
    $theme_data = get_theme_data( get_stylesheet_directory() . '/style.css');
    $theme_version = $theme_data['Version'];
}    
$theme_base = get_option('stylesheet');
/**************************************************/


/***********************Parent Theme**************
if(function_exists('wp_get_theme')){
    $theme_data = wp_get_theme(get_option('template'));
    $theme_version = $theme_data->Version;  
} else {
    $theme_data = get_theme_data( TEMPLATEPATH . '/style.css');
    $theme_version = $theme_data['Version'];
}    
$theme_base = get_option('template');
**************************************************/

//Uncomment below to find the theme slug that will need to be setup on the api server
//var_dump($theme_base);

add_filter('pre_set_site_transient_update_themes', 'check_for_update');

function check_for_update($checked_data) {
	global $wp_version, $theme_version, $theme_base, $app_api_url;

	$request = array(
		'slug' => $theme_base,
		'version' => $theme_version 
	);
	// Start checking for an update
	$send_for_check = array(
		'body' => array(
			'action' => 'theme_update', 
			'request' => serialize($request),
			'api-key' => md5(get_bloginfo('url'))
		),
		'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
	);
	$raw_response = wp_remote_post($app_api_url, $send_for_check);
	if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200))
		$response = unserialize($raw_response['body']);

	// Feed the update data into WP updater
	if (!empty($response)) 
		$checked_data->response[$theme_base] = $response;

	return $checked_data;
}

// Take over the Theme info screen on WP multisite
add_filter('themes_api', 'my_theme_api_call', 10, 3);

function my_theme_api_call($def, $action, $args) {
	global $theme_base, $app_api_url, $theme_version, $app_api_url;
	
	if ($args->slug != $theme_base)
		return false;
	
	// Get the current version

	$args->version = $theme_version;
	$request_string = prepare_request($action, $args);
	$request = wp_remote_post($app_api_url, $request_string);

	if (is_wp_error($request)) {
		$res = new WP_Error('themes_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>'), $request->get_error_message());
	} else {
		$res = unserialize($request['body']);
		
		if ($res === false)
			$res = new WP_Error('themes_api_failed', __('An unknown error occurred'), $request['body']);
	}
	
	return $res;
}

if (is_admin())
	$current = get_transient('update_themes');
	

add_action( 'admin_notices', 'app_update_nag' );
/**
 * Display the update nag at the top of the dashboard if there is a Maron Pro update available.
 *
 * @since 1.4
 *
 * @uses check_for_update() Ping http://www.appendipity.com/api/ asking if a new version of this theme is available.
 *
 * @return boolean Return false if there is no available update, or user is not a site administrator.
 */
function app_update_nag($response) {
	
	if ( !is_multisite() ) {

		if ( defined( 'DISALLOW_FILE_MODS' ) && true == DISALLOW_FILE_MODS )
			return false;
	
		$app_update = check_for_update($response);
	
		if ( ! is_super_admin() || ! $app_update )
			return false;
	
		echo '<div id="update-nag">';
		printf(
			__( 'Maron Pro 2.5 is available. <a href="%s" %s>Check out what\'s new</a> or <a href="%s">update now.</a>', 'maronpro' ),
			'https://www.appendipity.com/release-notes/maron-pro-theme-changelog/?TB_iframe=true',
			'class="thickbox thickbox-preview"',
			wp_nonce_url( 'update.php?action=upgrade-theme&amp;theme=maronpro', 'upgrade-theme_maronpro' )
		);
		echo '</div>';
	
	}

}

add_filter( 'update_theme_complete_actions', 'app_update_action_links', 10, 2 );
/**
 * Filter the action links at the end of an update.
 *
 * This function filters the action links that are presented to the user at the end of a theme update. If the theme
 * being updated is not Maron Pro, the filter returns the default values. Otherwise, it will provide a link to the
 * Maron Pro Theme Settings page, which will trigger the database upgrade.
 *
 * @since 2.2
 *
 * @param array  $actions Existing array of action links.
 * @param string $theme   Theme name.
 *
 * @return string Removes all existing action links in favour of a single link, if Maron Pro.
 */
function app_update_action_links( array $actions, $theme ) {

	if ( 'maronpro' !== $theme )
		return $actions;

	return sprintf( '<a href="%s">%s</a>%s', admin_url( 'admin.php?page=appendipity_options' ), __( 'Click here to complete the upgrade', 'maronpro' ), ' and make sure to re-save your Appendipity Options.' );

}
?>