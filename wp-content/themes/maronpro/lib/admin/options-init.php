<?php

/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('admin_folder_Redux_Framework_config')) {

    class admin_folder_Redux_Framework_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['app_options'].'/compiler', array( $this, 'compiler_action' ), 10, 3);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * 
        function compiler_action($options, $css, $changed_values) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r($changed_values); // Values that have changed since the last save
            echo "</pre>";
            print_r($options); //Option values
            print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/compile.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             
        } */

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'redux-framework-demo'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'redux-framework-demo'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'redux-framework-demo'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'redux-framework-demo'), $this->theme->display('Version')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            /* if ($this->theme->parent()) {
                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'redux-framework-demo'), $this->theme->parent()->display('Name'));
            } */
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }

            // ACTUAL DECLARATION OF SECTIONS
            $this->sections[] = array(
                'title'     => __('Getting Started', 'redux-framework-demo'),
                'desc'      => __('Welcome to the Appendipity Theme Options!', 'redux-framework-demo'),
                'icon'      => 'el-icon-dashboard',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields'    =>  array(
					array(
						'id'       => 'video-started',
						'type'     => 'raw',
						'desc'     => __('', 'redux-framework-demo'),
						'content'  => '<p>Hello, this is the getting started page. This is just a quick walkthrough of the Appendipity Options Framework so you\'ll be familiar with how it works and where everything is at.</p><br />
						<p>With Appendipity Options you\'ll be able to edit, stylize and pretty much customize your theme and site to your liking.</p><br />
						<p><strong>Support:</strong></p><p> Now let\'s start with how to contact us if and when you need any kind of help, support, having trouble with your theme or just stuck on something with your Appendipity Options.</p><br />
						<p>At the very top right hand corner you will see a tab called <strong>"Help"</strong>. Just click to open and there you can reach our help desk or you can simply click here: <a href="http://appendipity.com/helpdesk" target="_blank">http://appendipity.com/helpdesk</a></p><br />
						<p><strong>Menu Tabs:</strong></p>
						<p>To the left of this body text you will see a set of Menu Tabs. These are your Appendipity Options Tabs which are assigned to specific sections of your theme which allows you to edit, stylize and customize those specific sections of your theme.</p><br />
						<p><strong>Edit, Stylize and Customize:</strong></p>
						<p>To edit, stylize and customize a specific section of your theme simply click on the tab you would like to edit and stylize.</p><br />
						<p><strong>Saving your Changes and Settings:</strong></p>
						<p>Once you\'re done editing and stylizing that specific section, you\'re going to want to save it.</p><br />
						<p>To save simply either scroll up or down and click on the "Save Changes" button.</p><br />
						<p>Preview your theme once you save your changes to see if anymore editing is needed.</p><br />
						<p>Next to the save button you\'ll notice a Reset Section button. Clicking this button will reset that specific section to it\'s default settings.</p><br />
						<p>The last button is Reset All. Clicking this button will reset your entire Appendipity Options to its default settings.</p><br />
						<p><strong>WARNING!</strong> Be very careful with this button as it will reset your entire settings. ONLY do this if you\'re sure you want to reset all.</p><br />
						<p>Thank you for being a part of the Appendipity family. We hope you enjoy using our themes as much as we\'ve enjoyed creating them for you. If you have any suggestions or questions, please feel free to <a href="http://appendipity.com/helpdesk" target="_blank">contact us here</a>.</p>',
						//'align'		=> 'sectioned'
					),
				),
            );

            $this->sections[] = array(
                'type' => 'divide',
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-globe',
                'title'     => __('Sitewide Style', 'redux-framework-demo'),
                'heading'   => __('Completely customize the Sitewide Style.', 'redux-framework-demo'),
                'desc'      => __('', 'redux-framework-demo'),
                'fields'    => array(
					array(
						'id'       => 'video-style',
						'type'     => 'raw',
						//'title'    => __('Getting Started', 'redux-framework-demo'),
						//'subtitle' => __('Watch the video to see how to use the settings in this section.', 'redux-framework-demo'),
						//'desc'     => __('This is the description field for additional info.', 'redux-framework-demo'),
						//'content'  => '<iframe width="720" height="405" src="//www.youtube.com/embed/h5IhnsEjy_s?rel=0&amp;autohide=1&amp;modestbranding=1&amp;showinfo=0" frameborder="0" allowfullscreen="allowfullscreen"></iframe>',
						'content'  => '<p>This section is the Sitewide Styling section and basically here you will choose your color scheme of your theme.</p>
										<br />
										<p>We have 3 main color schemes, Default, light and dark. By default your theme will be in the default version.</p>
										<br />
										<p>Once you choose your color scheme you can leave as is or stylize as you wish.</p>
										<br />
										<p>You can change: </p>
										<ul style="list-style: outside none disc; padding-left: 30px;">
										  <li>
											colors of your links, both on hover and regular.
										  </li>
										  <li>
											body font style, size and color
										  </li>
										  <li>
											heading font style, size and color
										  </li>
										  <li>
											background color or upload a background image
										  </li>
										  <li>
											enable or disable Post Info
										  </li>
										  <li>
											enable or disable Post Meta
										  </li>
										  <li>
											Navigation Menu fonts styles and colors
										  </li>
										</ul>
										<p><strong>Saving your Changes and Settings:</strong></p>
										<p>Once you&rsquo;re done editing and stylizing this section simply either scroll up or down and click on the &ldquo;Save Changes&rdquo; button. </p>
										<br />
										<p>Once saved preview your theme to see if anymore editing is needed. You can either leave as is, edit some more, or reset this section by clicking the &ldquo;Reset Section&rdquo; button. Clicking this button will reset that specific section to it&rsquo;s default settings.</p><br />
										<p><strong>WARNING!</strong> The last button is Reset All. Clicking this button will reset your entire Appendipity Options to its default settings. Be very careful with this button as it will reset your entire settings. ONLY do this if you&rsquo;re sure you want to reset all.</p><hr>',
						//'align'		=> 'sectioned'
					),
					array(
						'id'   =>'ss-divide',
						'type' => 'divide',
					),
                    array(
                        'id'        => 'colors',
                        'type'      => 'switch',
						'required' 	=> array('layout','equals','1'),
                        'title'     => __('Theme Color Scheme', 'redux-framework-demo'),
                        'subtitle'  => __('Choose your sitewide color scheme', 'redux-framework-demo'),
                        'default'   => true,
                        'on'        => 'Light',
                        'off'       => 'Dark',
                    ),
                    array(
                        'id'        => 'ld-color-scheme',
                        'type'      => 'image_select',
                        'title'     => __('Theme Color Scheme', 'redux-framework-demo'),
                        'subtitle'  => __('Choose your sitewide color scheme', 'redux-framework-demo'),
						'presets'	=> true,
                        'options'   => array(
                            'default' => array(
								'title' => 'Default',
								'img' => get_stylesheet_directory_uri() . '/images/schemes/default-scheme.png',
								'presets' =>'{"colors":"1","body-bg":{"background-color":"#ececec"},"body-font":{"color":"#333"},"heading-font":{"color":"#000"},"message-bar-bg":{"color":"#e5e5e5","alpha":"0.5"},"message-bar-font":{"color":"#000"},"nav-bg":"#343434","nav-hover-bg":"#f76d3c","nav-text-color":"#cbcbcb","header-bg":"#292929","site-title-link":{"regular":"#cbcbcb","hover":"#f76d3c"},"hb-bg":"#292929","fg-bg":{"color":"#f4f4f4","alpha":"1"},"fg-text":"#000","fg-link":{"regular":"#000","hover":"#888"},"mp-headline-text-color":"#cbcbcb","player-bg-overlay":"#292929","mp-content-bg":{"color":"#000","alpha":"0.7"},"sp-text-color":"#cbcbcb","sp-link":{"regular":"#000","hover":"#777"},"player-button-bg":"#cbcbcb","player-button-bg-hover":"#f76d3c","d-link":{"regular":"#cbcbcb","hover":"#f76d3c"},"audio-bg":{"color":"#292929","alpha":"0.6"},"audio-text-color":"#cbcbcb","audio-link":{"regular":"#cbcbcb","hover":"#f76d3c"},"sm-d-link":{"regular":"#cbcbcb","hover":"#f76d3c"},"abp-bg":"#f8f8f8","optin-font":{"color":"#cbcbcb"},"optin-bg-color":"#292929","pnp-bg":"#f8f8f8","pnp-link":{"regular":"#333","hover":"#ececec"},"rp-bg":"#f8f8f8","rp-text":"#333","foot-bg":"#292929","foot-widget-bg":"#292929","foot-widget-text":"#cbcbcb","foot-text":"#cbcbcb"}'
							),
                            'light' => array(
								'title' => 'Light',
								'img' => get_stylesheet_directory_uri() . '/images/schemes/light-scheme.png',
								'presets' =>'{"colors":"1","body-bg":{"background-color":"#ececec"},"body-font":{"color":"#333"},"heading-font":{"color":"#333"},"message-bar-bg":{"color":"#8b8b8b","alpha":"1"},"message-bar-font":{"color":"#eee"},"nav-bg":"#d0d0d0","nav-hover-bg":"#707070","nav-text-color":"#6c6c6c","header-bg":"#e5e5e5","hb-bg":"#e5e5e5","abp-bg":"#f8f8f8","pnp-bg":"#f8f8f8","pnp-link":{"regular":"#333","hover":"#888"},"rp-bg":"#f8f8f8","rp-text":"#333","foot-bg":"#9b9b9b","foot-widget-bg":"#7c7c7c","foot-widget-text":"#333","foot-text":"#333","optin-font":{"color":"#333"},"optin-bg-color":"#9b9b9b","audio-text-color":"#333","site-title-link":{"regular":"#cbcbcb","hover":"#f76d3c"},"audio-bg":{"color":"#e4e4e4","alpha":"1"},"player-bg-overlay":"#b5b5b5","mp-content-bg":{"color":"#777","alpha":"1"},"sp-text-color":"#333","sp-link":{"regular":"#777","hover":"#333"},"player-button-bg":"#333","player-button-bg-hover":"#777","mp-headline-text-color":"#333","d-link":{"regular":"#777","hover":"#333"},"audio-text-color":"#333","audio-link":{"regular":"#777","hover":"#333"},"sm-d-link":{"regular":"#777","hover":"#333"},"fg-bg":{"color":"#c0c0c0","alpha":"1"},"fg-text":"#333","fg-link":{"regular":"#333","hover":"#888"}}'
							),
                            'dark' => array(
								'title' => 'Dark',
								'img' => get_stylesheet_directory_uri() . '/images/schemes/dark-scheme.png',
								'presets' =>'{"colors":"0","body-bg":{"background-color":"#121212"},"body-font":{"color":"#646464"},"heading-font":{"color":"#646464"},"message-bar-bg":{"color":"#262626","alpha":"1"},"message-bar-font":{"color":"#646464"},"nav-bg":"#101010","nav-hover-bg":"#373737","nav-text-color":"#ececec","header-bg":"#000","hb-bg":"#000","abp-bg":"#262626","pnp-bg":"#262626","pnp-link":{"regular":"#646464","hover":"#888"},"rp-bg":"#262626","rp-text":"#646464","foot-bg":"#262626","foot-widget-bg":"#1c1c1c","foot-widget-text":"#646464","foot-text":"#646464","optin-font":{"color":"#646464"},"optin-bg-color":"#262626","audio-text-color":"#646464","site-title-link":{"regular":"#cbcbcb","hover":"#f76d3c"},"audio-bg":{"color":"#414141","alpha":"1"},"player-bg-overlay":"#181818","mp-content-bg":{"color":"#000","alpha":"1"},"sp-text-color":"#646464","sp-link":{"regular":"#646464","hover":"#333"},"player-button-bg":"#333","player-button-bg-hover":"#777","mp-headline-text-color":"#646464","d-link":{"regular":"#646464","hover":"#333"},"audio-text-color":"#707070","audio-link":{"regular":"#707070","hover":"#333"},"sm-d-link":{"regular":"#707070","hover":"#333"},"fg-bg":{"color":"#222","alpha":"1"},"fg-text":"#646464","fg-link":{"regular":"#646464","hover":"#888"}}'
							),
						),
                        'default'   => 'default'
                    ),
                    array(
                        'id'        => 'links-color-scheme',
                        'type'      => 'image_select',
                        'title'     => __('Links and Buttons Color Scheme', 'redux-framework-demo'),
                        'subtitle'  => __('Choose your sitewide links and buttons color scheme', 'redux-framework-demo'),
						'presets'	=> true,
                        'options'   => array(
                            'default' => array(
								'title' => 'Default',
								'img' => get_stylesheet_directory_uri() . '/images/schemes/default.png',
								'presets' =>'{"links-color":{"regular":"#f76d3c","hover":"#ce5124"},"nav-hover-bg":"#f76d3c","site-title-link":{"regular":"#f76d3c","hover":"#ce5124"},"desc-color":"#555","pnp-bg-hover":"#f76d3c","rp-link":{"regular":"#f76d3c","hover":"#ce5124"},"foot-link":{"regular":"#cbcbcb","hover":"#f76d3c"},"foot-widget-link":{"regular":"#cbcbcb","hover":"#f76d3c"},"optin-button":"#f76d3c","optin-button-hover":"#ce5124","mb-links-color":{"regular":"#f76d3c","hover":"#ce5124"},"player-button-bg":"#cbcbcb","player-button-bg-hover":"#f76d3c","audio-bg":{"color":"#292929","alpha":"0.6"}}'
							),
                            'blue' => array(
								'title' => 'Blue',
								'img' => get_stylesheet_directory_uri() . '/images/schemes/blue.png',
								'presets' =>'{"links-color":{"regular":"#5481e6","hover":"#325ab4"},"nav-hover-bg":"#5481e6","site-title-link":{"regular":"#5481e6","hover":"#325ab4"},"desc-color":"#555","pnp-bg-hover":"#5481e6","rp-link":{"regular":"#5481e6","hover":"#325ab4"},"foot-link":{"regular":"#5481e6","hover":"#325ab4"},"foot-widget-link":{"regular":"#5481e6","hover":"#325ab4"},"optin-button":"#5481e6","optin-button-hover":"#325ab4","mb-links-color":{"regular":"#5481e6","hover":"#325ab4"},"player-button-bg":"#5481e6","player-button-bg-hover":"#325ab4","audio-bg":{"color":"#5481e6","alpha":"1"}}'
							),
                            'green' => array(
								'title' => 'Green',
								'img' => get_stylesheet_directory_uri() . '/images/schemes/green.png',
								'presets' =>'{"links-color":{"regular":"#36d887","hover":"#1ea561"},"nav-hover-bg":"#36d887","site-title-link":{"regular":"#36d887","hover":"#1ea561"},"desc-color":"#555","pnp-bg-hover":"#36d887","rp-link":{"regular":"#36d887","hover":"#1ea561"},"foot-link":{"regular":"#36d887","hover":"#1ea561"},"foot-widget-link":{"regular":"#36d887","hover":"#1ea561"},"optin-button":"#36d887","optin-button-hover":"#1ea561","mb-links-color":{"regular":"#36d887","hover":"#1ea561"},"player-button-bg":"#36d887","player-button-bg-hover":"#1ea561","audio-bg":{"color":"#36d887","alpha":"1"}}'
							),
                            'pink' => array(
								'title' => 'Pink',
								'img' => get_stylesheet_directory_uri() . '/images/schemes/pink.png',
								'presets' =>'{"links-color":{"regular":"#f15f74","hover":"#c7394d"},"nav-hover-bg":"#f15f74","site-title-link":{"regular":"#f15f74","hover":"#c7394d"},"desc-color":"#555","pnp-bg-hover":"#f15f74","rp-link":{"regular":"#f15f74","hover":"#c7394d"},"foot-link":{"regular":"#f15f74","hover":"#c7394d"},"foot-widget-link":{"regular":"#f15f74","hover":"#c7394d"},"optin-button":"#f15f74","optin-button-hover":"#c7394d","mb-links-color":{"regular":"#f15f74","hover":"#c7394d"},"player-button-bg":"#f15f74","player-button-bg-hover":"#c7394d","audio-bg":{"color":"#f15f74","alpha":"1"}}'
							),
                            'purple' => array(
								'title' => 'Purple',
								'img' => get_stylesheet_directory_uri() . '/images/schemes/purple.png',
								'presets' =>'{"links-color":{"regular":"#913ccd","hover":"#6d22a2"},"nav-hover-bg":"#913ccd","site-title-link":{"regular":"#913ccd","hover":"#6d22a2"},"desc-color":"#555","pnp-bg-hover":"#913ccd","rp-link":{"regular":"#913ccd","hover":"#6d22a2"},"foot-link":{"regular":"#913ccd","hover":"#6d22a2"},"foot-widget-link":{"regular":"#913ccd","hover":"#6d22a2"},"optin-button":"#913ccd","optin-button-hover":"#6d22a2","mb-links-color":{"regular":"#913ccd","hover":"#6d22a2"},"player-button-bg":"#913ccd","player-button-bg-hover":"#6d22a2","audio-bg":{"color":"#913ccd","alpha":"1"}}'
							),
                            'teal' => array(
								'title' => 'Teal',
								'img' => get_stylesheet_directory_uri() . '/images/schemes/teal.png',
								'presets' =>'{"links-color":{"regular":"#008ca5","hover":"#00a2e2"},"nav-hover-bg":"#008ca5","site-title-link":{"regular":"#008ca5","hover":"#00a2e2"},"desc-color":"#555","pnp-bg-hover":"#008ca5","rp-link":{"regular":"#008ca5","hover":"#00a2e2"},"foot-link":{"regular":"#008ca5","hover":"#00a2e2"},"foot-widget-link":{"regular":"#008ca5","hover":"#00a2e2"},"optin-button":"#008ca5","optin-button-hover":"#00a2e2","mb-links-color":{"regular":"#008ca5","hover":"#00a2e2"},"player-button-bg":"#008ca5","player-button-bg-hover":"#00a2e2","audio-bg":{"color":"#008ca5","alpha":"1"}}'
							),
                            'orange' => array(
								'title' => 'Orange',
								'img' => get_stylesheet_directory_uri() . '/images/schemes/orange.png',
								'presets' =>'{"links-color":{"regular":"#ff9200","hover":"#f17100"},"nav-hover-bg":"#ff9200","site-title-link":{"regular":"#ff9200","hover":"#f17100"},"desc-color":"#555","pnp-bg-hover":"#ff9200","rp-link":{"regular":"#ff9200","hover":"#f17100"},"foot-link":{"regular":"#ff9200","hover":"#f17100"},"foot-widget-link":{"regular":"#ff9200","hover":"#f17100"},"optin-button":"#ff9200","optin-button-hover":"#f17100","mb-links-color":{"regular":"#ff9200","hover":"#f17100"},"player-button-bg":"#ff9200","player-button-bg-hover":"#f17100","audio-bg":{"color":"#ff9200","alpha":"1"}}'
							),
                            'yellow' => array(
								'title' => 'Yellow',
								'img' => get_stylesheet_directory_uri() . '/images/schemes/yellow.png',
								'presets' =>'{"links-color":{"regular":"#f7d842","hover":"#d6b721"},"nav-hover-bg":"#f7d842","site-title-link":{"regular":"#f7d842","hover":"#d6b721"},"desc-color":"#555","pnp-bg-hover":"#f7d842","rp-link":{"regular":"#f7d842","hover":"#d6b721"},"foot-link":{"regular":"#f7d842","hover":"#d6b721"},"foot-widget-link":{"regular":"#f7d842","hover":"#d6b721"},"optin-button":"#f7d842","optin-button-hover":"#d6b721","mb-links-color":{"regular":"#f7d842","hover":"#d6b721"},"player-button-bg":"#f7d842","player-button-bg-hover":"#d6b721","audio-bg":{"color":"#f7d842","alpha":"1"}}'
							),
                            'slate' => array(
								'title' => 'Slate',
								'img' => get_stylesheet_directory_uri() . '/images/schemes/slate.png',
								'presets' =>'{"links-color":{"regular":"#839098","hover":"#444444"},"nav-hover-bg":"#839098","site-title-link":{"regular":"#839098","hover":"#444444"},"desc-color":"#555","pnp-bg-hover":"#839098","rp-link":{"regular":"#839098","hover":"#444444"},"foot-link":{"regular":"#839098","hover":"#444444"},"foot-widget-link":{"regular":"#839098","hover":"#444444"},"optin-button":"#839098","optin-button-hover":"#444444","mb-links-color":{"regular":"#839098","hover":"#444444"},"player-button-bg":"#839098","player-button-bg-hover":"#444444","audio-bg":{"color":"#839098","alpha":"1"}}'
							),
						),
                        'default'   => 'orange'
                    ),
                    array(
                        'id'        => 'links-color',
                        'type'      => 'link_color',
                        'title'     => __('Links Color Option', 'redux-framework-demo'),
                        'subtitle'  => __('Choose all of your link colors here', 'redux-framework-demo'),
                        'output'    => array('a'),
                        'active'    => false,
                        'default'   => array(
                            'regular'   => '#f76d3c',
                            'hover'     => '#ce5124',
                        )
                    ),
                    array(
                        'id'        => 'body-font',
                        'type'      => 'typography',
                        'title'     => __('Body Font', 'redux-framework-demo'),
                        'subtitle'  => __('Specify the body font properties.', 'redux-framework-demo'),
                        'output'        => array('body'),
                        'google'    => true,
						'line-height' => false,
                        'default'   => array(
                            'color'         => '#333',
                            'font-size'     => '16px',
                            'font-family'   => 'Noto Sans',
                            'font-weight'   => 'normal',
                        ),
                    ),
                    array(
                        'id'        => 'heading-font',
                        'type'      => 'typography',
                        'title'     => __('Heading Font', 'redux-framework-demo'),
                        'subtitle'  => __('Specify the H Tag font properties.', 'redux-framework-demo'),
                        'output'        => array('h1,h2,h3,h4,h5,h6'),
                        'google'    => true,
                        'font-size' => false,
						'line-height' => false,
						'text-align' => false,
                        'default'   => array(
                            'color'         => '#000',
                            'font-family'   => 'Noto Sans',
                            'font-weight'   => 'normal',
                        ),
                    ),
                    array(
                        'id'        => 'body-bg',
                        'type'      => 'background',
                        'output'    => array('body'),
                        'title'     => __('Background Color/Image', 'redux-framework-demo'),
                        'subtitle'  => __('Choose your body background image or solid color.', 'redux-framework-demo'),
                        'default'   => '#ececec',
                    ),
                    array(
                        'id'        => 'post-meta',
                        'type'      => 'switch',
                        'title'     => __('Post Info', 'redux-framework-demo'),
                        'subtitle'  => __('Date, Author Name and Comments', 'redux-framework-demo'),
                        'default'   => true,
                        'on'        => 'Enable',
                        'off'       => 'Disable',
                    ),
                    array(
                        'id'        => 'post-cats',
                        'type'      => 'switch',
                        'title'     => __('Post Meta', 'redux-framework-demo'),
                        'subtitle'  => __('Tags and Categories', 'redux-framework-demo'),
                        'default'   => false,
                        'on'        => 'Enable',
                        'off'       => 'Disable',
                    ),
                )
            );
			
            $this->sections[] = array(
                'icon'      => 'el-icon-bullhorn',
                'title'     => __('Message Bar', 'redux-framework-demo'),
                'heading'   => __('Completely customize your Message Bar.', 'redux-framework-demo'),
                'desc'      => __('', 'redux-framework-demo'),
                'fields'    => array(
					array(
						'id'       => 'video-message',
						'type'     => 'raw',
						//'title'    => __('Getting Started', 'redux-framework-demo'),
						//'subtitle' => __('Watch the video to see how to use the settings in this section.', 'redux-framework-demo'),
						//'desc'     => __('This is the description field for additional info.', 'redux-framework-demo'),
						//'content'  => '<iframe width="720" height="405" src="//www.youtube.com/embed/eqLDLpysAFw?rel=0&amp;autohide=1&amp;modestbranding=1&amp;showinfo=0" frameborder="0" allowfullscreen="allowfullscreen"></iframe>',
						'content'  => '<p>This is your Message Bar section. This feature allows you to add short simple messages about your latest post, announcement, or promotion.</p>
										<br />
										<p>Here you&rsquo;ll be able to edit, stylize, enable or disable this feature.</p>
										<br />
										<p><strong>Saving your Changes and Settings:</strong></p>
										<p>Once you&rsquo;re done editing and stylizing this section simply either scroll up or down and click on the &ldquo;Save Changes&rdquo; button. </p>
										<br />
										<p>Once saved preview your theme to see if anymore editing is needed. You can either leave as is, edit some more, or reset this section by clicking the &ldquo;Reset Section&rdquo; button. Clicking this button will reset that specific section to it&rsquo;s default settings.</p><br />
										<p><strong>WARNING!</strong> The last button is Reset All. Clicking this button will reset your entire Appendipity Options to its default settings. Be very careful with this button as it will reset your entire settings. ONLY do this if you&rsquo;re sure you want to reset all.</p><hr />',
						//'align'		=> 'sectioned'
					),
					array(
						'id'   =>'mb-divide',
						'type' => 'divide',
					),
                    array(
                        'id'        => 'showmb',
                        'type'      => 'switch',
                        'title'     => __('Sitewide Message Bar', 'redux-framework-demo'),
                        'subtitle'  => __('Enable and add some text below to activate the Message bar.', 'redux-framework-demo'),
                        'desc'  	=> __('Leave enabled when using secondary nav menu', 'redux-framework-demo'),
                        'default'   => true,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled',
                    ),
                    array(
                        'id'        => 'mb-position',
                        'type'      => 'switch',
						'required' 	=> array('showmb','equals','1'),
                        'title'     => __('Message Bar Position', 'redux-framework-demo'),
                        'subtitle'  => __('Select whether the message bar stays Fixed at the top of the page or Scrolls with it.', 'redux-framework-demo'),
                        'default'   => true,
                        'on'        => 'Fixed',
                        'off'       => 'Scroll',
                    ),
                    array(
                        'id'        => 'message-bar',
                        'type'      => 'editor',
						'required' 	=> array('showmb','equals','1'),
                        'title'     => __('Sitewide Message Bar Editor', 'redux-framework-demo'),
                        'subtitle'  => __('Here you can place your text for the Message Bar. This will show on all posts and pages. You can customize this on a per post/page basis in the Appendipity Custom Settings Meta Box.', 'redux-framework-demo'),
                        'default'   => '',
						'args'   => array(
							'teeny'            => true,
							'textarea_rows'    => 2
						)
                    ),
					array( 
						'id'       => 'message-bar-bg',
						'type'     => 'color_rgba',
						'required' 	=> array('showmb','equals','1'),
						'title'    => __('Message Bar Background', 'redux-framework-demo'),
						'subtitle' => __('Set your background color and opacity', 'redux-framework-demo'),
						'default'  => array(
							'color' => '#e5e5e5', 
							'alpha' => '0.5'
						),
						'output'   => array('#message_bar'),
						'mode'     => 'background',
					),
                    array(
                        'id'        => 'message-bar-font',
                        'type'      => 'typography',
						'required' 	=> array('showmb','equals','1'),
                        'title'     => __('Message Bar Font', 'redux-framework-demo'),
                        'subtitle'  => __('Specify the message bar font properties.', 'redux-framework-demo'),
                        'output'        => array('#message p'),
                        'google'    => true,
						'line-height' => false,
                        'default'   => array(
                            'color'         => '#000000',
                            'font-size'     => '17px',
                            'font-family'   => 'Noto Sans',
                            'font-weight'   => 'Normal',
                        ),
                    ),
                    array(
                        'id'        => 'mb-links-color',
                        'type'      => 'link_color',
						'required' 	=> array('showmb','equals','1'),
                        'title'     => __('Message Bar Link Colors', 'redux-framework-demo'),
                        'subtitle'  => __('Choose your message bar link colors here', 'redux-framework-demo'),
                        'output'    => array('#message_bar a'),
                        'active'    => false,
                        'default'   => array(
                            'regular'   => '#f76d3c',
                            'hover'     => '#ce5124',
                        )
                    ),
                )
            );
			
            $this->sections[] = array(
                'icon'      => 'el-icon-lines',
                'title'     => __('Navigation', 'redux-framework-demo'),
                'heading'   => __('Completely customize your Navigation Menus.', 'redux-framework-demo'),
                'desc'      => __('', 'redux-framework-demo'),
                'fields'    => array(
					array(
						'id'       => 'video-nav',
						'type'     => 'raw',
						//'title'    => __('Getting Started', 'redux-framework-demo'),
						//'subtitle' => __('Watch the video to see how to use the settings in this section.', 'redux-framework-demo'),
						//'desc'     => __('This is the description field for additional info.', 'redux-framework-demo'),
						//'content'  => '<iframe width="720" height="405" src="//www.youtube.com/embed/jfULP4jl5dw?rel=0&amp;autohide=1&amp;modestbranding=1&amp;showinfo=0" frameborder="0" allowfullscreen="allowfullscreen"></iframe>',
						'content'  => '<p>This section is for the Navigation section. Here you&rsquo;ll be able to edit, stylize and customize this feature.</p>
										<br />
										<p>This section will apply to your navigation menu. </p>
										<br />
										<p>To edit your menu hover over the Appearance tab on the far left and click on the Menu tab.</p>
										<br />
										<p><strong>Saving your Changes and Settings:</strong></p>
										<p>Once you&rsquo;re done editing and stylizing this section simply either scroll up or down and click on the &ldquo;Save Changes&rdquo; button. </p>
										<br />
										<p>Once saved preview your theme to see if anymore editing is needed. You can either leave as is, edit some more, or reset this section by clicking the &ldquo;Reset Section&rdquo; button. Clicking this button will reset that specific section to it&rsquo;s default settings.</p>
										<br />
										<p><strong>WARNING!</strong> The last button is Reset All. Clicking this button will reset your entire Appendipity Options to its default settings. Be very careful with this button as it will reset your entire settings. ONLY do this if you&rsquo;re sure you want to reset all.</p><hr>',
						//'align'		=> 'sectioned'
					),
					array(
						'id'   =>'nav-divide',
						'type' => 'divide',
					),
                    array(
                        'id'        => 'nav-bg',
                        'type'      => 'color',
                        'output'    => array('.nav-primary,.nav-header,.genesis-nav-menu .sub-menu a,button.menu-toggle'),
                        'title'     => __('Navigation Bar Background Color', 'redux-framework-demo'),
                        'subtitle'  => __('Pick a background color for the primary and secondary navigation.', 'redux-framework-demo'),
                        'default'   => '#343434',
                        'mode'      => 'background',
                    ),
					/*array(
						'id'       => 'nav-border',
						'type'     => 'color',
						'title'    => __('Navigation Borders Color', 'redux-framework-demo'),
						'subtitle' => __('Choose the color of your navigation borders.', 'redux-framework-demo'),
						'output'   => array('.nav-secondary,.nav-primary,.nav-header,.genesis-nav-menu a,.genesis-nav-menu .sub-menu,.genesis-nav-menu .sub-menu a'),
						'mode'     => 'border-color',
                        'default'   => '#ececec',
					),*/
                    array(
                        'id'        => 'nav-hover-bg',
                        'type'      => 'color',
                        'output'    => array('.genesis-nav-menu a:hover,.genesis-nav-menu .current-menu-item > a,.genesis-nav-menu .sub-menu a:hover,.genesis-nav-menu .sub-menu .current-menu-item > a,.archive-pagination li a'),
                        'title'     => __('Navigation Hover/Active Background Color', 'redux-framework-demo'),
                        'subtitle'  => __('Pick a background color for the navigation buttons hover/active color.', 'redux-framework-demo'),
                        'default'   => '#f76d3c',
                        'mode'      => 'background',
                    ),
                    array(
                        'id'        => 'nav-text-color',
                        'type'      => 'color',
						'output' 	=> array('.genesis-nav-menu a,button.menu-toggle'),
                        'title'     => __('Navigation Text Color', 'redux-framework-demo'),
                        'subtitle'  => __('Pick a color for the navigation text.', 'redux-framework-demo'),
                        'default'   => '#cbcbcb',
						'transparent' => false,
                        'mode'      => 'color',
                    ),
                    array(
                        'id'        => 'nav-text-hover-color',
                        'type'      => 'color',
						'output' 	=> array('.genesis-nav-menu a:hover,.genesis-nav-menu .sub-menu a:hover'),
                        'title'     => __('Navigation Text Hover Color', 'redux-framework-demo'),
                        'subtitle'  => __('Pick a color for the navigation text on hover.', 'redux-framework-demo'),
                        'default'   => '#f8f8f8',
						'transparent' => false,
                        'mode'      => 'color',
                    ),
                    array(
                        'id'        => 'nav-bar-font',
                        'type'      => 'typography',
						'required' 	=> array('showmb','equals','1'),
                        'title'     => __('Navigation Font', 'redux-framework-demo'),
                        'subtitle'  => __('Specify the navigation font properties.', 'redux-framework-demo'),
                        'output'        => array('.genesis-nav-menu a'),
                        'google'    => true,
                        'font-size' => false,
                        'font-style' => false,
                        'font-weight' => false,
                        'subsets' => false,
						'line-height' => false,
						'text-align' => false,
						'color' => false,
                        'default'   => array(
                            'font-family'   => 'Noto Sans',
                        ),
                    ),
                )
            );
			
            $this->sections[] = array(
                'icon'      => 'el-icon-picture',
                'title'     => __('Header', 'redux-framework-demo'),
                'heading'   => __('Completely customize your Header Section.', 'redux-framework-demo'),
                'desc'      => __('', 'redux-framework-demo'),
                'fields'    => array(
					array(
						'id'       => 'video-header',
						'type'     => 'raw',
						//'title'    => __('Getting Started', 'redux-framework-demo'),
						//'subtitle' => __('Watch the video to see how to use the settings in this section.', 'redux-framework-demo'),
						//'desc'     => __('This is the description field for additional info.', 'redux-framework-demo'),
						//'content'  => '<iframe width="720" height="405" src="//www.youtube.com/embed/hg9XNZwqBQY?rel=0&amp;autohide=1&amp;modestbranding=1&amp;showinfo=0" frameborder="0" allowfullscreen="allowfullscreen"></iframe>',
						'content'  => '<p>This section is for the Header. Here you&rsquo;ll be able to edit, stylize, customize, enable or disable this feature.</p>
										<br />
										<p>You can upload your own custom logo or image to your Primary Header or use the Custom Header to utilize the full width of this themes header.</p>
										<br />
										<p><strong>Saving your Changes and Settings:</strong></p>
										<p>Once you&rsquo;re done editing and stylizing this section simply either scroll up or down and click on the &ldquo;Save Changes&rdquo; button. </p>
										<br />
										<p>Once saved preview your theme to see if anymore editing is needed. You can either leave as is, edit some more, or reset this section by clicking the &ldquo;Reset Section&rdquo; button. Clicking this button will reset that specific section to it&rsquo;s default settings.</p>
										<br />
										<p><strong>WARNING!</strong> The last button is Reset All. Clicking this button will reset your entire Appendipity Options to its default settings. Be very careful with this button as it will reset your entire settings. ONLY do this if you&rsquo;re sure you want to reset all.</p><hr />',
						//'align'		=> 'sectioned'
					),
					array(
						'id'   =>'h-divide',
						'type' => 'divide'
					),
					array(
					   'id' => 'header',
					   'type' => 'section',
					   'title' => __('Primary Default Header', 'redux-framework-demo'),
					   'indent' => true
				   	),
					array(
						'id'       => 'showheader',
						'type'     => 'switch',
						'title'    => __('Show Primary Default Header', 'redux-framework-demo'),
						'desc'     => __('Enabled or Disabled the Primary Default Header Section. This does not affect the Custom Header below.', 'redux-framework-demo'),
						'default'  => true,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled',
					),
					array(
						'id'       => 'header-img',
						'type'     => 'media', 
						'required' 	=> array('showheader','equals','1'),
						'url'      => true,
						'title'    => __('Header Image', 'redux-framework-demo'),
						'desc'     => __('Upload your Header Image', 'redux-framework-demo'),
						'subtitle' => __('Any size image will work, but if you are using the Header Right widget area, then the image will show at a max width of 536px.', 'redux-framework-demo'),
					),
					array( 
						'id'       => 'header-bg',
						'type'     => 'color',
						'required' 	=> array('showheader','equals','1'),
						'title'    => __('Primary Default Header Background', 'redux-framework-demo'),
						'subtitle' => __('Set your background color', 'redux-framework-demo'),
						'default'  => '#292929',
						'output'   => array('.site-header'),
						'transparent' => false,
						'mode'     => 'background',
					),
                    array(
                        'id'        => 'header-font',
                        'type'      => 'typography',
						'required' 	=> array('showheader','equals','1'),
                        'title'     => __('Site Title Font', 'redux-framework-demo'),
                        'subtitle'  => __('Specify the site title font.', 'redux-framework-demo'),
                        'output'        => array('.site-title'),
                        'google'    => true,
						'line-height' => false,
                        'color' => false,
                        'text-align' => false,
						'letter-spacing' => true,
                        'default'   => array(
                            'font-family'   => 'Noto Sans',
                            'font-weight'   => 'Normal',
							'font-size'		=> '48px',
							'letter-spacing' => '-3px',
                        ),
                    ),
                    array(
                        'id'        => 'site-title-link',
                        'type'      => 'link_color',
						'required' 	=> array('showheader','equals','1'),
                        'title'     => __('Site Title Color', 'redux-framework-demo'),
                        'subtitle'  => __('Choose your site title link colors', 'redux-framework-demo'),
						'output'   => array('.site-title a'),
                        'active'    => false,
                        'default'   => array(
                            'regular'   => '#cbcbcb',
                            'hover'     => '#f76d3c',
                        )
                    ),
					array( 
						'id'       => 'desc-color',
						'type'     => 'color',
						'required' 	=> array('showheader','equals','1'),
						'title'    => __('Site Description Text Color', 'redux-framework-demo'),
						'subtitle' => __('Set your site description text color', 'redux-framework-demo'),
						'default'  => '#555555',
						'output'   => array('.site-description'),
						'mode'     => 'color',
						'transparent' => false
					),
					array(
						'id'   =>'hb-divide',
						'type' => 'divide',
						'required' 	=> array('showheader','equals','1'),
					),
					array(
					   'id' => 'h-banner',
					   'type' => 'section',
					   'title' => __('Custom Header', 'redux-framework-demo'),
					   'indent' => true
				   	),
                    array(
                        'id'        => 'showhb',
                        'type'      => 'switch',
                        'title'     => __('Show Custom Header', 'redux-framework-demo'),
                        'subtitle'  => __('Enable or Disable the Custom Header', 'redux-framework-demo'),
                        'default'   => false,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled',
                    ),
                    array(
                        'id'        => 'header-banner',
                        'type'      => 'editor',
						'required' 	=> array('showhb','equals','1'),
                        'title'     => __('Custom Header Editor', 'redux-framework-demo'),
                        'subtitle'  => __('Here you can place a banner under the header or if you remove the header section, you can use this as your header. Suggested image width is 1152px for the Custom Header, no limit on height.', 'redux-framework-demo'),
                        'default'   => '',
						'args'   => array(
							'teeny'            => false,
							'textarea_rows'    => 12
						)
                    ),
					array(
						'id'       => 'hb-placement',
						'type'     => 'select',
						'required' 	=> array('showhb','equals','1'),
						'title'    => __('Custom Header Placement', 'redux-framework-demo'),
						'subtitle' => __('Select where to show the Custom Header', 'redux-framework-demo'),
						'options'  => array(
							'1' => 'Above Primary Default Header',
							'2' => 'Below Primary Default Header',
						),
						'default'  => '1',
					),
					array( 
						'id'       => 'hb-bg',
						'type'     => 'color',
						'required' 	=> array('showhb','equals','1'),
						'title'    => __('Custom Header Background', 'redux-framework-demo'),
						'subtitle' => __('Set your background color', 'redux-framework-demo'),
						'default'  => '#292929',
						'output'   => array('.header-banner'),
						'transparent' => false,
						'mode'     => 'background',
					),
                    array(
                        'id'        => 'hb-font',
                        'type'      => 'typography',
						'required' 	=> array('showhb','equals','1'),
                        'title'     => __('Custom Header Font', 'redux-framework-demo'),
                        'subtitle'  => __('Specify the header banner font.', 'redux-framework-demo'),
                        'output'        => array('.header-banner, .header-banner h1, .header-banner h2, .header-banner h3, .header-banner h4, .header-banner h5, .header-banner h6'),
                        'google'    => true,
						'line-height' => false,
                        'font-size' => false,
                        'font-weight' => false,
                        'font-style' => false,
                        'color' => false,
                        'text-align' => false,
                        'default'   => array(
                            'font-family'   => 'Noto Sans',
                        ),
                    ),
					array(
						'id'             => 'hb-spacing',
						'type'           => 'spacing',
						'required' 		=> array('showhb','equals','1'),
						'output'         => array('.header-banner'),
						'mode'           => 'padding',
						'units'          => array('px', 'rem'),
						'units_extended' => 'false',
						'title'          => __('Custom Header Padding', 'redux-framework-demo'),
						'subtitle'       => __('Pick the amount of padding you want for your header banner.', 'redux-framework-demo'),
						'default'            => array(
							'padding-top'     => '30px',
							'padding-right'   => '30px',
							'padding-bottom'  => '30px',
							'padding-left'    => '30px',
							'units'          => 'px',
						)
					),
                )
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-website',
                'title'     => __('Homepage', 'redux-framework-demo'),
                'heading'   => __('Customize the Homepage layout.', 'redux-framework-demo'),
                'desc'      => __('', 'redux-framework-demo'),
                'fields'    => array(
					array(
						'id'       => 'video-style',
						'type'     => 'raw',
						//'desc'     => __('This is the description field for additional info.', 'redux-framework-demo'),
						//'content'  => '<iframe width="720" height="405" src="//www.youtube.com/embed/p20L-a8gbKA?rel=0&amp;autohide=1&amp;modestbranding=1&amp;showinfo=0" frameborder="0" allowfullscreen="allowfullscreen"></iframe>',
						'content'  => '<p>This section is for the Homepage. Here you&rsquo;ll be able to edit, stylize, customize, enable or disable this feature.</p>
										<br />
										<ul>
											<li>Fullwidth</li>
											<li>Sidebar on left side</li>
											<li>Sidebar on right side</li>
										</ui>
										<br />
										<p><strong>Saving your Changes and Settings:</strong></p>
										<p>Once you&rsquo;re done editing and stylizing this section simply either scroll up or down and click on the &ldquo;Save Changes&rdquo; button. </p>
										<br />
										<p>Once saved preview your theme to see if anymore editing is needed. You can either leave as is, edit some more, or reset this section by clicking the &ldquo;Reset Section&rdquo; button. Clicking this button will reset that specific section to it&rsquo;s default settings.</p>
										<br />
										<p><strong>WARNING!</strong> The last button is Reset All. Clicking this button will reset your entire Appendipity Options to its default settings. Be very careful with this button as it will reset your entire settings. ONLY do this if you&rsquo;re sure you want to reset all.</p><hr />',
						//'align'		=> 'sectioned'
					),
					array(
						'id'   =>'hp-divide',
						'type' => 'divide'
					),
					array(
						'id'       => 'hp-layout',
						'type'     => 'image_select',
						'title'    => __('Homepage Layout', 'redux-framework-demo'),
						'subtitle' => __('Choose between Full Width(No Sidebar), Sidebar/Content or Content/Sidebar layout.', 'redux-framework-demo'),
						'options'  => array(
							'1'      => array(
								'title'   => 'Full Width',
								'alt'   => 'Full Width',
								'img'   => get_stylesheet_directory_uri() . '/images/schemes/c.gif'
							),
							'2'      => array(
								'title'   => 'Sidebar/Content',
								'alt'   => 'Sidebar/Content',
								'img'   => get_stylesheet_directory_uri() . '/images/schemes/sc.gif'
							),
							'3'      => array(
								'title'   => 'Content/Sidebar',
								'alt'   => 'Content/Sidebar',
								'img'  => get_stylesheet_directory_uri() . '/images/schemes/cs.gif'
							),
						),
    					'default' => '3'
					),
                )
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-mic',
                'title'     => __('Featured Guest', 'redux-framework-demo'),
                'heading'   => __('Completely customize the Featured Guest Area.', 'redux-framework-demo'),
                //'desc'      => __('Watch video below to learn how to edit this section:', 'redux-framework-demo'),
                'fields'    => array(
					array(
						'id'       => 'video-style',
						'type'     => 'raw',
						//'desc'     => __('This is the description field for additional info.', 'redux-framework-demo'),
						//'content'  => '<iframe width="720" height="405" src="//www.youtube.com/embed/p20L-a8gbKA?rel=0&amp;autohide=1&amp;modestbranding=1&amp;showinfo=0" frameborder="0" allowfullscreen="allowfullscreen"></iframe>',
						'content'  => '<p>This section if for your featured guest. Here you can showcase your most recent and most popular guest and episodes.</p>
										<br />
										<p>You can choose from 1 - 5 guests to feature. We highly recommend no less than 3 guests to feature. This will ensure great proportionate sized images.</p>
										<br />
										<p>You can also position the Featured Guest area before or after the Main Player section.</p>
										<br />
										<p><strong>Saving your Changes and Settings:</strong></p>
										<p>Once you&rsquo;re done editing and stylizing this section simply either scroll up or down and click on the &ldquo;Save Changes&rdquo; button. </p>
										<br />
										<p>Once saved preview your theme to see if anymore editing is needed. You can either leave as is, edit some more, or reset this section by clicking the &ldquo;Reset Section&rdquo; button. Clicking this button will reset that specific section to it&rsquo;s default settings.</p>
										<br />
										<p><strong>WARNING!</strong> The last button is Reset All. Clicking this button will reset your entire Appendipity Options to its default settings. Be very careful with this button as it will reset your entire settings. ONLY do this if you&rsquo;re sure you want to reset all.</p><hr />',
						//'align'		=> 'sectioned'
					),
                    array(
                        'id'        => 'showfg',
                        'type'      => 'switch',
                        'title'     => __('Featured Guest Area', 'redux-framework-demo'),
                        'subtitle'  => __('Enable or Disable the Featured Guest Area', 'redux-framework-demo'),
                        'default'   => false,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled',
                    ),
					array(
						'id'       => 'fg-placement',
						'type'     => 'select',
						'required' 	=> array('showfg','equals','1'),
						'title'    => __('Featured Guest Placement', 'redux-framework-demo'),
						'subtitle' => __('Select where to show the Featured Guest Area', 'redux-framework-demo'),
						'options'  => array(
							'1' => 'Before Main Player',
							'2' => 'After Main Player',
						),
						'default'  => '1',
					),
					array( 
						'id'       => 'fg-bg',
						'type'     => 'color_rgba',
						'required' 	=> array('showfg','equals','1'),
						'title'    => __('Featured Guest Area Background Color', 'redux-framework-demo'),
						'subtitle' => __('Set your background color and opacity', 'redux-framework-demo'),
						'default'  => array(
							'color' => '#f4f4f4', 
							'alpha' => '1'
						),
						'output'   => array('.guest-area'),
						'mode'     => 'background',
					),
                    array(
                        'id'        => 'fg-text',
                        'type'      => 'color',
						'required' 	=> array('showfg','equals','1'),
                        'output'    => array('.guest-area,.guest-area h3'),
                        'title'     => __('Featured Guest Text Color', 'redux-framework-demo'),
                        'subtitle'  => __('Choose your text color.', 'redux-framework-demo'),
                        'default'   => '#000000',
						'mode'     => 'color',
                    ),
                    array(
                        'id'        => 'fg-headline',
                        'type'      => 'text',
						'required' 	=> array('showfg','equals','1'),
                        'title'     => __('Featured Guest Headline', 'redux-framework-demo'),
                        'subtitle'  => __('Add a headline to the featured guest area.', 'redux-framework-demo'),
						'default' 	=> 'This Section is to Feature the Most Popular Guests on Your Podcast!',
                    ),
                    array(
                        'id'        => 'fg-link',
                        'type'      => 'link_color',
						'required' 	=> array('showfg','equals','1'),
                        'title'     => __('Featured Guests Link Color', 'redux-framework-demo'),
                        'subtitle'  => __('Choose your featured guest link colors', 'redux-framework-demo'),
						'output'   => array('.guest-area ul li a'),
                        'active'    => false,
                        'default'   => array(
                            'regular'   => '#000000',
                            'hover'     => '#888888',
                        )
                    ),
                    array(
                        'id'        => 'sq-round',
                        'type'      => 'slider',
						'required' 	=> array('showfg','equals','1'),
                        'title'     => __('Featured Guest Image Corner Radius', 'redux-framework-demo'),
                        'subtitle'  => __('Choose 0 for square images or any other number for rounded images for your featured guests', 'redux-framework-demo'),
						'desc' 		=> __('Radius numbers are %\'s, so 50 will create round images and 0 will create square images.',  'redux-framework-demo'),
						'default'   => 0,
						'min'       => 0,
						'step'      => 1,
						'max'       => 50,
						'display_value' => 'text'
                    ),
					array(
						'id'   =>'pcast-divide',
						'type' => 'divide',
						'required' 	=> array('showfg','equals','1'),
					),
					array(
					   'id' => 'pcast',
					   'type' => 'section',
						'required' 	=> array('showfg','equals','1'),
					   'title' => __('Podcast Artwork', 'redux-framework-demo'),
					   'indent' => true
				   	),
					array(
						'id'       => 'pcast-img',
						'type'     => 'media', 
						'required' 	=> array('showfg','equals','1'),
						'url'      => true,
						'title'    => __('Podcast Artwork Image', 'redux-framework-demo'),
						'desc'     => __('Upload your Podcast Artwork Image', 'redux-framework-demo'),
						'subtitle' => __('Image MUST be used for this section to show. Square images 400px X 400px work best, but is not necessary.', 'redux-framework-demo'),
					),
                    array(
                        'id'        => 'pcast-link',
                        'type'      => 'text',
						'required' 	=> array('showfg','equals','1'),
                        'title'     => __('Podcast Artwork Link', 'redux-framework-demo'),
                        'subtitle'  => __('Add a link to your podcast.', 'redux-framework-demo'),
                        'validate' 	=> 'url',
                    ),
                    array(
                        'id'        => 'pcast-name',
                        'type'      => 'text',
						'required' 	=> array('showfg','equals','1'),
                        'title'     => __('Podcast Artwork Name', 'redux-framework-demo'),
                        'subtitle'  => __('Add the name of your podcast', 'redux-framework-demo'),
                    ),
					array(
						'id'       => 'pcast-new-win',
						'type'     => 'checkbox',
						'required' 	=> array('showfg','equals','1'),
						'title'    => __('Open in a New Window', 'redux-framework-demo'),
						'subtitle' => __('Check box to open Podcast Artwork link in a new window.', 'redux-framework-demo'),
						'default'  => '0',
					),
					array(
						'id'   =>'fg-one-divide',
						'type' => 'divide',
						'required' 	=> array('showfg','equals','1'),
					),
					array(
					   'id' => 'feat-guest-one',
					   'type' => 'section',
						'required' 	=> array('showfg','equals','1'),
					   'title' => __('Featured Guest #1', 'redux-framework-demo'),
					   'indent' => true
				   	),
					array(
						'id'       => 'guest-one-img',
						'type'     => 'media', 
						'required' 	=> array('showfg','equals','1'),
						'url'      => true,
						'title'    => __('Guest 1 Image', 'redux-framework-demo'),
						'desc'     => __('Upload your Guest 1 Image', 'redux-framework-demo'),
						'subtitle' => __('Image should be a square, because it will be cropped to a 150px X 150px thumbnail.', 'redux-framework-demo'),
					),
                    array(
                        'id'        => 'guest-one-link',
                        'type'      => 'text',
						'required' 	=> array('showfg','equals','1'),
                        'title'     => __('Guest 1 Link', 'redux-framework-demo'),
                        'subtitle'  => __('Add the link to your #1 guest post.', 'redux-framework-demo'),
                        'validate' 	=> 'url',
                    ),
                    array(
                        'id'        => 'guest-one-name',
                        'type'      => 'text',
						'required' 	=> array('showfg','equals','1'),
                        'title'     => __('Guest 1 Name', 'redux-framework-demo'),
                        'subtitle'  => __('Add the name of your #1 guest', 'redux-framework-demo'),
                    ),
					array(
						'id'       => 'g-one-new-win',
						'type'     => 'checkbox',
						'required' 	=> array('showfg','equals','1'),
						'title'    => __('Open in a New Window', 'redux-framework-demo'),
						'subtitle' => __('Check box to open Guest 1 link in a new window.', 'redux-framework-demo'),
						'default'  => '0',
					),
					array(
						'id'   =>'fg-two-divide',
						'type' => 'divide',
						'required' 	=> array('showfg','equals','1'),
					),
					array(
					   'id' => 'feat-guest-two',
					   'type' => 'section',
						'required' 	=> array('showfg','equals','1'),
					   'title' => __('Featured Guest #2', 'redux-framework-demo'),
					   'indent' => true
				   	),
					array(
						'id'       => 'guest-two-img',
						'type'     => 'media', 
						'required' 	=> array('showfg','equals','1'),
						'url'      => true,
						'title'    => __('Guest 2 Image', 'redux-framework-demo'),
						'desc'     => __('Upload your Guest 2 Image', 'redux-framework-demo'),
						'subtitle' => __('Image should be a square, because it will be cropped to a 150px X 150px thumbnail.', 'redux-framework-demo'),
					),
                    array(
                        'id'        => 'guest-two-link',
                        'type'      => 'text',
						'required' 	=> array('showfg','equals','1'),
                        'title'     => __('Guest 2 Link', 'redux-framework-demo'),
                        'subtitle'  => __('Add the link to your #2 guest post.', 'redux-framework-demo'),
                        'validate' 	=> 'url',
                    ),
                    array(
                        'id'        => 'guest-two-name',
                        'type'      => 'text',
						'required' 	=> array('showfg','equals','1'),
                        'title'     => __('Guest 2 Name', 'redux-framework-demo'),
                        'subtitle'  => __('Add the name of your #2 guest', 'redux-framework-demo'),
                    ),
					array(
						'id'       => 'g-two-new-win',
						'type'     => 'checkbox',
						'required' 	=> array('showfg','equals','1'),
						'title'    => __('Open in a New Window', 'redux-framework-demo'),
						'subtitle' => __('Check box to open Guest 2 link in a new window.', 'redux-framework-demo'),
						'default'  => '0',
					),
					array(
						'id'   =>'fg-three-divide',
						'type' => 'divide',
						'required' 	=> array('showfg','equals','1'),
					),
					array(
					   'id' => 'feat-guest-three',
					   'type' => 'section',
						'required' 	=> array('showfg','equals','1'),
					   'title' => __('Featured Guest #3', 'redux-framework-demo'),
					   'indent' => true
				   	),
					array(
						'id'       => 'guest-three-img',
						'type'     => 'media', 
						'required' 	=> array('showfg','equals','1'),
						'url'      => true,
						'title'    => __('Guest 3 Image', 'redux-framework-demo'),
						'desc'     => __('Upload your Guest 3 Image', 'redux-framework-demo'),
						'subtitle' => __('Image should be a square, because it will be cropped to a 150px X 150px thumbnail.', 'redux-framework-demo'),
					),
                    array(
                        'id'        => 'guest-three-link',
                        'type'      => 'text',
						'required' 	=> array('showfg','equals','1'),
                        'title'     => __('Guest 3 Link', 'redux-framework-demo'),
                        'subtitle'  => __('Add the link to your #3 guest post.', 'redux-framework-demo'),
                        'validate' 	=> 'url',
                    ),
                    array(
                        'id'        => 'guest-three-name',
                        'type'      => 'text',
						'required' 	=> array('showfg','equals','1'),
                        'title'     => __('Guest 3 Name', 'redux-framework-demo'),
                        'subtitle'  => __('Add the name of your #3 guest', 'redux-framework-demo'),
                    ),
					array(
						'id'       => 'g-three-new-win',
						'type'     => 'checkbox',
						'required' 	=> array('showfg','equals','1'),
						'title'    => __('Open in a New Window', 'redux-framework-demo'),
						'subtitle' => __('Check box to open Guest 3 link in a new window.', 'redux-framework-demo'),
						'default'  => '0',
					),
					array(
						'id'   =>'fg-four-divide',
						'type' => 'divide',
						'required' 	=> array('showfg','equals','1'),
					),
					array(
					   'id' => 'feat-guest-four',
					   'type' => 'section',
						'required' 	=> array('showfg','equals','1'),
					   'title' => __('Featured Guest #4', 'redux-framework-demo'),
					   'indent' => true
				   	),
					array(
						'id'       => 'guest-four-img',
						'type'     => 'media', 
						'required' 	=> array('showfg','equals','1'),
						'url'      => true,
						'title'    => __('Guest 4 Image', 'redux-framework-demo'),
						'desc'     => __('Upload your Guest 4 Image', 'redux-framework-demo'),
						'subtitle' => __('Image should be a square, because it will be cropped to a 150px X 150px thumbnail.', 'redux-framework-demo'),
					),
                    array(
                        'id'        => 'guest-four-link',
                        'type'      => 'text',
						'required' 	=> array('showfg','equals','1'),
                        'title'     => __('Guest 4 Link', 'redux-framework-demo'),
                        'subtitle'  => __('Add the link to your #4 guest post.', 'redux-framework-demo'),
                        'validate' 	=> 'url',
                    ),
                    array(
                        'id'        => 'guest-four-name',
                        'type'      => 'text',
						'required' 	=> array('showfg','equals','1'),
                        'title'     => __('Guest 4 Name', 'redux-framework-demo'),
                        'subtitle'  => __('Add the name of your #4 guest', 'redux-framework-demo'),
                    ),
					array(
						'id'       => 'g-four-new-win',
						'type'     => 'checkbox',
						'required' 	=> array('showfg','equals','1'),
						'title'    => __('Open in a New Window', 'redux-framework-demo'),
						'subtitle' => __('Check box to open Guest 4 link in a new window.', 'redux-framework-demo'),
						'default'  => '0',
					),
					array(
						'id'   =>'fg-five-divide',
						'type' => 'divide',
						'required' 	=> array('showfg','equals','1'),
					),
					array(
					   'id' => 'feat-guest-five',
					   'type' => 'section',
						'required' 	=> array('showfg','equals','1'),
					   'title' => __('Featured Guest #5', 'redux-framework-demo'),
					   'indent' => true
				   	),
					array(
						'id'       => 'guest-five-img',
						'type'     => 'media', 
						'required' 	=> array('showfg','equals','1'),
						'url'      => true,
						'title'    => __('Guest 5 Image', 'redux-framework-demo'),
						'desc'     => __('Upload your Guest 5 Image', 'redux-framework-demo'),
						'subtitle' => __('Image should be a square, because it will be cropped to a 150px X 150px thumbnail.', 'redux-framework-demo'),
					),
                    array(
                        'id'        => 'guest-five-link',
                        'type'      => 'text',
						'required' 	=> array('showfg','equals','1'),
                        'title'     => __('Guest 5 Link', 'redux-framework-demo'),
                        'subtitle'  => __('Add the link to your #5 guest post.', 'redux-framework-demo'),
                        'validate' 	=> 'url',
                    ),
                    array(
                        'id'        => 'guest-five-name',
                        'type'      => 'text',
						'required' 	=> array('showfg','equals','1'),
                        'title'     => __('Guest 5 Name', 'redux-framework-demo'),
                        'subtitle'  => __('Add the name of your #5 guest', 'redux-framework-demo'),
                    ),
					array(
						'id'       => 'g-five-new-win',
						'type'     => 'checkbox',
						'required' 	=> array('showfg','equals','1'),
						'title'    => __('Open in a New Window', 'redux-framework-demo'),
						'subtitle' => __('Check box to open Guest 5 link in a new window.', 'redux-framework-demo'),
						'default'  => '0',
					),
                )
            );
			
            $this->sections[] = array(
                'icon'      => 'el-icon-music',
                'title'     => __('Audio Players', 'redux-framework-demo'),
                'heading'   => __('Completely customize your Audio Players.', 'redux-framework-demo'),
                'desc'      => __('', 'redux-framework-demo'),
                'fields'    => array(
					array(
						'id'       => 'video-player',
						'type'     => 'raw',
						//'title'    => __('Getting Started', 'redux-framework-demo'),
						//'subtitle' => __('Watch the video to see how to use the settings in this section.', 'redux-framework-demo'),
						//'desc'     => __('This is the description field for additional info.', 'redux-framework-demo'),
						//'content'  => '<iframe width="720" height="405" src="//www.youtube.com/embed/n8xP2RtaB00?rel=0&amp;autohide=1&amp;modestbranding=1&amp;showinfo=0" frameborder="0" allowfullscreen="allowfullscreen"></iframe>',
						'content'  => '<p>This section is for the Audio Players throughout your entire site. Here you&rsquo;ll be able to edit, stylize, customize, enable or disable this feature.</p>
						<br />
						<p>You have 5 sections:</p>
						<br />
						<p>1: Homepage Main Player - Here you can enable or disable the Main Player from your homepage and stylize the Main Player sitewide.</p>
						<br />
						<p>2: Main Player Play/Download Buttons - You can enable or disable Main Player Play in New Window/Download buttons.</p>
						<br />
						<p>3: Single Post Players - You can enable or disable the Main Player within your Posts.</p>
						<br />
						<p>4: Widgets and Posts Audio Player - You can edit and stylize your audio players on the homepage widgets and within your posts.</p>
						<br />
						<p>5: Widget Play/Download Buttons - You can enable or disable Play in New Window/Download buttons on players from the homepage widgets and within your posts.</p>
						<br />
						<p><strong>Saving your Changes and Settings:</strong></p>
						<p>Once you&rsquo;re done editing and stylizing this section simply either scroll up or down and click on the &ldquo;Save Changes&rdquo; button. </p>
						<br />
						<p>Once saved preview your theme to see if anymore editing is needed. You can either leave as is, edit some more, or reset this section by clicking the &ldquo;Reset Section&rdquo; button. Clicking this button will reset that specific section to it&rsquo;s default settings.</p>
						<br />
						<p><strong>WARNING!</strong> The last button is Reset All. Clicking this button will reset your entire Appendipity Options to its default settings. Be very careful with this button as it will reset your entire settings. ONLY do this if you&rsquo;re sure you want to reset all.</p><hr />',
						//'align'		=> 'sectioned'
					),
					array(
						'id'   =>'a-divide',
						'type' => 'divide'
					),
					array(
					   'id' => 'hp-player',
					   'type' => 'section',
					   'title' => __('Homepage Main Player', 'redux-framework-demo'),
					   'indent' => true
				   	),
                    array(
                        'id'        => 'showmp',
                        'type'      => 'switch',
                        'title'     => __('Homepage Main Player', 'redux-framework-demo'),
                        'subtitle'  => __('Enable or Disable the Homepage Main Player', 'redux-framework-demo'),
                        'default'   => false,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled',
                    ),
					array(
						'id'       	=> 'mp-cat',
						'type'     	=> 'select',
						'required' 	=> array('showmp','equals','1'),
						'title'    	=> __('Select Category', 'redux-framework-demo'),
						'subtitle' 	=> __('Choose which category to display in the Homepage Main Player', 'redux-framework-demo'),
						'data'		=> 'category',
					),
                    array(
                        'id'        => 'mp-headline',
                        'type'      => 'text',
						'required' 	=> array('showmp','equals','1'),
                        'title'     => __('Homepage Main Player Headline', 'redux-framework-demo'),
                        'subtitle'  => __('Here you can change the Homepage Main Player Headline.', 'redux-framework-demo'),
                        'validate'  => 'no_html',
    					'msg'      => 'No HTML, only text can be used in this feild.',
    					'default'  => 'Latest Episode'
                    ),
					array( 
						'id'       => 'mp-headline-text-color',
						'type'     => 'color',
						'title'    => __('Main Player Headline Color', 'redux-framework-demo'),
						'subtitle' => __('Set your text color', 'redux-framework-demo'),
						'default'  => '#cbcbcb',
						'output'   => array('#player-bar .mp-headline,#player-bar .share-icon,#player-bar .play-dnld span.divider,.single #player-bar h2.post-title'),
						'mode'     => 'color',
						'transparent' => false
					),
					array( 
						'id'       => 'player-bg-overlay',
						'type'     => 'color',
						'title'    => __('Main Player Area Background', 'redux-framework-demo'),
						'subtitle' => __('Set your background color', 'redux-framework-demo'),
						'default'  => '#292929',
						'output'   => array('#player-bar .outer-wrap,#player-bar .player .mejs-container .mejs-controls .mejs-playpause-button,#player-bar .player .mejs-controls .mejs-time-rail .mejs-time-total,#player-bar .player .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-total'),
						'transparent' => false,
						'mode'     => 'background',
					),
					array( 
						'id'       => 'mp-content-bg',
						'type'     => 'color_rgba',
						'title'    => __('Main Player Content Background', 'redux-framework-demo'),
						'subtitle' => __('Set your background color', 'redux-framework-demo'),
						'default'  => array(
							'color' => '#000000', 
							'alpha' => '0.7'
						),
						'output'   => array('#player-bar .mp-content'),
						'transparent' => true,
						'mode'     => 'background',
					),
					array( 
						'id'       => 'sp-text-color',
						'type'     => 'color',
						'title'    => __('Main Player Content Text Color', 'redux-framework-demo'),
						'subtitle' => __('Set your text color', 'redux-framework-demo'),
						'default'  => '#cbcbcb',
						'output'   => array('#player-bar,#player-bar .entry-title,#player-bar .entry-title a, #player-bar .mejs-container .mejs-controls .mejs-time, #player-bar .mejs-container .mejs-controls .mejs-time span, #player-bar .mejs-controls .mejs-mute,#player-bar .player .mejs-controls .mejs-time-rail .mejs-time-float-current,#player-bar .player .mejs-controls .mejs-mute button,#player-bar .player .mejs-controls .mejs-unmute button'),
						'mode'     => 'color',
						'transparent' => false
					),
                    array(
                        'id'        => 'sp-link',
                        'type'      => 'link_color',
                        'title'     => __('Main Player Play/Pause Buttons', 'redux-framework-demo'),
                        'subtitle'  => __('Choose Main Player Play/Pause Buttons Colors', 'redux-framework-demo'),
						'output'   => array('#player-bar .mejs-controls .mejs-button button'),
                        'active'    => false,
                        'default'   => array(
                            'regular'   => '#000',
                            'hover'     => '#777',
                        )
                    ),
					array( 
						'id'       => 'player-button-bg',
						'type'     => 'color',
						'title'    => __('Main Player Button Background', 'redux-framework-demo'),
						'subtitle' => __('Set your background color', 'redux-framework-demo'),
						'default'  => '#cbcbcb',
						'output'   => array('#player-bar .player .mejs-controls .mejs-play button,#player-bar .player .mejs-controls .mejs-pause button'),
						'transparent' => false,
						'mode'     => 'background',
					),
					array( 
						'id'       => 'player-button-bg-hover',
						'type'     => 'color',
						'title'    => __('Main Player Button Hover Background', 'redux-framework-demo'),
						'subtitle' => __('Set your background color for hover', 'redux-framework-demo'),
						'default'  => '#f76d3c',
						'output'   => array('#player-bar .player .mejs-controls .mejs-play button:hover,#player-bar .player .mejs-controls .mejs-pause button:hover'),
						'transparent' => false,
						'mode'     => 'background',
					),
                    array(
                        'id'        => 'sp-font',
                        'type'      => 'typography',
                        'title'     => __('Main Player Font', 'redux-framework-demo'),
                        'subtitle'  => __('Specify the Main Player Area font.', 'redux-framework-demo'),
                        'output'        => array('#player-bar,#player-bar h1'),
                        'google'    => true,
						'line-height' => false,
                        'font-size' => false,
                        'font-weight' => false,
                        'font-style' => false,
                        'color' => false,
                        'text-align' => false,
                        'default'   => array(
                            'font-family'   => 'Noto Sans',
                        ),
                    ),
					array(
					   'id' => 'mp-pwd-title',
					   'type' => 'section',
					   'title' => __('Main Player Play/Download Buttons', 'redux-framework-demo'),
					   'indent' => true
				   	),
                    array(
                        'id'        => 'mp-showpwd',
                        'type'      => 'switch',
                        'title'     => __('Play/Download Buttons', 'redux-framework-demo'),
                        'subtitle'  => __('Enable or Disable the Play in New Window/Download Buttons', 'redux-framework-demo'),
                        'default'   => true,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled',
                    ),
                    array(
                        'id'        => 'd-link',
                        'type'      => 'link_color',
						'required' 	=> array('mp-showpwd','equals','1'),
                        'title'     => __('Main Player Download Button Text Colors', 'redux-framework-demo'),
                        'subtitle'  => __('Choose Download Text Colors', 'redux-framework-demo'),
						'output'   => array('#player-bar .play-dnld a'),
                        'active'    => false,
                        'default'   => array(
                            'regular'   => '#cbcbcb',
                            'hover'     => '#f76d3c',
                        )
                    ),
					array(
						'id'   =>'single-player-divide',
						'type' => 'divide'
					),
					array(
					   'id' => 'single-post-player',
					   'type' => 'section',
					   'title' => __('Single Post Players', 'redux-framework-demo'),
					   'indent' => true
				   	),
                    array(
                        'id'        => 'showsp',
                        'type'      => 'switch',
                        'title'     => __('Single Post Main Player', 'redux-framework-demo'),
                        'subtitle'  => __('Enable or Disable the Single Post Main Player', 'redux-framework-demo'),
                        'default'   => true,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled',
                    ),
                    array(
                        'id'        => 'show-single-embed',
                        'type'      => 'switch',
                        'title'     => __('Embed Post Audio Player', 'redux-framework-demo'),
                        'subtitle'  => __('Enable or Disable the auto embed Post Audio Player', 'redux-framework-demo'),
						'desc' 		=> __('This can only be used if you are using the Appendipity Podcast Settings or Simple Podcast Press. Blubrry users can use the Blubrry embed features.', 'redux-framework-demo'),
                        'default'   => false,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled',
                    ),
					array(
						'id'       => 'single-placement',
						'type'     => 'select',
						'required' 	=> array('show-single-embed','equals','1'),
						'title'    => __('Post Audio Player Placement', 'redux-framework-demo'),
						'subtitle' => __('Select where to the Embed the Post Audio Player', 'redux-framework-demo'),
						'desc' 		=> __('', 'redux-framework-demo'),
						'options'  => array(
							'1' => 'Before Post Content',
							'2' => 'After Post Content',
						),
						'default'  => '1',
					),
					array(
						'id'   =>'spp-divide',
						'type' => 'divide'
					),
					array(
					   'id' => 'spp-title',
					   'type' => 'section',
					   'title' => __('Blog and Archive Player', 'redux-framework-demo'),
					   'indent' => true
				   	),
                    array(
                        'id'        => 'show_ba_player',
                        'type'      => 'switch',
                        'title'     => __('Blog and Archive Player', 'redux-framework-demo'),
                        'subtitle'  => __('Enable or Disable the Blog and Archive Players', 'redux-framework-demo'),
                        'desc'  => __('Disable this player if you want to use the Simple Podcast Press player on your blog and archive pages. You will also need to make sure that the checkboxes next to <strong>"Resolve player conflict on home page of Appendipity Themes"</strong> and <strong>"Disable Player and Text from Home, Blog, or Archive Pages"</strong> are unchecked in the Simple Podcast Press settings.', 'redux-framework-demo'),
                        'default'   => true,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled',
                    ),
					array(
						'id'   =>'spp-on-divide',
						'type' => 'divide'
					),
					array(
					   'id' => 'spp-on-title',
					   'type' => 'section',
					   'title' => __('Smart Podcast Players', 'redux-framework-demo'),
					   'indent' => true
				   	),
                    array(
                        'id'        => 'show_spp_player',
                        'type'      => 'switch',
                        'title'     => __('Use Smart Podcast Player', 'redux-framework-demo'),
                        'subtitle'  => __('Enable or Disable the Smart Podcast Player', 'redux-framework-demo'),
                        'desc'  => __('Enable this feature if you want to replace the Appendipity audio players with the Smart Podcast Player.', 'redux-framework-demo'),
                        'default'   => false,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled',
                    ),
					array(
						'id'   =>'ap-divide',
						'type' => 'divide'
					),
					array(
					   'id' => 'audio-player',
					   'type' => 'section',
					   'title' => __('Widgets and Posts Audio Player', 'redux-framework-demo'),
					   'indent' => true
				   	),
					array( 
						'id'       => 'audio-bg',
						'type'     => 'color_rgba',
						'title'    => __('Audio Player Background Color', 'redux-framework-demo'),
						'subtitle' => __('Set your background color and opacity', 'redux-framework-demo'),
						'default'  => array(
							'color' => '#292929', 
							'alpha' => '0.6'
						),
						'output'   => array('.entry .mejs-container,.podcast-entry .player .mejs-container,.podcast-entry .mejs-video .mejs-controls,.entry .mejs-video .mejs-controls,.entry .mejs-controls .mejs-volume-button .mejs-volume-slider'),
						'mode'     => 'background',
					),
					array( 
						'id'       => 'audio-text-color',
						'type'     => 'color',
						'title'    => __('Audio Player Text Color', 'redux-framework-demo'),
						'subtitle' => __('Set your text color', 'redux-framework-demo'),
						'default'  => '#cbcbcb',
						'output'   => array('.mejs-container .mejs-controls .mejs-time span,.mejs-controls .mejs-time-rail .mejs-time-float-current,.mejs-container .mejs-controls .mejs-time'),
						'mode'     => 'color',
						'transparent' => false
					),
                    array(
                        'id'        => 'audio-link',
                        'type'      => 'link_color',
                        'title'     => __('Audio Player Buttons', 'redux-framework-demo'),
                        'subtitle'  => __('Choose Audio Player Buttons Colors', 'redux-framework-demo'),
						'output'   => array('.mejs-controls .mejs-button button'),
                        'active'    => false,
                        'default'   => array(
                            'regular'   => '#cbcbcb',
                            'hover'     => '#f76d3c',
                        )
                    ),
					array(
						'id'   =>'pwd-divide',
						'type' => 'divide'
					),
					array(
					   'id' => 'pwd-title',
					   'type' => 'section',
					   'title' => __('Widget Play/Download Buttons', 'redux-framework-demo'),
					   'indent' => true
				   	),
                    array(
                        'id'        => 'showpwd',
                        'type'      => 'switch',
                        'title'     => __('Play/Download Buttons', 'redux-framework-demo'),
                        'subtitle'  => __('Enable or Disable the Play in New Window/Download Buttons', 'redux-framework-demo'),
                        'default'   => false,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled',
                    ),
                    array(
                        'id'        => 'sm-d-link',
                        'type'      => 'link_color',
						'required' 	=> array('showpwd','equals','1'),
                        'title'     => __('Play/Download Button Colors', 'redux-framework-demo'),
                        'subtitle'  => __('Choose Play/Download Button Colors', 'redux-framework-demo'),
						'output'   => array('.dnld-play a'),
                        'active'    => false,
                        'default'   => array(
                            'regular'   => '#cbcbcb',
                            'hover'     => '#f76d3c',
                        )
                    ),
                )
            );
			
            $this->sections[] = array(
                'icon'      => 'el-icon-picture',
                'title'     => __('Above Post Banner', 'redux-framework-demo'),
                'heading'   => __('Completely customize your Above Post Banner.', 'redux-framework-demo'),
                'desc'      => __('', 'redux-framework-demo'),
                'fields'    => array(
					array(
						'id'       => 'video-banner',
						'type'     => 'raw',
						//'title'    => __('Getting Started', 'redux-framework-demo'),
						//'subtitle' => __('Watch the video to see how to use the settings in this section.', 'redux-framework-demo'),
						//'desc'     => __('This is the description field for additional info.', 'redux-framework-demo'),
						//'content'  => '<iframe width="720" height="405" src="//www.youtube.com/embed/-qZqrILxgMc?rel=0&amp;autohide=1&amp;modestbranding=1&amp;showinfo=0" frameborder="0" allowfullscreen="allowfullscreen"></iframe>',
						'content'  => '<p>This section is for the Above Post Banner section . Here you&rsquo;ll be able to edit, stylize, customize, enable or disable this feature.</p>
										<br />
										<p>This section will appear above your posts and pages on your entire site.</p>
										<br />
										<p>You can add videos, banners, or text. It&rsquo;s best used as an announcement and/or promotions.</p>
										<br />
										<p><strong>Saving your Changes and Settings:</strong></p>
										<p>Once you&rsquo;re done editing and stylizing this section simply either scroll up or down and click on the &ldquo;Save Changes&rdquo; button. </p>
										<br />
										<p>Once saved preview your theme to see if anymore editing is needed. You can either leave as is, edit some more, or reset this section by clicking the &ldquo;Reset Section&rdquo; button. Clicking this button will reset that specific section to it&rsquo;s default settings.</p>
										<br />
										<p><strong>WARNING!</strong> The last button is Reset All. Clicking this button will reset your entire Appendipity Options to its default settings. Be very careful with this button as it will reset your entire settings. ONLY do this if you&rsquo;re sure you want to reset all.</p><hr />',
						//'align'		=> 'sectioned'
					),
					array(
						'id'   =>'abp-divide',
						'type' => 'divide'
					),
                    array(
                        'id'        => 'showabp',
                        'type'      => 'switch',
                        'title'     => __('Sitewide Above Post Banner', 'redux-framework-demo'),
                        'subtitle'  => __('Enable and add some text or images below to activate the Above Post Banner.', 'redux-framework-demo'),
                        'default'   => true,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled',
                    ),
                    array(
                        'id'        => 'above-post-banner',
                        'type'      => 'editor',
						'required' 	=> array('showabp','equals','1'),
                        'title'     => __('Above Post Banner Editor', 'redux-framework-demo'),
                        'subtitle'  => __('Here you can place whatever you like for your Above Post Banner. This will show on all posts and pages. You can customize this on a per post/page basis in the Appendipity Custom Settings Meta Box. Suggested image width is 770px for the Above Post Banner, no limit on height.', 'redux-framework-demo'),
                        'default'   => '',
						'args'   => array(
							'teeny'            => false,
							'textarea_rows'    => 16
						)
                    ),
					array( 
						'id'       => 'abp-bg',
						'type'     => 'color',
						'required' 	=> array('showabp','equals','1'),
						'title'    => __('Above Post Banner Background', 'redux-framework-demo'),
						'subtitle' => __('Set your background color', 'redux-framework-demo'),
						'default'  => '#f8f8f8',
						'output'   => array('#before-content-banner'),
						'mode'     => 'background',
					),
                    array(
                        'id'        => 'abp-font',
                        'type'      => 'typography',
						'required' 	=> array('showabp','equals','1'),
                        'title'     => __('Above Post Banner Font', 'redux-framework-demo'),
                        'subtitle'  => __('Specify the above post banner font.', 'redux-framework-demo'),
                        'output'        => array('#before-content-banner, #before-content-banner h1, #before-content-banner h2, #before-content-banner h3, #before-content-banner h4, #before-content-banner h5, #before-content-banner h6'),
                        'google'    => true,
						'line-height' => false,
                        'font-size' => false,
                        'font-weight' => false,
                        'font-style' => false,
                        'color' => false,
                        'text-align' => false,
                        'default'   => array(
                            'font-family'   => 'Noto Sans',
                        ),
                    ),
					array(
						'id'             => 'abp-spacing',
						'type'           => 'spacing',
						//'required' 	=> array('showabp','equals','1'),
						'output'         => array('#before-content-banner'),
						'mode'           => 'padding',
						'units'          => array('px', 'rem'),
						'units_extended' => 'false',
						'title'          => __('Above Post Banner Padding', 'redux-framework-demo'),
						'subtitle'       => __('Pick the amount of padding you want for your above post banner.', 'redux-framework-demo'),
						'default'            => array(
							'padding-top'     => '30px',
							'padding-right'   => '30px',
							'padding-bottom'  => '30px',
							'padding-left'    => '30px',
							'units'          => 'px',
						)
					),
                )
            );
            
            $this->sections[] = array(
                'icon'      => 'el-icon-envelope',
                'title'     => __('Optin Widgets', 'redux-framework-demo'),
                'desc'      => __('', 'redux-framework-demo'),
                'fields'    => array(
					array(
						'id'       => 'video-optin',
						'type'     => 'raw',
						//'title'    => __('Getting Started', 'redux-framework-demo'),
						//'subtitle' => __('Watch the video to see how to use the settings in this section.', 'redux-framework-demo'),
						//'desc'     => __('This is the description field for additional info.', 'redux-framework-demo'),
						//'content'  => '<iframe width="720" height="405" src="//www.youtube.com/embed/a7UC9aYmojw?rel=0&amp;autohide=1&amp;modestbranding=1&amp;showinfo=0" frameborder="0" allowfullscreen="allowfullscreen"></iframe>',
						'content'  => '<p>This section is for the Optin Widgets. Here you&rsquo;ll be able to edit, stylize and customize this feature.</p>
										<br />
										<p>This feature is compatible with some of the top autoresponders in the industry and we&rsquo;ll be adding more in the future.</p>
										<br />
										<p>Currently compatible with the following</p>
										<br />
										<ul>
											<li><a target="_blank" href="https://www.appendipity.com/convertkit" >ConvertKit</a></li>
											<li><a target="_blank" href="https://www.appendipity.com/getresponse" >Getresponse</a></li>
											<li><a target="_blank" href="https://www.appendipity.com/aweber" >Aweber</a></li>
											<li><a target="_blank" href="https://www.appendipity.com/icontact" >iContact</a></li>
											<li><a target="_blank" href="https://www.appendipity.com/mailchimp" >Mailchimp</a></li>
											<li>Infusionsoft</li>
										</ul>
										<br />
										<p><strong>Saving your Changes and Settings:</strong></p>
										<p>Once you&rsquo;re done editing and stylizing this section simply either scroll up or down and click on the &ldquo;Save Changes&rdquo; button. </p>
										<br />
										<p>Once saved preview your theme to see if anymore editing is needed. You can either leave as is, edit some more, or reset this section by clicking the &ldquo;Reset Section&rdquo; button. Clicking this button will reset that specific section to it&rsquo;s default settings.</p>
										<br />
										<p><strong>WARNING!</strong> The last button is Reset All. Clicking this button will reset your entire Appendipity Options to its default settings. Be very careful with this button as it will reset your entire settings. ONLY do this if you&rsquo;re sure you want to reset all.</p><hr />',
						//'align'		=> 'sectioned'
					),
					array(
						'id'   =>'ow-divide',
						'type' => 'divide'
					),
					array(
						'id'       => 'autoresponder',
						'type'     => 'select',
						'title'    => __('Optin Widget AutoResponder', 'redux-framework-demo'),
						'subtitle' => __('Pick the autoresponder that you use.', 'redux-framework-demo'),
						'options'  => array(
							'getresponse' 	=> 'getresponse',
							'aweber' 		=> 'aweber',
							'icontact' 		=> 'icontact',
							'mailchimp' 	=> 'mailchimp',
							'infusionsoft' 	=> 'infusionsoft',
							'convertkit' 	=> 'convertkit',
						),
						'default'  => 'getresponse',
					),
					array( 
						'id'       => 'optin-bg-color',
						'type'     => 'color',
						'title'    => __('Optin Form Background Color', 'redux-framework-demo'),
						'subtitle' => __('Set your background color', 'redux-framework-demo'),
						'default'  => '#292929',
						'output'   => array('.sb-optin,#footer_optin_area'),
						'mode'     => 'background-color',
						'transparent' => false
					),
                    array(
                        'id'        => 'optin-font',
                        'type'      => 'typography',
                        'title'     => __('Optin Form Font', 'redux-framework-demo'),
                        'subtitle'  => __('Specify the Optin Form font and Color.', 'redux-framework-demo'),
                        'output'        => array('.sb-optin,.sb-optin h4.widgettitle'),
                        'google'    => true,
						'line-height' => false,
                        'font-size' => false,
                        'font-weight' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'default'   => array(
                            'font-family'   => 'Noto Sans',
							'color'			=> '#cbcbcb'
                        ),
                    ),
                    array(
                        'id'        => 'optin-button',
                        'type'      => 'color',
                        'title'     => __('Optin Submit Button', 'redux-framework-demo'),
                        'subtitle'  => __('Choose Optin Submit Button Color', 'redux-framework-demo'),
						'default'  => '#f76d3c',
						'output'   => array('.sb-optin .submit'),
						'mode'     => 'background-color',
						'transparent' => false
                    ),
                    array(
                        'id'        => 'optin-button-hover',
                        'type'      => 'color',
                        'title'     => __('Optin Submit Button Hover', 'redux-framework-demo'),
                        'subtitle'  => __('Choose Optin Submit Button Hover Color', 'redux-framework-demo'),
						'default'  => '#ce5124',
						'output'   => array('.sb-optin .submit:hover'),
						'mode'     => 'background-color',
						'transparent' => false
                    ),
                    array(
                        'id'        => 'optin-button-text',
                        'type'      => 'color',
                        'title'     => __('Optin Submit Button Text', 'redux-framework-demo'),
                        'subtitle'  => __('Choose Optin Submit Button Text Color', 'redux-framework-demo'),
						'default'  => '#fff',
						'output'   => array('.sb-optin .submit'),
						'mode'     => 'color',
						'transparent' => false
                    ),
                    array(
                        'id'        => 'optin-button-text-hover',
                        'type'      => 'color',
                        'title'     => __('Optin Submit Button Text Hover', 'redux-framework-demo'),
                        'subtitle'  => __('Choose Optin Submit Button Text Hover Color', 'redux-framework-demo'),
						'default'  => '#fff',
						'output'   => array('.sb-optin .submit:hover'),
						'mode'     => 'color',
						'transparent' => false
                    ),
                )
            );
            
            $this->sections[] = array(
                'icon'      => 'el-icon-thumbs-up',
                'title'     => __('Social Buttons', 'redux-framework-demo'),
                'desc'      => __('', 'redux-framework-demo'),
                'fields'    => array(
					array(
						'id'       => 'video-social',
						'type'     => 'raw',
						//'title'    => __('Getting Started', 'redux-framework-demo'),
						//'subtitle' => __('Watch the video to see how to use the settings in this section.', 'redux-framework-demo'),
						//'desc'     => __('This is the description field for additional info.', 'redux-framework-demo'),
						//'content'  => '<iframe width="720" height="405" src="//www.youtube.com/embed/yMZX9-a2cjs?rel=0&amp;autohide=1&amp;modestbranding=1&amp;showinfo=0" frameborder="0" allowfullscreen="allowfullscreen"></iframe>',
						'content'  => '<p>This section is for the Social Buttons. Here you\'ll be able to enable or disable some or all your social media buttons.</p>
										<br />
										<p><strong>Saving your Changes and Settings:</strong></p>
										<p>Once you&rsquo;re done editing and stylizing this section simply either scroll up or down and click on the &ldquo;Save Changes&rdquo; button. </p>
										<br />
										<p>Once saved preview your theme to see if anymore editing is needed. You can either leave as is, edit some more, or reset this section by clicking the &ldquo;Reset Section&rdquo; button. Clicking this button will reset that specific section to it&rsquo;s default settings.</p>
										<br />
										<p><strong>WARNING!</strong> The last button is Reset All. Clicking this button will reset your entire Appendipity Options to its default settings. Be very careful with this button as it will reset your entire settings. ONLY do this if you&rsquo;re sure you want to reset all.</p><hr />',
						//'align'		=> 'sectioned'
					),
					array(
						'id'   =>'sb-divide',
						'type' => 'divide'
					),
					array(
						'id'       => 'sb-placement',
						'type'     => 'select',
						'title'    => __('Social Share Buttons Placement', 'redux-framework-demo'),
						'subtitle' => __('Select where to show the Social Share Buttons on single posts and pages.', 'redux-framework-demo'),
						'options'  => array(
							'1' => 'After Post Content',
							'2' => 'Before Post Content',
							'3' => 'Both',
							'4' => 'None',
						),
						'default'  => '1',
					),
                    array(
                        'id'        => 'share-text',
                        'type'      => 'text',
                        'title'     => __('Share Headline', 'redux-framework-demo'),
                        'subtitle'  => __('Enter a headline above your share button to entice people to share your content.', 'redux-framework-demo'),
                    ),
                    array(
                        'id'        => 'showfb',
                        'type'      => 'switch',
                        'title'     => __('Facebook', 'redux-framework-demo'),
                        'subtitle'  => __('Show or hide facebook share button.', 'redux-framework-demo'),
                        'default'   => true,
                        'on'        => 'Show',
                        'off'       => 'Hide',
                    ),
                    array(
                        'id'        => 'showtw',
                        'type'      => 'switch',
                        'title'     => __('Twitter', 'redux-framework-demo'),
                        'subtitle'  => __('Show or hide tweet button.', 'redux-framework-demo'),
                        'default'   => true,
                        'on'        => 'Show',
                        'off'       => 'Hide',
                    ),
                    array(
                        'id'        => 'tw-username',
                        'type'      => 'text',
						'required' 	=> array('showtw','equals','1'),
                        'title'     => __('Twitter Username', 'redux-framework-demo'),
                        'subtitle'  => __('Enter your Twitter username to use via@yourusername in the tweets.', 'redux-framework-demo'),
                        'desc'      => __('No @ required.', 'redux-framework-demo'),
                    ),
                    array(
                        'id'        => 'showlin',
                        'type'      => 'switch',
                        'title'     => __('LinkedIn', 'redux-framework-demo'),
                        'subtitle'  => __('Show or hide linkedin share button.', 'redux-framework-demo'),
                        'default'   => true,
                        'on'        => 'Show',
                        'off'       => 'Hide',
                    ),
                    array(
                        'id'        => 'showgp',
                        'type'      => 'switch',
                        'title'     => __('Google+', 'redux-framework-demo'),
                        'subtitle'  => __('Show or hide google +1 button.', 'redux-framework-demo'),
                        'default'   => true,
                        'on'        => 'Show',
                        'off'       => 'Hide',
                    ),
                    array(
                        'id'        => 'showpin',
                        'type'      => 'switch',
                        'title'     => __('Pinterest', 'redux-framework-demo'),
                        'subtitle'  => __('Show or hide pinterest share button.', 'redux-framework-demo'),
                        'default'   => true,
                        'on'        => 'Show',
                        'off'       => 'Hide',
                    ),
                    array(
                        'id'        => 'pin-default',
                        'type'      => 'media',
						'required' 	=> array('showpin','equals','1'),
                        'url'       => true,
                        'title'     => __('Default Pinterest Image', 'redux-framework-demo'),
                        'subtitle'  => __('Upload a default image for sharing on pinterest.', 'redux-framework-demo'),
						'readonly' => false,
                    ),
                    array(
                        'id'        => 'showstum',
                        'type'      => 'switch',
                        'title'     => __('StumbleUpon', 'redux-framework-demo'),
                        'subtitle'  => __('Show or hide StumbleUpon share button.', 'redux-framework-demo'),
                        'default'   => true,
                        'on'        => 'Show',
                        'off'       => 'Hide',
                    ),
                )
            );
			
            $this->sections[] = array(
                'icon'      => 'el-icon-resize-horizontal',
                'title'     => __('Prev/Next Post', 'redux-framework-demo'),
                'heading'   => __('Completely customize your Prev/Next Post Nav.', 'redux-framework-demo'),
                'desc'      => __('', 'redux-framework-demo'),
                'fields'    => array(
					array(
						'id'       => 'video-prev-next',
						'type'     => 'raw',
						//'title'    => __('Getting Started', 'redux-framework-demo'),
						//'subtitle' => __('Watch the video to see how to use the settings in this section.', 'redux-framework-demo'),
						//'desc'     => __('This is the description field for additional info.', 'redux-framework-demo'),
						//'content'  => '<iframe width="720" height="405" src="//www.youtube.com/embed/4GEmiaeZGVA?rel=0&amp;autohide=1&amp;modestbranding=1&amp;showinfo=0" frameborder="0" allowfullscreen="allowfullscreen"></iframe>',
						'content'  => '<p>This section is for the Previous and Next Post options. Here you\'ll be able to edit, stylize, customize, enable or disable this feature.</p>
										<br />
										<p><strong>Saving your Changes and Settings:</strong></p>
										<p>Once you&rsquo;re done editing and stylizing this section simply either scroll up or down and click on the &ldquo;Save Changes&rdquo; button. </p>
										<br />
										<p>Once saved preview your theme to see if anymore editing is needed. You can either leave as is, edit some more, or reset this section by clicking the &ldquo;Reset Section&rdquo; button. Clicking this button will reset that specific section to it&rsquo;s default settings.</p>
										<br />
										<p><strong>WARNING!</strong> The last button is Reset All. Clicking this button will reset your entire Appendipity Options to its default settings. Be very careful with this button as it will reset your entire settings. ONLY do this if you&rsquo;re sure you want to reset all.</p><hr />',
						//'align'		=> 'sectioned'
					),
					array(
						'id'   =>'pn-divide',
						'type' => 'divide'
					),
                    array(
                        'id'        => 'showpnp',
                        'type'      => 'switch',
                        'title'     => __('Prev/Next Post Nav', 'redux-framework-demo'),
                        'subtitle'  => __('Enable or Disable the Prev/Next Posts', 'redux-framework-demo'),
                        'default'   => false,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled',
                    ),
					array(
						'id'       => 'pnp-placement',
						'type'     => 'select',
						'required' 	=> array('showpnp','equals','1'),
						'title'    => __('Prev/Next Post Nav Placement', 'redux-framework-demo'),
						'subtitle' => __('Select where to show the Prev/Next Post Nav', 'redux-framework-demo'),
						'options'  => array(
							'1' => 'After Post',
							'2' => 'Before Comments',
							'3' => 'After Comments',
						),
						'default'  => '1',
					),
                    array(
                        'id'        => 'showtitle',
                        'type'      => 'switch',
						'required' 	=> array('showpnp','equals','1'),
                        'title'     => __('Prev/Next Post Nav Title', 'redux-framework-demo'),
                        'subtitle'  => __('Enable or Disable the Prev/Next Post Nav Titles', 'redux-framework-demo'),
                        'desc'  	=> __('Enable to show post titles, Disable to show default Prev/Next text.', 'redux-framework-demo'),
                        'default'   => false,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled',
                    ),
					array( 
						'id'       => 'pnp-bg',
						'type'     => 'color',
						'required' 	=> array('showpnp','equals','1'),
						'title'    => __('Prev/Next Post Nav Background', 'redux-framework-demo'),
						'subtitle' => __('Set your background color', 'redux-framework-demo'),
						'default'  => '#f8f8f8',
						'output'   => array('#prev-next .previous,#prev-next .next'),
						'mode'     => 'background',
					),
					array( 
						'id'       => 'pnp-bg-hover',
						'type'     => 'color',
						'required' 	=> array('showpnp','equals','1'),
						'title'    => __('Prev/Next Post Nav Hover Background', 'redux-framework-demo'),
						'subtitle' => __('Set your hover background color', 'redux-framework-demo'),
						'default'  => '#f76d3c',
						'output'   => array('#prev-next .previous:hover,#prev-next .next:hover'),
						'mode'     => 'background',
					),
                    array(
                        'id'        => 'pnp-link',
                        'type'      => 'link_color',
						'required' 	=> array('showpnp','equals','1'),
                        'title'     => __('Prev/Next Post Nav Links', 'redux-framework-demo'),
                        'subtitle'  => __('Choose Prev/Next Post Nav link colors', 'redux-framework-demo'),
						'output'   => array('#prev-next a'),
                        'active'    => false,
                        'default'   => array(
                            'regular'   => '#333',
                            'hover'     => '#ececec',
                        )
                    ),
                    array(
                        'id'        => 'pnp-font',
                        'type'      => 'typography',
						'required' 	=> array('showpnp','equals','1'),
                        'title'     => __('Prev/Next Post Nav Font', 'redux-framework-demo'),
                        'subtitle'  => __('Specify the previous/next post navigation font.', 'redux-framework-demo'),
                        'output'        => array('#prev-next'),
                        'google'    => true,
						'line-height' => false,
                        'font-size' => false,
                        'font-weight' => false,
                        'font-style' => false,
                        'color' => false,
                        'text-align' => false,
                        'default'   => array(
                            'font-family'   => 'Noto Sans',
                        ),
                    ),
					array(
						'id'   =>'cs-divide',
						'type' => 'divide',
						'required' 	=> array('showpnp','equals','1'),
					),
					array(
					   'id' => 'cs-section',
					   'type' => 'section',
						'required' 	=> array('showpnp','equals','1'),
					   'title' => __('Coming Soon', 'redux-framework-demo'),
					   'indent' => true
				   	),
                    array(
                        'id'        => 'cs-title',
                        'type'      => 'text',
						'required' 	=> array('showpnp','equals','1'),
                        'title'     => __('Coming Soon Text', 'redux-framework-demo'),
                        'subtitle'  => __('Here you can change the Coming Soon title text.', 'redux-framework-demo'),
                        'validate'  => 'no_html',
    					'msg'      => 'No HTML, only text can be used in this feild',
    					'default'  => 'Coming Soon'
                    ),
                    array(
                        'id'        => 'cs-size',
                        'type'      => 'switch',
						'required' 	=> array('showpnp','equals','1'),
                        'title'     => __('Coming Soon Text Size', 'redux-framework-demo'),
                        'subtitle'  => __('Pick Big or Small coming soon text size', 'redux-framework-demo'),
                        'default'   => true,
                        'on'        => 'Big',
                        'off'       => 'Small',
                    ),
                    array(
                        'id'        => 'cs-link',
                        'type'      => 'text',
						'required' 	=> array('showpnp','equals','1'),
                        'title'     => __('Coming Soon Link', 'redux-framework-demo'),
                        'subtitle'  => __('Here you can change the Coming Soon Link.', 'redux-framework-demo'),
                        'validate'  => 'url',
    					'msg'      => 'Must be a valid url',
    					'default'  => ''
                    ),
					array(
						'id'       => 'cs-new-win',
						'type'     => 'checkbox',
						'required' 	=> array('showpnp','equals','1'),
						'title'    => __('Open in a New Window', 'redux-framework-demo'),
						'subtitle' => __('Check box to open coming soon link in a new window.', 'redux-framework-demo'),
						'default'  => '1',
					),
                )
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-list',
                'title'     => __('Related Posts', 'redux-framework-demo'),
                'heading'   => __('Completely customize your Related Posts.', 'redux-framework-demo'),
                'desc'      => __('', 'redux-framework-demo'),
                'fields'    => array(
					array(
						'id'       => 'video-related',
						'type'     => 'raw',
						//'title'    => __('Getting Started', 'redux-framework-demo'),
						//'subtitle' => __('Watch the video to see how to use the settings in this section.', 'redux-framework-demo'),
						//'desc'     => __('This is the description field for additional info.', 'redux-framework-demo'),
						//'content'  => '<iframe width="720" height="405" src="//www.youtube.com/embed/h2f1FNc-Ydk?rel=0&amp;autohide=1&amp;modestbranding=1&amp;showinfo=0" frameborder="0" allowfullscreen="allowfullscreen"></iframe>',
						'content'  => '<p>This section is for the Related Post section. Here you\'ll be able to edit, stylize, customize, enable or disable this feature.</p>
										<br />
										<p><strong>Saving your Changes and Settings:</strong></p>
										<p>Once you&rsquo;re done editing and stylizing this section simply either scroll up or down and click on the &ldquo;Save Changes&rdquo; button. </p>
										<br />
										<p>Once saved preview your theme to see if anymore editing is needed. You can either leave as is, edit some more, or reset this section by clicking the &ldquo;Reset Section&rdquo; button. Clicking this button will reset that specific section to it&rsquo;s default settings.</p>
										<br />
										<p><strong>WARNING!</strong> The last button is Reset All. Clicking this button will reset your entire Appendipity Options to its default settings. Be very careful with this button as it will reset your entire settings. ONLY do this if you&rsquo;re sure you want to reset all.</p><hr />',
						//'align'		=> 'sectioned'
					),
					array(
						'id'   =>'rp-divide',
						'type' => 'divide'
					),
                    array(
                        'id'        => 'showrp',
                        'type'      => 'switch',
                        'title'     => __('Related Posts', 'redux-framework-demo'),
                        'subtitle'  => __('Enable or Disable the Related Posts', 'redux-framework-demo'),
                        'default'   => false,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled',
                    ),
                    array(
                        'id'        => 'showrp-thumb',
                        'type'      => 'switch',
						'required' 	=> array('showrp','equals','1'),
                        'title'     => __('Related Posts Thumbnails', 'redux-framework-demo'),
                        'subtitle'  => __('Enable or Disable the Related Posts Thumbnails', 'redux-framework-demo'),
                        'default'   => false,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled',
                    ),
					array(
						'id'       => 'rp-thumb',
						'type'     => 'media', 
						'required' 	=> array('showrp-thumb','equals','1'),
						'url'      => true,
						'title'    => __('Related Posts Default Thumbnail', 'redux-framework-demo'),
						'desc'     => __('Upload your Default Thumbnail Image', 'redux-framework-demo'),
						'subtitle' => __('Default thumbnail will be used if there is no Featured Image or any images in the post. Suggested image size is 120px X 120px.', 'redux-framework-demo'),
						'default'  => array(
							'url'=> get_stylesheet_directory_uri() . '/images/related-post.png'
						),
					),
					array(
						'id'       => 'rp-placement',
						'type'     => 'select',
						'required' 	=> array('showrp','equals','1'),
						'title'    => __('Related Posts Placement', 'redux-framework-demo'),
						'subtitle' => __('Select where to show the Related Posts', 'redux-framework-demo'),
						'options'  => array(
							'1' => 'After Post',
							'2' => 'Before Comments',
							'3' => 'After Comments',
						),
						'default'  => '1',
					),
                    array(
                        'id'        => 'rp-font',
                        'type'      => 'typography',
						'required' 	=> array('showrp','equals','1'),
                        'title'     => __('Related Post Font', 'redux-framework-demo'),
                        'subtitle'  => __('Specify the Related Post font properties.', 'redux-framework-demo'),
                        'output'        => array('.related-list li'),
                        'google'    => true,
                        'font-size' => false,
						'line-height' => false,
						'text-align' => false,
						'color' 	=> false,
                        'default'   => array(
                            'font-family'   => 'Noto Sans',
                            'font-weight'   => 'normal',
                        ),
                    ),
					array( 
						'id'       => 'rp-bg',
						'type'     => 'color',
						'required' 	=> array('showrp','equals','1'),
						'title'    => __('Related Posts Background', 'redux-framework-demo'),
						'subtitle' => __('Set your background color', 'redux-framework-demo'),
						'default'  => '#f8f8f8',
						'output'   => array('.related-posts'),
						'mode'     => 'background',
					),
					array( 
						'id'       => 'rp-text',
						'type'     => 'color',
						'required' 	=> array('showrp','equals','1'),
						'title'    => __('Related Posts Text', 'redux-framework-demo'),
						'subtitle' => __('Set your text color', 'redux-framework-demo'),
						'default'  => '#333',
						'output'   => array('.related-posts,h3.related-title'),
						'mode'     => 'color',
						'transparent' => false
					),
                    array(
                        'id'        => 'rp-link',
                        'type'      => 'link_color',
						'required' 	=> array('showrp','equals','1'),
                        'title'     => __('Related Posts Links', 'redux-framework-demo'),
                        'subtitle'  => __('Choose Related Posts link colors', 'redux-framework-demo'),
						'output'   => array('.related-list li a'),
                        'active'    => false,
                        'default'   => array(
                            'regular'   => '#f76d3c',
                            'hover'     => '#ce5124',
                        )
                    ),
                    array(
                        'id'        => 'rp-headline',
                        'type'      => 'text',
						'required' 	=> array('showrp','equals','1'),
                        'title'     => __('Related Posts Headline', 'redux-framework-demo'),
                        'subtitle'  => __('Here you can change the Related Posts title text.', 'redux-framework-demo'),
                        'validate'  => 'no_html',
    					'msg'      => 'No HTML, only text can be used in this feild',
    					'default'  => 'Related Posts'
                    ),
					array(
						'id'       => 'rp-number',
						'type'     => 'select',
						'required' 	=> array('showrp','equals','1'),
						'title'    => __('Related Posts to Show', 'redux-framework-demo'),
						'subtitle' => __('Select number of related posts to be shown at the end of every post', 'redux-framework-demo'),
						'options'  => array(
							'1' => '1',
							'2' => '2',
							'3' => '3',
							'4' => '4',
							'5' => '5',
							'6' => '6',
							'7' => '7',
							'8' => '8',
							'9' => '9',
							'10' => '10'
						),
						'default'  => '5',
					),
                )
            );
			
            $this->sections[] = array(
                'icon'      => 'el-icon-resize-horizontal',
                'title'     => __('Footer', 'redux-framework-demo'),
                'heading'   => __('Completely customize the Footer and Footer Widgets.', 'redux-framework-demo'),
                'desc'      => __('', 'redux-framework-demo'),
                'fields'    => array(
					array(
						'id'       => 'video-footer',
						'type'     => 'raw',
						//'title'    => __('Getting Started', 'redux-framework-demo'),
						//'subtitle' => __('Watch the video to see how to use the settings in this section.', 'redux-framework-demo'),
						//'desc'     => __('This is the description field for additional info.', 'redux-framework-demo'),
						//'content'  => '<iframe width="720" height="405" src="//www.youtube.com/embed/QgZNaLQpEUc?rel=0&amp;autohide=1&amp;modestbranding=1&amp;showinfo=0" frameborder="0" allowfullscreen="allowfullscreen"></iframe>',
						'content'  => '<p>This section is for the Footer and Footer Widgets. Here you\'ll be able to edit, stylize and customize this feature.</p>
										<br />
										<p><strong>Saving your Changes and Settings:</strong></p>
										<p>Once you&rsquo;re done editing and stylizing this section simply either scroll up or down and click on the &ldquo;Save Changes&rdquo; button. </p>
										<br />
										<p>Once saved preview your theme to see if anymore editing is needed. You can either leave as is, edit some more, or reset this section by clicking the &ldquo;Reset Section&rdquo; button. Clicking this button will reset that specific section to it&rsquo;s default settings.</p>
										<br />
										<p><strong>WARNING!</strong> The last button is Reset All. Clicking this button will reset your entire Appendipity Options to its default settings. Be very careful with this button as it will reset your entire settings. ONLY do this if you&rsquo;re sure you want to reset all.</p><hr />',
						//'align'		=> 'sectioned'
					),
					array(
						'id'   =>'footer-divide',
						'type' => 'divide'
					),
					array(
					   'id' => 'footer',
					   'type' => 'section',
					   'title' => __('Footer', 'redux-framework-demo'),
					   'indent' => true
				   	),
					array( 
						'id'       => 'foot-bg',
						'type'     => 'color',
						'title'    => __('Footer Background', 'redux-framework-demo'),
						'subtitle' => __('Set your background color', 'redux-framework-demo'),
						'default'  => '#292929',
						'output'   => array('.site-footer'),
						'mode'     => 'background',
					),
					array( 
						'id'       => 'foot-text',
						'type'     => 'color',
						'title'    => __('Footer Text Color', 'redux-framework-demo'),
						'subtitle' => __('Set your font color', 'redux-framework-demo'),
						'default'  => '#cbcbcb',
						'output'   => array('.site-footer'),
						'mode'     => 'color',
						'transparent' => false
					),
                    array(
                        'id'        => 'foot-link',
                        'type'      => 'link_color',
                        'title'     => __('Footer Links', 'redux-framework-demo'),
                        'subtitle'  => __('Choose Footer link colors', 'redux-framework-demo'),
						'output'   => array('.site-footer a'),
                        'active'    => false,
                        'default'   => array(
                            'regular'   => '#cbcbcb',
                            'hover'     => '#f76d3c',
                        )
                    ),
					array(
						'id'   =>'foot-widgets-divide',
						'type' => 'divide'
					),
					array(
					   'id' => 'foot-widgets',
					   'type' => 'section',
					   'title' => __('Footer Widgets', 'redux-framework-demo'),
					   'indent' => true
				   	),
					array( 
						'id'       => 'foot-widget-bg',
						'type'     => 'color',
						'title'    => __('Footer Widgets Background', 'redux-framework-demo'),
						'subtitle' => __('Set your background color', 'redux-framework-demo'),
						'default'  => '#292929',
						'output'   => array('.footer-widgets'),
						'mode'     => 'background',
					),
					array( 
						'id'       => 'foot-widget-text',
						'type'     => 'color',
						'title'    => __('Footer Widgets Text Color', 'redux-framework-demo'),
						'subtitle' => __('Set your font color', 'redux-framework-demo'),
						'default'  => '#cbcbcb',
						'output'   => array('.footer-widgets'),
						'mode'     => 'color',
						'transparent' => false
					),
                    array(
                        'id'        => 'foot-widget-link',
                        'type'      => 'link_color',
                        'title'     => __('Footer Widgets Links', 'redux-framework-demo'),
                        'subtitle'  => __('Choose Footer link colors', 'redux-framework-demo'),
						'output'   => array('.footer-widgets a'),
                        'active'    => false,
                        'default'   => array(
                            'regular'   => '#cbcbcb',
                            'hover'     => '#f76d3c',
                        )
                    ),
                )
            );

            $theme_info  = '<div class="redux-framework-section-desc">';
            $theme_info .= '<p class="redux-framework-theme-data description theme-uri">' . __('<strong>Theme URL:</strong> ', 'redux-framework-demo') . '<a href="' . $this->theme->get('ThemeURI') . '" target="_blank">' . $this->theme->get('ThemeURI') . '</a></p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-author">' . __('<strong>Author:</strong> ', 'redux-framework-demo') . $this->theme->get('Author') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-version">' . __('<strong>Version:</strong> ', 'redux-framework-demo') . $this->theme->get('Version') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-description">' . $this->theme->get('Description') . '</p>';
            $tabs = $this->theme->get('Tags');
            if (!empty($tabs)) {
                $theme_info .= '<p class="redux-framework-theme-data description theme-tags">' . __('<strong>Tags:</strong> ', 'redux-framework-demo') . implode(', ', $tabs) . '</p>';
            }
            $theme_info .= '</div>';

            if (file_exists(dirname(__FILE__) . '/../README.md')) {
                $this->sections['theme_docs'] = array(
                    'icon'      => 'el-icon-list-alt',
                    'title'     => __('Documentation', 'redux-framework-demo'),
                    'fields'    => array(
                        array(
                            'id'        => '17',
                            'type'      => 'raw',
                            'markdown'  => true,
                            'content'   => file_get_contents(dirname(__FILE__) . '/../README.md')
                        ),
                    ),
                );
            }

            $this->sections[] = array(
                'title'     => __('Custom CSS', 'redux-framework-demo'),
                'desc'      => __('This section should be used by advanced developers only.', 'redux-framework-demo'),
                'icon'      => 'el-icon-warning-sign',
                'fields'    => array(
                    array(
                        'id'        => 'custom-css',
                        'type'      => 'ace_editor',
                        'title'     => __('CSS Code', 'redux-framework-demo'),
                        'subtitle'  => __('Paste your Custom CSS code here.', 'redux-framework-demo'),
                        'mode'      => 'css',
                        'theme'     => 'monokai',
                        'default'   => "#header{\nmargin: 0 auto;\n}",
						'options'	=>
							array(
								'minLines'=> 30,
								'maxLines' => 30
							)
                    ),
                ),
            );  

            $this->sections[] = array(
                'title'     => __('Import / Export', 'redux-framework-demo'),
                'desc'      => __('Watch video below to learn how to use this section:', 'redux-framework-demo'),
                'icon'      => 'el-icon-refresh',
                'fields'    => array(
					array(
						'id'       => 'import-export-footer',
						'type'     => 'raw',
						//'title'    => __('Getting Started', 'redux-framework-demo'),
						//'subtitle' => __('Watch the video to see how to use the settings in this section.', 'redux-framework-demo'),
						//'desc'     => __('This is the description field for additional info.', 'redux-framework-demo'),
						'content'  => '<iframe width="720" height="405" src="//www.youtube.com/embed/0del1081S9s?rel=0&amp;autohide=1&amp;modestbranding=1&amp;showinfo=0" frameborder="0" allowfullscreen="allowfullscreen"></iframe>',
						//'align'		=> 'sectioned'
					),
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => 'Import Export',
                        'subtitle'      => 'Save and restore your Redux options',
                        'full_width'    => false,
                    ),
                ),
            );                     
                    
            $this->sections[] = array(
                'type' => 'divide',
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-info-sign',
                'title'     => __('Theme Information', 'redux-framework-demo'),
                //'desc'      => __('<p class="description">This is the Description. Again HTML is allowed</p>', 'redux-framework-demo'),
                'fields'    => array(
                    array(
                        'id'        => 'opt-raw-info',
                        'type'      => 'raw',
                        'content'   => $item_info,
                    )
                ),
            );

            if (file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
                $tabs['docs'] = array(
                    'icon'      => 'el-icon-book',
                    'title'     => __('Documentation', 'redux-framework-demo'),
                    'content'   => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
                );
            }
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Appendipity Theme', 'redux-framework-demo'),
                'content'   => __('<p>Need help? Submit a Support Ticket (24 – 48 Hour Response Time): <a target="_blank" href="http://appendipity.com/helpdesk" title="Need help? Submit a Support Ticket">http://appendipity.com/helpdesk</a></p>', 'redux-framework-demo')
            );

            /* $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'redux-framework-demo'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
            ); */

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p></p>', 'redux-framework-demo');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                'opt_name' => 'app_options',
                'display_name' => 'Appendipity Options',
                'display_version' => '2.4',
                'page_slug' => 'appendipity_options',
                'page_title' => 'Appendipity Options',
                'dev_mode' => '0',
                'intro_text' => '<p>Completely customize your theme. No more looking like all of the other podcasters out there. You have the control with the Appendipity Options.</p>',
                'footer_text' => '<p>Remember to always save your settings after making changes.</p>',
                'admin_bar' => '1',
                'menu_type' => 'menu',
                'menu_title' => 'Appendipity',
                'allow_sub_menu' => '1',
                'page_parent_post_type' => 'your_post_type',
                'page_priority' => '30',
                'customizer' => '1',
                'default_show' => '1',
                'default_mark' => '*',
                'google_api_key' => 'AIzaSyCDR2uIbQehLHLnBeHyc9Bl1pAfkUX79nQ',
				'disable_tracking' => true,
                'hints' => 
                array(
                  'icon' => 'el-icon-question-sign',
                  'icon_position' => 'right',
                  'icon_size' => 'normal',
                  'tip_style' => 
                  array(
                    'color' => 'dark',
                    'shadow' => '1',
                    'rounded' => '1',
                  ),
                  'tip_position' => 
                  array(
                    'my' => 'top left',
                    'at' => 'bottom right',
                  ),
                  'tip_effect' => 
                  array(
                    'show' => 
                    array(
                      'duration' => '500',
                      'event' => 'mouseover',
                    ),
                    'hide' => 
                    array(
                      'duration' => '500',
                      'event' => 'mouseleave unfocus',
                    ),
                  ),
                ),
                'output' => '1',
                'output_tag' => '1',
                'compiler' => '0',
                'page_icon' => 'icon-themes',
                'page_permissions' => 'manage_options',
        		'save_defaults'        => true,
        		'default_show'         => false,
                'show_import_export' => '1',
                'database' => 'options',
                'transient_time' => '3600',
                'network_sites' => '1',
				'footer_credit' => 'Theme built by <a target="_blank" href="http://www.appendipity.com" >Appendipity</a>',
              );

            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/appendipity/',
                'title' => 'Like Appendipity on Facebook',
                'icon'  => 'el-icon-facebook'
                //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://twitter.com/joeykissimmee',
                'title' => 'Follow Appendipity on Twitter',
                'icon'  => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://www.appendipity.com',
                'title' => 'Visit Appendipity',
                'icon'  => 'el-icon-wordpress'
            );
            /*$this->args['share_icons'][] = array(
                'url'   => 'http://www.linkedin.com/company/redux-framework',
                'title' => 'Find us on LinkedIn',
                'icon'  => 'el-icon-linkedin'
            );*/

        }

    }
    
    global $reduxConfig;
    $reduxConfig = new admin_folder_Redux_Framework_config();
}

/**
  Custom function for the callback referenced above
 */
if (!function_exists('admin_folder_my_custom_field')):
    function admin_folder_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('admin_folder_validate_callback_function')):
    function admin_folder_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
