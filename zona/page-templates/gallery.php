<?php
/**
 * Template Name: Gallery
 *
 * @package zona
 * @since 1.0.0
 */

get_header(); ?>

<?php 

    $zona_opts = zona_opts();
    
    // Copy query
    $temp_post = $post;
    $query_temp = $wp_query;

    // Thumb Size
    $thumb_size = 'zona-gallery-thumb';

    // Options
    $limit = (int)get_post_meta( $wp_query->post->ID, '_limit', true );
    $limit = $limit && $limit == '' ? $limit = 6 : $limit = $limit;
    $cols_layout = 'grid-4';
    $pagination_method = get_post_meta( $wp_query->post->ID, '_pagination', true ); // pagination-ajax, pagination-default
    $ajax_filter = get_post_meta( $wp_query->post->ID, '_ajax_filter', true );
    $ajax_filter = ! $ajax_filter || $ajax_filter == 'on' ? $ajax_filter = '' : $ajax_filter = 'hidden';
 
    // Date format
    $date_format = get_option( 'date_format' );

?>

<?php 
    // Get Custom Intro Section
    get_template_part( 'inc/custom-intro' );

?>
<!--############ Filter ############ -->
<div class="gallery-filter filters-wrapper <?php echo esc_attr( $ajax_filter ); ?>">
    
    <!-- Filter -->
    <div class="filter filter-simple" data-grid="gallery--grid" data-obj='{"action": "zona_gallery_filter", "filterby": "taxonomy", "cpt": "zona_gallery", "tax": "zona_gallery_cats", "limit": "<?php echo esc_attr( $limit ); ?>", "cols_layout": "<?php echo esc_attr( $cols_layout ); ?>", "thumb_size": "<?php echo esc_attr( $thumb_size ); ?>"}' >

        <ul data-filter-group="">
            <li><a href="#" data-filter-name="all" class="is-active anim--reveal-static"><?php esc_html_e( 'All', 'zona' ) ?></a></li>
                <?php 
                    $term_args = array( 'hide_empty' => '1', 'orderby' => 'name', 'order' => 'ASC' );
                    $terms = get_terms( 'zona_gallery_cats', $term_args );
                    if ( $terms ) {
                        foreach ( $terms as $term ) {
                            echo '<li><a href="#" data-filter-name="' . esc_attr( $term->term_id ) . '" class="anim--reveal-static">' . $term->name . '</a></li>';
                        }
                    }
                ?>
        </ul>
    </div>
    <!-- /filter -->

</div>
<!-- gallery-filter -->

<!-- ############ CONTENT ############ -->
<div class="content">

    <!-- ############ Container ############ -->
    <div class="container">

        
        <?php
            $args = array(
                'post_type' => 'zona_gallery',
                'paged'     => $paged
            );
            
            // Posts number
            $temp_args = $args;
            $temp_args['showposts'] = -1;
            $temp_query_count = new WP_Query();
            $temp_query_count->query( $temp_args );
            $posts_nr = $temp_query_count->post_count;

            // Add limit
            $args['showposts'] = $limit;

            $wp_query = new WP_Query();
            $wp_query->query($args);

            if ( have_posts() ) : ?>
                
                <div class="gallery--grid grid-row grid-row-pad-large" data-min-height="200" data-cols="<?php echo esc_attr( $cols_layout ) ?>">

                <?php // Start the Loop.
                while ( have_posts() ) : the_post() ?>
                    <?php if ( has_post_thumbnail() ) : ?>
                    <div class="grid--item item-anim anim-fadeup <?php echo esc_attr( $cols_layout ) ?> grid-tablet-6 grid-mobile-12">
                       
                        <article <?php post_class( 'article' ); ?>>
                            <a href="<?php echo esc_url( get_permalink() ) ?>" class="anim--reveal">
                                <?php $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $thumb_size ); ?>
                                <img class="gallery--image" src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php echo esc_attr( esc_html__( 'Post image', 'zona' ) ) ?>">
                                <h2 class="gallery--title"><?php the_title(); ?></h2>
                                <span class="gallery--date"><span><?php the_time( $date_format ); ?></span></span>
                            </a>
                        </article>
                        
                    </div>
                    <?php endif; // has thumbnail ?>
        
                <?php endwhile; ?>

                </div>
                <!-- /grid -->
                <div class="clear"></div>
                <?php if ( $pagination_method == 'pagination-ajax' ) : ?>
                    <div class="load-more-wrap <?php if ( $posts_nr <= $limit ) { echo esc_attr( 'hidden' ); } ?>">
                        <a href="#" data-pagenum="2" class="btn--frame btn--dark btn--big load-more"><span></span><?php esc_html_e( 'Load more', 'zona' ) ?></a>
                     </div>
                <?php else : ?>
                <?php zona_paging_nav(); ?>
                <?php endif; // end pagination ?>
            <?php else : ?>
                <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'zona' ); ?></p>

            <?php endif; // have_posts() ?>
            
    </div>
    <!-- /container -->
</div>
<!-- /content -->
<?php get_footer(); ?>