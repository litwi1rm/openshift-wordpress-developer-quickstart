<?php
/**
 * Plugin Name: LeadPages Sticky Widget
 * Plugin URI: http://www.appendipity.com/leadpages-sticky/
 * Description: A widget that allows you to add an optin form to the built in LeadPages Sticky
 * Version: 0.1
 * Author: Ian Belanger
 * Author URI: http://ian-belanger.com
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'leadpages_sticky_load_widgets' );

/**
 * Register our widget.
 * 'App_Lp_Sticky' is the widget class used below.
 *
 * @since 0.1
 */
function leadpages_sticky_load_widgets() {
	register_widget( 'App_Lp_Sticky' );
}

/**
 * App_Lp_Sticky class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.
 *
 * @since 0.1
 */
class App_Lp_Sticky extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'leadpages-sticky', 'description' => __('Create a Sticky LeadPages Optin in any widget area.', 'leadpages-sticky') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'leadpages-sticky-widget' );

		/* Create the widget. */
		parent::__construct( 'leadpages-sticky-widget', __('Appendipity - LeadPages Sticky', 'leadpages-sticky'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$selecttype 	= $instance['selecttype'];	
		$textcolor 		= $instance['textcolor'];
		$title 			= apply_filters('widget_title', $instance['title'] );
		$subheadline 	= $instance['subheadline'];
		$btnonly 		= isset( $instance['btnonly'] ) ? $instance['btnonly'] : false;
		$lpscript	 	= $instance['lpscript'];
		$bgcolor 		= $instance['bgcolor'];
		$btntext 		= $instance['btntext'];
		$btncolor 		= $instance['btncolor'];

		/* Before widget (defined by themes). */
		echo $before_widget;
		
		if( $selecttype == 'Sticky' ) {
			echo '<div class="lp-sticky">';
		}
		
		if( $btnonly ) {
		
			echo '<div id="sticky-optin" style="background-color:' . $bgcolor . ';color:' . $textcolor . ';">';
	
				/* Display the widget title if one was input (before and after defined by themes). */
				if ( $title )
					echo '<h4 style="color:' . $textcolor . ';" class="widget-title widgettitle">' . $title . '</h4>';
		
				/* Adds Sub Headline to Appendipity Sidebar Optin. */
				if ( $subheadline ) {
		
					echo '<p style="color:' . $textcolor . ';">' . $subheadline . '</p>';
				
				}
		
		}
	
			if ( $lpscript ) {		
			
				echo '<div class="cta" style="background-color:' . $btncolor . ';">' . $lpscript . '</div>';
				
			}
		
		if( $btnonly ) {
		
			echo '</div>';
		
		}
		
		if( $selecttype == 'Sticky' ) {
			echo '</div>';
		}
		
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['selecttype'] 	= $new_instance['selecttype'];
		$instance['textcolor'] 		= $new_instance['textcolor'];
		$instance['title'] 			= strip_tags( $new_instance['title'] );
		$instance['subheadline'] 	= strip_tags( $new_instance['subheadline'] );
		$instance['btnonly'] 		= $new_instance['btnonly'];
		$instance['lpscript'] 		= $new_instance['lpscript'];
		$instance['bgcolor'] 		= $new_instance['bgcolor'];
		$instance['btntext'] 		= strip_tags( $new_instance['btntext'] );
		$instance['btncolor'] 		= $new_instance['btncolor'];
		
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'selecttype' => 'Normal', 'textcolor' => '#fff', 'title' => '', 'subheadline' =>'', 'btnonly' => 1, 'lpscript' => '', 'bgcolor' => '#777', 'btntext' => 'Submit', 'btncolor' => '#ff9900' ) );
		$selecttype 	= $instance['selecttype'];
		$textcolor 		= $instance['textcolor'];
		$title 			= esc_html($instance['title']);
		$subheadline 	= esc_html($instance['subheadline']);
		$btnonly 		= $instance['btnonly'];
		$lpscript 	 	= $instance['lpscript'];
		$bgcolor 		= $instance['bgcolor'];
		$btntext 		= strip_tags($instance['btntext']);
		$btncolor 		= $instance['btncolor'];
?>
		<p>Don't have LeadPages yet? <a target="_blank" href="https://www.appendipity.com/leadpages" title="Get LeadPages">Get it here</a></p>
        <div class="genesis-widget-column-box">
        
		<!-- Select Image: Drop Down Selection -->
		<p>
			<strong><label for="<?php echo $this->get_field_id( 'selecttype' ); ?>"><?php _e('Optin Type:', 'button-widget'); ?></label></strong>
				<select id="<?php echo $this->get_field_id( 'selecttype' ); ?>" name="<?php echo $this->get_field_name( 'selecttype' ); ?>" class="widefat" style="width:100%;">
					<option <?php if ( 'Normal' == $instance['selecttype'] ) echo 'selected="selected"'; ?>>Normal</option>
					<option <?php if ( 'Sticky' == $instance['selecttype'] ) echo 'selected="selected"'; ?>>Sticky</option>
				</select>
                <br /><small>Sticky Optin should only be used in one place on the site.</small>
		</p>
            
            <!-- Select Color: Background Color -->
            <p style="margin-top: 0;">
                <strong><label for="<?php echo $this->get_field_id( 'bgcolor' ); ?>" style="display:block;"><?php _e( 'Background Color:', 'button-widget' ); ?></label></strong>
                <input class="widefat color-picker" id="<?php echo $this->get_field_id( 'bgcolor' ); ?>" name="<?php echo $this->get_field_name( 'bgcolor' ); ?>" type="text" value="<?php echo esc_attr( $bgcolor ); ?>" />
            </p>
            
            <!-- Select Color: Text Color -->
            <p style="margin-top: 0;">
                <strong><label for="<?php echo $this->get_field_id( 'textcolor' ); ?>" style="display:block;"><?php _e( 'Text Color:', 'button-widget' ); ?></label></strong>
                <input class="widefat color-picker" id="<?php echo $this->get_field_id( 'textcolor' ); ?>" name="<?php echo $this->get_field_name( 'textcolor' ); ?>" type="text" value="<?php echo esc_attr( $textcolor ); ?>" />
            </p>
            
            <!-- Widget Title: Text Input -->
            <p>
                <strong><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Call to Action:', 'hybrid'); ?></label></strong>
                <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" class="widefat" type="text" size="36" value="<?php echo $title; ?>" />
            </p>
    
            <!-- Sub Headline: Text Input -->
            <p>
                <strong><label for="<?php echo $this->get_field_id( 'subheadline' ); ?>"><?php _e('Sub Headline:', 'leadpages-sticky'); ?></label></strong>
                <input id="<?php echo $this->get_field_id( 'subheadline' ); ?>" name="<?php echo $this->get_field_name( 'subheadline' ); ?>" class="widefat" type="text" size="36" value="<?php echo $subheadline; ?>" />
            </p>
            
        </div>
		
        <div class="genesis-widget-column-box" style="margin-bottom: 20px;">
            
            <!-- Button Only: Checkbox -->
            <p style="margin-top: 0;">
                <input class="checkbox" type="checkbox" value="1" <?php checked( $instance['btnonly'], 1 ); ?> id="<?php echo $this->get_field_id( 'btnonly' ); ?>" name="<?php echo $this->get_field_name( 'btnonly' ); ?>" /> 
                <label for="<?php echo $this->get_field_id( 'btnonly' ); ?>"> <strong>Show All Fields</strong></label>
                <br /><small>Un-checking the box will disable all fields except LeadBoxes Script and Button Color. Used for button only optin.</small>
            </p>
    
            <!-- Leadpages code: Textarea Input -->
            <p>
                <strong><label for="<?php echo $this->get_field_id( 'lpscript' ); ?>"><?php _e('LeadBoxes Script:', 'leadpages-sticky'); ?></label></strong>
                <textarea id="<?php echo $this->get_field_id( 'lpscript' ); ?>" name="<?php echo $this->get_field_name( 'lpscript' ); ?>" class="widefat"><?php echo $lpscript; ?></textarea>
            </p>
            
            <!-- Select Color: Button Color -->
            <p>
                <strong><label for="<?php echo $this->get_field_id( 'btncolor' ); ?>" style="display:block;"><?php _e( 'Button Color:', 'button-widget' ); ?></label></strong>
                <input class="widefat color-picker" id="<?php echo $this->get_field_id( 'btncolor' ); ?>" name="<?php echo $this->get_field_name( 'btncolor' ); ?>" type="text" value="<?php echo esc_attr( $btncolor ); ?>" />
            </p>
            
        </div>
        
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