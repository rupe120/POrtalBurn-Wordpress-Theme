<?php
/**
 * Theme Name: 		Zona - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/zona
 * Author URI: 		http://rascals.eu
 * File:			customizer.php
 * =========================================================================================================================================
 *
 * @package zona
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/**
* -------------------------- Customizer configuration
*/
Kirki::add_config( 'zona', array(
	'capability'    => 'edit_theme_options',
	'option_type'   => 'theme_mod',
) );


/**
* -------------------------- Display CSS method
*/
$css_display_method = 'file'; // file, head


/**
* -------------------------- Configuration sample for the Customizer.
*/
function zona_configuration_sample_styling( $config ) {
	return wp_parse_args( array(
		'logo_image'   => false,
		'description'  => false,
		'color_accent' => '#ff6239',
		'color_back'   => '#ffffff',
	), $config );
}
add_filter( 'kirki/config', 'zona_configuration_sample_styling' );


/**
* -------------------------- Remove a pre exising customizer setting.
*/
add_action( "customize_register", "zona_remove_customize_register" );
function zona_remove_customize_register( $wp_customize ) {

	$wp_customize->remove_section("themes");

}


/**
* -------------------------- Enqueue Customizer custom stylesheet
*/
function zona_customizer_stylesheet() {

	wp_register_style( 'custom-customizer-css', get_template_directory_uri() . '/inc/customizer/customizer-layout.css', NULL, NULL, 'all' );
	wp_enqueue_style( 'custom-customizer-css' );

}
add_action( 'customize_controls_print_styles', 'zona_customizer_stylesheet' );


/**
* -------------------------- Customzier Output
*/
class zona_CustomizerOutput 
{

    /**
     * Add default values to settings
     * @return array
    */
    function theme_mods() {
        return array(
            'zona_accent_color' => '#fcc92f',
            'zona_display_shadows' => '16px -16px 0px 0px',
            'zona_loading_layer_color' => '#000000'
        );
    }
    
    /**
     * Prepare CSS Values
     * @return array
    */
    function prepare_values() {
        $css_values = array();
     
        // Get our theme mods and default values.
        $theme_mods = $this->theme_mods();
     
        // For each theme mod, output the value of the theme mod or the default value.
        foreach( $theme_mods as $theme_mod => $default ) {
            $css_values[ $theme_mod ] = get_theme_mod( $theme_mod, $default );
        }
     
        return $css_values;
    }


    /**
     * Process CSS file
     * @return string
     */
    function process() {
        $css = '';
     
        // Modify this filename and / or location to meet your needs.
        $customizer_file = get_template_directory_uri() . '/inc/customizer/customizer-mods.css';
      
        $css = wp_remote_get( $customizer_file );

        // Error
        if ( ! $css || is_wp_error( $css ) ) {
            $css = '';
            return $css;
        }

        // Get CSS content
        $css_content = $css['body'];

        // Get our css values.
        $css_values = $this->prepare_values();
         
        // Replace each color
        foreach ( $css_values as $theme_mod => $css_val ) {
            $search = '[' . $theme_mod . ']';
            $css_content = str_replace( $search, $css_val, $css_content );
        }

        return $css_content;
    }

    // Display content
    function e_esc( $option ) {

        if ( is_string( $option ) ) {
            $option = preg_replace( array('/<(\?|\%)\=?(php)?/', '/(\%|\?)>/'), array('',''), $option );
        }

        print $option;
    }
}

/**
* -------------------------- Display customizer CSS in <head>
*/
if ( $css_display_method == 'head' ) {
    function zona_customizer_output() {
        // Make sure our class exists.
        if ( class_exists( 'zona_CustomizerOutput') ) {
            // Initialize the class and get processed css.
            $class = new zona_CustomizerOutput();
        } else {
            return;
        }
        // Either set css to the transient or rebuild.
        if ( false === ( $css = get_transient( 'slug_theme_customizer_css' ) ) ) {
            $css = $class->process();

            // Cache css for next time.
            set_transient( 'zona_customizer_css', $css );
        }
     
        // To be safe, make sure `process` method didn't return false or anything other than a string.
        if ( $css && is_string( $css ) ) {

            wp_add_inline_style( 'zona-style', $css );
        }
    }
    add_action( 'wp_enqueue_scripts', 'zona_customizer_output' );
     
    // Delete transient
    function zona_reset_theme_customizer_css_transient() {

        delete_transient( 'zona_customizer_css' );
    }
    // Get current theme's name.
    $theme = get_stylesheet();
    add_action( "update_option_theme_mods_{$theme}", 'zona_reset_theme_customizer_css_transient' );


/**
* -------------------------- Display customizer CSS by separated CSS file
*/
} else {

    if ( isset( $_REQUEST['wp_customize'] ) ) {

        // Make sure our class exists.
        if ( class_exists( 'zona_CustomizerOutput') ) {
            // Initialize the class and get processed css.
            $class = new zona_CustomizerOutput();
        } else {
            return;
        }

        // Preview
        function zona_customizer_preview() {

            // Initialize the class and get processed css.
            $class= new zona_CustomizerOutput();
            $css = $class->process();
          
            // To be safe, make sure `process` method didn't return false or anything other than a string.
            if ( $css && is_string( $css ) ) {
                wp_add_inline_style( 'zona-style', $css );
            }
        }
        add_action( 'wp_enqueue_scripts', 'zona_customizer_preview' );
    }

    // Update CSS file
    function zona_update_css_file() {

        // Display customizer CSS by file 
        if ( class_exists( 'zona_CustomizerOutput') ) {

            global $wp_filesystem;
            if ( empty( $wp_filesystem ) ) {
                require_once ( ABSPATH . '/wp-admin/includes/file.php' );
                WP_Filesystem();
            }

            // Initialize the class and get processed css.
            $class = new zona_CustomizerOutput();
            $css = $class->process();
            if ( $css && is_string( $css ) ) {
                $theme_customizer_file = get_template_directory() . '/inc/customizer/customizer.css';
                $f = $wp_filesystem->put_contents( $theme_customizer_file, $css, FS_CHMOD_FILE);
            }
               
        }        
    }

    // Get current theme's name.
    $theme = get_stylesheet();
    add_action( "update_option_theme_mods_{$theme}", 'zona_update_css_file' );

    // Add CSS file
    function zona_add_customizer_css_file() {
        if ( ! isset( $_REQUEST['wp_customize'] ) ) {
            wp_enqueue_style( 'customizer', get_template_directory_uri() . '/inc/customizer/customizer.css' );
        }
    }
    add_action( 'wp_enqueue_scripts', 'zona_add_customizer_css_file' );

}