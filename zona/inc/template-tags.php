<?php
/**
 * Theme Name: 		Zona - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/zona
 * Author URI: 		http://rascals.eu
 * File:			template-tags.php
 * =========================================================================================================================================
 *
 * @package zona
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ----------------------------------------------------------------------
	POST PAGINATION
	Display navigation to next/previous set of posts when applicable.
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'zona_paging_nav' ) ) :
function zona_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $GLOBALS['wp_query']->max_num_pages,
		'current'  => $paged,
		'mid_size' => 1,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => esc_html__( '&larr; Prev', 'zona' ),
		'next_text' => esc_html__( 'Next &rarr;', 'zona' ),
	) );

	if ( $links ) :

	?>
	<nav class="navigation paging-navigation">
		<div class="pagination loop-pagination">
			<?php 
			echo paginate_links( array(
				'base'     => $pagenum_link,
				'format'   => $format,
				'total'    => $GLOBALS['wp_query']->max_num_pages,
				'current'  => $paged,
				'mid_size' => 1,
				'add_args' => array_map( 'urlencode', $query_args ),
				'prev_text' => esc_html__( '&larr;', 'zona' ),
				'next_text' => esc_html__( '&rarr;', 'zona' ),
			) );

			?>
		</div><!-- .pagination -->
	</nav><!-- .navigation -->
	<?php
	endif;
}
endif;


/* ----------------------------------------------------------------------
	POST NAVIGATION
	Display navigation to next/previous post when applicable.
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'zona_post_nav' ) ) :
function zona_post_nav() {
	global $post;
	
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	$post_type = get_post_type( $post->ID );

	if ( ! $next && ! $previous ) {
		return;
	}

	$next_label = esc_html__( 'Next Article', 'zona' );
	$prev_label = esc_html__( 'Previous Article', 'zona' );


	$next_link = get_adjacent_post( false,'',false );          
	$prev_link = get_adjacent_post( false,'',true ); 

	$next_post_thumb = '';
	$prev_post_thumb = '';
	?>
	<nav class="post--navigation grid-row">
		<?php
			
			if ( $prev_link  ) {
				echo '<div class="grid-6 grid-mobile-12 prev--link"><figure>';
				if ( $prev_link ) {
					if ( has_post_thumbnail( $prev_link->ID ) ) {
					 	$prev_post_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $prev_link->ID ), 'large' );
					 	echo '<span class="post--nav-preview" style="background-image:url(' . esc_url( $prev_post_thumb[0] ). ')" data-bg-cover="cover"></span>';
					}
				}
				 				
				echo '<figcaption>
				<h4>' . get_the_title( $prev_link->ID ) . '</h4>
				<a href="' . esc_url( get_permalink( $prev_link->ID ) ) . '">' . esc_html( $prev_label ) . '</a>
				</figcaption>
				</figure>
				</div>';
			}

			if ( $next_link ) {
				echo '<div class="grid-6 grid-mobile-12 next--link"><figure>';
			 	if ( $next_link ) {
					if ( has_post_thumbnail( $next_link->ID ) ) {
					 	$next_post_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next_link->ID ), 'large' );
					 	echo '<span class="post--nav-preview" style="background-image:url(' . esc_url( $next_post_thumb[0] ) . ')" data-bg-cover="cover"></span>';
					}
				}			
				echo '<figcaption>
					<h4>' . get_the_title( $next_link->ID ) . '</h4>
					<a href="' . esc_url( get_permalink( $next_link->ID ) ) . '">' . esc_html( $next_label ) . '</a>
					</figcaption>
					</figure>
					</div>';
			} 
		?>
	</nav><!-- .navigation -->
	<?php
}
endif;


/* ----------------------------------------------------------------------
	POST NAVIGATION WITH CUSTOM ORDER
	Display navigation to next/previous post with custom order for special CP.
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'zona_custom_post_nav' ) ) :
function zona_custom_post_nav() {
	global $post;

	if ( isset( $post ) ) {
		$backup = $post;
	} else {
		return false;
	}
	if ( ! is_single() ) {
		return false;
	}

	$output = '';
	$post_type = get_post_type($post->ID);
	$id = $post->ID;
	$count = 0;
	$prev_id = '';
	$next_id = '';
	$posts = array();


	if ( $post_type == 'zona_music' ||  $post_type == 'zona_events' || $post_type == 'zona_gallery' ) {

		// Release
		if ( $post_type == 'zona_music' ) {
			
			$args = array(
				'post_type' => 'zona_music',
				'showposts'=> '-1'
			);
		
			$args['orderby'] = 'menu_order';
			$args['order'] = 'ASC';
		}


		// Gallery
		if ( $post_type == 'zona_gallery' ) {
			
			$args = array(
				'post_type' => 'zona_gallery',
				'showposts'=> '-1'
			);
	
		}

		// Events
		if ( $post_type == 'zona_events' ) {
			if ( is_object_in_term( $post->ID, 'zona_event_type', 'future-events' ) ) {
				$event_type = 'future-events';
			} else {
				$event_type = 'past-events';
			}
			$order = $event_type == 'future-events' ? $order = 'ASC' : $order = 'DSC';
			$args = array(
				'post_type' => 'zona_events',
				'tax_query' => 
					array(
						array(
						'taxonomy' => 'zona_event_type',
						'field' => 'slug',
						'terms' => $event_type
						)
					),
				'showposts'=> '-1',
				'orderby' => 'meta_value',
				'meta_key' => '_event_date_start',
				'order' => $order
			);
		}

		// Nav loop
		$nav_query = new WP_Query();
		$nav_query->query( $args );
		if ( $nav_query->have_posts() )	{
			while ( $nav_query->have_posts() ) {
				$nav_query->the_post();
				$posts[] = get_the_id();
				if ( $count == 1 ) break;
				if ( $id == get_the_id() ) $count++;
			}
			$current = array_search( $id, $posts );

			// Check IDs
			if ( isset( $posts[$current-1] ) ) {
				$prev_id = $posts[$current-1];
			}
			if ( isset( $posts[$current+1] ) ) {
				$next_id = $posts[$current+1];
			}

			// Display nav
			$output = '';

			if ( $next_id !== '' ) {
				$output .= '<div class="custom-post-nav next-post">' . esc_html__( 'Next:', 'zona' ) . '<a href="' . esc_url( get_permalink( $next_id ) ) . '">' . get_the_title( $next_id  ) . '</a></div>';
			}
			if ( $prev_id !== '' ) {
				$output .= '<div class="custom-post-nav prev-post">' . esc_html__( 'Previous:', 'zona' ) . '<a href="' . esc_url( get_permalink( $prev_id ) ) . '">' . get_the_title( $prev_id  ) . '</a></div>';
			} 

		}

		if ( isset( $post ) ) {
			$post = $backup;
		}
		
		return $output;
	} else {
		return false;
	}
}
endif;