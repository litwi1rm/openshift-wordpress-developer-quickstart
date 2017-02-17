<?php 

/* Add Editor Styles */

/** Apply styles to the visual editor **/  
add_filter('mce_css', 'app_mcekit_editor_style');
function app_mcekit_editor_style($url) {

    if ( !empty($url) )
        $url .= ',';

    // Change the path here if using different directories
    $url .= trailingslashit( get_stylesheet_directory_uri() ) . 'editor-styles.css';

    return $url;
}

/** Add "Styles" drop-down */ 
add_filter( 'mce_buttons_2', 'app_mce_editor_buttons' );

function app_mce_editor_buttons( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}

/** Add styles/classes to the "Styles" drop-down */ 
add_filter( 'tiny_mce_before_init', 'app_mce_before_init' );

function app_mce_before_init( $settings ) {

    $style_formats = array(
        array(
            'title' => 'Blue Shadow Box',
            'block' => 'div',
            'classes' => 'shadow-box-blue',
            'wrapper' => true
        ),
        array(
            'title' => 'Grey Shadow Box',
            'block' => 'div',
            'classes' => 'shadow-box-gray',
            'wrapper' => true
        ),
        array(
            'title' => 'Green Shadow Box',
            'block' => 'div',
            'classes' => 'shadow-box-green',
            'wrapper' => true
        ),
        array(
            'title' => 'Purple Shadow Box',
            'block' => 'div',
            'classes' => 'shadow-box-purple',
            'wrapper' => true
        ),
        array(
            'title' => 'Pink Shadow Box',
            'block' => 'div',
            'classes' => 'shadow-box-pink',
            'wrapper' => true
        ),
        array(
            'title' => 'Yellow Shadow Box',
            'block' => 'div',
            'classes' => 'shadow-box-yellow',
            'wrapper' => true
        ),
        array(
            'title' => 'Small Orange Button',
            'selector' => 'a',
            'classes' => 'orange btn small',
        ),
        array(
            'title' => 'Medium Orange Button',
            'selector' => 'a',
            'classes' => 'orange btn',
        ),
        array(
            'title' => 'Large Orange Button',
            'selector' => 'a',
            'classes' => 'orange btn large',
        ),
        array(
            'title' => 'Small Blue Button',
            'selector' => 'a',
            'classes' => 'blue btn small',
        ),
        array(
            'title' => 'Medium Blue Button',
            'selector' => 'a',
            'classes' => 'blue btn',
        ),
        array(
            'title' => 'Large Blue Button',
            'selector' => 'a',
            'classes' => 'blue btn large',
        ),
        array(
            'title' => 'Small Teal Button',
            'selector' => 'a',
            'classes' => 'teal btn small',
        ),
        array(
            'title' => 'Medium Teal Button',
            'selector' => 'a',
            'classes' => 'teal btn',
        ),
        array(
            'title' => 'Large Teal Button',
            'selector' => 'a',
            'classes' => 'teal btn large',
        ),
        array(
            'title' => 'Small Green Button',
            'selector' => 'a',
            'classes' => 'green btn small',
        ),
        array(
            'title' => 'Medium Green Button',
            'selector' => 'a',
            'classes' => 'green btn',
        ),
        array(
            'title' => 'Large Green Button',
            'selector' => 'a',
            'classes' => 'green btn large',
        ),
        array(
            'title' => 'Small Grey Button',
            'selector' => 'a',
            'classes' => 'grey btn small',
        ),
        array(
            'title' => 'Medium Grey Button',
            'selector' => 'a',
            'classes' => 'grey btn',
        ),
        array(
            'title' => 'Large Grey Button',
            'selector' => 'a',
            'classes' => 'grey btn large',
        ),
        array(
            'title' => 'Small Pink Button',
            'selector' => 'a',
            'classes' => 'pink btn small',
        ),
        array(
            'title' => 'Medium Pink Button',
            'selector' => 'a',
            'classes' => 'pink btn',
        ),
        array(
            'title' => 'Large Pink Button',
            'selector' => 'a',
            'classes' => 'pink btn large',
        ),
        array(
            'title' => 'Small Purple Button',
            'selector' => 'a',
            'classes' => 'purple btn small',
        ),
        array(
            'title' => 'Medium Purple Button',
            'selector' => 'a',
            'classes' => 'purple btn',
        ),
        array(
            'title' => 'Large Purple Button',
            'selector' => 'a',
            'classes' => 'purple btn large',
        ),
    );

    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;

}