<?php
/**
 * Template Name: Blog List
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
	$thumb_size = 'zona-full-thumb';

	$more = 0;

	// Blog options
    $limit = (int)get_post_meta( $wp_query->post->ID, '_limit', true );
    $limit = $limit && $limit == '' ? $limit = 6 : $limit = $limit;
    $show_featured = get_post_meta( $wp_query->post->ID, '_featured_images', true );

    // Date format
	$date_format = get_option( 'date_format' );

?>

<?php 
	// Get Custom Intro Section
	get_template_part( 'inc/custom-intro' );

?>

<!-- ############ CONTENT ############ -->
<div class="content blog--list article--hover clearfix">
	
	<div class="container">
	<!-- ############ Main ############ -->

	<div class="grid-row">
	<div class="grid-8 grid-tablet-12 grid-mobile-12 main">

		<?php
			$args = array(
				'paged' => $paged,
				'showposts' => $limit,
				'ignore_sticky_posts' => false
            );
		
            $wp_query = new WP_Query();
			$wp_query->query($args);

			if ( have_posts() ) : ?>
				

				<?php // Start the Loop.
				while ( have_posts() ) : the_post() ?>

					<div class="list--item item-anim anim-fadeup">
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

				<div class="clear"></div>
    			<?php zona_paging_nav(); ?>
			<?php else : ?>
				<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'zona' ); ?></p>

			<?php endif; // have_posts() ?>
			
	</div>
    <!-- /main -->

    <!-- Sidebar -->
    <div class="grid-4 grid-tablet-12 grid-mobile-12 sidebar--wrap">
    	
		<?php get_sidebar(); ?>

    </div>
    <!-- /sidebar -->
	

	</div>
    <!-- /grid row-->

    </div>
    <!-- /container-->
</div>
<!-- /content -->
<?php get_footer(); ?>