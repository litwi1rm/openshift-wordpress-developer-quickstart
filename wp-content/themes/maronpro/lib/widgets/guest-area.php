<?php

//Featured Guest Area

 	global $app_options;

	$fg_headline		= $app_options[ 'fg-headline' ];
	$sq_round			= $app_options[ 'sq-round' ];
	$pcast_img			= $app_options[ 'pcast-img' ][ 'url' ];
	$pcast_img_w		= $app_options[ 'pcast-img' ][ 'width' ];
	$pcast_img_h		= $app_options[ 'pcast-img' ][ 'height' ];
	$pcast_link			= $app_options[ 'pcast-link' ];
	$pcast_name			= $app_options[ 'pcast-name' ];	
	$pcast_win			= $app_options[ 'pcast-new-win' ];	
	$guest_one_img		= $app_options[ 'guest-one-img' ][ 'thumbnail' ];
	$guest_one_link		= $app_options[ 'guest-one-link' ];
	$guest_one_name		= $app_options[ 'guest-one-name' ];	
	$guest_one_win		= $app_options[ 'g-one-new-win' ];	
	$guest_two_img		= $app_options[ 'guest-two-img' ][ 'thumbnail' ];
	$guest_two_link		= $app_options[ 'guest-two-link' ];
	$guest_two_name		= $app_options[ 'guest-two-name' ];
	$guest_two_win		= $app_options[ 'g-two-new-win' ];	
	$guest_three_img	= $app_options[ 'guest-three-img' ][ 'thumbnail' ];
	$guest_three_link	= $app_options[ 'guest-three-link' ];
	$guest_three_name	= $app_options[ 'guest-three-name' ];
	$guest_three_win	= $app_options[ 'g-three-new-win' ];	
	$guest_four_img		= $app_options[ 'guest-four-img' ][ 'thumbnail' ];
	$guest_four_link	= $app_options[ 'guest-four-link' ];
	$guest_four_name	= $app_options[ 'guest-four-name' ];
	$guest_four_win		= $app_options[ 'g-four-new-win' ];	
	$guest_five_img		= $app_options[ 'guest-five-img' ][ 'thumbnail' ];
	$guest_five_link	= $app_options[ 'guest-five-link' ];
	$guest_five_name	= $app_options[ 'guest-five-name' ];
	$guest_five_win		= $app_options[ 'g-five-new-win' ];	
    
		echo '<div class="guest-area">';
		
			echo '<div class="wrap">';
			
				//* Featured Guest Headline
				if( $fg_headline ) {
			
					echo '<h3>' . $fg_headline . '</h3>';
				
				}
				
				//echo '<div class="outer">';
				
					//echo '<div class="inner">';
						
						echo '<ul>';
				
							//* Podcast Artwork
							if( $pcast_img && $pcast_link ) {
						
								echo '<li class="pcast-art">';
												
									echo '<a ' . (( $pcast_win == 1 ) ? 'target="_blank" ' : '') . 'href="' . $pcast_link . '" title="' . $pcast_name . '">';
											
										echo '<img style="border-radius: ' . $sq_round . '%;" class="aligncenter" src="' . $pcast_img . '" width="' . $pcast_img_w . '" height="' . $pcast_img_h . '"/>';
												
									echo '</a>';
									
								echo '</li>';
							
							}
						
							//* Guest One Section
							if( $guest_one_img && $guest_one_link ) {
							
								echo '<li>';
										
									echo '<a ' . (( $guest_one_win == 1 ) ? 'target="_blank" ' : '') . 'href="' . $guest_one_link . '" title="' . $guest_one_name . '">';
									
										echo '<img style="border-radius: ' . $sq_round . '%;" class="aligncenter" src="' . $guest_one_img . '" width="150"/>';
										
										if( $guest_one_name ) {
											
											echo '<span class="name">' . $guest_one_name . '</span>';
											
										}
										
									echo '</a>';
									
								echo '</li>';
								
							}
							
							if( $guest_one_img && empty( $guest_one_link ) ) {
							
								echo '<li>';
										
									echo '<div class="no-link">';
									
										echo '<img style="border-radius: ' . $sq_round . '%;" class="aligncenter" src="' . $guest_one_img . '" width="150"/>';
										
										if( $guest_one_name ) {
											
											echo '<span class="name">' . $guest_one_name . '</span>';
											
										}
										
									echo '</div>';
									
								echo '</li>';
								
							}
							
							if( empty( $guest_one_img ) && $guest_one_link && $guest_one_name ) {
							
								echo '<li>';
										
									echo '<a class="no-img" ' . (( $guest_one_win == 1 ) ? 'target="_blank" ' : '') . 'href="' . $guest_one_link . '" title="' . $guest_one_name . '">';
											
										echo '<span class="name">' . $guest_one_name . '</span>';
										
									echo '</a>';
									
								echo '</li>';
								
							}
		
							//* Guest Two Section
							if( $guest_two_img && $guest_two_link ) {
							
								echo '<li>';
										
									echo '<a ' . (( $guest_two_win == 1 ) ? 'target="_blank" ' : '') . 'href="' . $guest_two_link . '" title="' . $guest_two_name . '">';
									
										echo '<img style="border-radius: ' . $sq_round . '%;" class="aligncenter" src="' . $guest_two_img . '" width="150"/>';
										
										if( $guest_two_name ) {
											
											echo '<span class="name">' . $guest_two_name . '</span>';
											
										}
										
									echo '</a>';
									
								echo '</li>';
								
							} 
							
							if( $guest_two_img && empty( $guest_two_link ) ) {
							
								echo '<li>';
										
									echo '<div class="no-link">';
									
										echo '<img style="border-radius: ' . $sq_round . '%;" class="aligncenter" src="' . $guest_two_img . '" width="150"/>';
										
										if( $guest_two_name ) {
											
											echo '<span class="name">' . $guest_two_name . '</span>';
											
										}
										
									echo '</div>';
									
								echo '</li>';
								
							}
							
							if( empty( $guest_two_img ) && $guest_two_link && $guest_two_name ) {
							
								echo '<li>';
										
									echo '<a class="no-img" ' . (( $guest_two_win == 1 ) ? 'target="_blank" ' : '') . 'href="' . $guest_two_link . '" title="' . $guest_two_name . '">';
											
										echo '<span class="name">' . $guest_two_name . '</span>';
										
									echo '</a>';
									
								echo '</li>';
								
							}
						
							//* Guest Three Section
							if( $guest_three_img && $guest_three_link ) {
							
								echo '<li>';
										
									echo '<a ' . (( $guest_three_win == 1 ) ? 'target="_blank" ' : '') . 'href="' . $guest_three_link . '" title="' . $guest_three_name . '">';
									
										echo '<img style="border-radius: ' . $sq_round . '%;" class="aligncenter" src="' . $guest_three_img . '" width="150"/>';
										
										if( $guest_three_name ) {
											
											echo '<span class="name">' . $guest_three_name . '</span>';
											
										}
										
									echo '</a>';
									
								echo '</li>';
								
							} 
							
							if( $guest_three_img && empty( $guest_three_link ) ) {
							
								echo '<li>';
										
									echo '<div class="no-link">';
									
										echo '<img style="border-radius: ' . $sq_round . '%;" class="aligncenter" src="' . $guest_three_img . '" width="150"/>';
										
										if( $guest_three_name ) {
											
											echo '<span class="name">' . $guest_three_name . '</span>';
											
										}
										
									echo '</div>';
									
								echo '</li>';
								
							}
							
							if( empty( $guest_three_img ) && $guest_three_link && $guest_three_name ) {
							
								echo '<li>';
										
									echo '<a class="no-img" ' . (( $guest_three_win == 1 ) ? 'target="_blank" ' : '') . 'href="' . $guest_three_link . '" title="' . $guest_three_name . '">';
											
										echo '<span class="name">' . $guest_three_name . '</span>';
										
									echo '</a>';
									
								echo '</li>';
								
							}
						
							//* Guest Four Section
							if( $guest_four_img && $guest_four_link ) {
							
								echo '<li>';
										
									echo '<a ' . (( $guest_four_win == 1 ) ? 'target="_blank" ' : '') . 'href="' . $guest_four_link . '" title="' . $guest_four_name . '">';
									
										echo '<img style="border-radius: ' . $sq_round . '%;" class="aligncenter" src="' . $guest_four_img . '" width="150"/>';
										
										if( $guest_four_name ) {
											
											echo '<span class="name">' . $guest_four_name . '</span>';
											
										}
										
									echo '</a>';
									
								echo '</li>';
								
							} 
							
							if( $guest_four_img && empty( $guest_four_link ) ) {
							
								echo '<li>';
										
									echo '<div class="no-link">';
									
										echo '<img style="border-radius: ' . $sq_round . '%;" class="aligncenter" src="' . $guest_four_img . '" width="150"/>';
										
										if( $guest_four_name ) {
											
											echo '<span class="name">' . $guest_four_name . '</span>';
											
										}
										
									echo '</div>';
									
								echo '</li>';
								
							}
							
							if( empty( $guest_four_img ) && $guest_four_link && $guest_four_name ) {
							
								echo '<li>';
										
									echo '<a class="no-img" ' . (( $guest_four_win == 1 ) ? 'target="_blank" ' : '') . 'href="' . $guest_four_link . '" title="' . $guest_four_name . '">';
											
										echo '<span class="name">' . $guest_four_name . '</span>';
										
									echo '</a>';
									
								echo '</li>';
								
							}
		
							//* Guest Five Section
							if( $guest_five_img && $guest_five_link ) {
							
								echo '<li>';
										
									echo '<a ' . (( $guest_five_win == 1 ) ? 'target="_blank" ' : '') . 'href="' . $guest_five_link . '" title="' . $guest_five_name . '">';
									
										echo '<img style="border-radius: ' . $sq_round . '%;" class="aligncenter" src="' . $guest_five_img . '" width="150"/>';
										
										if( $guest_five_name ) {
											
											echo '<span class="name">' . $guest_five_name . '</span>';
											
										}
										
									echo '</a>';
									
								echo '</li>';
								
							} 
							
							if( $guest_five_img && empty( $guest_five_link ) ) {
							
								echo '<li>';
										
									echo '<div class="no-link">';
									
										echo '<img style="border-radius: ' . $sq_round . '%;" class="aligncenter" src="' . $guest_five_img . '" width="150"/>';
										
										if( $guest_five_name ) {
											
											echo '<span class="name">' . $guest_five_name . '</span>';
											
										}
										
									echo '</div>';
									
								echo '</li>';
								
							}
							
							if( empty( $guest_five_img ) && $guest_five_link && $guest_five_name ) {
							
								echo '<li>';
										
									echo '<a class="no-img" ' . (( $guest_five_win == 1 ) ? 'target="_blank" ' : '') . 'href="' . $guest_five_link . '" title="' . $guest_five_name . '">';
											
										echo '<span class="name">' . $guest_five_name . '</span>';
										
									echo '</a>';
									
								echo '</li>';
								
							}
			
						echo '</ul>';
				
					//echo '</div><!-- end .inner -->';
					
				//echo '</div><!-- end .outer -->';
				
			echo '</div><!-- end .wrap -->';
			
		echo '</div><!-- end .guest-area -->';