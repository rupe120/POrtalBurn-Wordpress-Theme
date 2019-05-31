<?php
/**
 * Template Name: Music - Floating
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

    // Date format
    $date_format = get_option( 'date_format' );

?>

<?php 
    // Get Custom Intro Section
    get_template_part( 'inc/custom-intro' );

?>


<!-- ############ CONTENT ############ -->
<div class="content">

    <!-- ############ Container ############ -->
    <div class="container">
        <?php

            $frictions = array( -40,-60,-60,-40,-60,-80,-40,-60,-80 );
            $count= 0;
            $args = array(
                'post_type' => 'zona_music',
                'paged'     => $paged,
                'showposts' => $limit,
                'orderby'   => 'menu_order',
                'order'     => 'ASC'
            );
        
            $wp_query = new WP_Query();
            $wp_query->query($args);

            if ( have_posts() ) : ?>
                
                <div class="float--grid float--music music--grid" style="perspective:800px; -webkit-perspective:800px; perspective:800px; -webkit-perspective:800px; ">

                <?php // Start the Loop.
                while ( have_posts() ) : the_post() ?>
                    <?php if ( has_post_thumbnail() ) : ?>
                    <?php 
                    //$friction = rand(100,1000)/1000;
                    $friction = $frictions[$count];
                    if ( $count == 9 ) {
                        $count=0;
                    }
                    $count++;
                    $track_id = get_post_meta( $post->ID, '_thumb_tracks', true );
                     ?>
                    <div class="grid--item grid--item--box" data-parallax='{"y": <?php echo esc_attr( $friction ) ?>}' style="z-index:<?php echo esc_attr( $limit ) ?>">
                        
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
                       
                    </div>
                    <?php $limit-- ?>
                    <?php endif; // has thumbnail ?>
        
                <?php endwhile; ?>

                </div>
                <!-- /masonry -->
                <div class="clear"></div>
                <?php zona_paging_nav(); ?>
            <?php else : ?>
                <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'zona' ); ?></p>

            <?php endif; // have_posts() ?>
            
    </div>
    <!-- /container -->
    <span class="scroll-discover"><span class="icon icon-line-arrow-left"></span> <?php esc_html_e('Scroll to discover', 'zona') ?></span>
</div>
<!-- /content -->
<?php get_footer(); ?>