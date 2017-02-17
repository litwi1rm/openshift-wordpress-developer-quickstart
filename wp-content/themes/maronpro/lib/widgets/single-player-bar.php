<?php

// Single Player Bar Template

	global $app_options, $post;

	$showpwd_s 		= $app_options[ 'mp-showpwd' ];
	$showsp 		= $app_options[ 'showsp' ];
	$podcast 		= get_post_meta(get_the_ID(), 'podcast', true);
	$podcast_embed 	= get_post_meta(get_the_ID(), '_cmb_podcast_embed', true);
	$hide_main_play = get_post_meta(get_the_ID(), '_cmb_hide_main_play', true);
	/*$mp_bg_image	= get_post_meta( get_the_ID(), '_cmb_mp_bg_image', true );
	$feat_img 		= wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
	$default_img	= $app_options[ 'player-bg' ][ 'url' ];*/
	
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
			$player_short = do_shortcode( '[app_audio src="' . preg_replace( '/.mp3.*/', '.mp3', $ppdata['url'] ) . '"]' );
		}
	} else {
			$filetype = NULL;
	}
	
	if ( class_exists( 'wp_simplepodcastpress' ) ) {
		$spp_podcast = get_post_meta( get_the_ID(), '_audiourl', true );
	} else {
		$spp_podcast = NULL;
	}

	if ( ( $showsp == 1 ) && $podcast || $ppdata || $podcast_embed ) {

			remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
			remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
			//remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
			remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

	}

	if ( $podcast && empty( $hide_main_play ) && empty( $podcast_embed ) ) { ?>
    
	<div id="player-bar">
   	 	<div class="outer-wrap">
            <div class="wrap">
            	<div class="inner-wrap<?php echo ( is_active_sidebar( 'player_bar' ) ) ? ' waa' : ''; ?>">
                    <h2 class="post-title" itemprop="headline"><?php the_title(); ?></h2>
                    <div class="mp-content">
                        <div class="player">
                            <?php echo do_shortcode('[app_audio src="' . preg_replace( '/.mp3.*/', '.mp3', $podcast ) . '"]'); ?>
                        </div><!-- end .player -->
                    </div><!-- end .mp-content -->
                    <?php
                        echo '<div class="share-icon"><i class="icon-share"></i></div>';
                        echo '<div class="side-share">';
                        	include ( CHILD_DIR . "/lib/admin/app-share.php" );
                    	echo '</div>';
                    
					if ( $showpwd_s == 1 ) {
                    	echo '<div class="play-dnld">';         
							echo '<a rel="nofollow" target="_blank" href="' . $podcast . '" title="Play Podcast Episode in New Window">Play in New Window</a>';
							echo '<span class="divider">|</span>';
							echo '<a rel="nofollow" href="' . $podcast . '" title="Download Podcast Episode" download="' . $p_file . '">Download</a>';
                    	echo '</div><!-- end .play-dnld -->';
                    } ?>
                </div><!-- end .inner-wrap -->
                <?php if ( is_active_sidebar( 'player_bar' ) ) {
						echo '<div class="pb-widget">';
							dynamic_sidebar( 'player_bar' );
						echo '</div><!-- end .pb-widget -->';
				} ?>
                </div><!-- end .inner-wrap -->
            </div><!-- end .wrap -->
        </div><!-- end .outer-wrap -->
    </div><!-- end #player-bar -->
    
	<?php 
	
	} elseif ( $ppdata['url'] && empty( $ppdata['embed'] ) && empty( $hide_main_play ) ) { ?>
    
	<div id="player-bar">
   	 	<div class="outer-wrap">
            <div class="wrap">
            	<div class="inner-wrap<?php echo ( is_active_sidebar( 'player_bar' ) ) ? ' waa' : ''; ?>">
                    <h2 class="post-title" itemprop="headline"><?php the_title(); ?></h2>
                    <div class="mp-content">
                        <div class="player">
                            <?php echo $player_short; ?>
                        </div><!-- end .player -->
                    </div><!-- end .mp-content -->
                    <?php
                        echo '<div class="share-icon"><i class="icon-share"></i></div>';
                        echo '<div class="side-share">';
                        	include ( CHILD_DIR . "/lib/admin/app-share.php" );
                    	echo '</div>';
                    
					if ( $showpwd_s == 1 ) {
                    	echo '<div class="play-dnld">';         
							echo '<a rel="nofollow" target="_blank" href="' . $ppdata['url'] . '" title="Play Podcast Episode in New Window">Play in New Window</a>';
							echo '<span class="divider">|</span>';
							echo '<a rel="nofollow" href="' . $ppdata['url'] . '" title="Download Podcast Episode" download="' . basename( $ppdata['url'] ) . '">Download</a>';
                    	echo '</div><!-- end .play-dnld -->';
                    } ?>
                </div><!-- end .inner-wrap -->
                <?php if ( is_active_sidebar( 'player_bar' ) ) {
						echo '<div class="pb-widget">';
							dynamic_sidebar( 'player_bar' );
						echo '</div><!-- end .pb-widget -->';
				} ?>
            </div><!-- end .wrap -->
        </div><!-- end .outer-wrap -->
    </div><!-- end #player-bar -->
    
	<?php 
	
	} elseif ( $spp_podcast && empty( $hide_main_play ) ) { ?>
    
	<div id="player-bar">
   	 	<div class="outer-wrap">
            <div class="wrap">
            	<div class="inner-wrap<?php echo ( is_active_sidebar( 'player_bar' ) ) ? ' waa' : ''; ?>">
                    <h2 class="post-title" itemprop="headline"><?php the_title(); ?></h2>
                    <div class="mp-content">
                        <div class="player">
                            <?php echo do_shortcode('[app_audio src="' . preg_replace( '/.mp3.*/', '.mp3', $spp_podcast ) . '"]'); ?>
                        </div><!-- end .player -->
                    </div><!-- end .mp-content -->
                    <?php
                        echo '<div class="share-icon"><i class="icon-share"></i></div>';
                        echo '<div class="side-share">';
                        	include ( CHILD_DIR . "/lib/admin/app-share.php" );
                    	echo '</div>';
                    
					if ( $showpwd_s == 1 ) {
                    	echo '<div class="play-dnld">';         
							echo '<a rel="nofollow" target="_blank" href="' . $spp_podcast . '" title="Play Podcast Episode in New Window">Play in New Window</a>';
							echo '<span class="divider">|</span>';
							echo '<a rel="nofollow" href="' . $spp_podcast . '" title="Download Podcast Episode" download="' . basename( $spp_podcast ) . '">Download</a>';
                    	echo '</div><!-- end .play-dnld -->';
                    } ?>
                </div><!-- end .inner-wrap -->
                <?php if ( is_active_sidebar( 'player_bar' ) ) {
						echo '<div class="pb-widget">';
							dynamic_sidebar( 'player_bar' );
						echo '</div><!-- end .pb-widget -->';
				} ?>
                </div><!-- end .inner-wrap -->
            </div><!-- end .wrap -->
        </div><!-- end .outer-wrap -->
    </div><!-- end #player-bar -->
    
	<?php 
	
	} elseif ( $podcast_embed && empty( $hide_main_play ) ) { ?>
    
	<div id="player-bar">
   	 	<div class="outer-wrap">
            <div class="wrap">
            	<div class="inner-wrap<?php echo ( is_active_sidebar( 'player_bar' ) ) ? ' waa' : ''; ?>">
                        <h2 class="post-title" itemprop="headline"><?php the_title(); ?></h2>
                        <div class="player-embed">
                            <?php echo $podcast_embed; ?>
                        </div><!-- end .player-embed -->
                    <?php
                        echo '<div class="share-icon"><i class="icon-share"></i></div>';
                        echo '<div class="side-share">';
                        	include ( CHILD_DIR . "/lib/admin/app-share.php" );
                    	echo '</div>';
                    if ( $showpwd_s == 1 && $podcast ) {
                    	echo '<div class="play-dnld">';         
							echo '<a rel="nofollow" target="_blank" href="' . $podcast . '" title="Play Podcast Episode in New Window">Play in New Window</a>';
							echo '<span class="divider">|</span>';
							echo '<a rel="nofollow" href="' . $podcast . '" title="Download Podcast Episode" download="' . $p_file . '">Download</a>';
                    	echo '</div><!-- end .play-dnld -->';
                    } ?>
                </div><!-- end .inner-wrap -->
                <?php if ( is_active_sidebar( 'player_bar' ) ) {
						echo '<div class="pb-widget">';
							dynamic_sidebar( 'player_bar' );
						echo '</div><!-- end .pb-widget -->';
				} ?>
            </div><!-- end .wrap -->
        </div><!-- end .outer-wrap -->
    </div><!-- end #player-bar -->
    
    <?php 
	
	} elseif ( !empty( $ppdata['embed'] ) && empty( $hide_main_play ) ) { ?>
    
	<div id="player-bar">
   	 	<div class="outer-wrap">
            <div class="wrap">
            	<div class="inner-wrap<?php echo ( is_active_sidebar( 'player_bar' ) ) ? ' waa' : ''; ?>">
                        <h2 class="post-title" itemprop="headline"><?php the_title(); ?></h2>
                        <div class="player-embed">
                            <?php echo $ppdata['embed']; ?>
                        </div><!-- end .player-embed -->
                    <?php
                        echo '<div class="share-icon"><i class="icon-share"></i></div>';
                        echo '<div class="side-share">';
                        	include ( CHILD_DIR . "/lib/admin/app-share.php" );
                    	echo '</div>';
                    if ( $showpwd_s == 1 ) {
                    	echo '<div class="play-dnld">';         
							echo '<a rel="nofollow" target="_blank" href="' . $ppdata['url'] . '" title="Play Podcast Episode in New Window">Play in New Window</a>';
							echo '<span class="divider">|</span>';
							echo '<a rel="nofollow" href="' . $ppdata['url'] . '" title="Download Podcast Episode" download="' . basename( $ppdata['url'] ) . '">Download</a>';
                    	echo '</div><!-- end .play-dnld -->';
                    } ?>
                </div><!-- end .inner-wrap -->
                <?php if ( is_active_sidebar( 'player_bar' ) ) {
						echo '<div class="pb-widget">';
							dynamic_sidebar( 'player_bar' );
						echo '</div><!-- end .pb-widget -->';
				} ?>
            </div><!-- end .wrap -->
        </div><!-- end .outer-wrap -->
    </div><!-- end #player-bar -->
    
    <?php 
	
	} else {
		
		echo '';
		
	}