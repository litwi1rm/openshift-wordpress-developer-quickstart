<?php

	global $app_options;
	
	$showfb 		= $app_options[ 'showfb' ];
	$showtw 		= $app_options[ 'showtw' ];
	$tw_username 	= $app_options[ 'tw-username' ];
	$showlin 		= $app_options[ 'showlin' ];
	$showgp 		= $app_options[ 'showgp' ];
	$showpin 		= $app_options[ 'showpin' ];
	$showstum 		= $app_options[ 'showstum' ];

	$permalink 		= get_the_permalink();
	$title 			= get_the_title();
	
		if ( ( $showfb == 1 ) || ( $showtw == 1 ) || ( $showlin == 1 ) || ( $showgp == 1 ) || ( $showpin == 1 ) || ( $showstum == 1 ) ) {
?>
                <div class="social-wrap">
                    <ul class="social-buttons clearfix">
                    <?php
                        if( $showfb == 1 ) { ?>
                        <li class="facebook">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $permalink; ?>" class="mypopup">
                                <span class="icon">
                                    <i class="icon-facebook-1"></i>
                                </span>
                            </a>
                        </li>
                        <?php }
                        if( $showlin == 1 ) { ?>
                        <li class="linkedin">
                            <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $permalink; ?>&amp;title=<?php echo rawurlencode($title); ?>" class="mypopup">
                                <span class="icon">
                                    <i class="icon-linkedin-1"></i>
                                </span>
                            </a>
                        </li>
                        <?php }
                        if( $showtw == 1 ) { ?>
                        <li class="twitter">
                            <a href="http://twitter.com/home?status=<?php echo rawurlencode($title); ?>%20<?php echo $permalink; ?>%20via%20@<?php echo $tw_username; ?>" class="mypopup">
                                <span class="icon">
                                    <i class="icon-twitter-1"></i>
                               </span>
                            </a>
                        </li>
                        <?php }
                        if( $showgp == 1 ) { ?>
                        <li class="googleplus">
                            <a href="https://plus.google.com/share?url=<?php echo rawurlencode($title); ?>%20<?php echo $permalink; ?>" class="mypopup">
                                <span class="icon">
                                    <i class="icon-gplus-1"></i>
                                </span>
                            </a>
                        </li>
                        <?php }
                        if( $showpin == 1 ) { ?>
                        <li class="pinterest">
                            <a href="http://pinterest.com/pin/create/button/?url=<?php echo $permalink; ?>&amp;media=<?php pin_default_image(); ?>&amp;description=<?php echo rawurlencode($title); ?>" class="mypopup">
                                <span class="icon">
                                    <i class="icon-pinterest"></i>
                                </span>
                            </a>
                        </li>
                        <?php }
                        if( $showstum == 1 ) { ?>
                        <li class="stumbleupon">
                            <a href="http://www.stumbleupon.com/submit?url=<?php echo $permalink; ?>&amp;title=<?php echo rawurlencode($title); ?>" class="mypopup">
                                <span class="icon">
                                    <i class="icon-stumble"></i>
                                </span>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <?php } ?>