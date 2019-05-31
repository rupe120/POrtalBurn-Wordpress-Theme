<?php
/**
 * Theme Name: 		Zona - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/zona
 * Author URI: 		http://rascals.eu
 * File:			page.php
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
				get_template_part( 'content', 'page' );

			endwhile;
		?>
		<?php
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) {
			$disqus = $zona_opts->get_option( 'disqus_comments' );
			$disqus_shortname = $zona_opts->get_option( 'disqus_shortname' );

			if ( ( $disqus && $disqus == 'on' ) && ( $disqus_shortname && $disqus_shortname != '' ) ) {
				get_template_part( 'inc/disqus' );
				
			} else {
				comments_template();
			}
		}
		?>
		<!-- /comments -->

	</div>
    <!-- /container -->
</div>
<!-- /content -->

<?php get_footer(); ?>