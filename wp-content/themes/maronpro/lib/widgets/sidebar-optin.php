<?php
/**
 * Plugin Name: Appendipity Sidebar Optin Widget
 * Plugin URI: http://www.appendipity.com/sidebar-optin/
 * Description: A widget that allows you to add an optin form to the built in Appendipity Sidebar Optin
 * Version: 2.0
 * Author: Ian Belanger
 * Author URI: http://belangerwebconsulting.com
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'sidebar_optin_load_widgets' );

/**
 * Register our widget.
 * 'App_Sidebar_Optin' is the widget class used below.
 *
 * @since 0.1
 */
function sidebar_optin_load_widgets() {
	register_widget( 'App_Sidebar_Optin' );
}

/**
 * App_Sidebar_Optin class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.
 *
 * @since 0.1
 */
class App_Sidebar_Optin extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'sidebar-optin', 'description' => __('Create a Custom Optin Form in any widget area.', 'sidebar-optin') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sidebar-optin-widget' );

		/* Create the widget. */
		parent::__construct( 'sidebar-optin-widget', __('Appendipity Optin', 'sidebar-optin'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
		
		$widget_class 		= $args['widget_id'];
		$widget_prefix 		= 'sidebar-optin-widget-';
		$id_num 			= str_replace( $widget_prefix, '', $widget_class );
		$name_tab_index 	= $id_num * 100;
		$email_tab_index 	= $name_tab_index + 1;	
		$submit_tab_index 	= $name_tab_index + 2;
		
		global $app_options;
		
		$autoresponder 	=  $app_options[ 'autoresponder' ];

		// All Forms
		$title 			= apply_filters('widget_title', $instance['title'] );
		$subheadline 	= $instance['subheadline'];
		$bulletone 		= $instance['bulletone'];
		$bullettwo 		= $instance['bullettwo'];
		$bulletthree 	= $instance['bulletthree'];
		$ebookimg 		= $instance['ebookimg'];
		$showname 		= isset( $instance['showname'] ) ? $instance['showname'] : false;
		$nametext 		= isset( $instance['nametext'] ) ? $instance['nametext'] : 'Enter Your Name';
		$emailtext 		= isset( $instance['emailtext'] ) ? $instance['emailtext'] : 'Enter Best Email';
		$btntext 		= $instance['btntext'];
		
		// GetResponse
		$campaign 		= $instance['campaign'];
		$confirmurl 	= $instance['confirmurl'];
		
		// Aweber
		$listname 		= $instance['listname'];
		$awtyurl 		= $instance['awtyurl'];
		$awtrack 		= $instance['awtrack'];
		
		// iContact
		$hiddeninput 	= $instance['hiddeninput'];
		$ictyurl 		= $instance['ictyurl'];
		
		// MailChimp
		$formlink 		= $instance['formlink'];
		
		// Infusionsoft
		$inf_form_xid	= $instance['inf_form_xid'];
		$inf_form_name	= $instance['inf_form_name'];
		$inf_track_xid	= $instance['inf_track_xid'];
		$inf_form_url	= $instance['inf_form_url'];
		$inf_form_ver	= $instance['inf_form_ver'];
		
		// ConvertKit
		$lp_id 			= $instance['lp_id'];
		
		/* Before widget (defined by themes). */
		echo $before_widget;
		
		echo '<div class="sb-optin">';

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* Adds Sub Headline to Appendipity Sidebar Optin. */
		if ( $subheadline ) { ?>

			<p><?php echo $subheadline; ?></p>
		
		<?php
        }
		if ( empty( $ebookimg ) && $bulletone ) {
			
			echo '<ul class="wide">';
			
		} else if ( $bulletone ) {
			
        	echo '<ul>';
			
		} else {
			
			echo'';
			
		}

		/* Adds Bullet One to Appendipity Sidebar Optin. */
		if ( $bulletone ) { ?>

			<li><i class="icon-ok"></i>&nbsp;&nbsp;<?php echo $bulletone; ?></li>
		
		<?php
        }
		
		/* Adds Bullet Two to Appendipity Sidebar Optin. */
		if ( $bullettwo ) { ?>
        
			<li><i class="icon-ok"></i>&nbsp;&nbsp;<?php echo $bullettwo; ?></li>
		
		<?php
        }
		
		/* Adds Bullet Three to Appendipity Sidebar Optin. */
		if ( $bulletthree ) { ?>

			<li><i class="icon-ok"></i>&nbsp;&nbsp;<?php echo $bulletthree; ?></li>
		
		<?php
        }
		
		if ( $bulletone ) {
        	echo '</ul>';
		}
		
		/* Adds Bullet Three to Appendipity Sidebar Optin. */
		if ( $ebookimg && empty( $bulletone ) ) {
			
			echo '<div class="ebookimg wide"><img class="aligncenter" src="' . $ebookimg . '" /></div>';
			
		} else if ( $ebookimg ) {
			
			echo '<div class="ebookimg"><img class="aligncenter" src="' . $ebookimg . '" /></div>';
			
        } else {
		
			echo '';
			
        }

		if ( $ebookimg ) {		
		
			echo'<div class="sb-optin-form">';
			
		} else {
			
			echo'<div class="sb-optin-form" class="wide">';
			
		}
		
		/* Adds aweber form code to Appendipity Sidebar Optin. */
		if ( $autoresponder == 'getresponse' ) { ?>

			<form class="form-wrapper" action="http://www.getresponse.com/cgi-bin/add.cgi" method="post" accept-charset="UTF-8">
				<div style="display: none;">
					<input type="hidden" name="campaign_name" value="<?php echo $campaign; ?>" />
					<input type="hidden" name="confirmation_url" value="<?php echo $confirmurl; ?>" />
				</div>
                <?php if ( $showname ) { ?>
					<input class="text name" type="text" name="name" value="<?php echo $nametext; ?>" tabindex="<?php echo $name_tab_index; ?>" onfocus=" if (this.value == '<?php echo $nametext; ?>') { this.value = ''; }" onblur="if (this.value == '') { this.value='<?php echo $nametext; ?>';} " />
                <?php } else { ?>
                    <input type="hidden" name="name" value="Friend"/>
                <?php } ?>
				<input class="text" type="text" name="email" value="<?php echo $emailtext; ?>" tabindex="<?php echo $email_tab_index; ?>" onfocus=" if (this.value == '<?php echo $emailtext; ?>') { this.value = ''; }" onblur="if (this.value == '') { this.value='<?php echo $emailtext; ?>';} " />
				<input name="submit" class="submit" type="submit" value="<?php echo $btntext; ?>" tabindex="<?php echo $submit_tab_index; ?>" />
			</form>
                    
		<?php } elseif ( $autoresponder == 'aweber' ) { ?>

			<form method="post" class="form-wrapper" action="http://www.aweber.com/scripts/addlead.pl">
				<div style="display: none;">
                	<input type="hidden" name="meta_web_form_id" value="" />
					<input type="hidden" name="meta_split_id" value="" />
                    <input type="hidden" name="listname" value="<?php echo $listname; ?>" />
                    <input type="hidden" name="redirect" value="<?php echo $awtyurl; ?>" />
                    <input type="hidden" name="meta_adtracking" value="<?php echo $awtrack; ?>" />
                    <input type="hidden" name="meta_message" value="1" />
                    <input type="hidden" name="meta_required" value="email" />
				</div>
                <?php if ( $showname ) { ?>
					<input class="text name" type="text" name="name" value="<?php echo $nametext; ?>" tabindex="<?php echo $name_tab_index; ?>" onfocus=" if (this.value == '<?php echo $nametext; ?>') { this.value = ''; }" onblur="if (this.value == '') { this.value='<?php echo $nametext; ?>';} " />
                <?php } else { ?>
                   	<input type="hidden" value="Friend" name="name" class="name" >
                <?php } ?>
				<input class="text" type="text" name="email" value="<?php echo $emailtext; ?>" tabindex="<?php echo $email_tab_index; ?>" onfocus=" if (this.value == '<?php echo $emailtext; ?>') { this.value = ''; }" onblur="if (this.value == '') { this.value='<?php echo $emailtext; ?>';} " />
				<input name="submit" class="submit" type="submit" value="<?php echo $btntext; ?>" tabindex="<?php echo $submit_tab_index; ?>" />
			</form>
                    
		<?php } elseif ( $autoresponder == 'icontact' ) { ?>

			<form method="post" class="form-wrapper" action="https://app.icontact.com/icp/signup.php" name="icpsignup">
            	<input type="hidden" name="redirect" value="<?php echo $ictyurl; ?>">
                <input type="hidden" name="errorredirect" value="http://www.icontact.com/www/signup/error.html">
                <div style="display: none;">
                     <?php echo $hiddeninput; ?>
                </div>
                <?php if ( $showname ) { ?>
                     <input class="text name" type="text" name="fields_name" value="<?php echo $nametext; ?>" tabindex="<?php echo $name_tab_index; ?>" onfocus=" if (this.value == '<?php echo $nametext; ?>') { this.value = ''; }" onblur="if (this.value == '') { this.value='<?php echo $nametext; ?>';} " />
                <?php } else { ?>
                     <input type="hidden" value="Friend" name="fields_name" class="name" >
                <?php } ?>
                <input class="text" type="text" name="fields_email" value="<?php echo $emailtext; ?>" tabindex="<?php echo $email_tab_index; ?>" onfocus=" if (this.value == '<?php echo $emailtext; ?>') { this.value = ''; }" onblur="if (this.value == '') { this.value='<?php echo $emailtext; ?>';} " />
                <input name="submit" class="submit" type="submit" value="<?php echo $btntext; ?>" tabindex="<?php echo $submit_tab_index; ?>" />
			</form>

		<?php }	elseif ( $autoresponder == 'mailchimp' ) { ?>

			<form action="<?php echo $formlink; ?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate form-wrapper" target="_blank">
				<div id="mce-responses" class="clear">
					<div class="response" id="mce-error-response" style="display:none"></div>
					<div class="response" id="mce-success-response" style="display:none"></div>
				</div>
                <?php if ( $showname ) { ?>
					<input class="text name" type="text" name="FNAME" id="mce-FNAME" value="<?php echo $nametext; ?>" tabindex="<?php echo $name_tab_index; ?>" onfocus=" if (this.value == '<?php echo $nametext; ?>') { this.value = ''; }" onblur="if (this.value == '') { this.value='<?php echo $nametext; ?>';} " />
                <?php } else { ?>
                    <input type="hidden" value="Friend" name="FNAME" class="name" id="mce-FNAME" >
                <?php } ?>
				<input class="text" type="text" name="EMAIL" id="mce-EMAIL" value="<?php echo $emailtext; ?>" tabindex="<?php echo $email_tab_index; ?>" onfocus=" if (this.value == '<?php echo $emailtext; ?>') { this.value = ''; }" onblur="if (this.value == '') { this.value='<?php echo $emailtext; ?>';} " />
				<input name="submit" class="submit" type="submit" value="<?php echo $btntext; ?>" tabindex="<?php echo $submit_tab_index; ?>" />
			</form>
		
		<?php } elseif ( $autoresponder == 'infusionsoft' ) { ?>

			<form accept-charset="UTF-8" action="<?php echo $inf_form_url; echo $inf_form_xid;?>" class="infusion-form" method="POST">					
            	<input name="inf_form_xid" type="hidden" value="<?php echo $inf_form_xid; ?>" />
                <input name="inf_form_name" type="hidden" value="<?php echo $inf_form_name; ?>" />
                <input name="infusionsoft_version" type="hidden" value="<?php echo $inf_form_ver; ?>" />					
                        
                <?php if ( $showname ) { ?>
                                            
                	<input class="text name infusion-field-input-container" type="text" name="inf_field_FirstName" value="<?php echo $nametext; ?>" tabindex="<?php echo $name_tab_index; ?>" onfocus=" if (this.value == '<?php echo $nametext; ?>') { this.value = ''; }" onblur="if (this.value == '') { this.value='<?php echo $nametext; ?>';} " />
    
                <?php } else { ?>
    
                    <input type="hidden" value="Friend" name="inf_field_FirstName" class="name" >
    
                <?php } ?>
                        
            <input class="text infusion-field-input-container" type="text" name="inf_field_Email" value="<?php echo $emailtext; ?>" tabindex="<?php echo $email_tab_index; ?>" onfocus=" if (this.value == '<?php echo $emailtext; ?>') { this.value = ''; }" onblur="if (this.value == '') { this.value='<?php echo $emailtext; ?>';} " />
    
            <input name="submit" class="submit" type="submit" value="<?php echo $btntext; ?>" tabindex="<?php echo $submit_tab_index; ?>" />

			</form>
			<script type="text/javascript" src="https://kw216.infusionsoft.com/app/webTracking/getTrackingCode?trackingId=<?php echo $inf_track_xid; ?>"></script>

		<?php } elseif ( $autoresponder == 'convertkit' ) { ?>
        
			<form id="ck_subscribe_form" class="ck_subscribe_form" action="https://app.convertkit.com/landing_pages/<?php echo $lp_id; ?>/subscribe" data-remote="true">					
            	<input type="hidden" name="id" value="<?php echo $lp_id; ?>" id="landing_page_id">					
                        
                <?php if ( $showname ) { ?>
                          
                	<input id="ck_firstNameField" class="text name ck_first_name" type="text" name="first_name" value="<?php echo $nametext; ?>" tabindex="<?php echo $name_tab_index; ?>" onfocus=" if (this.value == '<?php echo $nametext; ?>') { this.value = ''; }" onblur="if (this.value == '') { this.value='<?php echo $nametext; ?>';} " />
    
                <?php } else { ?>
    
                    <input id="ck_firstNameField" type="hidden" value="Friend" name="first_name" class="name ck_first_name" >
    
                <?php } ?>
                
            <input id="ck_emailField" class="text ck_email_address" type="text" name="email" value="<?php echo $emailtext; ?>" tabindex="<?php echo $email_tab_index; ?>" onfocus=" if (this.value == '<?php echo $emailtext; ?>') { this.value = ''; }" onblur="if (this.value == '') { this.value='<?php echo $emailtext; ?>';} " />
    
            <input id="ck_subscribe_button" name="submit" class="submit ck_subscribe_button" type="submit" value="<?php echo $btntext; ?>" tabindex="<?php echo $submit_tab_index; ?>" />

			</form>

		<?php }	
	
		echo '</div></div>';
		
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// All Forms
		$instance['title'] 			= strip_tags( $new_instance['title'] );
		$instance['subheadline'] 	= strip_tags( $new_instance['subheadline'] );
		$instance['bulletone'] 		= strip_tags( $new_instance['bulletone'] );
		$instance['bullettwo'] 		= strip_tags( $new_instance['bullettwo'] );
		$instance['bulletthree'] 	= strip_tags( $new_instance['bulletthree'] );
		$instance['ebookimg'] 		= strip_tags( $new_instance['ebookimg'] );
		$instance['showname'] 		= $new_instance['showname'];
		$instance['nametext'] 		= strip_tags( $new_instance['nametext'] );
		$instance['emailtext'] 		= strip_tags( $new_instance['emailtext'] );
		$instance['btntext'] 		= strip_tags( $new_instance['btntext'] );
		
		// GetResponse
		$instance['campaign'] 		= strip_tags( $new_instance['campaign'] );
		$instance['confirmurl'] 	= strip_tags( $new_instance['confirmurl'] );
		
		// Aweber
		$instance['listname'] 		= strip_tags( $new_instance['listname'] );
		$instance['awtyurl'] 		= strip_tags( $new_instance['awtyurl'] );
		$instance['awtrack'] 		= strip_tags( $new_instance['awtrack'] );
		
		// iContact
		if ( current_user_can('unfiltered_html') )
			$instance['hiddeninput'] = $new_instance['hiddeninput'];
		$instance['ictyurl'] 		= strip_tags( $new_instance['ictyurl'] );
		
		// MailChimp
		$instance['formlink'] 		= strip_tags( $new_instance['formlink'] );
		
		// Infusionsoft
		$instance['inf_form_xid'] 	= strip_tags( $new_instance['inf_form_xid'] );
		$instance['inf_form_name'] 	= strip_tags( $new_instance['inf_form_name'] );
		$instance['inf_track_xid'] 	= strip_tags( $new_instance['inf_track_xid'] );
		$instance['inf_form_ver'] 	= strip_tags( $new_instance['inf_form_ver'] );
		$instance['inf_form_url'] 	= strip_tags( $new_instance['inf_form_url'] );
		
		// ConvertKit
		$instance['lp_id'] 			= strip_tags( $new_instance['lp_id'] );
		
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {
	
		global $app_options;
		
			$f_autoresponder =  $app_options[ 'autoresponder' ];
			
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'subheadline' =>'', 'bulletone' => '', 'bullettwo' => '', 'bulletthree' => '', 'ebookimg' => '', 'campaign' => '', 'confirmurl' => '', 'listname' => '', 'awtyurl' => '', 'awtrack' => '', 'hiddeninput' => '', 'ictyurl' => '', 'formlink' => '', 'inf_form_xid' => '', 'inf_form_name' => '', 'inf_track_xid' => '', 'inf_form_url' => '', 'inf_form_ver' => '', 'lp_id' => '', 'showname' => 1, 'nametext' => 'Enter Your Name', 'emailtext' => 'Enter Best Email', 'btntext' => 'Submit' ) );
		$title 			= esc_html($instance['title']);
		$subheadline 	= esc_html($instance['subheadline']);
		$bulletone 		= esc_html($instance['bulletone']);
		$bullettwo 		= esc_html($instance['bullettwo']);
		$bulletthree 	= esc_html($instance['bulletthree']);
		$ebookimg 		= esc_html($instance['ebookimg']);
		$showname 		= $instance['showname'];
		$nametext 		= esc_html($instance['nametext']);
		$emailtext 		= esc_html($instance['emailtext']);
		$btntext 		= esc_html($instance['btntext']);
		
		// GetResponse
		$campaign 		= esc_html($instance['campaign']);
		$confirmurl 	= esc_html($instance['confirmurl']);
		
		// Aweber
		$listname 		= esc_html($instance['listname']);
		$awtyurl 		= esc_html($instance['awtyurl']);
		$awtrack 		= esc_html($instance['awtrack']);
		
		//iContact
		$hiddeninput 	= $instance['hiddeninput'];
		$ictyurl 		= esc_html($instance['ictyurl']);
		
		// MailChimp
		$formlink 		= esc_html($instance['formlink']);
		
		// Infusionsoft
		$inf_form_xid	= esc_html($instance['inf_form_xid']);
		$inf_form_name	= esc_html($instance['inf_form_name']);
		$inf_track_xid	= esc_html($instance['inf_track_xid']);
		$inf_form_url	= esc_html($instance['inf_form_url']);
		$inf_form_ver	= esc_html($instance['inf_form_ver']);
		
		// ConvertKit
		$lp_id			= esc_html($instance['lp_id']);
?>
                
		<!-- Tutorial Link 
        <p><strong>Need Help? Check out the <a target="_blank" href="http://www.appendipity.com/tutorial/" title="Sidebar Optin Tutorial" >Sidebar Optin Tutorial</a></strong></p>-->
        
		<!-- Widget Title: Text Input -->
		<p>
			<strong><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Call to Action:', 'hybrid'); ?></label></strong>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" class="widefat" type="text" size="36" value="<?php echo $title; ?>" />
		</p>

        <!-- Sub Headline: Text Input -->
		<p>
			<strong><label for="<?php echo $this->get_field_id( 'subheadline' ); ?>"><?php _e('Sub Headline:', 'sidebar-optin'); ?></label></strong>
			<input id="<?php echo $this->get_field_id( 'subheadline' ); ?>" name="<?php echo $this->get_field_name( 'subheadline' ); ?>" class="widefat" type="text" size="36" value="<?php echo $subheadline; ?>" />
		</p>
            
        <!-- Bullet 1: Text Input -->
		<p>
			<strong><label for="<?php echo $this->get_field_id( 'bulletone' ); ?>"><?php _e('Bullet Point 1:', 'sidebar-optin'); ?></label></strong>
			<input id="<?php echo $this->get_field_id( 'bulletone' ); ?>" name="<?php echo $this->get_field_name( 'bulletone' ); ?>" class="widefat" type="text" size="36" value="<?php echo $bulletone; ?>" />
		</p>

		<!-- Bullet 2: Text Input -->
		<p>
			<strong><label for="<?php echo $this->get_field_id( 'bullettwo' ); ?>"><?php _e('Bullet Point 2:', 'sidebar-optin'); ?></label></strong>
			<input id="<?php echo $this->get_field_id( 'bullettwo' ); ?>" name="<?php echo $this->get_field_name( 'bullettwo' ); ?>" class="widefat" type="text" size="36" value="<?php echo $bullettwo; ?>" />
		</p>  

		<!-- Bullet 3: Text Input -->
		<p>
			<strong><label for="<?php echo $this->get_field_id( 'bulletthree' ); ?>"><?php _e('Bullet Point 3:', 'sidebar-optin'); ?></label></strong>
			<input id="<?php echo $this->get_field_id( 'bulletthree' ); ?>" name="<?php echo $this->get_field_name( 'bulletthree' ); ?>" class="widefat" type="text" size="36" value="<?php echo $bulletthree; ?>" />
		</p>

		<!-- Image Link: Media Uploader -->
        <p>
            <strong><label for="<?php echo $this->get_field_name( 'ebookimg' ); ?>"><?php _e( 'eBook Image:', 'sidebar-optin'); ?></label></strong>
            <input name="<?php echo $this->get_field_name( 'ebookimg' ); ?>" id="<?php echo $this->get_field_id( 'ebookimg' ); ?>" class="widefat" type="text" size="36" value="<?php echo esc_url( $ebookimg ); ?>" />
            <input class="upload_image_button" type="button" value="Upload Image" />
            <br /><small>Use png or gif with a transparent background.</small>
        </p>
        
		<?php if ( $f_autoresponder == 'getresponse' ) { ?>
        
            <!-- Campaign: Text Input -->
            <p>
                <strong><label for="<?php echo $this->get_field_id( 'campaign' ); ?>"><?php _e('GetResponse Campaign Name:', 'sidebar-optin'); ?></label></strong>
                <input id="<?php echo $this->get_field_id( 'campaign' ); ?>" name="<?php echo $this->get_field_name( 'campaign' ); ?>" class="widefat" type="text" size="36" value="<?php echo $campaign; ?>" />
            </p>
    
            <!-- Confirmation Url: Text Input -->
            <p>
                <strong><label for="<?php echo $this->get_field_id( 'confirmurl' ); ?>"><?php _e('Confirmation URL:', 'sidebar-optin'); ?></label></strong>
                <input id="<?php echo $this->get_field_id( 'confirmurl' ); ?>" name="<?php echo $this->get_field_name( 'confirmurl' ); ?>" class="widefat" type="text" size="36" value="<?php echo $confirmurl; ?>" />
            <small>Leave Empty for Default Page</small>
            </p>
        
		<?php } elseif ( $f_autoresponder == 'aweber' ) { ?>
        
            <!-- Listname: Text Input -->
            <p>
                <strong><label for="<?php echo $this->get_field_id( 'listname' ); ?>"><?php _e('Aweber Unique List ID:', 'sidebar-optin'); ?></label></strong>
                <input id="<?php echo $this->get_field_id( 'listname' ); ?>" name="<?php echo $this->get_field_name( 'listname' ); ?>" class="widefat" type="text" size="36" value="<?php echo $listname; ?>" />
            </p>
    
            <!-- Thank You Url: Text Input -->
            <p>
                <strong><label for="<?php echo $this->get_field_id( 'awtyurl' ); ?>"><?php _e('Thank You URL:', 'sidebar-optin'); ?></label></strong>
                <input id="<?php echo $this->get_field_id( 'awtyurl' ); ?>" name="<?php echo $this->get_field_name( 'awtyurl' ); ?>" class="widefat" type="text" size="36" value="<?php echo $awtyurl; ?>" />
            <small>Use http://www.aweber.com/thankyou.htm?m=default for default page.</small> 
            </p> 
    
            <!-- Tracking Tag: Text Input -->
            <p>
                <strong><label for="<?php echo $this->get_field_id( 'awtrack' ); ?>"><?php _e('Form Tracking Tag:(Optional)', 'sidebar-optin'); ?></label></strong>
                <input id="<?php echo $this->get_field_id( 'awtrack' ); ?>" name="<?php echo $this->get_field_name( 'awtrack' ); ?>" class="widefat" type="text" size="36" value="<?php echo $awtrack; ?>" />
            <small>Use to track each form separately.</small>
            </p>
        
		<?php } elseif ( $f_autoresponder == 'icontact' ) { ?>

            <!-- Optin Form Code: Textarea Input -->
            <p>
                <strong><label for="<?php echo $this->get_field_id( 'hiddeninput' ); ?>"><?php _e('Optin Form Code:', 'sidebar-optin'); ?></label></strong>
                <textarea id="<?php echo $this->get_field_id( 'hiddeninput' ); ?>" name="<?php echo $this->get_field_name( 'hiddeninput' ); ?>" class="widefat" rows="8" cols="4" style="width:97%;" ><?php echo $hiddeninput; ?></textarea>
            </p>
    
            <!-- Thank You Url: Text Input -->
            <p>
                <strong><label for="<?php echo $this->get_field_id( 'ictyurl' ); ?>"><?php _e('Thank You URL:', 'sidebar-optin'); ?></label></strong>
                <input id="<?php echo $this->get_field_id( 'ictyurl' ); ?>" name="<?php echo $this->get_field_name( 'ictyurl' ); ?>" class="widefat" type="text" size="36" value="<?php echo $ictyurl; ?>" />
            <small>Use http://www.icontact.com/www/signup/thanks.html for default page.</small>
            </p>  
    
            <!-- Error Page URL: Text Input -->
            <p>
                <strong><label for="<?php echo $this->get_field_id( 'errorurl' ); ?>"><?php _e('Error Page URL:', 'sidebar-optin'); ?></label></strong>
                <input id="<?php echo $this->get_field_id( 'errorurl' ); ?>" name="<?php echo $this->get_field_name( 'errorurl' ); ?>" class="widefat" type="text" size="36" value="<?php echo $errorurl; ?>" />
            <small>Use http://www.icontact.com/www/signup/error.html for default page.</small>
            </p>

		<?php }	elseif ( $f_autoresponder == 'mailchimp' ) { ?>
        
            <!-- Listname: Text Input -->
            <p>
                <strong><label for="<?php echo $this->get_field_id( 'formlink' ); ?>"><?php _e('MailChimp Form Link:', 'sidebar-optin'); ?></label></strong>
                <input id="<?php echo $this->get_field_id( 'formlink' ); ?>" name="<?php echo $this->get_field_name( 'formlink' ); ?>" class="widefat" type="text" size="36" value="<?php echo $formlink; ?>" />
            </p>
		
		<?php } elseif ( $f_autoresponder == 'infusionsoft' ) { ?>

            <!-- Campaign: Text Input -->
            <p>
                <strong><label for="<?php echo $this->get_field_id( 'inf_form_name' ); ?>"><?php _e('Infusionsoft Form Name:', 'sidebar-optin'); ?></label></strong>
                <input id="<?php echo $this->get_field_id( 'inf_form_name' ); ?>" name="<?php echo $this->get_field_name( 'inf_form_name' ); ?>" class="widefat" type="text" size="36" value="<?php echo $inf_form_name; ?>" />
            </p>
            
            <p>
                <strong><label for="<?php echo $this->get_field_id( 'inf_form_xid' ); ?>"><?php _e('Infusionsoft Form XID:', 'sidebar-optin'); ?></label></strong>
                <input id="<?php echo $this->get_field_id( 'inf_form_xid' ); ?>" name="<?php echo $this->get_field_name( 'inf_form_xid' ); ?>" class="widefat" type="text" size="36" value="<?php echo $inf_form_xid; ?>" />
            </p>
            
            <p>
                <strong><label for="<?php echo $this->get_field_id( 'inf_track_xid' ); ?>"><?php _e('Infusionsoft Tracking XID:', 'sidebar-optin'); ?></label></strong>
                <input id="<?php echo $this->get_field_id( 'inf_track_xid' ); ?>" name="<?php echo $this->get_field_name( 'inf_track_xid' ); ?>" class="widefat" type="text" size="36" value="<?php echo $inf_track_xid; ?>" />
            </p>
            
            <p>
                <strong><label for="<?php echo $this->get_field_id( 'inf_form_url' ); ?>"><?php _e('Infusionsoft form URL [e.g. https://.../process/ ]:', 'sidebar-optin'); ?></label></strong>
                <input id="<?php echo $this->get_field_id( 'inf_form_url' ); ?>" name="<?php echo $this->get_field_name( 'inf_form_url' ); ?>" class="widefat" type="text" size="36" value="<?php echo $inf_form_url; ?>" />
            </p>
            
            <p>
                <strong><label for="<?php echo $this->get_field_id( 'inf_form_ver' ); ?>"><?php _e('Infusionsoft form version:', 'sidebar-optin'); ?></label></strong>
                <input id="<?php echo $this->get_field_id( 'inf_form_ver' ); ?>" name="<?php echo $this->get_field_name( 'inf_form_ver' ); ?>" class="widefat" type="text" size="36" value="<?php echo $inf_form_ver; ?>" />
            </p>

		<?php }	elseif ( $f_autoresponder == 'convertkit' ) { ?>
        
            <!-- Listname: Text Input -->
            <p>
                <strong><label for="<?php echo $this->get_field_id( 'lp_id' ); ?>"><?php _e('ConvertKit Landing Page ID:', 'sidebar-optin'); ?></label></strong>
                <input id="<?php echo $this->get_field_id( 'lp_id' ); ?>" name="<?php echo $this->get_field_name( 'lp_id' ); ?>" class="widefat" type="text" size="36" value="<?php echo $lp_id; ?>" />
            <small>Landing Page ID ex. - https://app.convertkit.com/landing_pages/<strong style="color: #ff0000">0000</strong>/subscribe</small> 
            </p>
            
        <?php } ?>
            
            <!-- Show Name: Checkbox -->
            <p>
                <input class="checkbox" type="checkbox" value="1" <?php checked( $instance['showname'], 1 ); ?> id="<?php echo $this->get_field_id( 'showname' ); ?>" name="<?php echo $this->get_field_name( 'showname' ); ?>" /> 
                <label for="<?php echo $this->get_field_id( 'showname' ); ?>"> <strong>Check Box to Show Name Field</strong></label>
            </p>
            
            <!-- Name Text: Text Input -->
            <p>
                <strong><label for="<?php echo $this->get_field_id( 'nametext' ); ?>"><?php _e('Name Field Text:', 'sidebar-optin'); ?></label></strong>
                <input id="<?php echo $this->get_field_id( 'nametext' ); ?>" name="<?php echo $this->get_field_name( 'nametext' ); ?>" class="widefat" type="text" size="36" value="<?php echo $nametext; ?>" />
            </p>
            
            <!-- Submit Button Text: Text Input -->
            <p>
                <strong><label for="<?php echo $this->get_field_id( 'emailtext' ); ?>"><?php _e('Email Field Text:', 'sidebar-optin'); ?></label></strong>
                <input id="<?php echo $this->get_field_id( 'emailtext' ); ?>" name="<?php echo $this->get_field_name( 'emailtext' ); ?>" class="widefat" type="text" size="36" value="<?php echo $emailtext; ?>" />
            </p>
            
            <!-- Submit Button Text: Text Input -->
            <p>
                <strong><label for="<?php echo $this->get_field_id( 'btntext' ); ?>"><?php _e('Submit Button Text:', 'sidebar-optin'); ?></label></strong>
                <input id="<?php echo $this->get_field_id( 'btntext' ); ?>" name="<?php echo $this->get_field_name( 'btntext' ); ?>" class="widefat" type="text" size="36" value="<?php echo $btntext; ?>" />
            </p>
             
		<?php
        }
}

?>