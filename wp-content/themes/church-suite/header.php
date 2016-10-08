<?php
GLOBAL $webnus_options; //Globalization $woptions
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
?>
<!DOCTYPE html>
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo('charset');?>">		
	<meta name="author" content="<?php 
		if( !is_single() )
			echo esc_attr(get_bloginfo('name'));
		else {
			global $post;
			if(isset($post) && is_object($post))
			{	
			$flname = get_the_author_meta('first_name',$post->post_author). ' ' . get_the_author_meta('last_name',$post->post_author);
			$flname = trim($flname);
			if (empty($flname)) 
				the_author_meta('display_name',$post->post_author);
			else 
				echo esc_html($flname);	
			}
		}
	?>">

	<?php //Mobile Specific Metas
	if($webnus_options->webnus_enable_responsive()){ ?>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php } else { ?>
	<meta name="viewport" content="width=1200,user-scalable=yes">
	<?php } ?>


	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/modernizr.custom.11889.js" type="text/javascript"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/respond.js" type="text/javascript"></script>
	<![endif]-->

<?php // Site Icon
if(!function_exists( 'has_site_icon' ) || ! has_site_icon() ) {
	echo($webnus_options->webnus_apple_iphone_icon())?'<link rel="apple-touch-icon-precomposed" href="'.esc_url($webnus_options->webnus_apple_iphone_icon()).'">':'';
	echo($webnus_options->webnus_apple_ipad_icon())?'<link rel="apple-touch-icon-precomposed" sizes="72x72" href="'.esc_url($webnus_options->webnus_apple_ipad_icon()).'">':'';
	echo($webnus_options->webnus_fav_icon())?'<link rel="shortcut icon" href="'.esc_url($webnus_options->webnus_fav_icon()).'">':'<link rel="shortcut icon" href="'.esc_url(get_template_directory_uri()).'/images/favicon.ico">';
} ?>


<?php wp_head();  // CSS + JS ?>
</head>


	<?php // Transparent Header
	$transparent_header = '';
	if(is_page()){
		GLOBAL $webnus_page_options_meta;
		$transparent_header_meta = isset($webnus_page_options_meta)?$webnus_page_options_meta->the_meta():null;
		$transparent_header =(isset($transparent_header_meta) && is_array($transparent_header_meta) && isset($transparent_header_meta['webnus_page_options'][0]['webnus_transparent_header']))?$transparent_header_meta['webnus_page_options'][0]['webnus_transparent_header']:null;
	}
	$transparent_header_class = ($transparent_header=='light')?' transparent-header-w':'';
	$transparent_header_class .= ($transparent_header=='dark')?' transparent-header-w t-dark-w':'';
	?>


	<?php // Post Show
	$postshow_class='';
	if (is_single()){
			global $blogpost_meta;
			$post_meta = $blogpost_meta->the_meta();
			if(!empty($post_meta)){
				if($post_meta['style_type']=="postshow1" && $thumbnail_id = get_post_thumbnail_id()){
					$postshow_class = " postshow1-hd transparent-header-w t-dark-w";
				} elseif ( $post_meta['style_type']=="postshow2" && $thumbnail_id = get_post_thumbnail_id() ) {
					$postshow_class = " postshow2-hd";
				}
			}
		}
	?>

	
	<?php
		$topbar_has =($webnus_options->webnus_header_topbar_enable())?' has-topbar-w':'';
		$topbar_fixed =($webnus_options->webnus_topbar_fixed())?' topbar-fixed':'';
	?>

<body <?php body_class($topbar_has . $topbar_fixed . $transparent_header_class . $postshow_class); ?>>


	<!-- Primary Page Layout
	================================================== -->
<div id="wrap" class="<?php echo($webnus_options->webnus_color_skin())?'colorskin-'.$webnus_options->webnus_color_skin().'':'';
echo($webnus_options->webnus_template_select())? ' '.$webnus_options->webnus_template_select().'-t ':'';
echo(($webnus_options->webnus_header_menu_type() != 6) && ($webnus_options->webnus_header_menu_type() != 7))? $webnus_options->webnus_get_layout():''; 
echo($webnus_options->webnus_header_menu_type() == 0)? ' no-menu-header':'';
echo($webnus_options->webnus_header_menu_type() == 6)? ' vertical-header-enabled':'';
echo($webnus_options->webnus_header_menu_type() == 7)? ' vertical-toggle-header-enabled':'';
echo($webnus_options->webnus_dark_submenu())? ' dark-submenu':'';
?>">

<?php
if( $webnus_options->webnus_toggle_toparea_enable() )
{
?>	
	<section class="toggle-top-area" >
		<div class="w_toparea container">
			<div class="col-md-3">
				<?php dynamic_sidebar('top-area-1'); ?>
			</div>
			<div class="col-md-3">
				<?php dynamic_sidebar('top-area-2'); ?>
			</div>
			<div class="col-md-3">
				<?php dynamic_sidebar('top-area-3'); ?>
			</div>	
			<div class="col-md-3">
				<?php dynamic_sidebar('top-area-4'); ?>
			</div>				
		</div>
		<a class="w_toggle" href="#"></a>
	</section>
<?php
}	


// Top Bar
 if($webnus_options->webnus_header_topbar_enable())
	get_template_part('parts/topbar');

// Menu Type
 $menu_type = $webnus_options->webnus_header_menu_type();
 switch($menu_type){
 	case 0:
	case 2:
	case 3:
	case 4:
	case 5:
		get_template_part('parts/header2');
	break;
	case 6:
	case 7:
		get_template_part('parts/header3');
	break;
	case 8:
		get_template_part('parts/header4');
	break;
	case 9:
	get_template_part('parts/header2');
	break;
	default: //case: 1
		get_template_part('parts/header1');
	break;
 }
 
// News Ticker
 if($webnus_options->webnus_news_ticker())
	get_template_part('parts/news-ticker');
	
	
// Modal Contact Form	
$form_id=esc_html($webnus_options->webnus_topbar_form());
echo '<div style="display:none"><div class="w-modal modal-contact" id="w-contact"><h3 class="modal-title">'.esc_html__('CONTACT US','webnus_framework').'</h3><br>'.do_shortcode('[contact-form-7 id="'.$form_id.'" title="Contact"]').'</div></div>';


/***************************************/
/*	If woocommerce available add page headline section.
/***************************************/
if(isset($post) && 'product' == get_post_type( $post->ID ))
{
if( ((function_exists('is_product') && is_product()) && $webnus_options->webnus_woo_product_title_enable()) ){
?>
<section id="headline">
    <div class="container">
      <h2><?php 
	  if( function_exists('is_product') ){
	  if( is_product() )
		echo esc_html($webnus_options->webnus_woo_product_title()) ;
	  }
	  ?></h2>
    </div>
</section><?php
	}
if((function_exists('is_product') && !is_product()) && $webnus_options->webnus_woo_shop_title_enable())
{?>
	<section id="headline">
    <div class="container">
      <h2><?php 
		echo esc_html($webnus_options->webnus_woo_shop_title()) ;  
	  ?></h2>
    </div>
</section>
<?php }
/***************************************/
/*			End woocommerce section
/***************************************/
?>
<section class="container" >
<!-- Start Page Content -->
<hr class="vertical-space">
<?php
}
?>