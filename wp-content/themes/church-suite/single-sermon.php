<?php
/******************/
/**  Single Sermon
/******************/
global $webnus_options; 
get_header();
$post_id = get_the_ID();  
?>
<section class="container page-content" >
<hr class="vertical-space2">
<?php 
if($webnus_options->webnus_singlesermon_sidebar() == 'left'){ ?>
	<aside class="col-md-3 sidebar leftside">
		<?php dynamic_sidebar( 'Left Sidebar' ); ?>
	</aside>
<?php } ?>
<section class="<?php echo ($webnus_options->webnus_singlesermon_sidebar()=='none')?'col-md-12':'col-md-9 cntt-w'?>">
<?php if( have_posts() ): while( have_posts() ): the_post();  ?>
<article class="blog-single-post">
<?php
webnus_setViews(get_the_ID());
$content = get_the_content(); ?>
<div class="post-trait-w"> <?php
if(!isset($background)) { ?>
<h1><?php the_title() ?></h1> <?php }
if(  $webnus_options->webnus_sermon_featuredimage() && !isset($background) ){
get_the_image( array( 'meta_key' => array( 'Full', 'Full' ), 'size' => 'Full', 'link_to_post' => false, ) ); 
}		
?>
</div>
<div <?php post_class('post'); ?>>

<div class="postmetadata">
	<?php if($webnus_options->webnus_sermon_speaker()){ ?>	
	<?php the_terms(get_the_id(), 'sermon_speaker' , '<h6>Speaker: ',', ','</h6>' ); ?> 
	<?php } ?>
	<?php if($webnus_options->webnus_sermon_date()){ ?>	
	<h6 class="blog-date"> <?php the_time('F d, Y') ?></h6>
	<?php } ?>
	<?php if($webnus_options->webnus_sermon_category()){ ?>
		 <?php the_terms(get_the_id(), 'sermon_category', '<h6>in ',', ','</h6>' ); ?> 
	<?php } ?>
	<?php if($webnus_options->webnus_sermon_comments()){ ?>
		<h6 class="blog-comments"> <?php comments_number(  ); ?> </h6>
	<?php } ?>
	<?php if($webnus_options->webnus_sermon_views()){ ?>
		<h6 class="blog-views"> <i class="fa-eye"></i><span><?php echo webnus_getViews(get_the_ID()); ?></span> </h6>
	<?php } ?>
</div>


<?php // sermon meta
	global $sermon_meta;
	$w_sermon_meta = $sermon_meta->the_meta();
	if(!empty($w_sermon_meta)){
		echo "<div class='media-links'>";
		echo (array_key_exists('sermon_video',$w_sermon_meta))?'<a href="'.$w_sermon_meta['sermon_video'].'" class="videolb button dark-gray  medium  " target="_self"><i class="fa-play-circle"></i>'.esc_html__('WATCH','webnus_framework').'</a>':'';
		echo (array_key_exists('sermon_audio',$w_sermon_meta))?'<a href="#w-audio-'.$post_id.'" class="inlinelb button dark-gray  medium " target="_self"><i class="fa-headphones"></i>'.esc_html__('LISTEN','webnus_framework').'</a><div style="display:none"><div class="w-audio" id="w-audio-'.$post_id.'">'.do_shortcode('[audio mp3="'.$w_sermon_meta['sermon_audio'].'"][/audio]').'</div></div>':'';
		echo (array_key_exists('sermon_pdf',$w_sermon_meta))?'<a href="'.$w_sermon_meta['sermon_pdf'].'" class="button dark-gray  medium  " target="_self"><i class="fa-download"></i>'.esc_html__('DOWNLOAD','webnus_framework').'</a>':'';
		echo '</div>';
	}
?>

<?php // content
echo apply_filters('the_content',$content); 
?>	

<?php // social share
	if($webnus_options->webnus_sermon_social_share()) { ?>	
	<div class="post-sharing"><div class="blog-social">
		<span><?php esc_html_e('Share','webnus_framework');?></span> 
		<a class="facebook" href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&amp;t=<?php the_title(); ?>" target="blank"><i class="fa-facebook"></i></a>
		<a class="google" href="https://plusone.google.com/_/+1/confirm?hl=en-US&amp;url=<?php the_permalink(); ?>" target="_blank"><i class="fa-google"></i></a>
		<a class="twitter" href="https://twitter.com/intent/tweet?original_referer=<?php the_permalink(); ?>&amp;text=<?php the_title(); ?>&amp;tw_p=tweetbutton&amp;url=<?php the_permalink(); ?><?php echo isset( $twitter_user ) ? '&amp;via='.$twitter_user : ''; ?>" target="_blank"><i class="fa-twitter"></i></a>
		<a class="linkedin" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>&amp;source=<?php bloginfo( 'name' ); ?>"><i class="fa-linkedin"></i></a>
		<a class="email" href="mailto:?subject=<?php the_title(); ?>&amp;body=<?php the_permalink(); ?>"><i class="fa-envelope"></i></a>
	</div></div>
<?php } ?>

<br class="clear"> 
<?php the_tags( '<div class="post-tags"><i class="fa-tags"></i>', '', '</div>' ); ?><!-- End Tags --> 
<div class="next-prev-posts">
<?php $args = array(
'before'           => '',
'after'            => '',
'link_before'      => '',
'link_after'       => '',
'next_or_number'   => 'next',
'nextpagelink'     => '&nbsp;&nbsp; '.esc_html__('Next Page','webnus_framework'),
'previouspagelink' => esc_html__('Previous Page','webnus_framework').'&nbsp;&nbsp;',
'pagelink'         => '%',
'echo'             => 1
); 
wp_link_pages($args);
?>	  
</div><!-- End next-prev post -->

<?php // Sermon Speaker Box
	if( $webnus_options->webnus_sermon_speakerbox()){
	echo '<div class="about-author-sec">';
	$terms = wp_get_post_terms($post->ID, "sermon_speaker");
	if (function_exists('z_taxonomy_image_url')){
		echo '<img class="sermon-speaker" width="80" src="' . z_taxonomy_image_url($terms[0]->term_id,array(160, 160), TRUE) . '">';
	}
	the_terms(get_the_id(), 'sermon_speaker' , '<h5>',', ','</h5>' );
	echo term_description( $terms[0]->term_id, "sermon_speaker" ) . '</div>';
	}
?>


<?php // Recent Sermons
	if($webnus_options->webnus_recent_sermons()) {
	$post_ids = array();
	$post_ids[] = $post->ID;
	echo '<div class="container rec-posts"><div class="col-md-12"><h3 class="rec-title">'. esc_html__('Recent Sermons','webnus_framework') .'</div></h3>';
		$args = array(
			'post__not_in' => $post_ids,
			'showposts' => 3,
			'post_type' => 'sermon',
			);
		$rec_query = new wp_query($args);
		if($rec_query->have_posts()){
			while ($rec_query->have_posts()){
				$rec_query->the_post();
?>
				<div class="col-md-4 col-sm-4"><article class="rec-post">
					<figure><?php get_the_image( array( 'meta_key' => array( 'thumbnail', 'thumbnail' ), 'size' => 'blog2_thumb' ) ); ?></figure>
					<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
					<p><?php the_time('F d, Y') ?> </p>  
				</article></div>
<?php 		}
			echo '</div>';
		}
}
?>	


</div>
</article>
<?php 
endwhile;
endif;
comments_template(); ?>
</section>
<!-- end-main-conten -->

<?php
if($webnus_options->webnus_singlesermon_sidebar() == 'right' ){ ?>
	<aside class="col-md-3 sidebar">
		<?php dynamic_sidebar( 'Right Sidebar' ); ?>
	</aside>
<?php } ?>

<div class="white-space"></div>
</section>
<?php 
get_footer();
?>