<section class="top-bar">
<div class="container">
<?php
	function webnus_topbar($pos){
		GLOBAL $webnus_options;
		$class=($pos=='left')?'lftflot':'rgtflot';
		echo '<div class="top-links '.$class.'">';
		
		if($webnus_options->webnus_topbar_search()==$pos){
			echo '<form id="topbar-search" role="search" action="'.esc_url(home_url( '/' )).'" method="get" ><input name="s" type="text" class="search-text-box" ><i class="search-icon fa-search"></i></form>';
		}
		
		if ($webnus_options->webnus_topbar_social()==$pos){
			echo '<div class="socialfollow">';
			get_template_part('parts/topbar','social' );
			echo '</div>';
		}
		
		if ($webnus_options->webnus_topbar_login()==$pos){
			$login_text = $webnus_options->webnus_topbar_login_text();
			if ( is_user_logged_in() ) {
				global $user_identity;
				$login_text = esc_html__('Welcome ','webnus_framework') . esc_html($user_identity);
			}
			echo '<a href="#w-login" class="inlinelb topbar-login" target="_self">'.esc_html($login_text).'</a>
			<div style="display:none"><div id="w-login" class="w-login">';
			webnus_login();
			echo '</div></div>';
		}
		
		if($webnus_options->webnus_topbar_contact()==$pos){ 
			echo'<a class="inlinelb topbar-contact" href="#w-contact" target="_self">'.esc_html__('CONTACT','webnus_framework').'</a>';
		}
		
		if ($webnus_options->webnus_topbar_info()==$pos){	
			echo '<h6><i class="fa-envelope-o"></i>'. esc_html($webnus_options->webnus_topbar_email()) .'</h6> <h6><i class="fa-phone"></i>'. esc_html($webnus_options->webnus_topbar_phone()).'</h6>';
		}
		
		if ($webnus_options->webnus_topbar_menu()==$pos && has_nav_menu('header-top-menu')){
				$menuParameters = array('theme_location' => 'header-top-menu','container' => 'false','menu_id' => 'nav','depth' => '5','items_wrap' => '<ul id="%1$s">%3$s</ul>',);
				echo strip_tags(wp_nav_menu( $menuParameters ), '<a>' );
		}

		if ($webnus_options->webnus_topbar_custom()==$pos){	
			echo esc_html($webnus_options->webnus_topbar_text());
		}
		
		if ($webnus_options->webnus_topbar_language()==$pos){				
			do_action('icl_language_selector');
		}
		echo'</div>';
	}
	webnus_topbar('left');
	webnus_topbar('right');
?>
</div>
</section>