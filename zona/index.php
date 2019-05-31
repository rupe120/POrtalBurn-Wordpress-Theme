<?php
/**
 * Theme Name: 		Zona - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/zona
 * Author URI: 		http://rascals.eu
 * File:			index.php
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

	// Thumb Size
	$thumb_size = 'zona-full-thumb';

	$more = 0;

    // Date format
	$date_format = get_option( 'date_format' );

?>

<section class="intro intro--page-title" style="min-height:340px">
	<div class="intro--title">
		<h6><?php esc_html_e( 'Here are some news from our band', 'zona') ?></h6>
		<h1><?php esc_html_e( 'Articles', 'zona') ?></h1>
	</div>
</section>

<!-- ############ CONTENT ############ -->
<div class="content blog--list blog--list-index clearfix">
	
	<div class="container">
	<!-- ############ Main ############ -->

	<div class="grid-row">
	<div class="grid-8 grid-tablet-12 grid-mobile-12 main">

		<?php
			$args = array(
				'paged' => $paged,
				'ignore_sticky_posts' => false
            );
		
            $wp_query = new WP_Query();
			$wp_query->query($args);

			if ( have_posts() ) : ?>
				

				<?php // Start the Loop.
				while ( have_posts() ) : the_post() ?>

					<div class="list--item">
						<?php if ( is_sticky() ) : ?>
							<article <?php post_class( 'article sticky' ); ?>>
						<?php else : ?>
							<article <?php post_class( 'article' ); ?>>
						<?php endif ?>
							<?php $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $thumb_size ); ?>
							<?php if ( has_post_thumbnail() ) : ?>
								<img class="featured--image" src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php esc_attr_e( 'Post image', 'zona' ) ?>">
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
					            	the_content( );
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