<?php
	get_header();
	GLOBAL $webnus_options;
	$sidebar = $webnus_options->webnus_blog_sidebar();
?>

<section id="headline"><div class="container"><h2><?php single_term_title('Sermons by '); ?></h2></div></section>
<section class="container page-content" ><hr class="vertical-space2">
<?php
if ($sidebar == 'left' || $sidebar == 'both'){?>
	<aside class="col-md-3 sidebar leftside">
		<?php dynamic_sidebar( 'Left Sidebar' ); ?>
	</aside>
<?php }
if ($sidebar == 'both')
	$class='col-md-6 cntt-w sermons-grid';
elseif ($sidebar == 'right' || $sidebar == 'left')
	$class='col-md-9 cntt-w sermons-grid';
else // none sidebar
	$class='col-md-12 omega sermons-grid';	
echo '<section class="'. $class .'">';
if(have_posts()):
		$count= 1 ;
	while( have_posts() ): the_post();
		echo ($count % 2 != 0)?'<div class="row">':'';
		$image = get_the_image( array( 'meta_key' => array( 'thumbnail', 'thumbnail' ), 'size' => 'sermons-grid','echo'=>false, ) );	
?>
		<div class="col-md-6">
			<article id="post-<?php the_ID(); ?>">
			<div class="container s-area">
				<div class="col-md-9"><h5><?php the_terms(get_the_id(), 'sermon_category', '<h6>in ',', ','</h6>' ); ?></h5></div>
				<div class="col-md-3"><div class="sermon-count"><i class="fa-eye"></i><?php echo webnus_getViews(get_the_ID()); ?></div></div>
			</div>
			<?php echo ($image)?'<figure class="sermon-img">'.$image.'</figure>':''; ?>
			<div class="container s-area">
				<div class="col-md-12">
					<h4><a href="<?php the_permalink() ?>"><?php the_title()?></a></h4>
					<div class="sermon-detail"><?php the_terms(get_the_id(), 'sermon_speaker' , '<span>Speaker: ',', ','</span>' ); ?> | <?php the_time('F d, Y'); ?></div>
					<p><?php echo webnus_excerpt(36); ?></p>
				</div>
			</div>
			<hr class="vertical-space1">
			</article>
		</div>
<?php
		echo ($count % 2 == 0)?'</div>':'';
		$count++;
	endwhile;
else:
	get_template_part('blogloop-none');
endif;
?>
<div class="vertical-space3"></div>
<?php if(function_exists('wp_pagenavi')){
	wp_pagenavi();
	echo '<hr class="vertical-space">';
} ?>
</section>

<?php if ($sidebar == 'right' || $sidebar == 'both'){?>
	<aside class="col-md-3 sidebar">
		<?php dynamic_sidebar( 'Right Sidebar' ); ?>
	</aside>
<?php } ?>

</section>
<?php get_footer(); ?>