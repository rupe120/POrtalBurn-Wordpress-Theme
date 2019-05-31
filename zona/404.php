<?php
/**
 * Theme Name: 		Zona - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/zona
 * Author URI: 		http://rascals.eu
 * File:			404.php
 * =========================================================================================================================================
 *
 * @package zona
 * @since 1.0.0
 */
?>
<?php get_header(); ?>

<?php 
    $zona_opts = zona_opts();
?>


<!-- ############ CONTENT ############ -->
<div class="content">

    <!-- ############ Container ############ -->
    <div class="container">

		<span class="error--404-text">404</span>

			<h1 class="error--404-title"><?php esc_html_e( 'Oops! Page was not found.', 'zona' ); ?></h1>
        	<p class="error--404-subtitle"><?php esc_html_e( 'Sorry, something went wrong and we cannot retrieve the page you were looking for. Maybe try a search?', 'zona' ); ?></p>
        	<?php get_search_form(); ?>
        	

			<a href="<?php echo esc_url( home_url('/') ) ?>" class="btn btn--big"><?php esc_html_e( 'Go to homepage', 'zona' ); ?></a>

	</div>

    <!-- /container -->
</div>
<!-- /content -->

<?php get_footer(); ?>