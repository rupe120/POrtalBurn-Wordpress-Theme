<?php
/**
 * Theme Name:      Zona - Music WordPress Theme
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascals.eu/zona
 * Author URI:      http://rascals.eu
 * File:            search.php
 * =========================================================================================================================================
 *
 * @package zona
 * @since 1.0.0
 */
?>
<?php get_header(); ?>

<?php 
    $more = 0;
    $zona_opts = zona_opts();

?>

<?php 
    // Get Category Intro Section
    get_template_part( 'inc/tag-intro' );

?>

<!-- ############ CONTENT ############ -->
<div class="content">

    <!-- ############ Container ############ -->
    <div class="container narrow">
        <div class="search-list">
        <?php
        

            if ( have_posts() ) :


                // Start the Loop.
                while ( have_posts() ) : the_post();
                    /*
                     * Include the post format-specific template for the content. If you want to
                     * use this in a child theme, then include a file called called content-___.php
                     * (where ___ is the post format) and that will be used instead.
                     */
                    get_template_part( 'content', 'search' );

                endwhile;

            else : ?>
                <div class="search--error">
                    <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'zona' ); ?></p>
                    <?php get_search_form(); ?>
                </div>

            <?php endif; // have_posts() ?>

        </div>
        <div class="clear"></div>
        <?php zona_paging_nav(); ?>
    </div>
    <!-- /container -->
</div>
<!-- /content -->

<?php get_footer(); ?>