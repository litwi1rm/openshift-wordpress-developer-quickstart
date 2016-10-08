<?php include_once str_replace("\\","/",get_template_directory()).'/inc/init.php';
class crtext extends WP_Widget{
	function __construct(){
		$params = array('description'=> 'Your copyright will be displayed','name'=> 'Webnus-Footer Copyright');
		parent::__construct('crtext', '', $params);
	}
	public function form($instance){
		$o = new webnus_options();
		extract($instance);	?>
		<p><label for="<?php echo $this->get_field_id('title') ?>">Title:</label><input type="text" class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" value="<?php if( isset($title) )  echo esc_attr($title); ?>"/></p>		
		<p><label for="<?php echo $this->get_field_id('copyright') ?>">Copyright Text:</label><input type="text" class="widefat" id="<?php echo $this->get_field_id('copyright') ?>" name="<?php echo $this->get_field_name('copyright') ?>" value="<?php if( isset($copyright) )  echo esc_attr($copyright); ?>" /></p>
		<?php 
	}
	public function widget($args, $instance){
		extract($args);
		extract($instance);
		if(!isset($title)) $title='';
		echo $before_widget;
		if(!empty($title))
			echo $before_title.$title.$after_title;	?>
		<p>
		<?php echo  $copyright; ?>
		</p>
		<?php echo $after_widget;
	} 
}
add_action('widgets_init', 'register_crtext');
function register_crtext(){
	register_widget('crtext');
}