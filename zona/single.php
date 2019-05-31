<?php
/**
 * Theme Name: 		Zona - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/zona
 * Author URI: 		http://rascals.eu
 * File:			single.php
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
	<div class="container narrow">

		<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();

				// Include the page content template.
				get_template_part( 'content' );

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

    <!-- Single Navigation  -->
	<?php if ( is_single() ) : ?>
	    <?php echo zona_post_nav(); ?>
	<?php endif; ?>
</div>
<!-- /content -->

<?php get_footer(); ?>