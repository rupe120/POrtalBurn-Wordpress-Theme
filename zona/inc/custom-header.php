<?php
/**
 * Theme Name: 		Zona - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/zona
 * Author URI: 		http://rascals.eu
 * File:			custom-header.php
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


?>


<?php 
	
	// ==================================================== HELPERS ====================================================

	
	// ========= Defaults values for social icons ==========
	$header_social_defaults = array(
        array(
            'social_type' => 'facebook',
            'social_link'  => '#',
        ),
        array(
            'social_type' => 'twitter',
            'social_link'  => '#',
        ),
        array(
            'social_type' => 'soundcloud',
            'social_link'  => '#',
        ),
        array(
            'social_type' => 'mixcloud',
            'social_link'  => '#',
        ),
        array(
            'social_type' => 'spotify',
            'social_link'  => '#',
        )
    );


	// ========= Defaults values for top navigation ==========
     $defaults = array(
            'theme_location'  => 'top',
            'menu'            => '',
            'container'       => false,
            'container_class' => '',
            'menu_class'      => 'menu',
            'fallback_cb'     => 'wp_page_menu',
            'depth'           => 3
        );             

	// ========= Get Recent Event ==========

	if ( get_theme_mod( 'zona_header_events', true ) ) : ?>

    <?php 

    // post backup
    $backup  = '';
    if ( isset( $post ) ) { 
        $backup = $post;
    }

    $most_recent_event = '';

    // Begin Loop
    $recent_event_args = array(
        'post_type'        => 'zona_events',
        'showposts'        => 1,
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

    $recent_event_query = new WP_Query();
    $recent_event_query->query( $recent_event_args );

    // Date format
    $header_events_date_format = 'd/m';
    if ( $zona_opts->get_option( 'event_date' ) ) {
        $header_events_date_format = $zona_opts->get_option( 'event_date' );
    }

    ?>
            
<?php if ( $recent_event_query->have_posts() ) : ?>
	<?php while ( $recent_event_query->have_posts() ) : $recent_event_query->the_post(); ?>

	    <?php 
	    /* Event Date */
        $event_time_start = get_post_meta( $recent_event_query->post->ID, '_event_time_start', true );
        $event_date_start = get_post_meta( $recent_event_query->post->ID, '_event_date_start', true );
        $event_date_start = strtotime( $event_date_start );
        $event_date_end = strtotime( get_post_meta( $recent_event_query->post->ID, '_event_date_end', true ) );
        /* Event data */
        $event_place = get_post_meta( $recent_event_query->post->ID, '_event_place', true );
        $event_city = get_post_meta( $recent_event_query->post->ID, '_event_city', true );
	    $most_recent_event = '<a href="' . esc_url( get_permalink() ) . '" class="event">
	        <span class="date">' . date_i18n( $header_events_date_format, $event_date_start ) . '</span>
	        <span class="location">' . get_the_title() . '<span>' . esc_html( $event_place ) .  '</span></span>
	    </a>';
	    ?>
<?php endwhile ?>
            
<?php endif; // end have_posts ?>
<?php  
if ( isset( $post ) ) {
    $post = $backup;
} ?>
<?php endif; ?>

<?php 
// ==================================================== HEADER ====================================================

$header_style = get_theme_mod( 'zona_header_styles', 'header-style-1' )
 ?>
<div class="header main-header">


	<?php 
	// ==================================================== Advanced 01 ====================================================

	if ( $header_style === 'header-style-1' || $header_style === 'header-style-2' ) : ?>

    <div class="header--moving">
        <div class="container">
            <div class="header--top-bar">
                <?php if ( get_theme_mod( 'zona_header_wpml' ) ) : ?>
                    <?php zona_languages_list( 'header-lang-selector', get_theme_mod( 'zona_header_wpml_display', 'language_codes' ) ) ?>
                <?php endif; ?>
            </div>
            <div class="header--top">
                <div class="header--social">
                    <?php
                    if ( function_exists( 'zona_social_buttons' ) ) {
                        echo zona_social_buttons( get_theme_mod( 'zona_header_social_buttons_a', $header_social_defaults ) );
                    }
                    ?>
                </div>
                <!-- ############################# Logo ############################# -->
            	<div id="site-logo" class="header--logo">
                    <?php zona_header_logo(); ?>
                </div>
                <div class="header--extra">
                    <?php if ( get_theme_mod( 'zona_search_button', true ) ) : ?>
                    <div class="header--search">
                        <a href="#show-search" class="btn--icon-square btn--frame btn--dark"><span></span><span class="icon icon-search"></span></a>
                        <a href="#show-search" class="header--search-responsive btn--icon"><span class="icon icon-search"></span></a>
                    </div>
                    <?php endif; ?>
                    <?php if ( get_theme_mod( 'zona_header_events', true ) && $most_recent_event != '' ) : ?>
                    <div class="header--events events--simple-list">
                        <?php echo wp_kses_post( $most_recent_event ); ?>
                        <a href="#show-events" class="events--more">...</a>
                        <a href="#show-events" class="header--events-responsive btn--icon"><span class="icon icon-calendar"></span></a>
                    </div>

                    <?php endif; ?>
                </div>
                
            </div>
        </div>
        <div class="nav--wrapper">
            <div class="container">
                <!-- ############################# Navigation ############################# -->
                <?php if ( has_nav_menu( 'top' ) ) : ?>
                <nav id="nav">
                    <?php wp_nav_menu( $defaults ); ?>
                </nav>
                <?php endif; ?>
                <!-- Responsive Button -->
                <a href="#" class="nav--responsive-trigger"><span class="icon"></span></a>
                <!-- Events -->
                <?php if ( get_theme_mod( 'zona_header_events', true ) ) : ?>
                <a href="#show-events" class="nav--responsive-events btn--icon"><span class="icon icon-calendar"></span></a>
                <?php endif; ?>
                <!-- Search -->
                <?php if ( get_theme_mod( 'zona_search_button', true ) ) : ?>
                <a href="#show-search" class="nav--responsive-search btn--icon"><span class="icon icon-search"></span></a>
                <?php endif; ?>
            </div>
        </div>
    </div>

	<?php 
	// ==================================================== Advanced 02 ====================================================

	elseif ( 
        $header_style === 'header-style-3' || 
        $header_style === 'header-style-4' || 
        $header_style === 'header-style-5' || 
        $header_style === 'header-style-6' ) : ?>

    <div class="header--moving">
        <?php if ( $header_style === 'header-style-5' || $header_style === 'header-style-6' ) : ?><div class="header--top-wrap"><?php endif ?>
        <div class="container">
            <div class="header--top">
                 
                 <?php if ( get_theme_mod( 'zona_header_wpml' ) ) : ?>
                    <?php zona_languages_list( 'header-lang-selector', get_theme_mod( 'zona_header_wpml_display', 'language_codes' ) ) ?>
                <?php endif; ?>

                <div class="header--social">
                    <?php
                    if ( function_exists( 'zona_social_buttons' ) ) {
                        echo zona_social_buttons( get_theme_mod( 'zona_header_social_buttons_a', $header_social_defaults ) );
                    }
                    ?>
                </div>
                
            </div>
        </div>
        <?php if ( $header_style === 'header-style-5' || $header_style === 'header-style-6' ) : ?></div><?php endif ?>
        <div class="nav--wrapper">
            <div class="container">
				
				<!-- ############################# Logo ############################# -->
            	<div id="site-logo" class="header--logo">
                    <?php zona_header_logo(); ?>
                </div>
                
               
               <div class="header--buttons">
                    <!-- Events -->
                    <?php if ( get_theme_mod( 'zona_header_events', true ) ) : ?>
                    <a href="#show-events" class="btn--icon"><span class="icon icon-calendar"></span></a>
                    <?php endif; ?>
                   
                    <!-- Cart -->
                    <?php if ( get_theme_mod( 'zona_cart_button', true ) ) : ?>
                        <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                            <?php 

                                global $woocommerce;
                                $count = $woocommerce->cart->cart_contents_count;
                                $wc_link = $woocommerce->cart->get_cart_url();
                                if ( get_theme_mod( 'zona_cart_link', 'shop' ) == 'shop' ) {
                                    $wc_link = get_permalink( get_option( 'woocommerce_shop_page_id' ) );
                                } 

                            ?>
                    
                            <a href="<?php echo esc_url( $wc_link ) ?>" id="shop-link" class="btn--icon"><span class="icon icon-cart"></span>
                            <span class='shop-items-count'><i><?php echo esc_attr( $count ) ?></i></span></a>
                        <?php endif ?>
                    <?php endif ?>

                    <!-- Search -->
                    <?php if ( get_theme_mod( 'zona_search_button', true ) ) : ?>
                    <a href="#show-search" class="btn--icon"><span class="icon icon-search"></span></a>
                    <?php endif; ?>

                     <!-- Responsive Button -->
                    <a href="#" class="nav--responsive-trigger"><span class="icon"></span></a>
                </div>

                <!-- ############################# Navigation ############################# -->
                <?php if ( has_nav_menu( 'top' ) ) : ?>
                <nav id="nav">
                    <?php wp_nav_menu( $defaults ); ?>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>


    <?php 
    // ==================================================== Simply 01 ====================================================

    elseif ( 
        $header_style === 'header-style-7' || 
        $header_style === 'header-style-8' ||
        $header_style === 'header-style-9' ||
        $header_style === 'header-style-10' ||
        $header_style === 'header-style-11' ||
        $header_style === 'header-style-12' ||
        $header_style === 'header-style-13' ||
        $header_style === 'header-style-14' ) : ?>

    <div class="header--wrap">
        <div class="nav--wrapper">
            <div class="container">
                
                <!-- ############################# Logo ############################# -->
                <div id="site-logo" class="header--logo">
                    <?php zona_header_logo(); ?>
                </div>
                <div class="header--buttons">
                    <!-- Events -->
                    <?php if ( get_theme_mod( 'zona_header_events', true ) ) : ?>
                    <a href="#show-events" class="btn--icon"><span class="icon icon-calendar"></span></a>
                    <?php endif; ?>
                   
                    <!-- Cart -->
                    <?php if ( get_theme_mod( 'zona_cart_button', true ) ) : ?>
                        <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                            <?php 

                                global $woocommerce;
                                $count = $woocommerce->cart->cart_contents_count;
                                $wc_link = $woocommerce->cart->get_cart_url();
                                if ( get_theme_mod( 'zona_cart_link', 'shop' ) == 'shop' ) {
                                    $wc_link = get_permalink( get_option( 'woocommerce_shop_page_id' ) );
                                } 

                            ?>
                    
                            <a href="<?php echo esc_url( $wc_link ) ?>" id="shop-link" class="btn--icon"><span class="icon icon-cart"></span>
                            <span class='shop-items-count'><i><?php echo esc_attr( $count ) ?></i></span></a>
                        <?php endif ?>
                    <?php endif ?>

                    <!-- Search -->
                    <?php if ( get_theme_mod( 'zona_search_button', true ) ) : ?>
                    <a href="#show-search" class="btn--icon"><span class="icon icon-search"></span></a>
                    <?php endif; ?>

                     <!-- Responsive Button -->
                    <a href="#" class="nav--responsive-trigger"><span class="icon"></span></a>
                </div>
                
                <?php if ( $header_style !== 'header-style-13' && $header_style !== 'header-style-14' ) : ?>
                    <!-- ############################# Navigation ############################# -->
                    <?php if ( has_nav_menu( 'top' ) ) : ?>
                    <nav id="nav">
                        <?php wp_nav_menu( $defaults ); ?>
                    </nav>
                    <?php endif; ?>
                <?php else: ?>

                    <div class="header--social">
                    <?php
                    if ( function_exists( 'zona_social_buttons' ) ) {
                        echo zona_social_buttons( get_theme_mod( 'zona_header_social_buttons_a', $header_social_defaults ) );
                    }
                    ?>
                </div>

                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php endif; ?>
</div>