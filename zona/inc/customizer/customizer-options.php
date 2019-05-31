<?php
/**
 * Theme Name: 		Zona - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/zona
 * Author URI: 		http://rascals.eu
 * File:			customizer-options.php
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
 * ---------------------------------------------------- Helpers
 *
 */

/** 
* ------------- Social Media Array
*/

$social_media_a = array(

	'twitter' => esc_html__( 'Twitter', 'zona' ),
    'facebook' => esc_html__( 'Facebook', 'zona' ),
    'youtube' => esc_html__( 'Youtube', 'zona' ),
    'instagram' => esc_html__( 'Instagram', 'zona' ),
    'soundcloud' => esc_html__( 'Soundcloud', 'zona' ),
    'mixcloud' => esc_html__( 'Mixcloud', 'zona' ),
    'bandcamp' => esc_html__( 'Bandcamp', 'zona' ),
    'spotify' => esc_html__( 'Spotify', 'zona' ),
    'lastfm' => esc_html__( 'lastfm', 'zona' ),
    'vimeo' => esc_html__( 'Vimeo', 'zona' ),
    'vk' => esc_html__( 'VK', 'zona' ),
    'flickr' => esc_html__( 'Flickr', 'zona' ),
    'googleplus' => esc_html__( 'Google Plus', 'zona' ),
    'dribbble' => esc_html__( 'Dribbble', 'zona' ),
    'deviantart' => esc_html__( 'Deviantart', 'zona' ),
    'github' => esc_html__( 'Github', 'zona' ),
    'blogger' => esc_html__( 'Blogger', 'zona' ),
    'yahoo' => esc_html__( 'Yahoo', 'zona' ),
    'finder' => esc_html__( 'Finder', 'zona' ),
    'skype' => esc_html__( 'Skype', 'zona' ),
    'reddit' => esc_html__( 'Reddit', 'zona' ),
    'linkedin' => esc_html__( 'Linkedin', 'zona' ),
    'amazon' => esc_html__( 'Amazon', 'zona' )
);

/**
 * ---------------------------------------------------- Panel: Personalizing
 *
 */

Kirki::add_panel( 'personalizing', array(
    'priority'    => 1,
    'title'       => esc_html__( 'Personalizing', 'zona' ),
    'description' => esc_html__( 'This panel will provide all the options of the personalizing.', 'zona' ),
) );

	/** 
	* ------------- Section: Colors
	*/

	Kirki::add_section( 'colors', array(
	    'title'          => esc_html__( 'Colors', 'zona' ),
	    'description'    => false,
	    'panel'          => 'personalizing',
	    'priority'       => 1,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	) );

		/** 
		* ------------- Control: Theme Skin
		*/
		Kirki::add_field( 'zona', array(
			'label'    => esc_html__( 'Theme Skin', 'zona' ),
			'section'  => 'colors',
			'settings' => 'zona_skin',
			'type'     => 'select',
			'priority' => 1,
			'multiple' => 1,
			'default'  => 'light',
			'choices'  => array(
				'light' => esc_attr__( 'Light', 'zona' ),
				'dark' => esc_attr__( 'Dark', 'zona' ),
			),
		) );

		/** 
		* ------------- Control: Accent Color
		*/
		Kirki::add_field( 'zona', array(
			'label'    => esc_html__( 'Accent Color', 'zona' ),
			'section'  => 'colors',
			'settings' => 'zona_accent_color',
			'type'     => 'color',
			'priority' => 2,
			'default'  => '#fcc92f',
			'choices'  => array(
				'alpha' => false,
			),
		) );

		/** 
		* ------------- Control: Loading Layer Color
		*/
		Kirki::add_field( 'zona', array(
			'label'    => esc_html__( 'Loading Layer Color', 'zona' ),
			'section'  => 'colors',
			'settings' => 'zona_loading_layer_color',
			'type'     => 'color',
			'priority' => 3,
			'default'  => '#000000',
			'choices'  => array(
				'alpha' => false,
			),
		) );


	/** 
	* ------------- Section: Layout
	*/

	Kirki::add_section( 'layout', array(
	    'title'          => esc_html__( 'Layout', 'zona' ),
	    'description'    => false,
	    'panel'          => 'personalizing',
	    'priority'       => 2,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	) );


		/** 
		* ------------- Control: Fullwidth
		*/
		Kirki::add_field( 'zona', array(
			'label'    => esc_html__( 'Fullwidth', 'zona' ),
			'section'  => 'layout',
			'settings' => 'zona_fullwidth',
			'type'     => 'toggle',
			'priority' => 1,
			'default'  => 0,
		) );

	/** 
	* ------------- Section: Elements
	*/

	Kirki::add_section( 'elements', array(
	    'title'          => esc_html__( 'Elements', 'zona' ),
	    'description'    => false,
	    'panel'          => 'personalizing',
	    'priority'       => 3,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	) );

		/** 
		* ------------- Control: Shadows
		*/
		Kirki::add_field( 'zona', array(
			'label'    => esc_html__( 'Shadows', 'zona' ),
			'section'  => 'elements',
			'settings' => 'zona_display_shadows',
			'type'     => 'select',
			'priority' => 1,
			'multiple' => 1,
			'default'  => '16px -16px 0px 0px',
			'choices'  => array(
				 '16px -16px 0px 0px' => esc_html__( 'Yes', 'zona' ),
                '0px 0px 0px 0px' => esc_html__( 'No', 'zona' )
			),
			'description' => esc_html__( 'Display shadows under elements, by default are yellow.', 'zona' ),
		) );

	/** 
	* ------------- Section: Animations
	*/

	Kirki::add_section( 'animations', array(
	    'title'          => esc_html__( 'Animations', 'zona' ),
	    'description'    => false,
	    'panel'          => 'personalizing',
	    'priority'       => 4,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	) );

		/** 
		* ------------- Control: Loading
		*/
		Kirki::add_field( 'zona', array(
			'label'    => esc_html__( 'Loading Animation', 'zona' ),
			'section'  => 'animations',
			'settings' => 'zona_loading_animation',
			'type'     => 'toggle',
			'priority' => 1,
			'default'  => 1,
		) );

		/** 
		* ------------- Control: Content
		*/
		Kirki::add_field( 'zona', array(
			'label'    => esc_html__( 'Content Animations', 'zona' ),
			'section'  => 'animations',
			'settings' => 'zona_content_animations',
			'type'     => 'toggle',
			'priority' => 2,
			'default'  => 1,
		) );

/**
 * ---------------------------------------------------- Panel: Header
 *
 */

Kirki::add_panel( 'header', array(
    'priority'    => 2,
    'title'       => esc_html__( 'Header', 'zona' ),
    'description' => esc_html__( 'This panel will provide all the options of the header.', 'zona' ),
) );
	
	/**
	 * ------------- Section: Header Styles
	 *
	 */

	Kirki::add_section( 'header_styles', array(
		    'title'          => esc_html__( 'Header Styles', 'zona' ),
		    'description'    => false,
		    'panel'          => 'header',
		    'priority'       => 0,
		    'capability'     => 'edit_theme_options',
		    'theme_supports' => '',
		) );

			/** 
			* ------------- Control: Header Styles
			*/
		
			Kirki::add_field( 'zona', array(
				'label'    => esc_html__( 'Header Style', 'zona' ),
				'section'  => 'header_styles',
				'settings' => 'zona_header_styles',
				'type'     => 'select',
				'priority' => 1,
				'default'  => 'header-style-1',
				'choices'  => array(
					'header-style-1' => esc_html__( 'Advanced Center', 'zona' ),
					'header-style-2' => esc_html__( 'Advanced Center Fullwidth', 'zona' ),
					'header-style-3' => esc_html__( 'Advanced Left', 'zona' ),
					'header-style-4' => esc_html__( 'Advanced Left Fullwidth', 'zona' ),
					'header-style-5' => esc_html__( 'Advanced Left 02', 'zona' ),
					'header-style-6' => esc_html__( 'Advanced Left 02 Fullwidth', 'zona' ),
					'header-style-7' => esc_html__( 'Simple Left Static', 'zona' ),
					'header-style-8' => esc_html__( 'Simple Left Static Fullwidth', 'zona' ),
					'header-style-9' => esc_html__( 'Simple Left Fixed', 'zona' ),
					'header-style-10' => esc_html__( 'Simple Left Fixed Fullwidth', 'zona' ),
					'header-style-11' => esc_html__( 'Simple Left Overlay', 'zona' ),
					'header-style-12' => esc_html__( 'Simple Left Overlay Fullwidth', 'zona' ),
					'header-style-13' => esc_html__( 'Minimal Left Overlay', 'zona' ),
					'header-style-14' => esc_html__( 'Minimal Left Overlay Fullwidth', 'zona' ),
				),
			) );


	/**
	 * ------------- Section: logo
	 *
	 */

	Kirki::add_section( 'header_logo', array(
		    'title'          => esc_html__( 'Logo', 'zona' ),
		    'description'    => false,
		    'panel'          => 'header',
		    'priority'       => 1,
		    'capability'     => 'edit_theme_options',
		    'theme_supports' => '',
		) );

			/** 
			* ------------- Control: Logo
			*/
			Kirki::add_field( 'zona', array(
				'label'    => esc_html__( 'Logo Image', 'zona' ),
				'section'  => 'header_logo',
				'settings' => 'zona_logo',
				'type'     => 'image',
				'priority' => 1,
				'default'  =>  get_template_directory_uri() . '/images/logo.png',
				'partial_refresh' => array(
					'zona_logo' => array(
						'selector'        => '.header--logo',
						'render_callback' => 'zona_header_logo',
					),
				),
			) );

			/** 
			* ------------- Control: Logo Alternative
			*/
			Kirki::add_field( 'zona', array(
				'label'    => esc_html__( 'Logo Image 2', 'zona' ),
				'section'  => 'header_logo',
				'settings' => 'zona_logo_alt',
				'type'     => 'image',
				'priority' => 1,
				'default'  =>  '',
				'description' => esc_html__( 'Add alternative logo to the header. Please note: Logo is displayed only with transparent header style and when header is at the top of the page.', 'zona' ),
				'partial_refresh' => array(
					'zona_logo' => array(
						'selector'        => '.header--logo',
						'render_callback' => 'zona_header_logo',
					),
				),
				
			) );


	/**
	 * ------------- Section: Search
	 *
	 */

	Kirki::add_section( 'header_search', array(
	    'title'          => esc_html__( 'Search', 'zona' ),
	    'description'    => false,
	    'panel'          => 'header',
	    'priority'       => 2,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	) );


		/** 
		* ------------- Control: Search button
		*/
		Kirki::add_field( 'zona', array(
			'label'    => esc_html__( 'Display Search Button', 'zona' ),
			'section'  => 'header_search',
			'settings' => 'zona_search_button',
			'type'     => 'toggle',
			'priority' => 1,
			'default'  => 1
		) );


	/**
	 * ------------- Section: Events
	 *
	 */

	Kirki::add_section( 'header_events', array(
	    'title'          => esc_html__( 'Events', 'zona' ),
	    'description'    => false,
	    'panel'          => 'header',
	    'priority'       => 3,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	) );

		/** 
		* ------------- Control: Display Upcoming Events
		*/
		Kirki::add_field( 'zona', array(
			'label'    => esc_html__( 'Display Upcoming Events', 'zona' ),
			'section'  => 'header_events',
			'settings' => 'zona_header_events',
			'type'     => 'toggle',
			'priority' => 1,
			'default'  => 1
		) );

		/** 
		* ------------- Control: Events link
		*/
		Kirki::add_field( 'zona', array(
			'label'    => esc_html__( 'Events link', 'zona' ),
			'section'  => 'header_events',
			'settings' => 'zona_events_link',
			'type'     => 'text',
			'priority' => 2,
			'default'  => '#',
			'description' => esc_html__( 'Add custom link to events page. By default link redirect to layer with upcoming events list.', 'zona' )
		) );


		/** 
		* ------------- Control: Events link
		*/
		Kirki::add_field( 'zona', array(
			'label'    => esc_html__( 'Events link', 'zona' ),
			'section'  => 'header_events',
			'settings' => 'zona_events_link',
			'type'     => 'text',
			'priority' => 3,
			'default'  => '#',
			'description' => esc_html__( 'Add custom link to events page. By default link redirect to layer with upcoming events list.', 'zona' )
		) );


	/**
	 * ------------- Section: Social Media 
	 *
	 */

	Kirki::add_section( 'header_social', array(
	    'title'          => esc_html__( 'Social Media', 'zona' ),
	    'description'    => false,
	    'panel'          => 'header',
	    'priority'       => 4,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	) );

		/** 
		* ------------- Control: Social Buttons
		*/
		Kirki::add_field( 'zona', array(
			'label'    => esc_html__( 'Social Buttons', 'zona' ),
			'section'  => 'header_social',
			'settings' => 'zona_header_social_buttons_a',
			'type'     => 'repeater',
			'priority' => 4,
			'row_label' => array(
				'type'  => 'field',
				'value' => esc_attr__('Social Button:', 'zona' ),
				'field' => 'social_type',
			),
			'default'     => array(
				array(
					'social_type' => 'facebook',
					'social_link'  => '#',
				),
				array(
					'social_type' => 'twitter',
					'social_link'  => '#',
				),
				array(
					'social_type' => 'soundcloud',
					'social_link'  => '#',
				),
				array(
					'social_type' => 'mixcloud',
					'social_link'  => '#',
				),
				array(
					'social_type' => 'spotify',
					'social_link'  => '#',
				)
			),
			'fields' => array(

				'social_type' => array(
					'type'        => 'select',
					'label'       => esc_attr__( 'Social Media', 'zona' ),
					'description' => esc_attr__( 'Select your social media button', 'zona' ),
					'default'     => '',
					'choices'  => $social_media_a,
				),
				'social_link' => array(
					'type'        => 'text',
					'label'       => esc_attr__( 'Link', 'zona' ),
					'description' => esc_attr__( 'Type your social link', 'zona' ),
					'default'     => '',
				),
			),
			'description' => esc_html__( 'Add custom link to events page. By default link redirect to layer with upcoming events list.', 'zona' ),
		) );

	/**
	 * ------------- Section: WPML 
	 *
	 */

	Kirki::add_section( 'wpml_header', array(
	    'title'          => esc_html__( 'WPML', 'zona' ),
	    'description'    => false,
	    'panel'          => 'header',
	    'priority'       => 5,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	) );

		/** 
		* ------------- Control: Display Language Switcher
		*/
		Kirki::add_field( 'zona', array(
			'label'    => esc_html__( 'Display Language Switcher', 'zona' ),
			'section'  => 'wpml_header',
			'settings' => 'zona_header_wpml',
			'type'     => 'toggle',
			'priority' => 1,
			'default'  => 0,
			'description' => esc_html__( 'Display WPML plugin language switcher above main header on the right side. Please note WPML plugin must be installed.', 'zona' )
		) );
		/** 
		* ------------- Control: Language Display
		*/
		Kirki::add_field( 'zona', array(
			'label'    => esc_html__( 'Switcher Display', 'zona' ),
			'section'  => 'wpml_header',
			'settings' => 'zona_header_wpml_display',
			'type'     => 'select',
			'priority' => 2,
			'default'  => 'language_codes',
			'choices'  => array(
				'language_codes' => esc_html__( 'Language codes', 'zona' ),
				'flags' => esc_html__( 'Language flags', 'zona' ),
                'language_codes_flags' => esc_html__( 'Language codes and flags', 'zona' )
			),
		) );


	/**
	 * ------------- Section: Header Buttons
	 *
	 */

	Kirki::add_section( 'header_buttons', array(
	    'title'          => esc_html__( 'Cart Button', 'zona' ),
	    'description'    => false,
	    'panel'          => 'header',
	    'priority'       => 6,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	) );


		/** 
		* ------------- Control: Cart Button
		*/
		Kirki::add_field( 'zona', array(
			'label'    => esc_html__( 'Display Cart', 'zona' ),
			'section'  => 'header_buttons',
			'settings' => 'zona_cart_button',
			'type'     => 'toggle',
			'priority' => 1,
			'default'  => 1
		) );


		/** 
		* ------------- Control: Cart link
		*/
		Kirki::add_field( 'zona', array(
			'label'    => esc_html__( 'Cart Link', 'zona' ),
			'section'  => 'header_buttons',
			'settings' => 'zona_cart_link',
			'type'     => 'select',
			'priority' => 2,
			'multiple' => 1,
			'default'  => 'shop',
			'choices'  => array(
				'shop' => esc_attr__( 'Shop page', 'zona' ),
				'cart' => esc_attr__( 'Cart', 'zona' ),
			),
		) );


/**
 * ---------------------------------------------------- Panel: Footer
 *
 */

Kirki::add_panel( 'footer', array(
    'priority'    => 3,
    'title'       => esc_html__( 'Footer', 'zona' ),
    'description' => esc_html__( 'This panel will provide all the options of the footer.', 'zona' ),
) );


	/**
	 * ------------- Section: Widgets
	 *
	 */

	Kirki::add_section( 'footer_widgets', array(
		    'title'          => esc_html__( 'Widgets', 'zona' ),
		    'description'    => false,
		    'panel'          => 'footer',
		    'priority'       => 1,
		    'capability'     => 'edit_theme_options',
		    'theme_supports' => '',
		) );

			/** 
			* ------------- Control: Display footer widgets
			*/
			Kirki::add_field( 'zona', array(
				'label'    => esc_html__( 'Display Footer Widgets', 'zona' ),
				'section'  => 'footer_widgets',
				'settings' => 'zona_footer_widgets',
				'type'     => 'toggle',
				'priority' => 1,
				'default'  => 1,
			) );


	/**
	 * ------------- Section: Social Media 
	 *
	 */

	Kirki::add_section( 'footer_social', array(
	    'title'          => esc_html__( 'Social Media', 'zona' ),
	    'description'    => false,
	    'panel'          => 'footer',
	    'priority'       => 2,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	) );

		/** 
		* ------------- Control: Social Buttons
		*/
		Kirki::add_field( 'zona', array(
			'label'    => esc_html__( 'Social Buttons', 'zona' ),
			'section'  => 'footer_social',
			'settings' => 'zona_footer_social_buttons_a',
			'type'     => 'repeater',
			'priority' => 1,
			'row_label' => array(
				'type'  => 'field',
				'value' => esc_attr__('Social Button:', 'zona' ),
				'field' => 'social_type',
			),
			'default'     => array(
				array(
					'social_type' => 'facebook',
					'social_link'  => '#',
				),
				array(
					'social_type' => 'twitter',
					'social_link'  => '#',
				),
				array(
					'social_type' => 'soundcloud',
					'social_link'  => '#',
				),
				array(
					'social_type' => 'mixcloud',
					'social_link'  => '#',
				),
				array(
					'social_type' => 'spotify',
					'social_link'  => '#',
				)
			),
			'fields' => array(

				'social_type' => array(
					'type'        => 'select',
					'label'       => esc_attr__( 'Social Media', 'zona' ),
					'description' => esc_attr__( 'Select your social media button', 'zona' ),
					'default'     => '',
					'choices'  => $social_media_a,
				),
				'social_link' => array(
					'type'        => 'text',
					'label'       => esc_attr__( 'Link', 'zona' ),
					'description' => esc_attr__( 'Type your social link', 'zona' ),
					'default'     => '',
				),
			),
			'description' => esc_html__( 'Add custom link to events page. By default link redirect to layer with upcoming events list.', 'zona' ),
		) );
	
	/**
	 * ------------- Section: Copyright Text
	 *
	 */

	Kirki::add_section( 'footer_copyright', array(
	    'title'          => esc_html__( 'Copyright Text', 'zona' ),
	    'description'    => false,
	    'panel'          => 'footer',
	    'priority'       => 3,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	) );

		/** 
		* ------------- Control: Social Buttons
		*/
		Kirki::add_field( 'zona', array(
			'label'    => esc_html__( 'Copyright Text', 'zona' ),
			'section'  => 'footer_copyright',
			'settings' => 'zona_copyright_note',
			'type'     => 'textarea',
			'priority' => 1,
			'default' => '&copy; Copyright 2017 ZONA. Powered by <a href="#" target="_blank">Rascals Themes</a>. Handcrafted in Europe.',
			'partial_refresh' => array(
					'zona_copyright_note' => array(
						'selector'        => '.footer-copyright',
						'render_callback' => 'zona_copyright_note',
					),
				),
			
		
		) );

	/**
	 * ------------- Section: WPML 
	 *
	 */

	Kirki::add_section( 'wpml_footer', array(
	    'title'          => esc_html__( 'WPML', 'zona' ),
	    'description'    => false,
	    'panel'          => 'footer',
	    'priority'       => 4,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	) );

		/** 
		* ------------- Control: Display Language Switcher
		*/
		Kirki::add_field( 'zona', array(
			'label'    => esc_html__( 'Display Language Switcher', 'zona' ),
			'section'  => 'wpml_footer',
			'settings' => 'zona_footer_wpml',
			'type'     => 'toggle',
			'priority' => 1,
			'default'  => 0,
			'description' => esc_html__( 'Display WPML plugin language switcher above main footer on the right side. Please note WPML plugin must be installed.', 'zona' )
		) );
		/** 
		* ------------- Control: Language Display
		*/
		Kirki::add_field( 'zona', array(
			'label'    => esc_html__( 'Switcher Display', 'zona' ),
			'section'  => 'wpml_footer',
			'settings' => 'zona_footer_wpml_display',
			'type'     => 'select',
			'priority' => 2,
			'default'  => 'language_codes',
			'choices'  => array(
				'language_codes' => esc_html__( 'Language codes', 'zona' ),
				'flags' => esc_html__( 'Language flags', 'zona' ),
                'language_codes_flags' => esc_html__( 'Language codes and flags', 'zona' )
			),
		) );