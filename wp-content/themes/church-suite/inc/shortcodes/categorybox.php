<?php

function webnus_category_box($attributes, $content){
	
	
extract(shortcode_atts(	array(
	'title'=>'',
	'show_title'=>'true',
	'post_count'=>5,
	'show_date'=>'true',
	'show_category'=>'true',
	'show_author'=>'true',
	'category'=>''

), $attributes));

$i = 0 ;
	
ob_start();	
?>	
	
	<div class="latest-cat">
		<?php if( 'true' == $show_title  ) { ?>
		<div class="sub-content">
			<h6 class="h-sub-content"><?php echo esc_html($title); ?></h6>
		</div>
		<?php } ?>
		<?php 
		if(empty($category))
			$qParams = array( 'post_type' => 'post','paged'=>1, 'posts_per_page' =>$post_count );
		else
			$qParams = array( 'post_type' => 'post','paged'=>1, 'posts_per_page' =>$post_count , 'category_name'=>$category);
		
   		$wpbp = new WP_Query( $qParams ); 
		$i = 0;
		$div_must_echo_first_time = 0;  
		if ($wpbp->have_posts()) : while ($wpbp->have_posts()) : $wpbp->the_post(); 
		
		
		
		if( 0 == $i ) {
		
		?>
	 	<article class="blog-post lc-main clearfix">
	 		<figure>
    			<?php
				  $image = get_the_image( array( 'meta_key' => array( 'thumbnail', 'thumbnail' ), 'size' => 'latestfromblog' ,'echo'=>false) );
				 
				  if( !empty($image) ) 
				  	echo $image;
				  else 
				  	echo '<img src="'.get_template_directory_uri() . '/images/featured.jpg" />';
	 			?>

	 		</figure>	
			<?php if('true' == $show_title){ ?>
        	<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
        	<?php } ?>

          	<p class="blog-author">	
          		   		<?php if('true' == $show_author) { ?>
	              		<strong><?php esc_html_e('by','webnus_framework'); ?></strong> <?php the_author_posts_link(); ?>
	              		<?php } ?>
	              		<?php if('true' == $show_category){ ?>
	              		<strong><?php esc_html_e('in','webnus_framework'); ?></strong> <?php the_category(', ') ?>
	              		<?php } ?>
	        </p>

			<p class="blog-detail"><?php echo webnus_excerpt(36); ?></p>
			
		</article> 
		<?php } else { ?>
  <?php if( 0 == $div_must_echo_first_time ){ ?>			
  <div class="lc-items">
  <?php } ?>
  	<article class="blog-line clearfix">
          <a href="<?php the_permalink(); ?>" class="img-hover"><?php 
		  $image = 	get_the_image( array( 'meta_key' => array( 'Thumbnail', 'Thumbnail' ), 'size' => 'tabs_img' ,'echo'=>false,'link_to_post' => false,) ); 
		  if( !empty($image) ) 
		  	echo $image;
		  else 
		  	echo '<img src="'.get_template_directory_uri() . '/images/featured_140x110.jpg" />';
          	?></a>

            <?php if('true' == $show_title) { ?>
            <h4><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h4>
            <?php } ?>

        <p class="blog-author">
        	    <?php if('true' == $show_date) echo get_the_time('F d, Y'); ?> 
            	<?php if( ('true' == $show_date) &&  ('true' == $show_author)) { ?>
            	/
            	<?php } ?>
            	<?php if('true' == $show_author) {  ?>
            	<strong><?php esc_html_e('by', 'webnus_framework') ?></strong> <?php echo get_the_author(); ?>
            	<?php } ?>

        </p>
    </article>


  
  <?php 
$div_must_echo_first_time++;
	} // end of else that check first block
	
	$i++;
		endwhile;
	endif;

 ?>
</div>
</div>
<?php	
$output = ob_get_contents();
ob_end_clean();	
return $output;
}

add_shortcode('categorybox', 'webnus_category_box');
?>