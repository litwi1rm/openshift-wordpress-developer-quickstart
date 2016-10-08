<?php GLOBAL $webnus_options; 
/***************************************/
/*	Close  head line if woocommerce available
/***************************************/		
if( isset($post) ){
	if( 'product' == get_post_type( $post->ID )){
		echo '</section>';
	}
}
$footer_show = 'true';
if(isset($post)){
	GLOBAL $webnus_page_options_meta;
	$footer_show_meta = isset($webnus_page_options_meta)?$webnus_page_options_meta->the_meta():null;
	$footer_show =(isset($footer_show_meta) && is_array($footer_show_meta) && isset($footer_show_meta['webnus_page_options'][0]['webnus_footer_show']))?$footer_show_meta['webnus_page_options'][0]['webnus_footer_show']:null;
} ?>	
<section id="pre-footer">	
<?php //start footer bars
if( $webnus_options->webnus_footer_instagram_bar() )
	get_template_part('parts/instagram-bar');
if( $webnus_options->webnus_footer_social_bar() )
	get_template_part('parts/social-bar');
if( $webnus_options->webnus_footer_subscribe_bar() )
	get_template_part('parts/subscribe-bar');
?>
</section>
<?php 
if ($footer_show != 'false') : ?>
	<footer id="footer" <?php if( $webnus_options->webnus_footer_color() == 2 ) echo 'class="litex"';?>>
	<section class="container footer-in">
	<div class="row">
	<?php $footer_type = $webnus_options->webnus_footer_type();
	switch($footer_type){
	case 1: ?>
	<div class="col-md-4"><?php dynamic_sidebar('footer-section-1'); ?></div>
	<div class="col-md-4"><?php dynamic_sidebar('footer-section-2'); ?></div>
	<div class="col-md-4"><?php dynamic_sidebar('footer-section-3'); ?></div>
	<?php break;
	case 2: ?>
	<div class="col-md-3"><?php dynamic_sidebar('footer-section-1'); ?></div>
	<div class="col-md-3"><?php dynamic_sidebar('footer-section-2'); ?></div>
	<div class="col-md-3"><?php dynamic_sidebar('footer-section-3'); ?></div>
	<div class="col-md-3"><?php dynamic_sidebar('footer-section-4'); ?></div>
	<?php break;
	case 3: ?>
	<div class="col-md-6"><?php dynamic_sidebar('footer-section-1'); ?></div>
	<div class="col-md-3"><?php dynamic_sidebar('footer-section-2'); ?></div>
	<div class="col-md-3"><?php dynamic_sidebar('footer-section-3'); ?></div>
	<?php break;
	case 4: ?>
	<div class="col-md-3"><?php dynamic_sidebar('footer-section-1'); ?></div>
	<div class="col-md-3"><?php dynamic_sidebar('footer-section-2'); ?></div>
	<div class="col-md-6"><?php dynamic_sidebar('footer-section-3'); ?></div>
	<?php break;
	case 5: ?>
	<div class="col-md-6"><?php dynamic_sidebar('footer-section-1'); ?></div>
	<div class="col-md-6"><?php dynamic_sidebar('footer-section-2'); ?></div>
	<?php break;
	case 6: ?>
	<div class="col-md-12"><?php dynamic_sidebar('footer-section-1'); ?></div>
	<?php break;
	 } ?>
	 </div>
	 </section>
	<!-- end-footer-in -->
	<?php if( $webnus_options->webnus_footer_bottom_enable() )
		get_template_part('parts/footer','bottom'); ?>
	<!-- end-footbot -->
	</footer>
	<!-- end-footer -->
<?php endif; ?>
<span id="scroll-top"><a class="scrollup"><i class="fa-chevron-up"></i></a></span></div>
<!-- end-wrap -->
<!-- End Document
================================================== -->
<?php
// sticky menu
GLOBAL $webnus_options;
$is_sticky = $webnus_options->webnus_header_sticky();
$scrolls_value = $webnus_options->webnus_header_sticky_scrolls();
$scrolls_value = !empty($scrolls_value) ? $scrolls_value : 150;
if( $is_sticky == '1' ) :
	echo '<script type="text/javascript">
		jQuery(document).ready(function(){ 
			jQuery(function() {
				var header = jQuery("#header.horizontal-w");
				var navHomeY = header.offset().top;
				var isFixed = false;
				var scrolls_pure = parseInt("' . $scrolls_value . '");
				var $w = jQuery(window);
				$w.scroll(function(e) {
					var scrollTop = $w.scrollTop();
					var shouldBeFixed = scrollTop > scrolls_pure;
					if (shouldBeFixed && !isFixed) {
						header.addClass("sticky");
						isFixed = true;
					}
					else if (!shouldBeFixed && isFixed) {
						header.removeClass("sticky");
						isFixed = false;
					}
					e.preventDefault();
				});
			});
		});
	</script>';
endif;
echo esc_html($webnus_options->webnus_space_before_body());
wp_footer(); ?>
</body>
</html>