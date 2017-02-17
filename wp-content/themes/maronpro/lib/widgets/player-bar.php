<?php

//Player Bar Template
 	global $post, $app_options;

	$mp_cat  		= $app_options[ 'mp-cat' ];
	$mpshowpwd 		= $app_options[ 'mp-showpwd' ];
	$mp_headline 	= $app_options[ 'mp-headline' ];
	
$my_query = new WP_Query('cat=' . $mp_cat . '&posts_per_page=1');
  while ($my_query->have_posts()) : $my_query->the_post();

	$mp_podcast 		= get_post_meta(get_the_ID(), 'podcast', true);
	$mp_podcast_embed 	= get_post_meta(get_the_ID(), '_cmb_podcast_embed', true);
	
	$mp_file			= basename( $mp_podcast );
	
	// Blubrry PowerPress
	if( function_exists( 'powerpress_get_enclosure_data' ) ) {
		$mp_ppdata = powerpress_get_enclosure_data( get_the_ID(), $feed_slug = 'podcast', $raw_data = false );
	} else {
		$mp_ppdata = NULL;
	}
		
	if( function_exists( 'powerpress_get_enclosure_data' ) ) {
		$mp_filetype = wp_check_filetype( $mp_ppdata['url'] );
		if( $mp_filetype['type'] == 'video/mp4' ) {
			$mp_player_short = '<span style="padding-left: 60px;">Sorry, Maron Pro does not support video files. Please use embed code to display video.</span>';
		} else {
			$mp_player_short = do_shortcode( '[app_audio src="' . preg_replace( '/.mp3.*/', '.mp3', $mp_ppdata['url'] ) . '"]' );
		}
	} else {
			$mp_filetype = NULL;
	}
	
	if ( class_exists( 'wp_simplepodcastpress' ) ) {
		$mp_spp_podcast = get_post_meta( get_the_ID(), '_audiourl', true );
	} else {
		$mp_spp_podcast = NULL;
	}
	
	if ( $mp_podcast && empty( $mp_podcast_embed ) ) { ?>
    
	<div id="player-bar">
   	 	<div class="outer-wrap">
            <div class="wrap">
            	<div class="inner-wrap<?php echo ( is_active_sidebar( 'hp_player_bar' ) ) ? ' waa' : ''; ?>">
                    <div class="mp-headline"><?php echo $mp_headline; ?></div>
                    <h2 class="post-title" itemprop="headline"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
                    <div class="mp-content">
                            <?php the_excerpt(); ?>
                        <div class="player">
                            <?php echo do_shortcode('[app_audio src="' . preg_replace( '/.mp3.*/', '.mp3', $mp_podcast ) . '"]'); ?>
                        </div><!-- end .player -->
                    </div><!-- end .mp-content -->
                    <?php
                        echo '<div class="share-icon"><i class="icon-share"></i></div>';
                        echo '<div class="side-share">';
                        	include ( CHILD_DIR . "/lib/admin/app-share.php" );
                    	echo '</div>';
                    
					if ( $mpshowpwd == 1 ) {
                    	echo '<div class="play-dnld">';         
							echo '<a rel="nofollow" target="_blank" href="' . $mp_podcast . '" title="Play Podcast Episode in New Window">Play in New Window</a>';
							echo '<span class="divider">|</span>';
							echo '<a rel="nofollow" href="' . $mp_podcast . '" title="Download Podcast Episode" download="' . $mp_file . '">Download</a>';
                    	echo '</div><!-- end .play-dnld -->';
                    } ?>
                </div><!-- end .inner-wrap -->
                <?php if ( is_active_sidebar( 'hp_player_bar' ) ) {
						echo '<div class="pb-widget">';
							dynamic_sidebar( 'hp_player_bar' );
						echo '</div><!-- end .pb-widget -->';
				} ?>
            </div><!-- end .wrap -->
        </div><!-- end .outer-wrap -->
    </div><!-- end #player-bar -->
    
	<?php } elseif ( $mp_ppdata['url'] && empty( $mp_ppdata['embed'] ) ) { ?>
    
	<div id="player-bar">
   	 	<div class="outer-wrap">
            <div class="wrap">
            	<div class="inner-wrap<?php echo ( is_active_sidebar( 'hp_player_bar' ) ) ? ' waa' : ''; ?>">
                    <div class="mp-headline"><?php echo $mp_headline; ?></div>
                    <h2 class="post-title" itemprop="headline"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
                    <div class="mp-content">
                            <?php the_excerpt(); ?>
                        <div class="player">
                            <?php echo $mp_player_short; ?>
                        </div><!-- end .player -->
                    </div><!-- end .mp-content -->
                    <?php
                        echo '<div class="share-icon"><i class="icon-share"></i></div>';
                        echo '<div class="side-share">';
                        	include ( CHILD_DIR . "/lib/admin/app-share.php" );
                    	echo '</div>';
                    
					if ( $mpshowpwd == 1 ) {
                    	echo '<div class="play-dnld">';         
							echo '<a rel="nofollow" target="_blank" href="' . $mp_ppdata['url'] . '" title="Play Podcast Episode in New Window">Play in New Window</a>';
							echo '<span class="divider">|</span>';
							echo '<a rel="nofollow" href="' . $mp_ppdata['url'] . '" title="Download Podcast Episode" download="' . basename( $mp_ppdata['url'] ) . '">Download</a>';
                    	echo '</div><!-- end .play-dnld -->';
                    } ?>
                </div><!-- end .inner-wrap -->
                <?php if ( is_active_sidebar( 'hp_player_bar' ) ) {
						echo '<div class="pb-widget">';
							dynamic_sidebar( 'hp_player_bar' );
						echo '</div><!-- end .pb-widget -->';
				} ?>
            </div><!-- end .wrap -->
        </div><!-- end .outer-wrap -->
    </div><!-- end #player-bar -->
    
	<?php } elseif ( $mp_spp_podcast ) { ?>
    
	<div id="player-bar">
   	 	<div class="outer-wrap">
            <div class="wrap">
            	<div class="inner-wrap<?php echo ( is_active_sidebar( 'hp_player_bar' ) ) ? ' waa' : ''; ?>">
                    <div class="mp-headline"><?php echo $mp_headline; ?></div>
                    <h2 class="post-title" itemprop="headline"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
                    <div class="mp-content">
                            <?php the_excerpt(); ?>
                        <div class="player">
                            <?php echo do_shortcode('[app_audio src="' . preg_replace( '/.mp3.*/', '.mp3', $mp_spp_podcast ) . '"]'); ?>
                        </div><!-- end .player -->
                    </div><!-- end .mp-content -->
                    <?php
                        echo '<div class="share-icon"><i class="icon-share"></i></div>';
                        echo '<div class="side-share">';
                        	include ( CHILD_DIR . "/lib/admin/app-share.php" );
                    	echo '</div>';
                    
					if ( $mpshowpwd == 1 ) {
                    	echo '<div class="play-dnld">';         
							echo '<a rel="nofollow" target="_blank" href="' . preg_replace( '/.mp3.*/', '.mp3', $mp_spp_podcast ) . '" title="Play Podcast Episode in New Window">Play in New Window</a>';
							echo '<span class="divider">|</span>';
							echo '<a rel="nofollow" href="' . $mp_spp_podcast . '" title="Download Podcast Episode" download="' . basename( $mp_spp_podcast ) . '">Download</a>';
                    	echo '</div><!-- end .play-dnld -->';
                    } ?>
                </div><!-- end .inner-wrap -->
                <?php if ( is_active_sidebar( 'hp_player_bar' ) ) {
						echo '<div class="pb-widget">';
							dynamic_sidebar( 'hp_player_bar' );
						echo '</div><!-- end .pb-widget -->';
				} ?>
            </div><!-- end .wrap -->
        </div><!-- end .outer-wrap -->
    </div><!-- end #player-bar -->
    
	<?php } elseif ( $mp_podcast_embed ) { ?>
    
	<div id="player-bar">
   	 	<div class="outer-wrap">
            <div class="wrap">
            	<div class="inner-wrap<?php echo ( is_active_sidebar( 'hp_player_bar' ) ) ? ' waa' : ''; ?>">
                    <div class="mp-headline"><?php echo $mp_headline; ?></div>
                        <h2 class="post-title" itemprop="headline"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
                        <div class="player-embed">
                            <?php echo $mp_podcast_embed; ?>
                        </div><!-- end .player-embed -->
                            <?php the_excerpt(); ?>
                            <div class="show-notes embed">
                            	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?> Show Notes">Show Notes</a>
                            </div>
                    <?php
                        echo '<div class="share-icon"><i class="icon-share"></i></div>';
                        echo '<div class="side-share">';
                        	include ( CHILD_DIR . "/lib/admin/app-share.php" );
                    	echo '</div>';
                    if ( $mpshowpwd == 1 && $mp_podcast ) {
                    	echo '<div class="play-dnld">';         
							echo '<a rel="nofollow" target="_blank" href="' . $mp_podcast . '" title="Play Podcast Episode in New Window">Play in New Window</a>';
							echo '<span class="divider">|</span>';
							echo '<a rel="nofollow" href="' . $mp_podcast . '" title="Download Podcast Episode" download="' . $mp_file . '">Download</a>';
                    	echo '</div><!-- end .play-dnld -->';
                    } ?>
                </div><!-- end .inner-wrap -->
                <?php if ( is_active_sidebar( 'hp_player_bar' ) ) {
						echo '<div class="pb-widget">';
							dynamic_sidebar( 'hp_player_bar' );
						echo '</div><!-- end .pb-widget -->';
				} ?>
            </div><!-- end .wrap -->
        </div><!-- end .outer-wrap -->
    </div><!-- end #player-bar -->
    
    <?php } elseif ( $mp_ppdata['embed'] ) { ?>
    
	<div id="player-bar">
   	 	<div class="outer-wrap">
            <div class="wrap">
            	<div class="inner-wrap<?php echo ( is_active_sidebar( 'hp_player_bar' ) ) ? ' waa' : ''; ?>">
                    <div class="mp-headline"><?php echo $mp_headline; ?></div>
                        <h2 class="post-title" itemprop="headline"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
                        <div class="player-embed">
                            <?php echo $mp_ppdata['embed']; ?>
                        </div><!-- end .player-embed -->
                            <?php the_excerpt(); ?>
                            <div class="show-notes embed">
                            	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?> Show Notes">Show Notes</a>
                            </div>
                    <?php
                        echo '<div class="share-icon"><i class="icon-share"></i></div>';
                        echo '<div class="side-share">';
                        	include ( CHILD_DIR . "/lib/admin/app-share.php" );
                    	echo '</div>';
                    if ( $mpshowpwd == 1 ) {
                    	echo '<div class="play-dnld">';         
							echo '<a rel="nofollow" target="_blank" href="' . $mp_ppdata['url'] . '" title="Play Podcast Episode in New Window">Play in New Window</a>';
							echo '<span class="divider">|</span>';
							echo '<a rel="nofollow" href="' . $mp_ppdata['url'] . '" title="Download Podcast Episode" download="' . basename( $mp_ppdata['url'] ) . '">Download</a>';
                    	echo '</div><!-- end .play-dnld -->';
                    } ?>
                </div><!-- end .inner-wrap -->
                <?php if ( is_active_sidebar( 'hp_player_bar' ) ) {
						echo '<div class="pb-widget">';
							dynamic_sidebar( 'hp_player_bar' );
						echo '</div><!-- end .pb-widget -->';
				} ?>
            </div><!-- end .wrap -->
        </div><!-- end .outer-wrap -->
    </div><!-- end #player-bar -->
    
    <?php } else {
		echo '';
	}

  endwhile;
  
  wp_reset_postdata();
