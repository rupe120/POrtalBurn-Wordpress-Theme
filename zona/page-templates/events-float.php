<?php
/**
 * Template Name: Events - Floating
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
    $event_type = get_post_meta( $wp_query->post->ID, '_event_type', true );

    // Date format
    $date_format = 'd-m';
    if ( $zona_opts->get_option( 'event_date' ) ) {
        $date_format = $zona_opts->get_option( 'event_date' );
    }

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
        if ( $event_type == 'all-events' ) {
                // Future Events
                $future_events = get_posts( array(
                    'post_type' => 'zona_events',
                    'showposts' => -1,
                    'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'zona_event_type',
                            'field' => 'slug',
                            'terms' => 'future-events'
                        )
                    ),
                    'orderby' => 'meta_value',
                    'meta_key' => '_event_date_start',
                    'order' => 'ASC'
                ));

                // Past Events
                $past_events = get_posts(array(
                    'post_type' => 'zona_events',
                    'showposts' => -1,
                    'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'zona_event_type',
                            'field' => 'slug',
                            'terms' => 'past-events'
                        ),
                    ),
                    'orderby' => 'meta_value',
                    'meta_key' => '_event_date_start',
                    'order' => 'DSC'
                ));

                $future_nr = count( $future_events );
                $past_nr = count( $past_events );

                // echo "Paged: $paged, Future events: $future_nr, Past events: $past_nr";

                $mergedposts = array_merge( $future_events, $past_events ); //combine queries

                $postids = array();
                foreach( $mergedposts as $item ) {
                    $postids[] = $item->ID; //create a new query only of the post ids
                }
                $uniqueposts = array_unique( $postids ); //remove duplicate post ids

                // var_dump($uniqueposts);
                $args = array(
                    'post_type' => 'zona_events',
                    'showposts' => $limit,
                    'paged'     => $paged,
                    'post__in'  => $uniqueposts,
                    'orderby' => 'post__in'
                );

            } else {

                // Begin Loop

                /* Set order */
                $order = $event_type == 'future-events' ? $order = 'ASC' : $order = 'DSC';

                // Event type taxonomy
                $tax = array(
                    array(
                       'taxonomy' => 'zona_event_type',
                       'field' => 'slug',
                       'terms' => $event_type
                      )
                );

                // Begin Loop
                $args = array(
                    'post_type'        => 'zona_events',
                    'paged'            => $paged,
                    'showposts'        => $limit,
                    'tax_query'        => $tax,
                    'orderby'          => 'meta_value',
                    'meta_key'         => '_event_date_start',
                    'order'            => $order,
                    'suppress_filters' => 0 // WPML FIX
                );

            }
            $wp_query = new WP_Query();
            $wp_query->query( $args );

            $frictions = array( -50,-100,-40,-80,-40,-80,-40,-70,-80,-60 );
            $count= 0;
        ?>
        
        <?php if ( have_posts() ) : ?>
                
            <div class="float--events float--grid" style="perspective:800px; -webkit-perspective:800px; perspective:800px; -webkit-perspective:800px; ">
                <?php // Start the Loop.
                while ( have_posts() ) : the_post() ?>
                    <?php 

                    /* Event Date */
                    $event_time_start = get_post_meta( $wp_query->post->ID, '_event_time_start', true );
                    $event_date_start = get_post_meta( $wp_query->post->ID, '_event_date_start', true );
                    $event_date_start = strtotime( $event_date_start );
                    $event_date_end = strtotime( get_post_meta( $wp_query->post->ID, '_event_date_end', true ) );

                    /* Event data */
                    $event_place = get_post_meta( $wp_query->post->ID, '_event_place', true );
                    $event_city = get_post_meta( $wp_query->post->ID, '_event_city', true );
                    $event_tickets_url = get_post_meta( $wp_query->post->ID, '_event_tickets_url', true );
                    $event_tickets_target = get_post_meta( $wp_query->post->ID, '_event_tickets_new_window', true );

                    //$friction = rand(100,1000)/1000;
                    $friction = $frictions[$count];
                    if ( $count == 10 ) {
                        $count=0;
                    }
                    $count++;
                    ?>

                    <?php if ( has_post_thumbnail() ) : ?>

                        <?php 
                        $post_thumbnail_id = get_post_thumbnail_id( $post->ID );
                        $imgmeta = wp_get_attachment_metadata( $post_thumbnail_id );
                        if ( $imgmeta['width'] > $imgmeta['height'] ) {
                            $img_orientation = 'landscape';
                        } else {
                            $img_orientation = 'portrait';
                        }
                        $img_orientation = 'landscape';
                                                     ?>
                        <div <?php post_class( 'grid--item grid--item--' . esc_attr( $img_orientation ) ); ?>  data-parallax='{"y": <?php echo esc_attr( $friction ) ?>}' style="z-index:<?php echo esc_attr( $limit ) ?>">
                            <a href="<?php the_permalink() ?>" class="float--event anim--reveal">
                                <?php $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $thumb_size ); ?>
                                <img class="music--image" src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php esc_attr_e( 'Event image', 'zona' ) ?>">
                                <span class="float--event-content">
                                    <span class="float--event-row">
                                        <span class="float--event-date hidden"><?php echo date_i18n( $date_format, $event_date_start ); ?></span>  
                                        <span class="float--event-title hidden"><?php the_title(); ?></span>
                                        <span class="float--event-place hidden"><?php echo esc_html( $event_place ) ?></span>
                                        <span class="float--event-city hidden"><?php echo esc_html( $event_city ) ?></span>
                                    </span>
                                </span>
                            </a>
                            <span class="float--event-title-bottom"><span><?php echo date_i18n( $date_format, $event_date_start ); ?></span><?php the_title(); ?></span>
                        </div>
                        <?php $limit-- ?>
                    <?php endif; // has thumbnail ?>
                   
        
                <?php endwhile; ?>
            </div>

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