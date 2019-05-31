<?php
/**
 * Internationalization helper.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

if ( ! class_exists( 'Kirki_l10n' ) ) {

	/**
	 * Handles translations
	 */
	class Kirki_l10n {

		/**
		 * The plugin textdomain
		 *
		 * @access protected
		 * @var string
		 */
		protected $textdomain = 'zona';

		/**
		 * The class constructor.
		 * Adds actions & filters to handle the rest of the methods.
		 *
		 * @access public
		 */
		public function __construct() {

			add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

		}

		/**
		 * Load the plugin textdomain
		 *
		 * @access public
		 */
		public function load_textdomain() {

			if ( null !== $this->get_path() ) {
				load_textdomain( $this->textdomain, $this->get_path() );
			}
			load_plugin_textdomain( $this->textdomain, false, Kirki::$path . '/languages' );

		}

		/**
		 * Gets the path to a translation file.
		 *
		 * @access protected
		 * @return string Absolute path to the translation file.
		 */
		protected function get_path() {
			$path_found = false;
			$found_path = null;
			foreach ( $this->get_paths() as $path ) {
				if ( $path_found ) {
					continue;
				}
				$path = wp_normalize_path( $path );
				if ( file_exists( $path ) ) {
					$path_found = true;
					$found_path = $path;
				}
			}

			return $found_path;

		}

		/**
		 * Returns an array of paths where translation files may be located.
		 *
		 * @access protected
		 * @return array
		 */
		protected function get_paths() {

			return array(
				WP_LANG_DIR . '/' . $this->textdomain . '-' . get_locale() . '.mo',
				Kirki::$path . '/languages/' . $this->textdomain . '-' . get_locale() . '.mo',
			);

		}

		/**
		 * Shortcut method to get the translation strings
		 *
		 * @static
		 * @access public
		 * @param string $config_id The config ID. See Kirki_Config.
		 * @return array
		 */
		public static function get_strings( $config_id = 'global' ) {

			$translation_strings = array(
				'background-color'      => esc_attr__( 'Background Color', 'zona' ),
				'background-image'      => esc_attr__( 'Background Image', 'zona' ),
				'no-repeat'             => esc_attr__( 'No Repeat', 'zona' ),
				'repeat-all'            => esc_attr__( 'Repeat All', 'zona' ),
				'repeat-x'              => esc_attr__( 'Repeat Horizontally', 'zona' ),
				'repeat-y'              => esc_attr__( 'Repeat Vertically', 'zona' ),
				'inherit'               => esc_attr__( 'Inherit', 'zona' ),
				'background-repeat'     => esc_attr__( 'Background Repeat', 'zona' ),
				'cover'                 => esc_attr__( 'Cover', 'zona' ),
				'contain'               => esc_attr__( 'Contain', 'zona' ),
				'background-size'       => esc_attr__( 'Background Size', 'zona' ),
				'fixed'                 => esc_attr__( 'Fixed', 'zona' ),
				'scroll'                => esc_attr__( 'Scroll', 'zona' ),
				'background-attachment' => esc_attr__( 'Background Attachment', 'zona' ),
				'left-top'              => esc_attr__( 'Left Top', 'zona' ),
				'left-center'           => esc_attr__( 'Left Center', 'zona' ),
				'left-bottom'           => esc_attr__( 'Left Bottom', 'zona' ),
				'right-top'             => esc_attr__( 'Right Top', 'zona' ),
				'right-center'          => esc_attr__( 'Right Center', 'zona' ),
				'right-bottom'          => esc_attr__( 'Right Bottom', 'zona' ),
				'center-top'            => esc_attr__( 'Center Top', 'zona' ),
				'center-center'         => esc_attr__( 'Center Center', 'zona' ),
				'center-bottom'         => esc_attr__( 'Center Bottom', 'zona' ),
				'background-position'   => esc_attr__( 'Background Position', 'zona' ),
				'background-opacity'    => esc_attr__( 'Background Opacity', 'zona' ),
				'on'                    => esc_attr__( 'ON', 'zona' ),
				'off'                   => esc_attr__( 'OFF', 'zona' ),
				'all'                   => esc_attr__( 'All', 'zona' ),
				'cyrillic'              => esc_attr__( 'Cyrillic', 'zona' ),
				'cyrillic-ext'          => esc_attr__( 'Cyrillic Extended', 'zona' ),
				'devanagari'            => esc_attr__( 'Devanagari', 'zona' ),
				'greek'                 => esc_attr__( 'Greek', 'zona' ),
				'greek-ext'             => esc_attr__( 'Greek Extended', 'zona' ),
				'khmer'                 => esc_attr__( 'Khmer', 'zona' ),
				'latin'                 => esc_attr__( 'Latin', 'zona' ),
				'latin-ext'             => esc_attr__( 'Latin Extended', 'zona' ),
				'vietnamese'            => esc_attr__( 'Vietnamese', 'zona' ),
				'hebrew'                => esc_attr__( 'Hebrew', 'zona' ),
				'arabic'                => esc_attr__( 'Arabic', 'zona' ),
				'bengali'               => esc_attr__( 'Bengali', 'zona' ),
				'gujarati'              => esc_attr__( 'Gujarati', 'zona' ),
				'tamil'                 => esc_attr__( 'Tamil', 'zona' ),
				'telugu'                => esc_attr__( 'Telugu', 'zona' ),
				'thai'                  => esc_attr__( 'Thai', 'zona' ),
				'serif'                 => _x( 'Serif', 'font style', 'zona' ),
				'sans-serif'            => _x( 'Sans Serif', 'font style', 'zona' ),
				'monospace'             => _x( 'Monospace', 'font style', 'zona' ),
				'font-family'           => esc_attr__( 'Font Family', 'zona' ),
				'font-size'             => esc_attr__( 'Font Size', 'zona' ),
				'font-weight'           => esc_attr__( 'Font Weight', 'zona' ),
				'line-height'           => esc_attr__( 'Line Height', 'zona' ),
				'font-style'            => esc_attr__( 'Font Style', 'zona' ),
				'letter-spacing'        => esc_attr__( 'Letter Spacing', 'zona' ),
				'top'                   => esc_attr__( 'Top', 'zona' ),
				'bottom'                => esc_attr__( 'Bottom', 'zona' ),
				'left'                  => esc_attr__( 'Left', 'zona' ),
				'right'                 => esc_attr__( 'Right', 'zona' ),
				'center'                => esc_attr__( 'Center', 'zona' ),
				'justify'               => esc_attr__( 'Justify', 'zona' ),
				'color'                 => esc_attr__( 'Color', 'zona' ),
				'add-image'             => esc_attr__( 'Add Image', 'zona' ),
				'change-image'          => esc_attr__( 'Change Image', 'zona' ),
				'no-image-selected'     => esc_attr__( 'No Image Selected', 'zona' ),
				'add-file'              => esc_attr__( 'Add File', 'zona' ),
				'change-file'           => esc_attr__( 'Change File', 'zona' ),
				'no-file-selected'      => esc_attr__( 'No File Selected', 'zona' ),
				'remove'                => esc_attr__( 'Remove', 'zona' ),
				'select-font-family'    => esc_attr__( 'Select a font-family', 'zona' ),
				'variant'               => esc_attr__( 'Variant', 'zona' ),
				'subsets'               => esc_attr__( 'Subset', 'zona' ),
				'size'                  => esc_attr__( 'Size', 'zona' ),
				'height'                => esc_attr__( 'Height', 'zona' ),
				'spacing'               => esc_attr__( 'Spacing', 'zona' ),
				'ultra-light'           => esc_attr__( 'Ultra-Light 100', 'zona' ),
				'ultra-light-italic'    => esc_attr__( 'Ultra-Light 100 Italic', 'zona' ),
				'light'                 => esc_attr__( 'Light 200', 'zona' ),
				'light-italic'          => esc_attr__( 'Light 200 Italic', 'zona' ),
				'book'                  => esc_attr__( 'Book 300', 'zona' ),
				'book-italic'           => esc_attr__( 'Book 300 Italic', 'zona' ),
				'regular'               => esc_attr__( 'Normal 400', 'zona' ),
				'italic'                => esc_attr__( 'Normal 400 Italic', 'zona' ),
				'medium'                => esc_attr__( 'Medium 500', 'zona' ),
				'medium-italic'         => esc_attr__( 'Medium 500 Italic', 'zona' ),
				'semi-bold'             => esc_attr__( 'Semi-Bold 600', 'zona' ),
				'semi-bold-italic'      => esc_attr__( 'Semi-Bold 600 Italic', 'zona' ),
				'bold'                  => esc_attr__( 'Bold 700', 'zona' ),
				'bold-italic'           => esc_attr__( 'Bold 700 Italic', 'zona' ),
				'extra-bold'            => esc_attr__( 'Extra-Bold 800', 'zona' ),
				'extra-bold-italic'     => esc_attr__( 'Extra-Bold 800 Italic', 'zona' ),
				'ultra-bold'            => esc_attr__( 'Ultra-Bold 900', 'zona' ),
				'ultra-bold-italic'     => esc_attr__( 'Ultra-Bold 900 Italic', 'zona' ),
				'invalid-value'         => esc_attr__( 'Invalid Value', 'zona' ),
				'add-new'           	=> esc_attr__( 'Add new', 'zona' ),
				'row'           		=> esc_attr__( 'row', 'zona' ),
				'limit-rows'            => esc_attr__( 'Limit: %s rows', 'zona' ),
				'open-section'          => esc_attr__( 'Press return or enter to open this section', 'zona' ),
				'back'                  => esc_attr__( 'Back', 'zona' ),
				'reset-with-icon'       => sprintf( esc_attr__( '%s Reset', 'zona' ), '<span class="dashicons dashicons-image-rotate"></span>' ),
				'text-align'            => esc_attr__( 'Text Align', 'zona' ),
				'text-transform'        => esc_attr__( 'Text Transform', 'zona' ),
				'none'                  => esc_attr__( 'None', 'zona' ),
				'capitalize'            => esc_attr__( 'Capitalize', 'zona' ),
				'uppercase'             => esc_attr__( 'Uppercase', 'zona' ),
				'lowercase'             => esc_attr__( 'Lowercase', 'zona' ),
				'initial'               => esc_attr__( 'Initial', 'zona' ),
				'select-page'           => esc_attr__( 'Select a Page', 'zona' ),
				'open-editor'           => esc_attr__( 'Open Editor', 'zona' ),
				'close-editor'          => esc_attr__( 'Close Editor', 'zona' ),
				'switch-editor'         => esc_attr__( 'Switch Editor', 'zona' ),
				'hex-value'             => esc_attr__( 'Hex Value', 'zona' ),
			);

			// Apply global changes from the kirki/config filter.
			// This is generally to be avoided.
			// It is ONLY provided here for backwards-compatibility reasons.
			// Please use the kirki/{$config_id}/l10n filter instead.
			$config = apply_filters( 'kirki/config', array() );
			if ( isset( $config['i18n'] ) ) {
				$translation_strings = wp_parse_args( $config['i18n'], $translation_strings );
			}

			// Apply l10n changes using the kirki/{$config_id}/l10n filter.
			return apply_filters( 'kirki/' . $config_id . '/l10n', $translation_strings );

		}
	}
}
