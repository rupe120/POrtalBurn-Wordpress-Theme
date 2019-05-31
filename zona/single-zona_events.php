<?php
/**
 * Theme Name: 		Zona - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/zona
 * Author URI: 		http://rascals.eu
 * File:			single-zona_events.php
 * =========================================================================================================================================
 *
 * @package zona
 * @since 1.0.0
 */
?>
<?php get_header(); ?>


<?php 

   	$zona_opts = zona_opts();
   	
   	// Get layout
   	$zona_layout = get_post_meta( $wp_query->post->ID, '_page_layout', true ); // wide, narrow, vc
   	$zona_layout = isset( $zona_layout ) && $zona_layout != '' ? $zona_layout = $zona_layout : $zona_layout = 'narrow';
?>

<?php 
	// Get Custom Intro Section
	get_template_part( 'inc/custom-intro' );

?>
<!-- ############ CONTENT ############ -->
<div class="content <?php if ($zona_layout == 'vc' ) {  echo esc_attr( $zona_layout );  } ?>">

	<!-- ############ Container ############ -->
	<div class="container <?php echo esc_attr( $zona_layout ) ?>">

		<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();

				// Include the page content template.
				get_template_part( 'content', 'custom' );

			endwhile;
		?>
	</div>
    <!-- /container -->
</div>
<!-- /content -->

<?php 
// Single navigation

if ( function_exists( 'zona_custom_post_nav' ) ) : ?>
    <?php echo zona_custom_post_nav(); ?>
<?php endif; ?>

<?php get_footer(); ?>