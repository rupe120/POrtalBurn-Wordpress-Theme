<?php
/**
 * Theme Name: 		Zona - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/zona
 * Author URI: 		http://rascals.eu
 * File:			content-custom.php
 * =========================================================================================================================================
 *
 * @package zona
 * @since 1.0.0
 */
?>

<?php 

   $zona_opts = zona_opts();
?>
	
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
    <?php  the_content( esc_html__( 'Continue reading ', 'zona' ) . '<span class="meta-nav">&rarr;</span>' ); ?>
 	
</article>