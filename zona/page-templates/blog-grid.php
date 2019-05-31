<?php
/**
 * Template Name: Blog Grid
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
	$thumb_size = 'zona-main-thumb';

	$more = 0;

	// Blog options
    $limit = (int)get_post_meta( $wp_query->post->ID, '_limit', true );
    $limit = $limit && $limit == '' ? $limit = 6 : $limit = $limit;
    $cols_layout = get_post_meta( $wp_query->post->ID, '_columns', true ); // grid-6, grid-4
    $cols_layout = ! $cols_layout ? $cols_layout = 'grid-6' : $cols_layout = $cols_layout;
    $pagination_method = get_post_meta( $wp_query->post->ID, '_pagination', true ); // pagination-ajax, pagination-default
    $ajax_filter = get_post_meta( $wp_query->post->ID, '_ajax_filter', true );
    $ajax_filter = ! $ajax_filter || $ajax_filter == 'on' ? $ajax_filter = '' : $ajax_filter = 'hidden';
    $show_featured = get_post_meta( $wp_query->post->ID, '_featured_images', true );

   	// Date format
	$date_format = get_option( 'date_format' );

?>

<?php 
	// Get Custom Intro Section
	get_template_part( 'inc/custom-intro' );

?>
<!--############ Filter ############ -->
<div class="blog-filter filters-wrapper <?php echo esc_attr( $ajax_filter ); ?>">
	
	<div class="container">
		<!-- Filter -->
	    <div class="filter filter-simple" data-grid="blog--grid" data-obj='{"action": "zona_blog_filter", "filterby": "taxonomy", "cpt": "post", "tax": "category", "limit": "<?php echo esc_attr( $limit ); ?>", "cols_layout": "<?php echo esc_attr( $cols_layout ); ?>", "thumb_size": "<?php echo esc_attr( $thumb_size ); ?>", "show_featured":"<?php echo esc_attr( $show_featured ); ?>"}' >

	        <ul data-filter-group="">
	            <li><a href="#" data-filter-name="all" class="is-active"><span></span><?php esc_html_e( 'All', 'zona' ) ?></a></li>
	                <?php 
	                    $term_args = array( 'hide_empty' => '1', 'orderby' => 'name', 'order' => 'ASC' );
	                    $terms = get_terms( 'category', $term_args );
	                    if ( $terms ) {
	                        foreach ( $terms as $term ) {
	                            echo '<li><a href="#" data-filter-name="' . esc_attr( $term->term_id ) . '"><span></span>' . esc_html( $term->name ) . '</a></li>';
	                        }
	                    }
	                ?>
	        </ul>
	    </div>
	    <!-- /filter -->
    </div>

</div>
<!-- blog-filter -->

<!-- ############ CONTENT ############ -->
<div class="content">

	<!-- ############ Container ############ -->
	<div class="container">

		
		<?php
			$args = array(
				'paged' => $paged,
				'ignore_sticky_posts' => false
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
				
				<div class="blog--grid grid-row" data-min-height="400" data-cols="<?php echo esc_attr( $cols_layout ) ?>">

				<?php // Start the Loop.
				while ( have_posts() ) : the_post() ?>

					<div class="grid--item item-anim anim-fadeup <?php echo esc_attr( $cols_layout ) ?> grid-tablet-12 grid-mobile-12">
						<article <?php post_class( 'article' ); ?>>

							<?php $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $thumb_size ); ?>
							<?php if ( $show_featured && $show_featured == 'on' ) : ?>
								<?php if ( has_post_thumbnail() ) : ?>
									<img class="featured--image" src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php esc_attr_e( 'Post image', 'zona' ) ?>">
								<?php endif; ?>
							<?php endif; ?>
							<div class="article--preview">
								<figure style="background-image: url(<?php echo esc_url( $img_src[0] ); ?>)"></figure>
							</div>
					      
							
							<?php the_title( '<h2 class="article--title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
							<div class="article--excerpt">
								<?php 
								if ( has_excerpt() ) {
					                echo wp_trim_words( get_the_excerpt(), 30, ' [...]' );
					            } else {
					                echo wp_trim_words( strip_shortcodes( get_the_content() ), 30, ' [...]' ); 
					            }
								?>
							</div>
							<footer class="article--footer meta--cols">
								<div class="meta--col">
					                <span class="meta--author-image"><?php echo get_avatar( get_the_author_meta( 'email' ), '50' ); ?></span>
					                <div class="meta--author">
					                    <?php esc_html_e( 'by', 'zona' ) ?> <a href="<?php echo get_author_posts_url( $post->post_author ); ?>" class="author-name"><?php echo get_the_author_meta( 'display_name', $post->post_author ); ?></a><br>
					                    <span class="meta--date"><?php the_time( $date_format ); ?></span>
					                </div>
					            </div>
					            <div class="meta--col meta--col-link">
									<?php echo '<a href="' . esc_url( get_permalink() ) . '" class="btn--read-more meta--link">' . esc_html__( 'Read more', 'zona' ) . '</a>';?>
								</div>
							</footer>
							<?php if ( is_sticky() ) : ?>
							<span class="is-sticky"><?php esc_html_e( 'sticky post', 'zona' ) ?></span>
							<?php endif; ?>
						</article>
					</div>
		
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