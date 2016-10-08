<?php
GLOBAL $webnus_options;
if($webnus_options->webnus_top_social_icons_facebook())
	echo '<a target="_blank" href="'. $webnus_options->webnus_facebook_ID() .'" class="facebook"><i class="fa-facebook"></i></a>';
if($webnus_options->webnus_top_social_icons_twitter())
	echo '<a target="_blank" href="'. $webnus_options->webnus_twitter_ID() .'" class="twitter"><i class="fa-twitter"></i></a>';
if($webnus_options->webnus_top_social_icons_dribbble())
	echo '<a target="_blank" href="'. $webnus_options->webnus_dribbble_ID().'" class="dribble"><i class="fa-dribbble"></i></a>';
if($webnus_options->webnus_top_social_icons_pinterest())
	echo '<a target="_blank" href="'. $webnus_options->webnus_pinterest_ID() .'" class="pinterest"><i class="fa-pinterest"></i></a>';
if($webnus_options->webnus_top_social_icons_vimeo())
	echo '<a target="_blank" href="'. $webnus_options->webnus_vimeo_ID() .'" class="vimeo"><i class="fa-vimeo-square"></i></a>';
if($webnus_options->webnus_top_social_icons_youtube())
	echo '<a target="_blank" href="'. $webnus_options->webnus_youtube_ID() .'" class="youtube"><i class="fa-youtube"></i></a>';	
if($webnus_options->webnus_top_social_icons_google())
	echo '<a target="_blank" href="'. $webnus_options->webnus_google_ID() .'" class="google"><i class="fa-google"></i></a>';	
if($webnus_options->webnus_top_social_icons_linkedin())
	echo '<a target="_blank" href="'. $webnus_options->webnus_linkedin_ID() .'" class="linkedin"><i class="fa-linkedin"></i></a>';	
if($webnus_options->webnus_top_social_icons_rss())
	echo '<a target="_blank" href="'. $webnus_options->webnus_rss_ID() .'" class="rss"><i class="fa-rss-square"></i></a>';
if($webnus_options->webnus_top_social_icons_instagram())
	echo '<a target="_blank" href="'. $webnus_options->webnus_instagram_ID() .'" class="instagram"><i class="fa-instagram"></i></a>';	
if($webnus_options->webnus_top_social_icons_flickr())
	echo '<a target="_blank" href="'. $webnus_options->webnus_flickr_ID() .'" class="other-social"><i class="fa-flickr"></i></a>';	
if($webnus_options->webnus_top_social_icons_reddit())
	echo '<a target="_blank" href="'. $webnus_options->webnus_reddit_ID() .'" class="other-social"><i class="fa-reddit"></i></a>';
if($webnus_options->webnus_top_social_icons_delicious())
	echo '<a target="_blank" href="'. $webnus_options->webnus_delicious_ID() .'" class="other-social"><i class="fa-delicious"></i></a>';	
if($webnus_options->webnus_top_social_icons_lastfm())
	echo '<a target="_blank" href="'. $webnus_options->webnus_lastfm_ID() .'" class="other-social"><i class="fa-lastfm-square"></i></a>';
if($webnus_options->webnus_top_social_icons_tumblr())
	echo '<a target="_blank" href="'. $webnus_options->webnus_tumblr_ID() .'" class="other-social"><i class="fa-tumblr-square"></i></a>';
if($webnus_options->webnus_top_social_icons_skype())
	echo '<a target="_blank" href="'. $webnus_options->webnus_skype_ID() .'" class="other-social"><i class="fa-skype"></i></a>'; 
?>