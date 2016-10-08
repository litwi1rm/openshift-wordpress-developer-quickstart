<?php
ob_start();

$thm_options = get_option('webnus_options');

/*
 * Header Style
*/

if(!empty($thm_options['webnus_container_width']))
{
	$w_value = trim ($thm_options['webnus_container_width']);
	if($w_value){
		if(substr($w_value,-2,2)!="px"){$w_value.='px';};
		echo "#wrap .container {max-width:{$w_value};}\n\n";
	}
}

if(!empty($thm_options['webnus_header_padding_top']))
{
	$w_value = trim ($thm_options['webnus_header_padding_top']);
	if($w_value){
		if(substr($w_value,-2,2)!="px"){$w_value.='px';};
		echo "#header {padding-top:{$w_value};}\n\n";
	}
}

if(!empty($thm_options['webnus_header_padding_bottom']))
{
	$w_value = trim ($thm_options['webnus_header_padding_bottom']);
	if($w_value){
		if(substr($w_value,-2,2)!="px"){$w_value.='px';};
		echo "#header {padding-bottom:{$w_value};}\n\n";
	}
}

/*
 * Custom Fonts For P,H Tags
*/
$w_custom_font1_src = $w_custom_font2_src = $w_custom_font3_src ='';

//custom-font-1 font-face

  if(isset($thm_options['webnus_custom_font1_eot']) && $thm_options['webnus_custom_font1_eot']!='')
    $w_custom_font1_src[] = "url('{$thm_options['webnus_custom_font1_eot']}?#iefix') format('embedded-opentype')";
  if(isset($thm_options['webnus_custom_font1_woff']) && $thm_options['webnus_custom_font1_woff']!='')   
    $w_custom_font1_src[] = "url('{$thm_options['webnus_custom_font1_woff']}') format('woff')";
  if(isset($thm_options['webnus_custom_font1_ttf']) && $thm_options['webnus_custom_font1_ttf']!='')
    $w_custom_font1_src[] = "url('{$thm_options['webnus_custom_font1_ttf']}') format('truetype')";

if($w_custom_font1_src !='')
{
  $w_custom_font1_src= implode(",\n",$w_custom_font1_src);
  echo "@font-face {
  font-family: 'custom-font-1';
  font-style: normal;
  font-weight: normal;
  src: {$w_custom_font1_src};\n}\n";
}

//custom-font-2 font-face

  if(isset($thm_options['webnus_custom_font2_eot']) && $thm_options['webnus_custom_font2_eot']!='')
    $w_custom_font2_src[] = "url('{$thm_options['webnus_custom_font2_eot']}?#iefix') format('embedded-opentype')";
  if(isset($thm_options['webnus_custom_font2_woff']) && $thm_options['webnus_custom_font2_woff']!='')   
    $w_custom_font2_src[] = "url('{$thm_options['webnus_custom_font2_woff']}') format('woff')";
  if(isset($thm_options['webnus_custom_font2_ttf']) && $thm_options['webnus_custom_font2_ttf']!='')
    $w_custom_font2_src[] = "url('{$thm_options['webnus_custom_font2_ttf']}') format('truetype')";

if($w_custom_font2_src !='')
{
  $w_custom_font2_src= implode(",\n",$w_custom_font2_src);
  echo "@font-face {
  font-family: 'custom-font-2';
  font-style: normal;
  font-weight: normal;
  src: {$w_custom_font2_src};\n}\n";
}

//custom-font-3 font-face

  if(isset($thm_options['webnus_custom_font3_eot']) && $thm_options['webnus_custom_font3_eot']!='')
    $w_custom_font3_src[] = "url('{$thm_options['webnus_custom_font3_eot']}?#iefix') format('embedded-opentype')";
  if(isset($thm_options['webnus_custom_font3_woff']) && $thm_options['webnus_custom_font3_woff']!='')   
    $w_custom_font3_src[] = "url('{$thm_options['webnus_custom_font3_woff']}') format('woff')";
  if(isset($thm_options['webnus_custom_font3_ttf']) && $thm_options['webnus_custom_font3_ttf']!='')
    $w_custom_font3_src[] = "url('{$thm_options['webnus_custom_font3_ttf']}') format('truetype')";

if($w_custom_font3_src !='')
{
  $w_custom_font3_src= implode(",\n",$w_custom_font3_src);
  echo "@font-face {
  font-family: 'custom-font-3';
  font-style: normal;
  font-weight: normal;
  src: {$w_custom_font3_src};\n}\n";
}


// p-font select

if(isset($thm_options['webnus_p_font']) && $thm_options['webnus_p_font']!='')
{
	if ($thm_options['webnus_p_font'] == 'typekit-font-1')
	  $thm_options['webnus_p_font'] = $thm_options['webnus_typekit_font1'];
	if ($thm_options['webnus_p_font'] == 'typekit-font-2')
	  $thm_options['webnus_p_font'] = $thm_options['webnus_typekit_font2'];
	if ($thm_options['webnus_p_font'] == 'typekit-font-3')
	  $thm_options['webnus_p_font'] = $thm_options['webnus_typekit_font3'];
	echo "#wrap p { font-family: {$thm_options['webnus_p_font']};}\n";
}


// heading-font select

if(isset($thm_options['webnus_heading_font']) && $thm_options['webnus_heading_font']!='')
{
	if ($thm_options['webnus_heading_font'] == 'typekit-font-1')
	  $thm_options['webnus_heading_font'] = $thm_options['webnus_typekit_font1'];
	if ($thm_options['webnus_heading_font'] == 'typekit-font-2')
	  $thm_options['webnus_heading_font'] = $thm_options['webnus_typekit_font2'];
	if ($thm_options['webnus_heading_font'] == 'typekit-font-3')
	  $thm_options['webnus_heading_font'] = $thm_options['webnus_typekit_font3'];
	echo "#wrap h1, #wrap h2, #wrap h3, #wrap h4, #wrap h5, #wrap h6 { font-family: {$thm_options['webnus_heading_font']};}\n";
}


// body-font select

if(isset($thm_options['webnus_body_font']) && $thm_options['webnus_body_font']!='')
{
	if ($thm_options['webnus_body_font'] == 'typekit-font-1')
	  $thm_options['webnus_body_font'] = $thm_options['webnus_typekit_font1'];
	if ($thm_options['webnus_body_font'] == 'typekit-font-2')
	  $thm_options['webnus_body_font'] = $thm_options['webnus_typekit_font2'];
	if ($thm_options['webnus_body_font'] == 'typekit-font-3')
	  $thm_options['webnus_body_font'] = $thm_options['webnus_typekit_font3'];
	echo "body { font-family: {$thm_options['webnus_body_font']};}\n";
}


// menu-font select

if(isset($thm_options['webnus_menu_font']) && $thm_options['webnus_menu_font']!='')
{
	if ($thm_options['webnus_menu_font'] == 'typekit-font-1')
	  $thm_options['webnus_menu_font'] = $thm_options['webnus_typekit_font1'];
	if ($thm_options['webnus_menu_font'] == 'typekit-font-2')
	  $thm_options['webnus_menu_font'] = $thm_options['webnus_typekit_font2'];
	if ($thm_options['webnus_menu_font'] == 'typekit-font-3')
	  $thm_options['webnus_menu_font'] = $thm_options['webnus_typekit_font3'];
	echo "#wrap #nav a { font-family: {$thm_options['webnus_menu_font']};}\n";
}


/* header menu font size */

$webnus_topnav_font_size = $webnus_options->webnus_topnav_font_size(); 
if( !empty($webnus_topnav_font_size) ){
	echo "#wrap ul#nav * { font-size:{$webnus_topnav_font_size}; }\n";
}
$webnus_topnav_letter_spacing = $webnus_options->webnus_topnav_letter_spacing(); 
if( !empty($webnus_topnav_letter_spacing) ){
	echo "#wrap ul#nav * { letter-spacing:{$webnus_topnav_letter_spacing}; }\n";
}
$webnus_topnav_line_height = $webnus_options->webnus_topnav_line_height(); 
if( !empty($webnus_topnav_line_height) ){	
	echo "#wrap ul#nav * { line-height:{$webnus_topnav_line_height}; }\n";	
}



/*  P */

$webnus_p_font_size = $webnus_options->webnus_p_font_size(); 
if( !empty($webnus_p_font_size) )
{
	echo "#wrap p { font-size:{$webnus_p_font_size}; }\n";
}
$webnus_p_letter_spacing = $webnus_options->webnus_p_letter_spacing(); 
if( !empty($webnus_p_letter_spacing) ){
	echo "#wrap p { letter-spacing:{$webnus_p_letter_spacing}; }\n";
}
$webnus_p_line_height = $webnus_options->webnus_p_line_height(); 
if( !empty($webnus_p_line_height) ){
	echo "#wrap p { line-height:{$webnus_p_line_height}; }\n";
}

$webnus_p_font_color = $webnus_options->webnus_p_font_color(); 
if( !empty($webnus_p_font_color) ){
	echo "#wrap p { color:{$webnus_p_font_color}; }\n";
}


/*  H1 */

$webnus_h1_font_size = $webnus_options->webnus_h1_font_size(); 
if( !empty($webnus_h1_font_size) ){
	echo "#wrap h1 { font-size:{$webnus_h1_font_size}; }\n";
}
$webnus_h1_letter_spacing = $webnus_options->webnus_h1_letter_spacing(); 
if( !empty($webnus_h1_letter_spacing) ){
	echo "#wrap h1 { letter-spacing:{$webnus_h1_letter_spacing}; }\n";
}
$webnus_h1_line_height = $webnus_options->webnus_h1_line_height(); 
if( !empty($webnus_h1_line_height) ){
	echo "#wrap h1 { line-height:{$webnus_h1_line_height}; }\n";
}

$webnus_h1_font_color = $webnus_options->webnus_h1_font_color(); 
if( !empty($webnus_h1_font_color) ){	
	echo "#wrap h1 { color:{$webnus_h1_font_color}; }\n";	
}



/*  H2 */

$webnus_h2_font_size = $webnus_options->webnus_h2_font_size(); 
if( !empty($webnus_h2_font_size) ){	
	echo "#wrap h2 { font-size:{$webnus_h2_font_size}; }\n";	
}
$webnus_h2_letter_spacing = $webnus_options->webnus_h2_letter_spacing(); 
if( !empty($webnus_h2_letter_spacing) ){	
	echo "#wrap h2 { letter-spacing:{$webnus_h2_letter_spacing}; }\n";	
}
$webnus_h2_line_height = $webnus_options->webnus_h2_line_height(); 
if( !empty($webnus_h2_line_height) ){
	echo "#wrap h2 { line-height:{$webnus_h2_line_height}; }\n";
}

$webnus_h2_font_color = $webnus_options->webnus_h2_font_color(); 
if( !empty($webnus_h2_font_color) ){
	echo "#wrap h2 { color:{$webnus_h2_font_color}; }\n";	
}


/*  H3 */

$webnus_h3_font_size = $webnus_options->webnus_h3_font_size(); 
if( !empty($webnus_h3_font_size) ){
	echo "#wrap h3 { font-size:{$webnus_h3_font_size}; }\n";
}
$webnus_h3_letter_spacing = $webnus_options->webnus_h3_letter_spacing(); 
if( !empty($webnus_h3_letter_spacing) ){	
	echo "#wrap h3 { letter-spacing:{$webnus_h3_letter_spacing}; }\n";
}
$webnus_h3_line_height = $webnus_options->webnus_h3_line_height(); 
if( !empty($webnus_h3_line_height) ){	
	echo "#wrap h3 { line-height:{$webnus_h3_line_height}; }\n";	
}

$webnus_h3_font_color = $webnus_options->webnus_h3_font_color(); 
if( !empty($webnus_h3_font_color) ){
	echo "#wrap h3 { color:{$webnus_h3_font_color}; }\n";
}



/*  H4 */

$webnus_h4_font_size = $webnus_options->webnus_h4_font_size(); 
if( !empty($webnus_h4_font_size) ){
	echo "#wrap h4 { font-size:{$webnus_h4_font_size}; }\n";	
}
$webnus_h4_letter_spacing = $webnus_options->webnus_h4_letter_spacing(); 
if( !empty($webnus_h4_letter_spacing) ){
	echo "#wrap h4 { letter-spacing:{$webnus_h4_letter_spacing}; }\n";
	
}
$webnus_h4_line_height = $webnus_options->webnus_h4_line_height(); 
if( !empty($webnus_h4_line_height) ){
	echo "#wrap h4 { line-height:{$webnus_h4_line_height}; }\n";
}

$webnus_h4_font_color = $webnus_options->webnus_h4_font_color(); 
if( !empty($webnus_h4_font_color) ){
	echo "#wrap h4 { color:{$webnus_h4_font_color}; }\n";
}



/*  H5 */

$webnus_h5_font_size = $webnus_options->webnus_h5_font_size(); 
if( !empty($webnus_h5_font_size) ){	
	echo "#wrap h5 { font-size:{$webnus_h5_font_size}; }\n";	
}
$webnus_h5_letter_spacing = $webnus_options->webnus_h5_letter_spacing(); 
if( !empty($webnus_h5_letter_spacing) ){	
	echo "#wrap h5 { letter-spacing:{$webnus_h5_letter_spacing}; }\n";	
}
$webnus_h5_line_height = $webnus_options->webnus_h5_line_height(); 
if( !empty($webnus_h5_line_height) ){	
	echo "#wrap h5 { line-height:{$webnus_h5_line_height}; }\n";	
}

$webnus_h5_font_color = $webnus_options->webnus_h5_font_color(); 
if( !empty($webnus_h5_font_color) ){
	
	echo "#wrap h5 { color:{$webnus_h5_font_color}; }\n";	
}



/*  H6 */

$webnus_h6_font_size = $webnus_options->webnus_h6_font_size(); 
if( !empty($webnus_h6_font_size) ){
	echo "#wrap h6 { font-size:{$webnus_h6_font_size}; }\n";
}
$webnus_h6_letter_spacing = $webnus_options->webnus_h6_letter_spacing(); 
if( !empty($webnus_h6_letter_spacing) ){
	echo "#wrap h6 { letter-spacing:{$webnus_h6_letter_spacing}; }\n";
}
$webnus_h6_line_height = $webnus_options->webnus_h6_line_height(); 
if( !empty($webnus_h6_line_height) ){
	echo "#wrap h6 { line-height:{$webnus_h6_line_height}; }\n";
}

$webnus_h6_font_color = $webnus_options->webnus_h6_font_color(); 
if( !empty($webnus_h6_font_color) ){
	echo "#wrap h6 { color:{$webnus_h6_font_color}; }\n";
}






/*
 * Color Skin Style Generator
 */

 /* Link Color */
 if(!empty($thm_options['webnus_link_color']))
 	echo "a {color:{$thm_options['webnus_link_color']};}\n\n";
 if(!empty($thm_options['webnus_hover_link_color']))
 	echo "a:hover {color:{$thm_options['webnus_hover_link_color']};}\n\n";	
 if(!empty($thm_options['webnus_visited_link_color']))
 	echo "a:visited {color:{$thm_options['webnus_visited_link_color']};}\n\n";	
 
 
 
 /* == Menu Colors ------------------ */
 
if(!empty($thm_options['webnus_menu_link_color']))	
	echo "#wrap #nav a { color:{$thm_options['webnus_menu_link_color']};}\n\n";

if(!empty($thm_options['webnus_menu_hover_link_color']))
	echo "
		#wrap.pax-t #nav li a:hover,
		#wrap.pax-t #nav li:hover > a,
		#wrap.pax-t #nav li.current > a,
		#wrap.pax-t #header.horizontal-w #nav > li > a:hover,
		#wrap.pax-t #header.horizontal-w #nav > li.current > a,
		.transparent-header-w.t-dark-w .pax-t #header.horizontal-w.duplex-hd #nav > li:hover > a,
		.transparent-header-w .pax-t #header.horizontal-w #nav > li:hover > a,
		
		#wrap.trust-t #nav li a:hover,
		#wrap.trust-t #nav li:hover > a,
		#wrap.trust-t #nav li.current > a,
		#wrap.trust-t #header.horizontal-w #nav > li > a:hover,
		#wrap.trust-t #header.horizontal-w #nav > li.current > a,
		.transparent-header-w.t-dark-w .trust-t #header.horizontal-w.duplex-hd #nav > li:hover > a,
		.transparent-header-w .trust-t #header.horizontal-w #nav > li:hover > a,
		
		#wrap.solace-t #nav li a:hover,
		#wrap.solace-t #nav li:hover > a,
		#wrap.solace-t #nav li.current > a,
		#wrap.solace-t #header.horizontal-w #nav > li > a:hover,
		#wrap.solace-t #header.horizontal-w #nav > li.current > a,
		.transparent-header-w.t-dark-w .solace-t #header.horizontal-w.duplex-hd #nav > li:hover > a,
		.transparent-header-w .solace-t #header.horizontal-w #nav > li:hover > a {color:{$thm_options['webnus_menu_hover_link_color']};}\n\n
		";
if(!empty($thm_options['webnus_menu_selected_link_color']))
	echo "#wrap #nav li.current > a, #wrap #nav li.current ul li a:hover, #wrap #nav li.active > a {color:{$thm_options['webnus_menu_selected_link_color']};}\n\n";
	
if($thm_options['webnus_menu_selected_border_color'])
	echo "#wrap.remittal-t #nav > li.current > a:before, #wrap.pax-t #nav > li.current > a:before {background:{$thm_options['webnus_menu_selected_border_color']};}\n\n";

if($thm_options['webnus_resoponsive_menu_icon_color'])
	echo "#wrap #header.sm-rgt-mn #menu-icon span.mn-ext1, #wrap #header.sm-rgt-mn #menu-icon span.mn-ext2, #wrap #header.sm-rgt-mn #menu-icon span.mn-ext3 {color:{$thm_options['webnus_resoponsive_menu_icon_color']};}\n\n";



/* == Icon Box Colors---------------------- */


if(isset($thm_options['webnus_iconbox_base_color']) && $thm_options['webnus_iconbox_base_color']!='')
{
	echo "#wrap .icon-box  i, #wrap  .icon-box1  i, #wrap .icon-box2 i, #wrap  .icon-box3  i, #wrap  .icon-box4 i, #wrap  .icon-box5 i , #wrap  .icon-box7  i { color:{$thm_options['webnus_iconbox_base_color']};}\n\n";
}

/* learn more link color */

if(isset($thm_options['webnus_learnmore_link_color']) && $thm_options['webnus_learnmore_link_color']!='')
{
	echo "#wrap a.magicmore { color:{$thm_options['webnus_learnmore_link_color']};}\n";
}
/* learn more hover link color */

if(isset($thm_options['webnus_learnmore_hover_link_color']) && $thm_options['webnus_learnmore_hover_link_color']!='')
{
	echo "#wrap a.magicmore:hover { color:{$thm_options['webnus_learnmore_hover_link_color']};}\n";
}




/* == Portfolio Colors---------------------- */


/* portfolio filter links color + border color */
if(isset($thm_options['webnus_portfolio_filter_links_color']) && $thm_options['webnus_portfolio_filter_links_color']!='')
{
	echo "#wrap nav.primary .portfolioFilters a { color:{$thm_options['webnus_portfolio_filter_links_color']};}\n";
}
if(isset($thm_options['webnus_portfolio_filter_links_border_color']) && $thm_options['webnus_portfolio_filter_links_border_color']!='')
{
	echo "#wrap nav.primary .portfolioFilters a { border-color:{$thm_options['webnus_portfolio_filter_links_border_color']};}\n";
}
/* portfolio filter links hover color + border color */

if(isset($thm_options['webnus_portfolio_filter_links_hover_color']) && $thm_options['webnus_portfolio_filter_links_hover_color']!='')
{
	echo "#wrap nav.primary .portfolioFilters a:hover {  color:{$thm_options['webnus_portfolio_filter_links_hover_color']};}\n";
}
if(isset($thm_options['webnus_portfolio_filter_links_hover_border_color']) && $thm_options['webnus_portfolio_filter_links_hover_border_color']!='')
{
	echo "#wrap nav.primary .portfolioFilters a:hover {  border-color:{$thm_options['webnus_portfolio_filter_links_hover_border_color']};}\n";
}

/* portfolio filter links color selected + border color */
if(isset($thm_options['webnus_portfolio_filter_selected_links_color']) && $thm_options['webnus_portfolio_filter_selected_links_color']!='')
{
	echo "#wrap nav.primary .portfolioFilters a.selected, #wrap nav.primary ul li a:active {  color:{$thm_options['webnus_portfolio_filter_selected_links_color']}; }\n";
}

if(isset($thm_options['webnus_portfolio_filter_selected_links_border_color']) && $thm_options['webnus_portfolio_filter_selected_links_border_color']!='')
{
	echo "#wrap nav.primary .portfolioFilters a.selected, #wrap nav.primary ul li a:active {  border-color:{$thm_options['webnus_portfolio_filter_selected_links_border_color']}; }\n";
}



/* portfolio item zoom link color */

if(isset($thm_options['webnus_portfolio_item_zoom_link_color']) && $thm_options['webnus_portfolio_item_zoom_link_color']!='')
{
	echo ".zoomex2 a { color:{$thm_options['webnus_portfolio_item_zoom_link_color']};}\n";
}
/* portfolio item zoom link border color */
if(isset($thm_options['webnus_portfolio_item_zoom_link_border_color']) && $thm_options['webnus_portfolio_item_zoom_link_border_color']!='')
{
	echo ".zoomex2 a i { border-color:{$thm_options['webnus_portfolio_item_zoom_link_border_color']};}\n";
}


/* portfolio item zoom link hover color + border color */
if(isset($thm_options['webnus_portfolio_item_zoom_link_hover_color']) && $thm_options['webnus_portfolio_item_zoom_link_hover_color']!='')
{
	echo "#wrap .zoomex2 a:hover i { color:{$thm_options['webnus_portfolio_item_zoom_link_hover_color']};  }\n";
}
if(isset($thm_options['webnus_portfolio_item_zoom_link_hover_border_color']) && $thm_options['webnus_portfolio_item_zoom_link_hover_border_color']!='')
{
	echo "#wrap .zoomex2 a:hover i { border-color:{$thm_options['webnus_portfolio_item_zoom_link_hover_border_color']};  }\n";
}




/* contact form */

if(isset($thm_options['webnus_contactform_button_color']) && $thm_options['webnus_contactform_button_color']!='')
{
	echo "#wrap #footer .footer-in .contact-inf button, #wrap .contact-form .btnSend {background-color:{$thm_options['webnus_contactform_button_color']};}\n";
}

if(isset($thm_options['webnus_contactform_button_hover_color']) && $thm_options['webnus_contactform_button_hover_color']!='')
{
	echo "#wrap #footer .footer-in .contact-inf button:hover , #wrap .contact-form .btnSend:hover {background-color:{$thm_options['webnus_contactform_button_hover_color']}; border-color:{$thm_options['webnus_contactform_button_hover_color']}; }\n";
}




/* scroll to top */

if(isset($thm_options['webnus_scroll_to_top_background_color']) && $thm_options['webnus_scroll_to_top_background_color']!='')
{
	echo "#wrap #scroll-top a {background-color:{$thm_options['webnus_scroll_to_top_background_color']};}\n";
}

if(isset($thm_options['webnus_scroll_to_top_hover_background_color']) && $thm_options['webnus_scroll_to_top_hover_background_color']!='')
{
	echo "#wrap #scroll-top a:hover {background-color:{$thm_options['webnus_scroll_to_top_hover_background_color']};}\n";
}




/*
 * Blog Loop And Single Blog Styles
 * 
 */
/* All Posts Title Font-family */
$webnus_blog_title_font_family = $webnus_options->webnus_blog_title_font_family(); 
if(!empty($webnus_blog_title_font_family) ){
	echo ".blog-post h4, .blog-post h1, .blog-post h3, .blog-line h4, .blog-single-post h1 { font-family:$webnus_blog_title_font_family;}\n";
}

/* Blog Loop Title font-size */
$webnus_blog_loop_title_font_size = $webnus_options->webnus_blog_loop_title_font_size(); 
if(!empty($webnus_blog_loop_title_font_size) ){
	echo ".blog-post h3 { font-size:{$webnus_blog_loop_title_font_size};}\n";
}

/* Blog Loop Title line-height */
$webnus_blog_loop_title_line_height = $webnus_options->webnus_blog_loop_title_line_height(); 
if(!empty($webnus_blog_loop_title_line_height) ){
	echo ".blog-post h3 { line-height:{$webnus_blog_loop_title_line_height};}\n";
}

/* Blog Loop Title font-weight */
$webnus_blog_loop_title_font_weight = $webnus_options->webnus_blog_loop_title_font_weight(); 
if(!empty($webnus_blog_loop_title_font_weight) ){
	echo ".blog-post h3 { font-weight:{$webnus_blog_loop_title_font_weight};}\n";
}

/* Blog Loop Title letter-spacing */
$webnus_blog_loop_title_letter_spacing = $webnus_options->webnus_blog_loop_title_letter_spacing(); 
if(!empty($webnus_blog_loop_title_letter_spacing) ){
	echo ".blog-post h3 { letter-spacing:{$webnus_blog_loop_title_letter_spacing};}\n";
}

/* Blog Loop Title color */
$webnus_blog_loop_title_color = $webnus_options->webnus_blog_loop_title_color(); 
if(!empty($webnus_blog_loop_title_color) ){
	echo ".blog-post h3, .blog-post h3 a { color:$webnus_blog_loop_title_color;}\n";
}


/* Blog Loop Title hover color */
$webnus_blog_loop_title_hover_color = $webnus_options->webnus_blog_loop_title_hover_color(); 
if(!empty($webnus_blog_loop_title_hover_color) )
{
	echo ".blog-post h3 a:hover { color:$webnus_blog_loop_title_hover_color;}\n";
}

/***** Blog Single Title Font Options *****/

/* Single post Title font-size */

$webnus_blog_single_post_title_font_size = $webnus_options->webnus_blog_single_post_title_font_size(); 
if(!empty($webnus_blog_single_post_title_font_size) )
{
	echo ".blog-single-post h1 { font-size:{$webnus_blog_single_post_title_font_size};}\n";
}


/* Single post Title line-height */

$webnus_blog_single_title_line_height = $webnus_options->webnus_blog_single_title_line_height(); 
if(!empty($webnus_blog_single_title_line_height) )
{
	echo ".blog-single-post h1 { line-height:{$webnus_blog_single_title_line_height};}\n";
}


/* Single post Title font-weight */

$webnus_blog_single_title_font_weight = $webnus_options->webnus_blog_single_title_font_weight(); 
if(!empty($webnus_blog_single_title_font_weight) )
{
	echo ".blog-single-post h1 { font-weight:{$webnus_blog_single_title_font_weight};}\n";
}

/* Single post Title letter-spacing */

$webnus_blog_single_title_letter_spacing = $webnus_options->webnus_blog_single_title_letter_spacing(); 
if(!empty($webnus_blog_single_title_letter_spacing) )
{
	echo ".blog-single-post h1 { letter-spacing:{$webnus_blog_single_title_letter_spacing};}\n";
}


/* Single post Title color */

$webnus_blog_single_title_color = $webnus_options->webnus_blog_single_title_color(); 
if(!empty($webnus_blog_single_title_color) )
{
	echo ".blog-single-post h1 { color:$webnus_blog_single_title_color;}\n";
}


/* Topbar background color */

$topbar_background = $webnus_options->webnus_topbar_background_color();

if(!empty($topbar_background))
	echo ".top-bar { background-color:$topbar_background; }\n";

	
/* footer background color */
$footer_background = $webnus_options->webnus_footer_background_color();

if(!empty($footer_background))
	echo "#wrap #footer { background-color:$footer_background; }\n";

$footer_bottom_background = $webnus_options->webnus_footer_bottom_background_color();

if(!empty($footer_bottom_background))
	echo "#wrap #footer .footbot { background-color:$footer_bottom_background; }\n";



if( $thm_options['webnus_custom_color_skin_enable'] ) { ?>
	/* == TextColors
	---------------- */
	#wrap.colorskin-custom #nav li a:hover, #wrap.colorskin-custom #nav li:hover > a, #wrap.colorskin-custom #nav li.current > a, #wrap.colorskin-custom #header.horizontal-w #nav > li > a:hover, #wrap.colorskin-custom #header.horizontal-w #nav > li.current > a, .transparent-header-w.t-dark-w .colorskin-custom #header.horizontal-w.duplex-hd #nav > li:hover > a, .transparent-header-w .colorskin-custom #header.horizontal-w #nav > li:hover > a, .colorskin-custom .latestposts-seven .wrap-date-icons h3.latest-date, .colorskin-custom .latestposts-seven .latest-content .latest-author a, .colorskin-custom .latestposts-seven .latest-content .latest-title a:hover, .colorskin-custom .our-team h5, .colorskin-custom .blog-single-post .postmetadata h6 a:hover, .colorskin-custom .blog-single-post h6.blog-author a:hover, .colorskin-custom .rec-post h5 a:hover, .colorskin-custom .about-author-sec h5 a:hover, .colorskin-custom .sermons-clean .sermon-detail, .colorskin-custom .max-quote h2:before, .colorskin-custom .max-quote h2:after, .colorskin-custom .max-quote cite, .colorskin-custom .event-clean .event-date, .colorskin-custom .event-clean .event-article:hover .event-title, .colorskin-custom .latestposts-six .latest-title a:hover, .colorskin-custom .latestposts-six .latest-author a:hover, .colorskin-custom .latestposts-five h6.latest-b2-cat a, .colorskin-custom .latestposts-one .latest-title a:hover, .colorskin-custom .pin-ecxt h6.blog-cat a:hover, .colorskin-custom .pin-box h4 a:hover, .colorskin-custom .tline-box h4 a:hover, .colorskin-custom .latestposts-three h6.latest-b2-cat a, .colorskin-custom .latestposts-three h3.latest-b2-title a:hover, .colorskin-custom .latestposts-three .latest-b2-metad2 span a:hover, .colorskin-custom .latestposts-two .blog-line p.blog-cat a, .colorskin-custom .latestposts-two .blog-line a:hover, .colorskin-custom .latestposts-two .blog-line:hover .img-hover:before, .colorskin-custom .latestposts-two .blog-line:hover h4 a, .colorskin-custom .latestposts-two .blog-post p.blog-author a:hover, .colorskin-custom .dpromo .magicmore, .colorskin-custom .testimonial-brand h5 strong, .colorskin-custom .ministry-box2:hover h4, .colorskin-custom .sermons-simple article:hover h4 a, .colorskin-custom .sermons-minimal .sermon-icon, .colorskin-custom .sermons-minimal a:hover h4, .colorskin-custom .sermons-minimal .media-links a:hover i, .colorskin-custom .latestposts-six .latest-content p.latest-date, .colorskin-custom .rec-post h5 a:hover, .colorskin-custom .blog-post a:hover, .colorskin-custom .blog-author span, .colorskin-custom .blog-line p a:hover, .colorskin-custom .blgtyp3.blog-post h6 a:hover, .colorskin-custom .blgtyp1.blog-post h6 a:hover, .colorskin-custom .blgtyp2.blog-post h6 a:hover, .colorskin-custom .sermons-clean h4 a:hover, .colorskin-custom .sermons-clean .media-links a:hover, .colorskin-custom .blog-post h3 a:hover, .colorskin-custom .postmetadata h6 a:hover, .colorskin-custom .event-grid .event-article .event-title:hover, .colorskin-custom .a-sermon h4 a:hover, .colorskin-custom #tribe-events-content .tribe-events-tooltip h4, .colorskin-custom #tribe_events_filters_wrapper .tribe_events_slider_val, .colorskin-custom .single-tribe_events a.tribe-events-gcal, .colorskin-custom .single-tribe_events a.tribe-events-ical, .colorskin-custom .tribe-events-list .type-tribe_events h2 a:hover, .colorskin-custom .tribe-events-list .tribe-events-read-more, .colorskin-custom .tribe-events-event-meta span.event-m, .colorskin-custom .event-grid .event-article .event-title:hover, .colorskin-custom .causes .cause-content .donate-button-exx, .colorskin-custom .cause-box .donate-button, .colorskin-custom .causes .cause-content .cause-title:hover, .colorskin-custom .event-list2 .event-date .event-d, .colorskin-custom .event-list2 .event-title a:hover, .colorskin-custom .teaser-box7:hover h4, .colorskin-custom .latestnews2 .ln-content .ln-title:hover, .colorskin-custom .dark.blox .latestnews2 .ln-content .ln-title:hover
	{ color: <?php echo $thm_options['webnus_custom_color_skin']; ?>}

	/* == Backgrounds
	----------------- */
	.colorskin-custom #header.sm-rgt-mn #menu-icon span.mn-ext1, .colorskin-custom #header.sm-rgt-mn #menu-icon span.mn-ext2, .colorskin-custom #header.sm-rgt-mn #menu-icon span.mn-ext3,
	.colorskin-custom .pin-ecxt2 .col1-3 span, .colorskin-custom .comments-number-x span, .colorskin-custom .side-list li:hover img, .colorskin-custom .subscribe-box .subscribe-box-top, .colorskin-custom .event-clean .event-article:hover .event-date, .colorskin-custom .teaser-box7 h4:before, .remittal-t.colorskin-custom #nav ul, .colorskin-custom .event-list .event-date, .colorskin-custom .latestposts-seven .latest-img:hover img, .colorskin-custom #nav > li.current > a:before, .colorskin-custom .max-hero h5:before, .colorskin-custom .ministry-box2:hover img, .colorskin-custom .sermons-simple article:hover .sermon-img img,	 .colorskin-custom .a-sermon .sermon-img:hover img, .colorskin-custom .a-sermon .media-links, .colorskin-custom .event-grid .event-detail, .colorskin-custom .teaser-box4 .teaser-title, .colorskin-custom .magic-link a, .colorskin-custom .subscribe-flat .subscribe-box-input .subscribe-box-submit, .colorskin-custom .w-callout.w-callout-b, .colorskin-custom .top-bar .topbar-login, .colorskin-custom .icon-box4:hover i, .colorskin-custom .icon-box12 i, .colorskin-custom .teaser-box4 .teaser-title, .colorskin-custom .magic-link a, .colorskin-custom #tribe-events-content-wrapper .tribe-events-calendar td:hover, .colorskin-custom #tribe-events-content-wrapper .tribe-events-sub-nav a:hover, .colorskin-custom #tribe-events-content-wrapper #tribe-bar-form .tribe-events-button, .colorskin-custom .tribe-events-list .booking-button, .colorskin-custom .tribe-events-list .event-sharing > li:hover, .colorskin-custom .tribe-events-list .event-sharing .event-share:hover .event-sharing-icon, .colorskin-custom .tribe-events-list .event-sharing .event-social li a, .colorskin-custom #tribe-events-pg-template .tribe-events-button, .colorskin-custom .single-tribe_events .booking-button, .colorskin-custom .event-grid .event-detail, .colorskin-custom .causes .cause-content .donate-button-exx:hover, .colorskin-custom .cause-box .donate-button:hover, .colorskin-custom .tribe-events-list-separator-month span, .colorskin-custom .flip-clock-wrapper ul, .colorskin-custom .flip-clock-wrapper ul li a div div.inn, .colorskin-custom .latestnews2 .ln-date .ln-month 
	{ background-color: <?php echo $thm_options['webnus_custom_color_skin']; ?>}

	/* == BorderColors
	------------------ */
	.colorskin-custom .wpcf7 .wpcf7-form input[type="text"]:hover, .colorskin-custom .wpcf7 .wpcf7-form input[type="password"]:hover, .colorskin-custom .wpcf7 .wpcf7-form input[type="email"]:hover, .colorskin-custom .wpcf7 .wpcf7-form textarea:hover,	.colorskin-custom .subtitle-four:after, .colorskin-custom .widget h4.subtitle:after, .colorskin-custom h6.h-sub-content, .colorskin-custom .max-title1 *, .colorskin-custom .sermons-clean .sermon-img:hover, .colorskin-custom #header.box-menu .nav-wrap2 #nav > li ul, .colorskin-custom #header.box-menu .nav-wrap2 #nav > li:hover, .colorskin-custom #header.box-menu .nav-wrap2 #nav > li > ul, .colorskin-custom #header.box-menu .nav-wrap2 #nav > li.current, .colorskin-custom .event-clean .event-article:hover .event-date, .colorskin-custom .teaser-box7 h4:before, .remittal-t.colorskin-custom #nav ul 
	{ border-color: <?php echo $thm_options['webnus_custom_color_skin']; ?>}
<?php } 


/*
 * Custom CSS
*/
echo strip_tags($webnus_options->webnus_custom_css());

$out = $GLOBALS['webnus_dyncss'] = '';
$out = ob_get_contents();
$out = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $out);
$GLOBALS['webnus_dyncss'] = str_replace(array("\r\n", "\r", "\n", "\t", '    '), '', $out);
ob_end_clean();

?>