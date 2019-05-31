<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'MuttleyImporterData' ) ) {

	require_once( get_template_directory() . '/inc/importer/MuttleyImporter.php' ); //load admin theme data importer

	class MuttleyImporterData extends MuttleyImporter {

		/**
		 * Set framewok
		 *
		 *
		 * @since 0.0.3
		 *
		 * @var string
		 */
		public $theme_options_framework = 'MuttleyPanel';


		public $flag_as_imported;

		/**
		 * Show Console
		 *
		 *
		 * @since 0.0.3
		 *
		 * @var string
		 */
		public $wp_importer_console = 'hidden';


		/**
		 * Holds a copy of the object for easy reference.
		 *
		 * @since 0.0.1
		 *
		 * @var object
		 */
		private static $instance;


		/**
		 * Set the key to be used to store theme options
		 *
		 * @since 0.0.2
		 *
		 * @var array
		 */
		public $importer_options;

		/**
		 * Set the key to be used to store theme options
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $theme_option_name  = 'zona_panel_opts'; 


		/**
		 * Holds a copy of the widget settings
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $widget_import_results;

		/**
		 * Required plugins
		 *
		 * @since 0.0.3
		 *
		 * @var array
		 */
		public $required_plugins;

		/**
		 * Constructor. Hooks all interactions to initialize the class.
		 *
		 * @since 0.0.1
		 */
		public function __construct() {

			$this->demo_files_path = get_template_directory() . '/inc/importer/demo-files/'; //can

			$this->importer_options = array(
				array(
					'id'		   	 	 => 'light',
					'name'   	 		 => 'Light Version',
					'content_files'      =>  array(
						array(
							'file_path' => 'light/content_media.xml',
						),
						array(
							'file_path' => 'light/content.xml',
						),
					),
					'widget_file'        => 'light/widgets.json',
					'customizer_file'    => '',
					'panel_options_file' => 'light/theme_options.txt',
					'homepage'           => 'home',
					'set_menus' 		 => true,
					'import_notice'      => esc_html__( 'After you import this demo, you will have to import the REVOLUTION SLIDER separately. More information can be found in theme documentation, section "Revolution Slider"', 'zona' ),
				),
				array(
					'id'		   	 	 => 'dark',
					'name'   	 		 => 'Dark Version',
					'content_files'      =>  array(
						array(
							'file_path' => 'dark/content_media.xml',
						),
						array(
							'file_path' => 'dark/content.xml',
						),
					),
					'widget_file'        => 'dark/widgets.json',
					'customizer_file'    => 'dark/customizer.dat',
					'panel_options_file' => 'dark/theme_options.txt',
					'homepage'           => 'home',
					'set_menus' 		 => true,
					'import_notice'      => esc_html__( 'After you import this demo, you will have to import the REVOLUTION SLIDER separately. More information can be found in theme documentation, section "Revolution Slider"', 'zona' ),
				),
			);


			$this->required_plugins = array(
				array(
			    	'path' => 'js_composer/js_composer.php',
			    	'name' => esc_html__( 'WPBakery Visual Composer', 'zona' )
			    ),
			    array(
			    	'path' => 'rascals_zona_plugin/rascals_zona_plugin.php',
			    	'name' => esc_html__( 'Rascals Themes - Zona Plugin', 'zona' )
			    )
			);

			self::$instance = $this;	
			parent::__construct();

		}

		/**
		 * Add menus - the menus listed here largely depend on the ones registered in the theme
		 *
		 * @since 0.0.1
		 */
		public function set_demo_menus(){

			// Menus to Import and assign - you can remove or add as many as you want
			$top_menu = get_term_by( 'name', 'Top menu', 'nav_menu' );
			
			if (  $top_menu  ) {	
				set_theme_mod( 'nav_menu_locations', array(
						'top' => $top_menu->term_id
					)
				);
			}

			$this->flag_as_imported['menus'] = true;

		}


	}

	new MuttleyImporterData;

}