<?php
/**
 * Theme Name: 		Zona - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/zona
 * Author URI: 		http://rascals.eu
 * File:			tag-intro.php
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
$title = '';
$subtitle = esc_html__( 'Here are some news from our music site.', 'zona' );

// Categories
if ( is_category() ) {
	$title = single_cat_title('', false);
	$subtitle = esc_html__( 'PORTALBURN', 'zona' );
}
// Author
elseif ( is_author() ) {
	$author_id = $wp_query->post->post_author;
	$title = get_the_author_meta( 'display_name', $author_id );
	$subtitle = esc_html__( 'Author', 'zona' );
}
// Tags
elseif ( is_tag() ) {
	$title = single_cat_title('', false);
	$subtitle = esc_html__( 'Tag', 'zona' );
}
// Music
elseif ( is_tax( 'zona_music_cats' ) ) {
	$title = single_cat_title('', false);
	$subtitle = esc_html__( 'Music Category', 'zona' );
}
// Events
elseif ( is_tax( 'zona_events_cats' ) ) {
	$title = single_cat_title('', false);
	$subtitle = esc_html__( 'Events Category', 'zona' );
}
// Archive
elseif (is_archive()) {
	if ( is_year() ) {
		$title = get_the_time( 'Y' );
	}
	if ( is_month() ) { 
		$title = get_the_time( 'F, Y' );
	}
	if ( is_day() || is_time() ) {
		$title  = get_the_time( 'l - ' . get_option( 'date_format' ) );
	}
	$subtitle = esc_html__( 'Archives', 'zona' );
}
// Search
elseif ( is_search() ) {
	$title = get_search_query();
	$subtitle = esc_html__( 'Search results for:', 'zona' );
}

?>
<section class="intro intro--page-title intro--category" style="min-height:340px">
	<div class="intro--title">
		<h6><?php echo esc_html( $subtitle ) ?></h6>
		<h1><?php echo esc_html( $title ); ?></h1>
	</div>
</section>