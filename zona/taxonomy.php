<?php
/**
 * Theme Name: 		Zona - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/zona
 * Author URI: 		http://rascals.eu
 * File:			taxonomy.php
 * =========================================================================================================================================
 *
 * @package zona
 * @since 1.0.0
 */
?>
<?php get_header(); ?>

<?php 
	// Get Category Intro Section
	get_template_part( 'inc/tag-intro' );

?>

<?php 

   	$zona_opts = zona_opts();

   	// Vars
   	$thumb_size = 'full';
   	$classes = '';

   	// Current TAX
	$queried_object = get_queried_object();
	$taxonomy = $queried_object->taxonomy;
	$term_id = $queried_object->term_id;

	// Date format
	$date_format = get_option( 'date_format' );

  	if ( is_tax( 'zona_music_cats' ) )  {
		$tax = 'music';
		$thumb_size = 'zona-medium-thumb';
		$classes .= 'music--grid grid-row grid-row-pad-large';
	// Events
	} elseif ( is_tax( 'zona_events_cats' ) )  {
		$tax = 'events';
		$classes .= 'events--list-wrap';

		// Date format
	    $date_format = 'd-m';
	    if ( $zona_opts->get_option( 'event_date' ) ) {
	        $date_format = $zona_opts->get_option( 'event_date' );
	   	}

		// Limit
		$limit = 8;

		// Count
		$count = 1;
		$paged_events = $paged;
		if ( $paged_events > 0 ) {
			$paged_events = $paged_events-1;
		}
		$events_count = ($paged_events*$limit)+1;

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
				),
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'id',
					'terms'    => $term_id
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
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'id',
					'terms'    => $term_id
				)	
			),
	        'orderby' => 'meta_value',
	        'meta_key' => '_event_date_start',
	        'order' => 'DSC'
	    ));

	    $future_nr = count( $future_events );
	   	$past_nr = count( $past_events );

		$mergedposts = array_merge( $future_events, $past_events ); //combine queries

		$postids = array();
		foreach( $mergedposts as $item ) {
			$postids[] = $item->ID; //create a new query only of the post ids
		}
		$uniqueposts = array_unique( $postids ); //remove duplicate post ids

		$args = array(
			'post_type' => 'zona_events',
			'showposts' => $limit,
			'paged'     => $paged,
			'post__in'  => $uniqueposts,
			'orderby' => 'post__in'
	 	);

	 	$wp_query = new WP_Query();
		$wp_query->query( $args );
		}
	?>
		
<!-- ############ CONTENT ############ -->
<div class="content">

	<!-- ############ Container ############ -->
	<div class="container custom-taxonomies">
		<?php if ( have_posts() ) : ?>
				
			<div class="<?php echo esc_attr( $classes ) ?>">

			<?php if ( $tax == 'events' ) : ?>
			<ul class="events--list">
			<?php endif; ?>

			<?php // Start the Loop.
			while ( have_posts() ) : the_post() ?>

					<?php 

					// -----------------------------------------------------------------
					// Portfolio
					if ( $tax == 'music' ) : ?>
					<?php if ( has_post_thumbnail() ) : ?> 

						<div class="grid--item item-anim anim-fadeup grid-4 grid-tablet-6 grid-mobile-12">
							<article <?php post_class( 'article anim--disabled' ); ?>>
                                <?php echo '<a href="' . esc_url( get_permalink() ) . '" class="music--click-layer"></a>';?>
                                <?php $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $thumb_size ); ?>
                                <img class="music--image" src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php esc_attr_e( 'Post image', 'zona' ) ?>">
                            </article>
	                    </div>
						<?php endif; // end has_post_thumbnail  ?>
                    <?php

					// -----------------------------------------------------------------
					// Events
					elseif ( $tax == 'events' ) : ?>
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
             
                	<?php endif; // end $tax ?>
	
			<?php endwhile; ?>
			
			<?php if ( $tax == 'events' ) : ?>
			</ul>
			<?php endif; ?>

			</div>
			
			<div class="clear"></div>
			<?php zona_paging_nav(); ?>

		<?php else : ?>
			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'zona' ); ?></p>
		<?php endif; // have_posts() ?>
			
	</div>
    <!-- /container -->
</div>
<!-- /content -->

<?php get_footer(); ?>