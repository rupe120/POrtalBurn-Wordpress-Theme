<?php
/**
 * Theme Name: 		Zona - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/zona
 * Author URI: 		http://rascals.eu
 * File:			sidebar.php
 * =========================================================================================================================================
 *
 * @package zona
 * @since 1.0.0
 */
?>

<?php if ( is_active_sidebar( 'primary-sidebar' )  ) : ?>
	<aside class="sidebar">
		<?php dynamic_sidebar( 'primary-sidebar' ); ?>
	</aside>
<?php endif; ?>