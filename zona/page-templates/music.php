<?php
/**
 * Template Name: Music
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
    $thumb_size = 'zona-medium-thumb';

    // Options
    $limit = (int)get_post_meta( $wp_query->post->ID, '_limit', true );
    $limit = $limit && $limit == '' ? $limit = 6 : $limit = $limit;
    $cols_layout = get_post_meta( $wp_query->post->ID, '_columns', true ); // grid-6, grid-4
    $cols_layout = ! $cols_layout ? $cols_layout = 'grid-6' : $cols_layout = $cols_layout;
    $pagination_method = get_post_meta( $wp_query->post->ID, '_pagination', true ); // pagination-ajax, pagination-default
    $ajax_filter = get_post_meta( $wp_query->post->ID, '_ajax_filter', true );
    $ajax_filter = ! $ajax_filter || $ajax_filter == 'on' ? $ajax_filter = '' : $ajax_filter = 'hidden';
    $thumb_style = get_post_meta( $wp_query->post->ID, '_thumb_style', true );

    // Date format
    $date_format = get_option( 'date_format' );

?>

<?php 
    // Get Custom Intro Section
    get_template_part( 'inc/custom-intro' );

?>
<!--############ Filter ############ -->
<div class="music-filter filters-wrapper <?php echo esc_attr( $ajax_filter ); ?>">
    
    <!-- Filter -->
    <div class="filter filter-simple" data-grid="music--grid" data-obj='{"action": "zona_music_filter", "filterby": "taxonomy", "cpt": "zona_music", "tax": "zona_music_cats", "limit": "<?php echo esc_attr( $limit ); ?>", "cols_layout": "<?php echo esc_attr( $cols_layout ); ?>", "thumb_size": "<?php echo esc_attr( $thumb_size ); ?>", "thumb_style": "<?php echo esc_attr( $thumb_style ); ?>"}' >

        <ul data-filter-group="">
            <li><a href="#" data-filter-name="all" class="is-active anim--reveal-static"><?php esc_html_e( 'All', 'zona' ) ?></a></li>
                <?php 
                    $term_args = array( 'hide_empty' => '1', 'orderby' => 'name', 'order' => 'ASC' );
                    $terms = get_terms( 'zona_music_cats', $term_args );
                    if ( $terms ) {
                        foreach ( $terms as $term ) {
                            echo '<li><a href="#" data-filter-name="' . esc_attr( $term->term_id ) . '" class="anim--reveal-static">' . esc_html( $term->name ) . '</a></li>';
                        }
                    }
                ?>
        </ul>
    </div>
    <!-- /filter -->

</div>
<!-- music-filter -->

<!-- ############ CONTENT ############ -->
<div class="content">

    <!-- ############ Container ############ -->
    <div class="container">

        
        <?php
            $args = array(
                'post_type' => 'zona_music',
                'paged'     => $paged,
                'orderby'   => 'menu_order',
                'order'     => 'ASC'
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
                
                <div class="music--grid grid-row grid-row-pad-large music--grid-<?php echo esc_attr( $cols_layout ) ?>" data-min-height="200" data-cols="<?php echo esc_attr( $cols_layout ) ?>">

                <?php // Start the Loop.
                while ( have_posts() ) : the_post() ?>
                    <?php if ( has_post_thumbnail() ) : ?>
                    <?php 
                    $track_id = get_post_meta( $post->ID, '_thumb_tracks', true );
                     ?>
                    <div class="grid--item item-anim anim-fadeup <?php echo esc_attr( $cols_layout ) ?> grid-tablet-6 grid-mobile-6">
                        <?php if ( $thumb_style == 'advanced' ) : ?>
                            <article <?php post_class( 'article anim--reveal' ); ?>>
                                <?php $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $thumb_size ); ?>
                                <img class="music--image" src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php esc_attr_e( 'Post image', 'zona' ) ?>">

                                <div class="music--buttons">
                                    <?php if ( $track_id && $track_id != 'none' ) : ?>
                                    <?php $tracklist_id = 'simple_tracklist_' . $post->ID ?>
                                    <div class="music--button">
                                        <a href="#" class="btn--icon-square anim--reveal music--btn-play sp-play-list" data-id="<?php echo esc_attr( $tracklist_id ) ?>" ><span class="icon icon-play2"></span></a>
                                        <div class="music--tracks">
                                            <?php 
                                                if ( function_exists( 'zona_simple_tracklist' ) ) {
                                                    echo zona_simple_tracklist( array( 'id' =>  $track_id, 'tracklist_id' =>  $tracklist_id ) );

                                                } 
                                                
                                            ?>
                                         

                                        </div>
                                    </div>
                                    <?php endif;?>
                                    
                                    <div class="music--button">
                                         <a href="<?php echo esc_url( get_permalink() ) ?>" class="btn--icon-square anim--reveal music--btn-link"><span class="icon icon-link"></span></a>
                                    </div>
                                    
                                </div>
                                <h2 class="music--title"><span><?php the_title(); ?></span></h2>
                                <span class="music--date"><?php the_time( $date_format ); ?></span>
                            </article>
                        <?php else : ?>
                            <article <?php post_class( 'article anim--disabled' ); ?>>
                                <?php echo '<a href="' . esc_url( get_permalink() ) . '" class="music--click-layer"></a>';?>
                                <?php $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $thumb_size ); ?>
                                <img class="music--image" src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php esc_attr_e( 'Post image', 'zona' ) ?>">
                            </article>
                        <?php endif; // thumb style ?>
                    </div>
                    <?php endif; // has thumbnail ?>
        
                <?php endwhile; ?>

                </div>
                <!-- /masonry -->
                <div class="clear"></div>
                <?php if ( $pagination_method == 'pagination-ajax' ) : ?>

                    <div class="load-more-wrap <?php if ( $posts_nr <= $limit ) { echo esc_attr( 'hidden' ); } ?>">
                        <a href="#" data-pagenum="2" class="btn--frame btn--dark btn--big load-more"><span></span><?php esc_html_e( 'Load more', 'zona' ) ?></a>
                     </div>
                <?php else : ?>
                <?php zona_paging_nav(); ?>
                <?php endif; // have_posts() ?>
            <?php else : ?>
                <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'zona' ); ?></p>

            <?php endif; // have_posts() ?>
            
    </div>
    <!-- /container -->
</div>
<!-- /content -->
<?php get_footer(); ?>