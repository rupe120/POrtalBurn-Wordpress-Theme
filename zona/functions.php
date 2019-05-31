<?php
/**
 * Theme Name: 		Zona - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/zona
 * Author URI: 		http://rascals.eu
 * File:			functions.php
 * =========================================================================================================================================
 *
 * @package zona
 * @since 1.0.0
 */


/* Set up the content width value based on the theme's design.
 -------------------------------------------------------------------------------- */
if ( ! isset( $content_width ) ) {
	$content_width = 680;
}


/* ----------------------------------------------------------------------
	THEME TRANSLATION
/* ---------------------------------------------------------------------- */

load_theme_textdomain( 'zona', get_template_directory() . '/languages' );


/* ----------------------------------------------------------------------
	ADMIN NOTICES
/* ---------------------------------------------------------------------- */

if ( !function_exists( 'zona_custom_admin_notice' ) ) :
function zona_custom_admin_notice() { ?>
	
	<div class="notice notice-warning is-dismissible">
		<p><strong><?php _e( 'PLEASE NOTE: ', 'zona' ); ?></strong><?php _e( 'Set again "header social icons" and "footer social icons", because they are not compatible with previous versions. The new "drag and drop" method of setting options is very simple and user friendly.', 'zona' ); ?><br><a href="<?php echo admin_url( '/customize.php') ?>" class="button-primary"><?php esc_html_e( 'Customizer', 'zona' ) ; ?></a></p>
	</div>
	
<?php }
//add_action('admin_notices', 'zona_custom_admin_notice');
endif;



/* ----------------------------------------------------------------------
	ADMIN PANEL
/* ---------------------------------------------------------------------- */

// Admin panel
require_once( trailingslashit( get_template_directory() ) . '/admin/panel-init.php' );


/* ----------------------------------------------------------------------
	THEME SETUP
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'zona_setup' ) ) :

	/**
	 * zona setup.
	 *
	 * Set up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support post thumbnails.
	 *
	 */

function zona_setup() {

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( get_template_directory_uri() . '/css/editor-style.css' );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Add Title tag
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails, and declare two sizes.
	add_theme_support( 'post-thumbnails' );

	set_post_thumbnail_size( 780, 440, array( 'center', 'center' ) );

	add_image_size( 'zona-full-thumb', 1400, 800, array( 'center', 'center' )  );
	add_image_size( 'zona-main-thumb', 780, 440, array( 'center', 'center' ) );
	add_image_size( 'zona-medium-thumb', 660, 660, array( 'center', 'center' ) );
	add_image_size( 'zona-small-thumb', 300, 300, array( 'center', 'center' ) );
	add_image_size( 'zona-gallery-thumb', 440, 300, array( 'center', 'center' ) );

	// Menu support
	add_theme_support( 'menus' );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'top'   => esc_html__( 'Top menu', 'zona' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
	 'image'
	) );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );


	// Enable support for Woocommerce
	add_theme_support( 'woocommerce' );

}

add_action( 'after_setup_theme', 'zona_setup' );

endif; 


/* ----------------------------------------------------------------------
	GOOGLE FONTS
/* ---------------------------------------------------------------------- */
function zona_fonts_url() {
    	

    	$font_url = '';
	    $zona_opts = zona_opts();
	    
	    if ( $zona_opts->get_option( 'use_google_fonts' ) == 'on' ) {
	        if ( $zona_opts->get_option( 'google_fonts' ) ) {
	             $font_url = add_query_arg( 'family', urlencode( esc_attr( $zona_opts->get_option( 'google_fonts' ) ) ), "//fonts.googleapis.com/css" );
	        }
    	}

    return $font_url;

}

/*
Enqueue scripts and styles.
*/
function zona_fonts_scripts() {
    wp_enqueue_style( 'zona-fonts', zona_fonts_url(), array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'zona_fonts_scripts' );


/* ----------------------------------------------------------------------
	REQUIRED STYLES AND SCRIPTS
/* ---------------------------------------------------------------------- */
function zona_scripts_and_styles() {
	
	global $post, $wp_query;

	$zona_opts = zona_opts();

	$skin = get_theme_mod( 'zona_skin', 'light' );

	// Add comment reply script when applicable
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
	
	// Google maps
	if ( ! is_404() && $zona_opts->get_option( 'google_maps_key' ) && $zona_opts->get_option( 'google_maps_key' ) !== '') {
		$map_key = '?key=' . $zona_opts->get_option( 'google_maps_key' );
		if ( $zona_opts->get_option( 'ajaxed' ) && $zona_opts->get_option( 'ajaxed' ) === 'on' ) {
	  		wp_enqueue_script('js-gmaps-api','https://maps.googleapis.com/maps/api/js' . $map_key . '&async=2', false, '1.0.0' );
	  		wp_enqueue_script( 'gmap', get_template_directory_uri() . '/js/jquery.gmap.min.js', array( 'jquery' ), false, true );
		} else {
			if ( get_post_meta( $wp_query->post->ID, '_intro_type', true ) === 'gmap' || has_shortcode( $post->post_content, 'google_maps' ) ) {
		  		wp_enqueue_script('js-gmaps-api','https://maps.googleapis.com/maps/api/js' . $map_key, false, '1.0.0' );
	  			wp_enqueue_script( 'gmap', get_template_directory_uri() . '/js/jquery.gmap.min.js', array( 'jquery' ), false, true );
		  	}
		}
	}

	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array( 'jquery' ), false, true ); //OWL CAROUSEL
	wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), false, true ); // jQuery lightbox
	wp_enqueue_script( 'waypoints', get_template_directory_uri() . '/js/jquery.waypoints.min.js', array( 'jquery' ), false, true );

	// Small Custom Plugins
	wp_enqueue_script( 'zona-plugins', get_template_directory_uri() . '/js/plugins.js', array( 'jquery' ), false, true );

	// Slide sidebar
	wp_enqueue_script( 'iscroll', get_template_directory_uri() . '/js/iscroll.js', array( 'jquery' ), false, true );

	// Enable retina displays
	if ( $zona_opts->get_option( 'retina' ) && $zona_opts->get_option( 'retina' ) === 'on' ) {
		wp_enqueue_script( 'retina', get_template_directory_uri() . '/js/retina.min.js', array( 'jquery' ), false, true );
	}

	// Smooth scroll
	if ( $zona_opts->get_option( 'smooth_scroll' ) && $zona_opts->get_option( 'smooth_scroll' ) === 'on' ) {
		wp_enqueue_script( 'smoothscroll', get_template_directory_uri() . '/js/smoothscroll.js', array( 'jquery' ), false, true );	
	}

	// ----------------------- WP Ajax Loader
	$ajaxed = 0;

	if ( $zona_opts->get_option( 'ajaxed' ) && $zona_opts->get_option( 'ajaxed' ) === 'on' ) {

		$ajaxed = 1;
		wp_enqueue_script( 'jquery.WPAjaxLoader.plugins', get_template_directory_uri() . '/js/jquery.WPAjaxLoader.plugins.js' , array( 'jquery' ), false, true);
		wp_enqueue_script( 'jquery.WPAjaxLoader', get_template_directory_uri() . '/js/jquery.WPAjaxLoader.js' , array( 'jquery' ), false, true);
	
	 	
	 	// ----------------------- Ajax Containers

		$default_ajax_containers = array(
			'#nav',
			'#responsive-nav',
			'#header-lang-selector',
			'#footer-lang-selector',
			'#site-logo',
			'#wpadminbar'
		);

		$ajax_containers = $zona_opts->get_option( 'ajax_reload_containers' );
		$ajax_containers = preg_replace( '/\n$/','',preg_replace('/^\n/','',preg_replace('/[\r\n]+/',"\n", $ajax_containers) ) );
		$ajax_containers = str_replace("\n", ',', $ajax_containers );
	    $ajax_containers = explode( ",", $ajax_containers );
	    $ajax_containers = array_unique ( array_merge( $default_ajax_containers, $ajax_containers ) );
	    $ajax_containers = array_filter( $ajax_containers );


		// ----------------------- Ajax Scripts

		$default_ajax_scripts = array(
			'waypoints.min.js',
			'shortcodes/assets/js/shortcodes.js',
			'contact-form-7/includes/js/scripts.js',
			'/dist/skrollr.min.js',
			'js_composer_front.min.js',
			'/js/custom.js'
		);

		$ajax_scripts = $zona_opts->get_option( 'ajax_reload_scripts' );
		$ajax_scripts = preg_replace( '/\n$/','',preg_replace('/^\n/','',preg_replace('/[\r\n]+/',"\n", $ajax_scripts) ) );
		$ajax_scripts = str_replace("\n", ',', $ajax_scripts );
	    $ajax_scripts = explode( ",", $ajax_scripts );
	    $ajax_scripts = array_unique ( array_merge( $default_ajax_scripts, $ajax_scripts ) );
	    $ajax_scripts = array_filter( $ajax_scripts );


		// ----------------------- Ajax Events

		$default_ajax_events = array(
			'YTAPIReady',
			'getVideoInfo_bgndVideo'
		);

		$ajax_events = $zona_opts->get_option( 'ajax_events' );
		$ajax_events = preg_replace( '/\n$/','',preg_replace('/^\n/','',preg_replace('/[\r\n]+/',"\n", $ajax_events) ) );
		$ajax_events = str_replace("\n", ',', $ajax_events );
	    $ajax_events = explode( ",", $ajax_events );
	    $ajax_events = array_unique ( array_merge( $default_ajax_events, $ajax_events ) );
	    $ajax_events = array_filter( $ajax_events );
		

		// ----------------------- Ajax Elements Filter
		$default_ajax_el = array(
			'.sp-play-list.sp-add-list',
			'.sp-play-track',
			'.sp-add-track',
			'.smooth-scroll',
			'.ui-tabs-nav li a',
			'.wpb_tour_next_prev_nav span a',
			'.wpb_accordion_header a',
			'.vc_tta-tab',
			'.vc_tta-tab a',
			'.vc_pagination-trigger'
		);
		if ( class_exists( 'WooCommerce' ) ) {
			$wc_ajax_el  = array(
				'.ajax_add_to_cart',
				'.wc-tabs li a',
				'ul.tabs li a',
				'.woocommerce-review-link',
				'.woocommerce-Button.download',
				'.woocommerce-MyAccount-downloads-file'
			);
			$default_ajax_el = array_unique ( array_merge( $default_ajax_el, $wc_ajax_el ) );
		}

		$ajax_el = $zona_opts->get_option( 'ajax_elements' );
		$ajax_el = preg_replace( '/\n$/','',preg_replace('/^\n/','',preg_replace('/[\r\n]+/',"\n", $ajax_el) ) );
		$ajax_el = str_replace("\n", ',', $ajax_el );
	    $ajax_el = explode( ",", $ajax_el );
	    $ajax_el = array_unique ( array_merge( $default_ajax_el, $ajax_el ) );
	    $ajax_el = array_filter( $ajax_el );


	    // ----------------------- Ajax Exclude Links
		$default_ajax_exclude_links = array(

		);
		if ( class_exists( 'WooCommerce' ) ) {
			$wc_ajax_exclude_links  = array();

			$wc_ajax_exclude_links[] = str_replace( home_url('/'), '', get_permalink( get_option( 'woocommerce_shop_page_id' ) ) );
			$wc_ajax_exclude_links[] = str_replace( home_url('/'), '', get_permalink( get_option( 'woocommerce_cart_page_id' ) ) );
			$wc_ajax_exclude_links[] = str_replace( home_url('/'), '', get_permalink( get_option( 'woocommerce_checkout_page_id' ) ) ); 
			$wc_ajax_exclude_links[] = str_replace( home_url('/'), '', get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); 
			$wc_ajax_exclude_links[] = str_replace( home_url('/'), '', get_post_type_archive_link( 'product' ) );

			$permalinks = get_option( 'woocommerce_permalinks' ); 
			$wc_ajax_exclude_links[] = '?product=';
			if ( isset( $permalinks['product_base'] ) && $permalinks['product_base'] ) {
				$wc_ajax_exclude_links[] = $permalinks['product_base'];
			} else {
				$wc_ajax_exclude_links[] = '/product';
			}

			$wc_ajax_exclude_links[] = '?product_tag=';
			if ( isset( $permalinks['tag_base'] ) && $permalinks['tag_base'] ) {
				$wc_ajax_exclude_links[] = $permalinks['tag_base'];
			} else {
				$wc_ajax_exclude_links[] = '/product-tag';
			}

			$wc_ajax_exclude_links[] = '?product_cat=';
			if ( isset( $permalinks['category_base'] ) && $permalinks['category_base'] != '' ) {
				$wc_ajax_exclude_links[] = $permalinks['category_base'];
			} else {
				$wc_ajax_exclude_links[] = '/product-category';
			}

			if ( isset( $permalinks['attribute_base'] ) && $permalinks['attribute_base'] != '' ) {
				$wc_ajax_exclude_links[] = $permalinks['attribute_base'];
			} else {
				$wc_ajax_exclude_links[] = '/attribute' ;
			}

			$default_ajax_exclude_links = array_unique ( array_merge( $default_ajax_exclude_links, $wc_ajax_exclude_links ) );
		}

		$ajax_exclude_links = $zona_opts->get_option( 'ajax_exclude_links' );
		$ajax_exclude_links = preg_replace( '/\n$/','',preg_replace('/^\n/','',preg_replace('/[\r\n]+/',"\n", $ajax_exclude_links) ) );
		$ajax_exclude_links = str_replace("\n", ',', $ajax_exclude_links );
	    $ajax_exclude_links = explode( "|", $ajax_exclude_links );
	    $ajax_exclude_links = array_unique ( array_merge( $default_ajax_exclude_links, $ajax_exclude_links ) );
	    $ajax_exclude_links = array_filter( $ajax_exclude_links );


		// Get AJAX path
		$dir = parse_url( get_option( 'home' ) );
		if ( ! isset( $dir[ 'path' ] ) ) {
			$dir[ 'path' ] = '';
		}

		// Permalinks
		$permalinks = 0;
		if ( get_option('permalink_structure') ) {
			$permalinks = 1;
		}

		$js_controls_variables = array(
			'home_url'               => esc_url( home_url('/') ),
			'theme_uri'              => get_template_directory_uri(),
			'dir'                    => esc_url( $dir[ 'path' ] ),
			'ajaxed'                 => esc_attr( $ajaxed ),
			'permalinks'             => $permalinks,
			'ajax_events'            => esc_attr( implode( ",", $ajax_events ) ),
			'ajax_elements'          => esc_attr( implode( ",", $ajax_el ) ),
			'ajax_reload_scripts'    => esc_attr( implode( ",", $ajax_scripts ) ),
			'ajax_reload_containers' => esc_attr( implode( ",", $ajax_containers ) ),
			'ajax_exclude_links'     => esc_attr( implode( "|", $ajax_exclude_links ) ),
			'ajax_async'             => esc_attr( $zona_opts->get_option( 'ajax_async' ) ),
			'ajax_cache'             => esc_attr( $zona_opts->get_option( 'ajax_cache' ) ),
			
		);
	} else {
		$js_controls_variables = array(
			'ajaxed'              => esc_attr( $ajaxed ),
		);
	}

	wp_enqueue_script( 'custom-controls', get_template_directory_uri() . '/js/custom.controls.js' , array( 'jquery', 'imagesloaded' ), false, true );
	wp_localize_script( 'custom-controls', 'controls_vars', $js_controls_variables );
	wp_localize_script( 'custom-controls', 'ajax_action', array('ajaxurl' => admin_url('admin-ajax.php'), 'ajax_nonce' => wp_create_nonce( 'ajax-nonce') ) );

	// ----------------------- Custom Scripts
	wp_enqueue_script( 'custom-scripts', get_template_directory_uri() . '/js/custom.js' , 'jquery', 'imagesloaded', false, true ); // Loads custom scripts

	$js_variables = array(
		'theme_uri'          => get_template_directory_uri(),
		'map_marker'         => esc_url( $zona_opts->get_image( $zona_opts->get_option( 'map_marker' ) ) )
	);
	wp_localize_script( 'custom-scripts', 'theme_vars', $js_variables );

	// ----------------------- Styles
	wp_enqueue_style( 'icomoon', get_template_directory_uri() . '/icons/icomoon.css' ); // Loads icons ICOMOON.
	wp_enqueue_style( 'Pe-icon-7-stroke', get_template_directory_uri() . '/icons/Pe-icon-7-stroke.css' ); // Loads icons ICOMOON.
	wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css' );
	wp_enqueue_style( 'owl-carousel-style', get_template_directory_uri() . '/css/owl.carousel.css' );


	// Theme styles
	wp_enqueue_style( 'zona-style', get_stylesheet_uri() );	// Loads the main stylesheet.

	// Skin
	if ( $skin != 'light' ) {
		wp_enqueue_style( 'zona-style-' . $skin, get_stylesheet_directory_uri() . '/css/theme-style-' . $skin . '.css' );	// Loads skin stylesheet.
	}

	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style( 'woocommerce-theme-style', get_stylesheet_directory_uri() . '/css/woocommerce-theme-style-' . $skin . '.css' );	// Loads woocommerce stylesheet.
	}
	
}

add_action( 'wp_enqueue_scripts', 'zona_scripts_and_styles' );


/* ----------------------------------------------------------------------
	TGM PLUGIN ACTIVATION 
/* ---------------------------------------------------------------------- */

require_once( 'inc/class-tgm-plugin-activation.php' );

add_action( 'tgmpa_register', 'zona_register_required_plugins' );

function zona_register_required_plugins() {

	$plugins = array(
 		
 		/**
		 * Pre-packaged Plugins
		*/
		array(
			'name'                  => esc_html__( 'Rascals Themes - Zona Plugin', 'zona' ), // The plugin name
			'slug'                  => 'rascals_zona_plugin', // The plugin slug (typically the folder name)
			'source'                => get_template_directory() . '/plugins/rascals_zona_plugin.tar', // The plugin source
			'required'              => true, // If false, the plugin is only 'recommended' instead of required
			'version'               => '1.1.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'          => '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'               => esc_html__( 'WPBakery Visual Composer', 'zona' ), // The plugin name
			'slug'               => 'js_composer', // The plugin slug (typically the folder name)
			'source'             => get_template_directory() . '/plugins/js_composer.tar', // The plugin source
			'required'           => true, // If false, the plugin is only 'recommended' instead of required
			'version'            => '5.1.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'       => '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'               => esc_html__( 'Slider Revolution', 'zona' ), // The plugin name
			'slug'               => 'revslider', // The plugin slug (typically the folder name)
			'source'             => get_template_directory() . '/plugins/revslider.tar', // The plugin source
			'required'           => false, // If false, the plugin is only 'recommended' instead of required
			'version'            => '5.4.5', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'       => '', // If set, overrides default API URL and points to an external URL
		),

		/**
		 * WordPress.org Plugins
		 */
		array(
			'name'               => esc_html__( 'Contact Form 7', 'zona' ), // The plugin name
			'slug'               => 'contact-form-7', // The plugin slug (typically the folder name)
			'required'           => false, // If false, the plugin is only 'recommended' instead of required
		),
		array(
			'name'               => esc_html__( 'MailChimp for WordPress', 'zona' ), // The plugin name
			'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name)
			'required'           => false, // If false, the plugin is only 'recommended' instead of required
		),
 		array(
			'name'               => esc_html__( 'SVG Support', 'zona' ), // The plugin name
			'slug'               => 'svg-support', // The plugin slug (typically the folder name)
			'required'           => false, // If false, the plugin is only 'recommended' instead of required
		),
		array(
			'name'               => esc_html__( 'WooCommerce', 'zona' ), // The plugin name
			'slug'               => 'woocommerce', // The plugin slug (typically the folder name)
			'required'           => false, // If false, the plugin is only 'recommended' instead of required
		)
   );
 
	// Change this to your theme text domain, used for internationalising strings
	$theme_text_domain = 'zona';
 
	$config = array(
		'domain'            => 'zona',           // Text domain - likely want to be the same as your theme.
		'default_path'      => '',                           // Default absolute path to pre-packaged plugins
		'menu'              => 'install-required-plugins',   // Menu slug
		'has_notices'       => true,                         // Show admin notices or not
		'is_automatic'      => false,            // Automatically activate plugins after installation or not
		'message'           => ''               // Message to output right before the plugins table
	);
 
	tgmpa( $plugins, $config );
 
}


/* ----------------------------------------------------------------------
	VC
/* ---------------------------------------------------------------------- */

if ( function_exists( 'vc_set_as_theme' ) ) {
	vc_set_as_theme( true );
}


/* ----------------------------------------------------------------------
	REVOLUTION SLIDER
/* ---------------------------------------------------------------------- */

if  ( class_exists( 'RevSliderFront' ) ) {
	set_revslider_as_theme();
}


/* ----------------------------------------------------------------------
	WOOCOMMERCE
/* ---------------------------------------------------------------------- */

if ( class_exists( 'WooCommerce' ) ) {

	$zona_opts = zona_opts();

	 add_theme_support( 'wc-product-gallery-zoom' );
	 add_theme_support( 'wc-product-gallery-lightbox' );
	 add_theme_support( 'wc-product-gallery-slider' );

	// Add body class if page is excluded
	if ( $zona_opts->get_option( 'ajaxed' ) && $zona_opts->get_option( 'ajaxed' ) === 'on' ) {

		if ( ! function_exists( 'wc_body_classes' ) ) {
			function wc_body_classes( $classes ) {

				if ( is_woocommerce() || is_shop() || is_product_category() || is_product_tag() || is_product() || is_cart() || is_checkout() || is_account_page() ){
					return array_merge( $classes, array( 'wp-ajax-exclude-page' ) );
				} else {
					return $classes;
				}

			}
			add_filter( 'body_class','wc_body_classes' );
		}
	}

}


/* ----------------------------------------------------------------------
	WIDGETS AND SIDEBARS
/* ---------------------------------------------------------------------- */
function zona_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'zona' ),
		'id'            => 'primary-sidebar',
		'description'   => esc_html__( 'Main sidebar that appears on the left or right.', 'zona' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 1', 'zona' ),
		'id'            => 'footer-col1-sidebar',
		'description'   => esc_html__( 'Footer Column 1 that appear on the botton of the page.', 'zona' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 2', 'zona' ),
		'id'            => 'footer-col2-sidebar',
		'description'   => esc_html__( 'Footer Column 2 that appear on the botton of the page.', 'zona' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 3', 'zona' ),
		'id'            => 'footer-col3-sidebar',
		'description'   => esc_html__( 'Footer Column 3 that appear on the botton of the page.', 'zona' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	

}
add_action( 'widgets_init', 'zona_widgets_init' );


/* ----------------------------------------------------------------------
	INCLUDE NECESSARY FILES
/* ---------------------------------------------------------------------- */


// Helpers
require_once( trailingslashit( get_template_directory() ) . '/inc/helpers.php' );
require_once( trailingslashit( get_template_directory() ) . '/inc/template-tags.php' );

// Add Theme Customizer functionality.
require_once( trailingslashit( get_template_directory() ) . '/inc/customizer/customizer-class/kirki.php' );
require_once( trailingslashit( get_template_directory() ) . '/inc/customizer/customizer.php' );
require_once( trailingslashit( get_template_directory() ) . '/inc/customizer/customizer-options.php' );

// One Click Import
require_once( trailingslashit( get_template_directory() ) . '/inc/importer/init.php' );