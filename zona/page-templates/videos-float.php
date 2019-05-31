<?php
/**
 * Template Name: Videos - Floating
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
    $thumb_size = 'large';

    // Options
    $limit = (int)get_post_meta( $wp_query->post->ID, '_limit', true );
    $limit = $limit && $limit == '' ? $limit = 6 : $limit = $limit;

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

            $frictions = array( -50,-100,-40,-80,-40,-80,-40,-70,-80,-60 );
            $count= 0;

            $args = array(
                'post_type' => 'zona_videos',
                'paged'     => $paged,
                'showposts' => $limit,
                'orderby'   => 'menu_order',
                'order'     => 'ASC'
            );
        
            $wp_query = new WP_Query();
            $wp_query->query($args);
            if ( have_posts() ) : ?>
                
                <div class="float--videos float--grid" style="perspective:800px; -webkit-perspective:800px; perspective:800px; -webkit-perspective:800px; ">

                <?php // Start the Loop.
                while ( have_posts() ) : the_post() ?>

                    <?php 
                    $video_url = get_post_meta( $post->ID, '_video_url', true );
                     ?>
                    <?php if ( has_post_thumbnail() && $video_url && $video_url != '' ) : ?>
                    <?php 

                        // Friction
                        $friction = $frictions[$count];
                        if ( $count == 10 ) {
                            $count=0;
                        }
                        $count++;
                    ?>
                    <div <?php post_class( 'grid--item grid--item--landscape' ); ?>  data-parallax='{"y": <?php echo esc_attr( $friction ) ?>}' style="z-index:<?php echo esc_attr( $limit ) ?>">
                       
                            <a href="<?php echo esc_url( $video_url  ) ?>" class="float--video iframebox anim--reveal">
                                <?php $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $thumb_size ); ?>
                                <img class="videos--image" src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php esc_attr_e( 'Post image', 'zona' ) ?>">
                                <h2 class="videos--title"><?php the_title(); ?></h2>
                                <span class="videos--play-layer"><span class="icon icon-play"></span></span>
                            </a>
                        
                    </div>
                    <?php $limit-- ?>
                    <?php endif; // has thumbnail ?>
        
                <?php endwhile; ?>

                </div>
                <!-- /float grid -->
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