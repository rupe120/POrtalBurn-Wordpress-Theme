<?php
/**
 * Theme Name: 		Zona - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/zona
 * Author URI: 		http://rascals.eu
 * File:			sidebar-footer-col3.php
 * =========================================================================================================================================
 *
 * @package zona
 * @since 1.0.0
 */
?>

<?php if ( is_active_sidebar( 'footer-col3-sidebar' )  ) : ?>
	<?php dynamic_sidebar( 'footer-col3-sidebar' ); ?>
<?php endif; ?>