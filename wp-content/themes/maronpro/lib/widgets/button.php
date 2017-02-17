<?php
/**
 * Plugin Name: Button Widget
 * Plugin URI: http://www.appendipity.com/
 * Description: A widget that allows you to add a button to any widget area.
 * Version: 0.1
 * Author: Ian Belanger
 * Author URI: http://ian-belanger.com
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'button_load_widgets' );

/**
 * Register our widget.
 * 'Button_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function button_load_widgets() {
	register_widget( 'Button_Widget' );
}

/**
 * Button_Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.
 *
 * @since 0.1
 */
class Button_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'button-widget', 'description' => __('Adds an Appendipity Button to any widget area.', 'button-widget') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'button-widget-widget' );

		/* Create the widget. */
		parent::__construct( 'button-widget-widget', __('Appendipity Button', 'button-widget'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title 		= apply_filters('widget_title', $instance['title'] );
		$selectimg 	= $instance['selectimg'];
		$imglink 	= $instance['imglink'];
		$btnlink 	= $instance['btnlink'];
		$lpjs 		= $instance['lpjs'];
		$linktarget = isset( $instance['linktarget'] ) ? $instance['linktarget'] : false;
		$color 		= $instance['color'];


		/* Before widget (defined by themes). */
		echo $before_widget;
		
		echo '<div class="widget-btn">';

		/* Adds an image class to the button. */
		if (!empty($selectimg)) { ?>
			<a <?php if ( $linktarget ) echo 'target="_blank"'; ?> class="btn-widget" href="<?php echo $btnlink; ?>" alt="<?php echo $title; ?>" title="<?php echo $title; ?>" ><div style="background-color:<?php echo $color; ?>; padding: 18px 0px;"><img alt="<?php echo $title; ?>" class="aligncenter" src="<?php echo trailingslashit( get_stylesheet_directory_uri()) . 'images/btn-widget/' . $selectimg . '.png'; ?>" height="50" /></div></a><?php if( $lpjs ) { echo $lpjs; } ?>
		<?php
		}
		else {
			echo '';
		}
	
		/* Adds an image to the button. */
		if ( $imglink && empty($selectimg) ) { ?>
			<a <?php if ( $linktarget ) echo 'target="_blank"'; ?> class="btn-widget" href="<?php echo $btnlink; ?>" alt="<?php echo $title; ?>" title="<?php echo $title; ?>" ><div style="background-color:<?php echo $color; ?>; padding: 0;"><img alt="<?php echo $title; ?>" class="aligncenter" src="<?php echo $imglink; ?>" /></div></a><?php if( $lpjs ) { echo $lpjs; } ?>
		<?php
		}
	
		echo '</div>';
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] 		= $new_instance['title'];
		$instance['selectimg'] 	= $new_instance['selectimg'];
		$instance['imglink'] 	= strip_tags( $new_instance['imglink'] );
		$instance['btnlink'] 	= strip_tags( $new_instance['btnlink'] );
		$instance['lpjs'] 		= $new_instance['lpjs'];
		$instance['linktarget'] = $new_instance['linktarget'];
		$instance['color'] 		= $new_instance['color'];
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'selectimg' => '', 'imglink' => '', 'btnlink' => '', 'lpjs' => '', 'linktarget' => 1, 'color' => '#e2e2e2' ) );
		$title 		= $instance['title'];
		$selectimg 	= $instance['selectimg'];
		$imglink 	= strip_tags($instance['imglink']);
		$btnlink 	= strip_tags($instance['btnlink']);
		$lpjs 		= esc_textarea( $instance['lpjs'] );
		$linktarget = $instance['linktarget'];
		$color 		= $instance['color'];
?>
        
        <!-- Widget Title: Text Input -->
		<p>
			<strong><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Button Title:', 'hybrid'); ?></label></strong>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" class="widefat" type="text" size="36" value="<?php echo $instance['title']; ?>" />
            <br /><small>Title will only show if button is hovered over.</small>
		</p>
        
		<!-- Select Image: Drop Down Selection -->
		<p>
			<strong><label for="<?php echo $this->get_field_id( 'selectimg' ); ?>"><?php _e('Select an Image:', 'button-widget'); ?></label></strong>
				<select id="<?php echo $this->get_field_id( 'selectimg' ); ?>" name="<?php echo $this->get_field_name( 'selectimg' ); ?>" class="widefat" style="width:100%;">
                	<option value=""></option>
					<option <?php if ( 'itunes1' == $instance['selectimg'] ) echo 'selected="selected"'; ?>>itunes1</option>
					<option <?php if ( 'itunes2' == $instance['selectimg'] ) echo 'selected="selected"'; ?>>itunes2</option>
					<option <?php if ( 'itunes3' == $instance['selectimg'] ) echo 'selected="selected"'; ?>>itunes3</option>
					<option <?php if ( 'subscribe1' == $instance['selectimg'] ) echo 'selected="selected"'; ?>>subscribe1</option>
					<option <?php if ( 'subscribe2' == $instance['selectimg'] ) echo 'selected="selected"'; ?>>subscribe2</option>
					<option <?php if ( 'subscribe3' == $instance['selectimg'] ) echo 'selected="selected"'; ?>>subscribe3</option>
					<option <?php if ( 'stitcher1' == $instance['selectimg'] ) echo 'selected="selected"'; ?>>stitcher1</option>
					<option <?php if ( 'stitcher2' == $instance['selectimg'] ) echo 'selected="selected"'; ?>>stitcher2</option>
					<option <?php if ( 'stitcher3' == $instance['selectimg'] ) echo 'selected="selected"'; ?>>stitcher3</option>
					<option <?php if ( 'stitcher4' == $instance['selectimg'] ) echo 'selected="selected"'; ?>>stitcher4</option>
					<option <?php if ( 'google-play1' == $instance['selectimg'] ) echo 'selected="selected"'; ?>>google-play1</option>
					<option <?php if ( 'google-play2' == $instance['selectimg'] ) echo 'selected="selected"'; ?>>google-play2</option>
					<option <?php if ( 'google-play3' == $instance['selectimg'] ) echo 'selected="selected"'; ?>>google-play3</option>
					<option <?php if ( 'google-play4' == $instance['selectimg'] ) echo 'selected="selected"'; ?>>google-play4</option>
					<option <?php if ( 'soundcloud1' == $instance['selectimg'] ) echo 'selected="selected"'; ?>>soundcloud1</option>
					<option <?php if ( 'soundcloud2' == $instance['selectimg'] ) echo 'selected="selected"'; ?>>soundcloud2</option>
					<option <?php if ( 'soundcloud3' == $instance['selectimg'] ) echo 'selected="selected"'; ?>>soundcloud3</option>
					<option <?php if ( 'spreaker1' == $instance['selectimg'] ) echo 'selected="selected"'; ?>>spreaker1</option>
					<option <?php if ( 'spreaker2' == $instance['selectimg'] ) echo 'selected="selected"'; ?>>spreaker2</option>
					<option <?php if ( 'audioboo1' == $instance['selectimg'] ) echo 'selected="selected"'; ?>>audioboo1</option>
					<option <?php if ( 'audioboo2' == $instance['selectimg'] ) echo 'selected="selected"'; ?>>audioboo2</option>
					<option <?php if ( 'review' == $instance['selectimg'] ) echo 'selected="selected"'; ?>>review</option>
					<option <?php if ( 'app-store' == $instance['selectimg'] ) echo 'selected="selected"'; ?>>app-store</option>
					<option <?php if ( 'fb-connect' == $instance['selectimg'] ) echo 'selected="selected"'; ?>>fb-connect</option>
					<option <?php if ( 'tw-connect' == $instance['selectimg'] ) echo 'selected="selected"'; ?>>tw-connect</option>
					<option <?php if ( 'gp-connect' == $instance['selectimg'] ) echo 'selected="selected"'; ?>>gp-connect</option>
				</select>
                <br /><small>Leave selection blank if using your own image.</small>
		</p>

		<!-- Image Link: Media Uploader -->
        <p>
            <strong><label for="<?php echo $this->get_field_name( 'imglink' ); ?>"><?php _e( 'Or Use Your Own Image:', 'button-widget'); ?></label></strong>
            <input name="<?php echo $this->get_field_name( 'imglink' ); ?>" id="<?php echo $this->get_field_id( 'imglink' ); ?>" class="widefat" type="text" size="36" value="<?php echo esc_url( $imglink ); ?>" />
            <input class="upload_image_button" type="button" value="Upload Image" />
            <br /><small>Use png or gif with a transparent background.</small>
        </p>
        
		<!-- Button Link: Text Input -->
		<p>
			<strong><label for="<?php echo $this->get_field_id( 'btnlink' ); ?>"><?php _e('Button Link:', 'button-widget'); ?></label></strong>
			<input id="<?php echo $this->get_field_id( 'btnlink' ); ?>" name="<?php echo $this->get_field_name( 'btnlink' ); ?>" class="widefat" type="text" size="36" value="<?php echo $btnlink; ?>" />
            <br /><small>No HTML formatting needed. Ex. http://www.appendipity.com</small>
		</p>
        
		<!-- Lead Pages JS: Textarea Input -->
		<p>
			<strong><label for="<?php echo $this->get_field_id( 'lpjs' ); ?>"><?php _e('Lead Pages JS:', 'button-widget'); ?></label></strong>
			<textarea id="<?php echo $this->get_field_id( 'lpjs' ); ?>" name="<?php echo $this->get_field_name( 'lpjs' ); ?>" class="widefat" type="text" size="36"><?php echo $lpjs; ?></textarea>
            <br /><small>This section should only be used for LeadPages Javascript</small>
		</p>
        
        <!-- Button Link Target: Checkbox -->
        <p>
			<input class="checkbox" type="checkbox" value="1" <?php checked( $instance['linktarget'], 1 ); ?> id="<?php echo $this->get_field_id( 'linktarget' ); ?>" name="<?php echo $this->get_field_name( 'linktarget' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'linktarget' ); ?>"> <strong>Button Link Opens in New Window</strong></label>
            <br /><small>External links should always open in a new window.</small>
		</p>
        
        		<!-- Select Color: Button Color -->
		<p>
            <label for="<?php echo $this->get_field_id( 'color' ); ?>" style="display:block;"><?php _e( 'Button Color:', 'button-widget' ); ?></label> 
            <input class="widefat color-picker" id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" type="text" value="<?php echo esc_attr( $color ); ?>" />
        </p>
        
        <script type="text/javascript">
			jQuery(document).ready(function($) { 
					jQuery('.color-picker').on('focus', function(){
						var parent = jQuery(this).parent();
						jQuery(this).wpColorPicker()
						parent.find('.wp-color-result').click();
					}); 
			}); 
		</script>
          
	<?php
	}
}

?>