<?php
/**
 * Template Name: Events
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
    $pagination_method = get_post_meta( $wp_query->post->ID, '_pagination', true ); // pagination-ajax, pagination-default
    $ajax_filter = get_post_meta( $wp_query->post->ID, '_ajax_filter', true );
    $ajax_filter = ! $ajax_filter || $ajax_filter == 'on' ? $ajax_filter = '' : $ajax_filter = 'hidden';
    $event_type = get_post_meta( $wp_query->post->ID, '_event_type', true );

    // BG Image
    $events_bg = get_post_meta( $wp_query->post->ID, '_events_bg', true );
    // If image exists
    if ( $events_bg ) {
        $events_bg = $zona_opts->get_image( $events_bg );
    } else {
        $events_bg = '';
    }

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
<!--############ Filter ############ -->
<div class="events-filter filters-wrapper <?php echo esc_attr( $ajax_filter ); ?>">
    
    <!-- Filter -->
    <div class="filter filter-simple" data-grid="events--list" data-obj='{"action": "zona_events_filter", "filterby": "taxonomy", "cpt": "zona_events", "tax": "zona_events_cats", "limit": "<?php echo esc_attr( $limit ); ?>", "event_type": "<?php echo esc_attr( $event_type ); ?>"}' >

        <ul data-filter-group="">
            <li><a href="#" data-filter-name="all" class="is-active anim--reveal-static"><?php esc_html_e( 'All', 'zona' ) ?></a></li>
                <?php 
                    $term_args = array( 'hide_empty' => '1', 'orderby' => 'name', 'order' => 'ASC' );
                    $terms = get_terms( 'zona_events_cats', $term_args );
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
<!-- events-filter -->

<!-- ############ CONTENT ############ -->
<div class="content" style="background-image:url(<?php echo esc_url( $events_bg ) ?>);">

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
                    'tax_query'        => $tax,
                    'orderby'          => 'meta_value',
                    'meta_key'         => '_event_date_start',
                    'order'            => $order,
                    'suppress_filters' => 0 // WPML FIX
                );

            }

            // Posts number
            $temp_args = $args;
            $temp_args['showposts'] = -1;
            $temp_query_count = new WP_Query();
            $temp_query_count->query( $temp_args );
            $posts_nr = $temp_query_count->post_count;

            // Add limit
            $args['showposts'] = $limit;

            $wp_query = new WP_Query();
            $wp_query->query( $args );
        ?>
        
        <?php if ( have_posts() ) : ?>
                
            <div class="events--list-wrap">
                <ul class="events--list" data-min-height="100">
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

                         ?>
                        <li <?php post_class( 'grid--item item-anim anim-fadeup' ); ?>>
                            
                            <div class="event--col event--col-date">
                                <?php echo date_i18n( $date_format, $event_date_start ); ?>
<?php echo date_i18n( $date_format, $event_date_end ); ?> 

                            </div>

                            <div class="event--col event--col-title">
                                <div class="event--show-on-mobile event--date">
                                    <?php echo date_i18n( $date_format, $event_date_start ); ?>

                                </div>
                                <?php 
                                if ( has_term( 'past-events', 'zona_event_type' ) ) {
                                    echo '<span class="past-event-label">' . esc_html__( 'Past Event', 'zona' ) . '</span>';
                                }    
                                 ?>
                                <a href="<?php the_permalink() ?>" class="event--title"><?php the_title() ?></a>
                                <div class="event--show-on-mobile event--city">
                                    <?php echo esc_html( $event_city ) ?>
                                </div>
                                
                            </div>
                            <div class="event--col event--col-city">
                                <?php echo esc_html( $event_city ) ?>
                                
                            </div>
                            <div class="event--col event--col-tickets">
                                <?php if ( $event_tickets_url != '' ) : ?>
                                    <?php 
                                    if ( $event_tickets_target == 'yes' ) {
                                        $event_tickets_target = '_blank';
                                    } else {
                                        $event_tickets_target = '_self';
                                    }
                                     ?>
                                    <a class="event--button anim--reveal" href="<?php echo esc_url( $event_tickets_url ) ?>" target="<?php echo esc_attr( $event_tickets_target ) ?>"><span><?php esc_html_e( 'Tickets', 'zona' ) ?></span></a>
                                <?php endif ?>
                                
                            </div>

                        </li>
                       
            
                    <?php endwhile; ?>
                </ul>

            </div>
                <!-- /list -->
            <div class="clear"></div>
            <?php if ( $pagination_method == 'pagination-ajax' ) : ?>
                <div class="load-more-wrap <?php if ( $posts_nr <= $limit ) { echo esc_attr( 'hidden' ); } ?>">
                    <a href="#" data-pagenum="2" class="btn--frame btn--dark btn--big load-more"><span></span><?php esc_html_e( 'Load more', 'zona' ) ?></a>
                 </div>
            <?php else : ?>
                <?php zona_paging_nav(); ?>
            <?php endif; // pagination ?>
        <?php else : ?>
            <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'zona' ); ?></p>
        <?php endif; // have_posts() ?>
            
    </div>
    <!-- /container -->
</div>
<!-- /content -->
<?php get_footer(); ?>