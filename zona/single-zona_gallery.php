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
   	
   	// Copy query
    $temp_post = $post;
    $query_temp = $wp_query;

   	// Pagination Limit
    $limit = (int)get_post_meta( $wp_query->post->ID, '_limit', true );
    $limit = $limit && $limit == '' ? $limit = 6 : $limit = $limit;

    // Intro
    $intro_type = get_post_meta( $wp_query->post->ID, '_intro_type', true );

    // Variables
   	$cols_layout = 'grid-4';
    $thumb_size = 'zona-gallery-thumb';

    // Date format
	$date_format = get_option( 'date_format' );
?>

<?php 
	// Get Custom Intro Section
	if ( $intro_type != 'disabled' ) {
		get_template_part( 'inc/custom-intro' );
	}


?>

<!-- ############ CONTENT ############ -->
<div class="content">

	<!-- ############ Container ############ -->
	<div class="container">
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'single--post-article' ); ?>>

			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post(); 

					/* Album ID */
					$album_id = get_the_id();

					/* Images ids */
			        $images_ids = get_post_meta( $wp_query->post->ID, '_gallery_ids', true ); ?>
					
					<?php if ( $intro_type == 'disabled' ) : ?>
				    <!-- ############ POST HEADER ############ -->
				    <header class="single--post-header content--extended">
				        <div class="single--post-header-meta">
				            <div class="single--post-header-date"><?php the_time( $date_format ); ?></div>
				        </div>
				        <h1><?php the_title(); ?></h1>
				    </header>
					<?php endif; ?>
					<?php the_content(); ?>

				<?php endwhile; ?>

				    <?php if ( $images_ids || $images_ids !== '' ) :

					$ids = explode( '|', $images_ids ); 
		           	$gallery_loop_args = array(
		                'post_type' => 'attachment',
						'post_mime_type' => 'image',
						'post__in' => $ids,
						'orderby' => 'post__in',
						'post_status' => 'any'
					);

					// Posts number
		            $temp_args = $gallery_loop_args;
		            $temp_args['showposts'] = -1;
		            $temp_query_count = new WP_Query();
		            $temp_query_count->query( $temp_args );
		            $posts_nr = $temp_query_count->post_count;

		            // Add limit
		            $gallery_loop_args['showposts'] = $limit;

					$wp_query = new WP_Query();
					$wp_query->query( $gallery_loop_args );
					?>
				
					<!--############ Images grid ############ -->
					<div class="gallery--grid images--grid grid-row grid-row-pad" data-min-height="200" data-cols="<?php echo esc_attr( $cols_layout ) ?>">

						<?php if ( have_posts() ) : ?>

							<?php while ( have_posts() ) : the_post(); ?>
								
								<?php 
								$image_att = wp_get_attachment_image_src( get_the_id(), $thumb_size );
								if ( ! $image_att[0] ) { 
									continue;
								}

								$defaults = array(
									'title' => '',
									'custom_link'  => '',
									'thumb_icon' => 'view'
						         );

								/* Get image meta */
								$image = get_post_meta( $album_id, '_gallery_ids_' . get_the_id(), true );

								/* Add default values */
								if ( isset( $image ) && is_array( $image ) ) {
									$image = array_merge( $defaults, $image );
								} else {
									$image = $defaults;
								}

								/* Add image src to array */
								$image['src'] = $image_att[0];
								if ( $image[ 'custom_link' ] != '' ) {
									$link = $image[ 'custom_link' ];
								} else {
									$link = wp_get_attachment_image_src( get_the_id(), 'full' );
									$link = $link[0];
								}

								?>
		
								<div class="grid--item item-anim anim-fadeup grid-3 grid-tablet-6 grid-mobile-6">
                       
			                        <article <?php post_class( 'article' ); ?>>
			                            <a href="<?php echo esc_attr( $link ) ?>" class="<?php if ( $image[ 'custom_link' ] != '' ) { echo esc_attr( 'iframe-link'); } ?> g-item" title="<?php echo esc_attr( $image['title'] ); ?>">
			                               	<img src="<?php echo esc_url( $image['src'] ) ?>" alt="<?php esc_attr_e( 'Gallery thumbnail', 'zona' ); ?>" title="<?php echo esc_attr( $image['title'] ); ?>">
			                            </a>
			                        </article>
			                        
			                    </div>

							<?php endwhile; // End Loop ?>

						<?php endif; ?>
					</div>
					<div class="clear"></div>

					<!-- Load more -->
					<div class="filter filter-simple hidden" data-grid="gallery--grid" data-obj='{"action": "zona_gallery_images", "filterby": "taxonomy", "cpt": "zona_gallery", "tax": "zona_gallery_cats", "limit": "<?php echo esc_attr( $limit ); ?>", "cols_layout": "<?php echo esc_attr( $cols_layout ); ?>", "thumb_size": "<?php echo esc_attr( $thumb_size ); ?>", "id": "<?php echo esc_attr( $album_id ); ?>"}' ></div>

					<div class="load-more-wrap <?php if ( $posts_nr <= $limit ) { echo esc_attr( 'hidden' ); } ?>">
                    	<a href="#" data-pagenum="2" class="btn--frame btn--dark btn--big load-more"><span></span><?php esc_html_e( 'Load more', 'zona' ) ?></a>
                 	</div>

				<?php else : ?>
					<?php echo '<p class="message error">' . esc_html__( 'Gallery error: Album has no pictures.', 'zona' ) . '</p>'; ?>
		        <?php endif; // images ids ?>
				
				<?php
				   // Get orginal query
				   $post = $temp_post;
				   $wp_query = $query_temp;
				?>			
		</article>

	</div>
    <!-- /container -->

  <?php if ( function_exists( 'zona_custom_post_nav' ) ) : ?>
    <?php echo zona_custom_post_nav(); ?>
<?php endif; ?>
</div>
<!-- /content -->

<?php get_footer(); ?>