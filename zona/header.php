<?php
/**
 * Theme Name: 		Zona - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/zona
 * Author URI: 		http://rascals.eu
 * File:			header.php
 * =========================================================================================================================================
 *
 * @package zona
 * @since 1.0.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<?php 
    $zona_opts = zona_opts();
?>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>
<?php 
    $page_id = '0';

    if ( isset( $wp_query ) && isset( $post ) ) {
        $page_id = $wp_query->post->ID;
    }
?>
<body <?php body_class() ?> data-page_id="<?php echo esc_attr( $page_id ) ?>" data-wp_title="<?php esc_attr( wp_title( '|', true, 'right' ) ) ?>">

 <!-- ############################# Loader ############################# -->
<?php if ( ! is_customize_preview() ) : ?>
    <?php if ( get_theme_mod( 'zona_loading_animation', true ) ) {
        echo zona_wpal_show_loader();
    } ?>
<?php endif; ?>

<!-- ############################# Layers ############################# -->

<?php if ( get_theme_mod( 'zona_search_button', true ) ) : ?>
<div class="layer--site layer--search anim--reveal-static">
    <a href="#" class="layer--close"></a>
    <div class="layer--content">
        <div class="layer--searchform"><?php get_search_form(); ?></div>
        <span class="search--placeholder">
            <span class="search--placeholder-row search--placeholder-row-1"><span><?php esc_html_e( 'Click and', 'zona' ) ?></span></span>
            <span class="search--placeholder-row search--placeholder-row-2"><span><?php esc_html_e( 'Search', 'zona' )  ?></span></span>
        </span>

    </div>
</div>
<?php endif; ?>

<div class="layer--site layer--nav anim--reveal-static">
    <a href="#" class="layer--close"></a>
    <div class="layer--content">
        <div id="layer--nav-wrapper" class="layer--nav-wrapper">
            
            <?php 

                /* ############ TOP NAVIGATION ############ */
                if ( has_nav_menu( 'top' ) ) {

                    $defaults = array(
                        'theme_location'  => 'top',
                        'menu'            => '',
                        'container'       => false,
                        'container_class' => '',
                        'menu_class'      => 'menu',
                        'fallback_cb'     => 'wp_page_menu',
                        'depth'           => 3
                    );     

                    echo '<nav id="responsive-nav">';
                    wp_nav_menu( $defaults );
                    echo '</nav>'; 
                }
             ?>

        </div>
    </div>
</div>

<?php if ( get_theme_mod( 'zona_header_events', true ) ) : ?>

    <?php 

    // post backup
    $backup  = '';
    if ( isset( $post ) ) { 
        $backup = $post;
    }

    // Begin Loop
    $header_events_args = array(
        'post_type'        => 'zona_events',
        'showposts'        => 10,
        'tax_query'        => array(
            array(
               'taxonomy' => 'zona_event_type',
               'field' => 'slug',
               'terms' => 'future-events'
            )
        ),
        'orderby'          => 'meta_value',
        'meta_key'         => '_event_date_start',
        'order'            => 'ASC',
        'suppress_filters' => 0 // WPML FIX
    );

    $header_events_query = new WP_Query();
    $header_events_query->query( $header_events_args );

    // Date format
    $header_events_date_format = 'd/m';
    if ( $zona_opts->get_option( 'event_date' ) ) {
        $header_events_date_format = $zona_opts->get_option( 'event_date' );
    }

    ?>
            
<?php if ( $header_events_query->have_posts() ) : ?>
<div class="layer--site layer--events anim--reveal-static">
    <a href="#" class="layer--close"></a>
    <div class="layer--content">
        <span class="events--placeholder">
            <span class="events--placeholder-row events--placeholder-row-1"><span><?php esc_html_e( 'Upcoming', 'zona' ) ?></span></span>
            <span class="events--placeholder-row events--placeholder-row-2"><span><?php esc_html_e( 'Events', 'zona' ) ?></span></span>
        </span>
        <div id="layer--events-wrapper">
            <div>
                <ul class="layer--events-list">
                    <?php while ( $header_events_query->have_posts() ) : $header_events_query->the_post(); ?>
                        <?php 
                            /* Event Date */
                            $event_time_start = get_post_meta( $header_events_query->post->ID, '_event_time_start', true );
                            $event_date_start = get_post_meta( $header_events_query->post->ID, '_event_date_start', true );
                            $event_date_start = strtotime( $event_date_start );
                            $event_date_end = strtotime( get_post_meta( $header_events_query->post->ID, '_event_date_end', true ) );
                            /* Event data */
                            $event_place = get_post_meta( $header_events_query->post->ID, '_event_place', true );
                            $event_city = get_post_meta( $header_events_query->post->ID, '_event_city', true );
                        ?>

                    <li>
                        <a href="<?php echo esc_url( get_permalink() ) ?>"><span class="date"><?php echo date_i18n( $header_events_date_format, $event_date_start ); ?></span><span class="title"><?php the_title(); ?><span class="place"><?php echo esc_html( $event_place ) ?></span><span class="localisation"><?php echo esc_html( $event_city ) ?></span></span></a>
                    </li>

                    <?php endwhile ?>
                </ul>
                <br>
                <span class="layer--events-button-wrapper">
                    <a href="<?php echo esc_url( get_theme_mod( 'zona_events_link', '#' ) ) ?>" class="btn--frame btn--medium"><span></span><?php esc_html_e( 'View More Events', 'zona' ) ?></a>
                </span>
            </div>
        </div>
    </div>
</div>
<?php endif; // end have_posts ?>
<?php  
if ( isset( $post ) ) {
    $post = $backup;
} ?>
<?php endif; ?>

<div class="site">

    <?php 
        // Get Custom Header
        get_template_part( 'inc/custom-header' );
    ?>

    <!-- ############################# AJAX CONTAINER ############################# -->
    <div id="ajax-container">
        <div id="ajax-content">