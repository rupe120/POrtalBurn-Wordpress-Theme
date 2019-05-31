<?php
/**
 * Theme Name: 		Zona - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/zona
 * Author URI: 		http://rascals.eu
 * File:			custom-intro.php
 * =========================================================================================================================================
 *
 * @package zona
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$zona_opts = zona_opts();

if ( class_exists( 'WooCommerce' ) && is_shop() ) {
    $intro_id = get_option( 'woocommerce_shop_page_id' );
} else {
	$intro_id = $wp_query->post->ID;
}


// Intro
// ======================================================= 

$intro_type = get_post_meta( $intro_id, '_intro_type', true );

if ( ! $intro_type ) {
	$intro_type = 'simple_page_title';
}

if ( $intro_type === 'disabled' ) {
	return;
}

$intro_title = get_post_meta( $intro_id, '_intro_title', true );

// Date format
$date_format = get_option( 'date_format' );


// ==================================================== Revo Slider ====================================================

if ( $intro_type === 'revslider' ) : ?>

<section class="intro intro-revslider">
	
	<?php
      $rev_id = get_post_meta( $intro_id, '_revslider_id', true );

      if ( isset( $rev_id ) && function_exists( 'putRevSlider' ) ) { 
        	$rev_id = intval( $rev_id );
        	putRevSlider( $rev_id );
      	}
   ?>
</section>

<?php

// ==================================================== Intro Simple Page Title ====================================================

elseif ( $intro_type === 'simple_page_title' ) : ?>
	<section class="intro intro--simple-page-title">
		<div class="container">
			<h1><?php echo get_the_title( $intro_id ) ?></h1>
		</div>
	</section>


<?php

// ==================================================== Intro Page Title ====================================================

elseif ( $intro_type === 'page_title' ) : ?>

	<?php
		// Vars
		$image_classes = 'intro--image';
		$img = get_post_meta( $intro_id, '_image', true );
		$image_effect = get_post_meta( $intro_id, '_image_effect', true );
		$image_filter = get_post_meta( $intro_id, '_image_filter', true );
		$image_classes .= ' ' . $image_filter;
		$disable_title = get_post_meta( $intro_id, '_disable_title', true );
		$min_height = get_post_meta( $intro_id, '_min_height', true );
		$opacity = get_post_meta( $intro_id, '_opacity', true );
		$custom_title = get_post_meta( $intro_id, '_custom_title', true );
		$subtitle = get_post_meta( $intro_id, '_subtitle', true );
		$overlay = get_post_meta( $intro_id, '_overlay', true );

		// If image exists
	   	if ( $img ) {
	   		$img = $zona_opts->get_image( $img );
		} else {
			$img = '';
		}
		// Opacity
		if ( ! $opacity ) {
			$opacity = 100;
		}
		$opacity = $opacity/100;

		// Image effect
		if ( $image_effect === 'parallax' ) {
			$image_classes .= ' intro--parallax';
		}	

	 ?>
	<section class="intro intro--page-title" style="min-height:<?php echo esc_attr( $min_height ) ?>px">
		<?php if ( ! $disable_title || $disable_title === 'off' ) : ?>
		<div class="intro--title">
			<?php if ( $subtitle != '' ) : ?>
			<h6><?php echo wp_kses_post( $subtitle ) ?></h6>
			<?php endif; ?>
			<?php if ( $custom_title && $custom_title != '' ) : ?>
				<h1><?php echo wp_kses_post( $custom_title ) ?></h1>
			<?php else : ?>
				<h1><?php echo get_the_title( $intro_id ) ?></h1>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<figure data-bg-cover="cover" class="<?php echo esc_attr( $image_classes ) ?>" style="background-image: url( <?php echo esc_url( $img ) ?>);opacity:<?php echo esc_attr( $opacity ) ?>"></figure>

		<?php
       		// Overlay
			if ( $overlay && $overlay != 'disabled' ) {
				echo '<span class="overlay ' . esc_attr( $overlay ) . '"></span>';
			}
       	 ?>
	</section>
	
	<?php

// ==================================================== Intro Music Post ====================================================

elseif ( $intro_type === 'music' ) : ?>

	<?php
		// Vars
		$image_classes = 'intro--image';
		$img = get_post_meta( $intro_id, '_image', true );
		$music_buttons = get_post_meta( $intro_id, '_intro_music_buttons', true );
		$image_effect = get_post_meta( $intro_id, '_image_effect', true );
		$image_filter = get_post_meta( $intro_id, '_image_filter', true );
		$image_classes .= ' ' . $image_filter;
		$intro_music_tracks = get_post_meta( $intro_id, '_intro_music_tracks', true );
		$min_height = 700;
		$opacity = get_post_meta( $intro_id, '_opacity', true );
		$overlay = get_post_meta( $intro_id, '_overlay', true );

		// If image exists
	   	if ( $img ) {
	   		$img = $zona_opts->get_image( $img );
		} else {
			$img = '';
		}
		// Opacity
		if ( ! $opacity ) {
			$opacity = 100;
		}
		$opacity = $opacity/100;

		// Image effect
		if ( $image_effect === 'parallax' ) {
			$image_classes .= ' intro--parallax';
		}	

	 ?>
	<section class="intro--music-wrapper"> 
		<div class="intro intro--music <?php if ( has_post_thumbnail() ) { echo esc_attr( 'has--thumbnail' ); } ?>" style="min-height:<?php echo esc_attr( $min_height ) ?>px">

			<?php if ( has_post_thumbnail() ) : ?>
			<div class="intro--cover">
				<?php $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'zona-medium-thumb'); ?>
				<div>
					<span class="date"><?php the_time( $date_format ); ?></span>
					<img src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php esc_attr_e( 'Artist Image', 'zona' ); ?>">
				</div>
			</div>
			<?php endif; ?>

			<figure data-bg-cover="cover" class="<?php echo esc_attr( $image_classes ) ?>" style="background-image: url( <?php echo esc_url( $img ) ?>);opacity:<?php echo esc_attr( $opacity ) ?>"></figure>

			<?php
	       		// Overlay
				if ( $overlay && $overlay != 'disabled' ) {
					echo '<span class="overlay ' . esc_attr( $overlay ) . '"></span>';
				}
	       	 ?>
		</div>
		
		<div class="container small">
			<h1 class="intro--music-title"><?php the_title() ?></h1>
			<div class="intro--music-tracklist">
				<?php 
	                if ( function_exists( 'zona_tracklist' ) ) {
	                    echo zona_tracklist( array( 'id' =>  $intro_music_tracks ) );
	                } 
	            ?>
			</div>
			<footer class="intro--music-footer">
				<div class="music--grid grid-row">
					<div class="grid-10 grid-tablet-10 grid-mobile-12">
						<?php if (  $music_buttons && $music_buttons != '' ) : ?>
							<span class="music-footer-title"><?php esc_html_e( 'Available Now on:', 'zona' ) ?></span>
							<?php if ( function_exists( 'zona_images_buttons' ) ) { echo zona_images_buttons( $music_buttons ); } ?>
						<?php endif; ?>
					</div>
					<div class="grid-2 grid-tablet-2 grid-mobile-12">
						<span class="music-footer-title"><?php esc_html_e( 'Share on:', 'zona' ) ?></span>
						<?php if ( function_exists( 'zona_share_buttons' ) ) { echo zona_share_buttons( $post->ID ); } ?>
					</div>
				</div>
			</footer>
		</div>
	</section>


<?php

// ==================================================== Intro Event Post ====================================================

elseif ( $intro_type === 'event' ) : ?>

	<?php
		// Vars
		$image_classes = 'intro--image';
		$img = get_post_meta( $intro_id, '_image', true );
		$display_content = get_post_meta( $intro_id, '_display_event_content', true );
		$event_content = get_post_meta( $intro_id, '_event_content', true );
		$tickets_buttons = get_post_meta( $intro_id, '_intro_tickets_buttons', true );
		$image_effect = get_post_meta( $intro_id, '_image_effect', true );
		$image_filter = get_post_meta( $intro_id, '_image_filter', true );
		$image_classes .= ' ' . $image_filter;
		$min_height = 700;
		$opacity = get_post_meta( $intro_id, '_opacity', true );
		$overlay = get_post_meta( $intro_id, '_overlay', true );

		// If image exists
	   	if ( $img ) {
	   		$img = $zona_opts->get_image( $img );
		} else {
			$img = '';
		}

		// Opacity
		if ( ! $opacity ) {
			$opacity = 100;
		}
		$opacity = $opacity/100;

		// Image effect
		if ( $image_effect === 'parallax' ) {
			$image_classes .= ' intro--parallax';
		}

	 ?>
	<section class="intro--music-event"> 
		<div class="intro intro--event <?php if ( has_post_thumbnail() && $display_content == 'on' ) { echo esc_attr( 'has--thumbnail' ); } ?>">
			 <?php 

            /* Event Date */
            $event_time = get_post_meta( $intro_id, '_event_time', true );
            $event_time_start = strtotime( get_post_meta( $intro_id, '_event_time_start', true ) );
 $event_time_end = strtotime( get_post_meta( $intro_id, '_event_time_end', true ) );
            $event_date_start = get_post_meta( $intro_id, '_event_date_start', true );
            $event_date_start = strtotime( $event_date_start );
            $event_date_end = strtotime( get_post_meta( $intro_id, '_event_date_end', true ) );
            /* Event data */
            $event_place = get_post_meta( $intro_id, '_event_place', true );
            $event_city = get_post_meta( $intro_id, '_event_city', true );
            $map_address = get_post_meta( $intro_id, '_event_map_address', true );

            // Date format
		    $date_format = 'd-m';
		    if ( $zona_opts->get_option( 'event_date' ) ) {
		        $date_format = $zona_opts->get_option( 'event_date' );
		    }
		    $date_format .= '-Y';
			// Time format
		    $time_format = 'g:i A';
		    if ( $zona_opts->get_option( 'event_time' ) ) {
		        $time_format = $zona_opts->get_option( 'event_time' );
		    }

             ?>
			<div class="container">
				<h1 class="intro--event-title"><?php the_title() ?></h1>
				<div class="grid-row grid-row-pad intro--event-details">
					
					<div class="grid-3 grid-tablet-6 grid-mobile-6">
						<h6><?php esc_html_e( 'Date:', 'zona' ) ?></h6>
						<b>STARTS</b> <span><?php echo date_i18n( $date_format, $event_date_start ); ?> <?php if ( ! $event_time || $event_time == 'on' ) : ?><br /><?php esc_html_e( 'at', 'zona' ) ?> <?php echo date_i18n( $time_format, $event_time_start ); ?></span> <br />
<b>ENDS</b> <span><?php echo date_i18n( $date_format, $event_date_end ); ?><br /><?php esc_html_e( 'at', 'zona' ) ?> <?php echo date_i18n( $time_format, $event_time_end ); ?></span><?php endif; ?>
					</div>

					<div class="grid-3 grid-tablet-6 grid-mobile-6 intro--event-place">
						<h6><?php esc_html_e( 'Place:', 'zona' ) ?></h6>
						<span><?php $zona_opts->e_esc( $event_place ) ?></span>
						<span><?php $zona_opts->e_esc( $map_address ) ?></span>
					</div>

					<div class="grid-3 grid-tablet-6 grid-mobile-6">
						<h6><?php esc_html_e( 'Tickets:', 'zona' ) ?></h6>
						<?php if ( $tickets_buttons && $tickets_buttons != '' ) : ?>
							<?php if ( function_exists( 'zona_simple_buttons' ) ) { echo zona_simple_buttons( $tickets_buttons ); } ?>
						<?php endif; ?>
					</div>

					<div class="grid-3 grid-tablet-6 grid-mobile-6">
						<h6><?php esc_html_e( 'Share:', 'zona' ) ?></h6>
						<?php if ( function_exists( 'zona_share_buttons' ) ) { echo zona_share_buttons( $post->ID ); } ?>
					</div>

				</div>
			</div>

			<figure data-bg-cover="cover" class="<?php echo esc_attr( $image_classes ) ?>" style="background-image: url( <?php echo esc_url( $img ) ?>);opacity:<?php echo esc_attr( $opacity ) ?>"></figure>

			<?php
	       		// Overlay
				if ( $overlay && $overlay != 'disabled' ) {
					echo '<span class="overlay ' . esc_attr( $overlay ) . '"></span>';
				}
	       	 ?>
		</div>
		<?php if ( $display_content == 'on' ) : ?>
		<div class="container">
		
			
			<?php 
				// Image
				if ( has_post_thumbnail() ) :
	                $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $intro_id ), 'large' );
				?>
					<div class="intro--event-image"><img src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php esc_attr_e( 'Artist Image', 'zona' ); ?>"></div>
				<?php endif; ?>

						<?php if ( $event_content != '' ) : ?>
				
				<div class="intro--event-content">
					
					<?php echo do_shortcode( $event_content ) ?>
				</div>
				<?php endif; ?>
			
		</div>
		<?php endif; ?>
	</section>


<?php
// ==================================================== Featured Slider ====================================================

elseif ( $intro_type === 'featured_slider' ) : ?>

	<?php

		// Vars
		$image_classes = 'intro--image';
		$pt = 'post';
		$tax_name = 'category';
		$featured_cat = get_post_meta( $intro_id, '_featured_cat', true );
		$featured_limit = (int)get_post_meta( $intro_id, '_featured_limit', true );
    	$featured_limit = $featured_limit && $featured_limit == '' ? $featured_limit = 3 : $featured_limit = $featured_limit;
		$image_effect = get_post_meta( $intro_id, '_image_effect', true );
		$image_filter = get_post_meta( $intro_id, '_image_filter', true );
		$image_classes .= ' ' . $image_filter;
		$min_height = get_post_meta( $intro_id, '_min_height', true );
		$opacity = get_post_meta( $intro_id, '_opacity', true );
		// Slider opts
		$slider_nav = get_post_meta( $intro_id, '_slider_nav', true );
		$slider_nav = $slider_nav && $slider_nav == 'on' ? $slider_nav = 'true' : $slider_nav = 'false';
		$slider_pagination = get_post_meta( $intro_id, '_slider_pagination', 'true' );
		$slider_pagination = $slider_pagination && $slider_pagination == 'on' ? $slider_pagination = 'true' : $slider_pagination = 'false';
		$slider_pause_time = get_post_meta( $intro_id, '_slider_pause_time', true );

		// Opacity
		if ( ! $opacity ) {
			$opacity = 100;
		}
		$opacity = $opacity/100;

		// Image effect
		if ( $image_effect === 'parallax' ) {
			$image_classes .= ' slider--parallax';
		}	

	 ?>
	<section class="intro intro--slider intro--featured-slider intro--posts">
		<div id="intro-slider" class="slider--content" data-auto-height="false" data-slider-nav="<?php echo esc_attr($slider_nav) ?>" data-slider-pagination="<?php echo esc_attr($slider_pagination) ?>" data-slider-speed="600" data-slider-pause-time="<?php echo esc_attr($slider_pause_time) ?>" style="min-height:<?php echo esc_attr( $min_height ) ?>px">
		
			<?php 
				// Begin Loop
			    $args = array(
			        'post_type' => $pt,
			        'showposts' => $featured_limit
			    );
			    $term = get_term_by( 'id', $featured_cat, 'category');
				if ( $term ) {
				  
				    $args['tax_query'] = array(
			            array(
			                'taxonomy' => $tax_name,
			                'field' => 'term_id',
			                'terms' => $featured_cat
			            )
			        );
				}

			$featured_query = new WP_Query();
	    	$featured_query->query( $args );

	    	// Begin Loop
	   		if ( $featured_query->have_posts() ) :
	        
	        	while ( $featured_query->have_posts() ) :
	            	$featured_query->the_post();
			?>

			<div class="slide" style="min-height:<?php echo esc_attr( $min_height ) ?>px">
				<div class="intro--title">
					<h6><?php _e( 'Featured Articles', 'zona' ) ?></h6>
					<h2><?php echo get_the_title( $featured_query->post->ID ) ?></h2>
					<div class="slider--excerpt">
						<?php 
						if (  has_excerpt() ) {
			                echo wp_trim_words( get_the_excerpt(), 30, ' [...]' );
			            } else {
			                echo wp_trim_words( strip_shortcodes( get_the_content() ), 30, ' [...]' ); 
			            }
						?>
					</div>
					<a href="<?php echo esc_url( get_permalink( $featured_query->post->ID ) ) ?>" class="btn--frame btn--medium slider--btn"><span></span><?php esc_html_e( 'read more', 'zona' ) ?></a>
				</div>
				<?php 
				// Image
				if ( has_post_thumbnail() ) :
	                $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $featured_query->post->ID ), 'large' );
				?>

					<figure data-bg-cover="cover" class="<?php echo esc_attr( $image_classes ) ?>" style="background-image: url( <?php echo esc_url( $img_src[0] ) ?>);opacity:<?php echo esc_attr( $opacity ) ?>"></figure>
				<?php endif; ?>
			
				
			</div>

			<?php endwhile ?>
			<?php endif; ?>
		</div>
	</section>


	<?php
// ==================================================== Images Slider ====================================================

elseif ( $intro_type === 'slider' ) : ?>

	<?php

		// Vars
		$image_classes = 'intro--image';
		$image_effect = get_post_meta( $intro_id, '_image_effect', true );
		$image_filter = get_post_meta( $intro_id, '_image_filter', true );
		$image_classes .= ' ' . $image_filter;
		$min_height = get_post_meta( $intro_id, '_min_height', true );
		$opacity = get_post_meta( $intro_id, '_opacity', true );
		// Slider opts
		$slider_nav = get_post_meta( $intro_id, '_slider_nav', true );
		$slider_nav = $slider_nav && $slider_nav == 'on' ? $slider_nav = 'true' : $slider_nav = 'false';
		$slider_pagination = get_post_meta( $intro_id, '_slider_pagination', 'true' );
		$slider_pagination = $slider_pagination && $slider_pagination == 'on' ? $slider_pagination = 'true' : $slider_pagination = 'false';
		$slider_pause_time = get_post_meta( $intro_id, '_slider_pause_time', true );

		// Opacity
		if ( ! $opacity ) {
			$opacity = 100;
		}
		$opacity = $opacity/100;

		// Image effect
		if ( $image_effect === 'parallax' ) {
			$image_classes .= ' slider--parallax';
		}	

	 ?>
	<?php if ( function_exists( 'zona_get_slider' ) && zona_get_slider( $intro_id, '_intro_slider' ) ) : ?>

	<section class="intro intro--slider intro--images-slider">
		<div id="intro-slider" class="slider--content" data-auto-height="false" data-slider-nav="<?php echo esc_attr($slider_nav) ?>" data-slider-pagination="<?php echo esc_attr($slider_pagination) ?>" data-slider-speed="600" data-slider-pause-time="<?php echo esc_attr($slider_pause_time) ?>" style="min-height:<?php echo esc_attr( $min_height ) ?>px">
	
			
			<?php $slider = zona_get_slider( $intro_id, '_intro_slider' ); ?>
			<?php foreach ( $slider as $slide ) : ?>
				<div class="slide" style="min-height:<?php echo esc_attr( $min_height ) ?>px">

					<div class="intro--title">
						<?php if ( $slide['subtitle'] !== '' ) : ?>
						<h6><?php echo esc_html( $slide['subtitle'] ) ?></h6>
						<?php endif ?>
						
						<?php if ( $slide['title'] !== '' ) : ?>
						<h2><?php echo esc_html( $slide['title'] ) ?></h2>
						<?php endif ?>
						
						<?php if ( $slide['slider_button_url'] !== '' ) : ?>
						<a href="<?php echo esc_url( $slide['slider_button_url'] ) ?>" class="btn--frame btn--medium slider--btn" target="<?php echo esc_attr( $slide['slider_button_target'] ) ?>"><span></span><?php echo esc_html( $slide['slider_button_title'] ) ?></a>
						<?php endif ?>
					</div>
					<figure data-bg-cover="cover" class="<?php echo esc_attr( $image_classes ) ?>" style="background-image: url( <?php echo esc_url( $slide[ 'src' ] ) ?>);opacity:<?php echo esc_attr( $opacity ) ?>"></figure>

				</div>
			<?php endforeach; ?>

		</div>
	</section>
	<?php endif; // end zona_get_slider ?>



<?php endif ?>