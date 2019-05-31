<?php
/**
 * Theme Name: 		Zona - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/zona
 * Author URI: 		http://rascals.eu
 * File:			helpers.php
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
    Show Ajax Loader
/* ---------------------------------------------------------------------- */

function zona_wpal_show_loader() {
        
    $loader = '<div class="ajax--loader"></div>';
    if( has_filter('zona_wpal_change_loader') ) {
        $loader = apply_filters( 'zona_wpal_change_loader', $loader );
    }
    return '<div id="loading-layer" class="wpal-loading-layer show-layer">' . $loader . '</div>';
}



/* ----------------------------------------------------------------------
    Copyright Note
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'zona_copyright_note' ) ) :
function zona_copyright_note() {

    echo wp_kses_post( get_theme_mod( 'zona_copyright_note', '&copy; Copyright 2017 ZONA. Powered by <a href="#" target="_blank">Rascals Themes</a>. Handcrafted in Europe.' ) );
}
endif;


/* ----------------------------------------------------------------------
    Header Logo
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'zona_header_logo' ) ) :
function zona_header_logo() {

    if ( get_theme_mod( 'zona_logo_alt' ) ) {
        $logo_classes = 'is-logo-alt';
    } else {
        $logo_classes = '';
    }
    echo '<a href="' . esc_url( home_url('/') ) . '" class="theme--logo ' . esc_attr( $logo_classes ) . '">';
    if ( get_theme_mod( 'zona_logo' ) ) {
                
        echo '<img src="' . esc_url( get_theme_mod( 'zona_logo' ) ) . '" class="theme--logo-img" alt="' . esc_attr__( 'Logo Image', 'zona' ) . '">';
    } else {
        echo '<img src="' . esc_url( get_template_directory_uri() . '/images/logo.png' ) . '" class="theme--logo-img" alt="' . esc_attr__( 'Logo Image', 'zona' ) . '">';
    }

    if ( get_theme_mod( 'zona_logo_alt' ) ) {
                
        echo '<img src="' . esc_url( get_theme_mod( 'zona_logo_alt' ) ) . '" class="theme--logo-img-alt" alt="' . esc_attr__( 'Logo Image Alt', 'zona' ) . '">';
    } 
    echo '</a>';

}
endif;


/* ----------------------------------------------------------------------
    WPML LANGUAGE SELECTOR
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'zona_languages_list' ) ) :
function zona_languages_list( $id = '', $display ){
    if ( function_exists( 'icl_get_languages' ) ) {

        $languages = icl_get_languages( 'skip_missing=0&orderby=code' );
        if ( ! empty( $languages ) ) {
            if ( $id != '' ) {
                echo '<div id="' . esc_attr($id) . '" class="lang-selector"><ul>';
            } else {
                 echo '<div class="lang-selector"><ul>';
            }
            foreach($languages as $l){
                echo '<li>';

                if ( $display == 'flags' ||  $display == 'language_codes_flags'  ) {
                    if ( $l['country_flag_url'] ) {
                        if ( ! $l[ 'active' ] ) {
                            echo '<a href="'. esc_url( $l['url'] ) . '">';
                        }
                        echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
                        if ( ! $l['active'] ) {
                            echo '</a>';
                         }
                     }

                }

                if ( $display != 'flags' ) {
                    if ( ! $l[ 'active' ] ) {
                        echo '<a href="'. esc_url( $l['url'] ) . '">';
                    }
                    echo esc_attr( $l['language_code'] );

                    if ( ! $l['active'] ) {
                        echo '</a>';
                    }
                    echo '</li>';
                }
            }
            echo '</ul></div>';
        }
    }
}
endif;

/* ----------------------------------------------------------------------
	COMMENTS LIST
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'zona_comments' ) ) :
function zona_comments( $comment, $args, $depth ) {

    $zona_opts = zona_opts();

    $GLOBALS['comment'] = $comment; 

    // Date format
    $date_format = 'd/m/y';

    if ( $zona_opts->get_option( 'custom_comment_date' ) ) {
    	$date_format = $zona_opts->get_option( 'custom_comment_date' );
    }
    ?>

    <!-- Comment -->
    <li id="li-comment-<?php comment_ID() ?>" <?php comment_class( 'theme_comment' ); ?>>
        <article id="comment-<?php comment_ID(); ?>">
            <div class="avatar-wrap">
                <?php echo get_avatar( $comment, '100' ); ?>
            </div>
            <div class="comment-meta">
                <h5 class="author"><?php comment_author_link(); ?></h5>
                <p class="date"><?php comment_date( $date_format ); ?> <span class="reply"><?php comment_reply_link( array_merge( $args, array( 'reply_text' => esc_html__('Reply', 'zona' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span></p>
            </div>
            <div class="comment-body">
                <?php comment_text(); ?>
                <?php if ( $comment->comment_approved == '0' ) : ?>
                <p class="message info"><?php esc_html_e( 'Your comment is awaiting moderation.', 'zona' ); ?></p>
                <?php endif; ?> 
            </div>
        </article>
<?php 
}
endif;


/* ----------------------------------------------------------------------
    SLIDER GET LIST ARRAY

    return: array or false

/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'zona_get_slider' ) ) :

    function zona_get_slider( $slider_id, $opt_name = '_custom_slider' ) {


        /* Images ids */
        $images_ids = get_post_meta( $slider_id, $opt_name, true );

        if ( ! $images_ids || $images_ids == '' ) {
             return false;
        }

        $count = 0;
        $ids = explode( '|', $images_ids );


        $defaults = array(
            'title' => '',
            'subtitle' => '',
            'slider_button_url' => '',
            'slider_button_target' => '_self',
            'slider_button_title'  => esc_html__( 'Read More', 'zona' )
        );

        $slider = array();

        /* Start Loop */
        foreach ( $ids as $id ) {

            // Vars 
            $title = '';
            $subtitle = '';

            // Get image data
            $image_att = wp_get_attachment_image_src( $id );

            if ( ! $image_att[0] ) {
                continue;
            }

            /* Count */
            $count++;

            /* Get meta */
            $slide = get_post_meta( $slider_id, $opt_name . '_' . $id, true );

            /* Add default values */
            if ( isset( $slide ) && is_array( $slide ) ) {
                $slide = array_merge( $defaults, $slide );
            } else {
                $slide = $defaults;
            }

            /* Add image src to array */
            $slide['src'] = wp_get_attachment_url( $id );

            array_push( $slider, $slide );
        }
        
        return $slider;
    }
endif; // End check for function_exists()


/* ----------------------------------------------------------------------
	TAG CLOUD FILTER
/* ---------------------------------------------------------------------- */
function zona_tag_cloud_filter( $args = array() ) {
   $args['smallest'] = 12;
   $args['largest'] = 12;
   $args['unit'] = 'px';
   return $args;
}

add_filter( 'widget_tag_cloud_args', 'zona_tag_cloud_filter', 90 );


/* ----------------------------------------------------------------------
    CUSTOM AJAX LOADER (CONTACT FORM 7)
/* ---------------------------------------------------------------------- */

function zona_wpcf7_ajax_loader () {
    return  get_template_directory_uri() . '/images/ajax-loader.gif';
}
add_filter( 'wpcf7_ajax_loader', 'zona_wpcf7_ajax_loader' );


/* ----------------------------------------------------------------------
	NICE TITLE FILTER
/* ---------------------------------------------------------------------- */
/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
*/
if ( ! function_exists( 'zona_wp_title' ) ) :
function zona_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = esc_html( "$title $sep " . sprintf( esc_html__( 'Page %s', 'zona' ), max( $paged, $page ) ) );
	}

	return $title;
}
add_filter( 'wp_title', 'zona_wp_title', 10, 2 );
endif;


/* ----------------------------------------------------------------------
    SHARE BUTTONS
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'zona_meta_share_buttons' ) ) :
function zona_meta_share_buttons( $post_id ) {
    return '<div class="share-buttons">
            <a class="circle-btn share-button fb-share-btn" target="_blank" href="http://www.facebook.com/sharer.php?u=' . esc_url( get_permalink( $post_id ) ) . '"><span class="icon icon-facebook"></span></a>
            <a class="circle-btn share-button twitter-share-btn" target="_blank" href="http://twitter.com/share?url=' . esc_url( get_permalink( $post_id ) ) . '"><span class="icon icon-twitter"></span></a>
            <a class="circle-btn share-button gplus-share-btn" target="_blank" href="https://plus.google.com/share?url=' . esc_url( get_permalink( $post_id ) ) . '"><span class="icon icon-googleplus"></span></a>
        </div>';

}
endif;

if ( ! function_exists( 'zona_share_buttons' ) ) :
function zona_share_buttons( $post_id ) {
    return '<div class="share-buttons">
            <a class="share-button fb-share-btn" target="_blank" href="http://www.facebook.com/sharer.php?u=' . esc_url( get_permalink( $post_id ) ) . '"><span class="icon icon-facebook"></span></a>
            <a class="share-button twitter-share-btn" target="_blank" href="http://twitter.com/share?url=' . esc_url( get_permalink( $post_id ) ) . '"><span class="icon icon-twitter"></span></a>
            <a class="share-button gplus-share-btn" target="_blank" href="https://plus.google.com/share?url=' . esc_url( get_permalink( $post_id ) ) . '"><span class="icon icon-googleplus"></span></a>
        </div>';

}
endif;


/* ----------------------------------------------------------------------
    SOCIAL BUTTONS
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'zona_social_buttons' ) ) :
function zona_social_buttons( $buttons ) {
    
    if ( isset( $buttons ) && is_array( $buttons ) && ! empty( $buttons ) ) {
        $html = '';

        foreach ( $buttons as $button ) {
            $html .= '<a href="' . esc_url( $button['social_link'] ) . '" class="btn--social" target="_blank"><span class="icon icon-' . esc_attr( $button['social_type'] ) . '"></span></a>';
        }

        return $html;

    }

}
endif;


/* ----------------------------------------------------------------------
    BODY CLASS
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'zona_body_class' ) ) :
function zona_body_class( $classes ) {
    
    global $wp_query;

    

    // Animations
    if ( get_theme_mod( 'zona_content_animations', true ) ) {
        $classes[] = 'is-anim';
    }
    
    // Layout
    if ( get_theme_mod( 'zona_fullwidth', false ) ) {
        $classes[] = 'fullwidth';
    } else {
        $classes[] = 'boxed';
    }

    // Header styles
    $header_classes = array(
        'header-style-1' => 'header-style-1',
        'header-style-2' => 'header-style-2 header-fullwidth',
        'header-style-3' => 'header-style-3 header-advanced',
        'header-style-4' => 'header-style-4 header-advanced header-fullwidth',
        'header-style-5' => 'header-style-5 header-advanced',
        'header-style-6' => 'header-style-6 header-advanced header-fullwidth',
        'header-style-7' => 'header-style-7 header-simple header-static',
        'header-style-8' => 'header-style-8 header-simple header-static header-fullwidth',
        'header-style-9' => 'header-style-9 header-simple header-fixed',
        'header-style-10' => 'header-style-10 header-simple header-fixed header-fullwidth',
        'header-style-11' => 'header-style-11 header-simple header-fixed',
        'header-style-12' => 'header-style-12 header-simple header-fixed header-fullwidth',
        'header-style-13' => 'header-style-13 header-simple header-minimal header-fixed',
        'header-style-14' => 'header-style-14 header-simple header-minimal header-fixed header-fullwidth'
    );

    // Intro
    if ( isset( $wp_query ) && isset( $wp_query->post->ID ) ) {

        $intro_type = get_post_meta( $wp_query->post->ID, '_intro_type', true );
        if ( ! $intro_type ) {
            $intro_type = 'simple_page_title';
        }

        if ( $intro_type != 'simple_page_title' && $intro_type != 'disabled' ) {
            $header_classes['header-style-11'] = 'has-intro header-style-11 header-overlay header-simple header-fixed';
            $header_classes['header-style-12'] = 'has-intro header-style-12 header-overlay header-simple header-fixed header-fullwidth';
            $header_classes['header-style-13'] = 'has-intro header-style-13 header-overlay header-simple header-minimal header-fixed';
            $header_classes['header-style-14'] = 'has-intro header-style-14 header-overlay header-simple header-minimal header-fixed header-fullwidth';
        }
    }
    $header_style = esc_attr( get_theme_mod( 'zona_header_styles', 'header-style-1' ) );
    $classes[] = $header_classes[ $header_style ];
    return $classes;
     
}
add_filter( 'body_class', 'zona_body_class' );
endif;


/* ----------------------------------------------------------------------
    IMAGES BUTTONS
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'zona_images_buttons' ) ) :
function zona_images_buttons( $content ) {
    
    if ( $content === '' ) {
        return;
    }
    $buttons = preg_replace( '/\n$/','',preg_replace('/^\n/','',preg_replace('/[\r\n]+/',"\n", $content ) ) );
    $buttons = explode( "\n", $buttons );
    $html = '';

    if ( is_array( $buttons ) ) {
        foreach ( $buttons as $button ) {
            $button = explode( "|", $button );
            if ( is_array( $button ) ) {
                if ( $button[0] == 'custom' && $button[3] != ''  ) {
                    $html .= '<a href="' . esc_url( $button[1] ) . '" class="btn--image" target="' . esc_attr( $button[2] ) . '"><img src="' . esc_url( $button[3] ) . '"  alt="' . esc_attr__( 'Image button', 'zona' ) . '"></a>';
                } else {
                    $html .= '<a href="' . esc_url( $button[1] ) . '" class="btn--image" target="' . esc_attr( $button[2] ) . '"><img src="' . esc_url( get_template_directory_uri() . '/images/badge-' . $button[0] . '.png' ) . '"  alt="' . esc_attr__( 'Image button', 'zona' ) . '"></a>';
                }
            }
        }
    }

    return $html;

}
endif;


/* ----------------------------------------------------------------------
    SIMPLE BUTTONS
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'zona_simple_buttons' ) ) :
function zona_simple_buttons( $content ) {
    
    if ( $content === '' ) {
        return;
    }
    $buttons = preg_replace( '/\n$/','',preg_replace('/^\n/','',preg_replace('/[\r\n]+/',"\n", $content ) ) );
    $buttons = explode( "\n", $buttons );
    $html = '';

    if ( is_array( $buttons ) ) {
        foreach ( $buttons as $button ) {
            $button = explode( "|", $button );
            if ( is_array( $button ) ) {
             
                $html .= '<a href="' . esc_url( $button[1] ) . '" class="btn--simple" target="' . esc_attr( $button[2] ) . '">' . esc_html( $button[0] ) . '</a>';
                
            }
        }
    }

    return $html;

}
endif;


/* ----------------------------------------------------------------------
    SHARE OPTIONS
 ------------------------------------------------------------------------*/
if ( ! function_exists( 'zona_share_options' ) ) :
function zona_share_options() {
    global $wp_query; 
    if ( is_single() || is_page() ) { 

        // URL
        echo "\n" .'<meta property="og:url" content="' . esc_url( get_permalink( $wp_query->post->ID ) ) . '"/>' . "\n";
        
        // Title
        $share_title = get_post_meta( $wp_query->post->ID, '_share_title', true );
        if ( isset( $share_title ) && $share_title != '' ) {
             echo "\n" .'<meta property="og:title" content="' . esc_attr( $share_title ) . '"/>' . "\n";     
        } else {
            // Site name
            echo "\n" .'<meta property="og:title" content="' . esc_attr( get_bloginfo('name') ) . '"/>' . "\n";     
        }

        // Description
        $share_description = get_post_meta( $wp_query->post->ID, '_share_description', true );
        if ( isset( $share_description ) && $share_description != '' ) {
             echo "\n" .'<meta property="og:description" content="' . esc_attr( $share_description ) . '"/>' . "\n";     
        }

        // Image
        $share_image = get_post_meta( $wp_query->post->ID, 'share_image', true );
        if ( isset( $share_image ) ) {
            $image_attributes = wp_get_attachment_image_src( $share_image, 'full' );
            if ( $image_attributes ) {
                echo "\n" .'<meta property="og:image" content="' . esc_attr( $image_attributes[0] ) . '"/>' . "\n";
            }
        }  

    }
}
add_action( 'wp_head', 'zona_share_options' ); 
endif;


/* ----------------------------------------------------------------------
    AJAX FILTERS
 ------------------------------------------------------------------------*/

// BLOG GRID
function zona_blog_filter() {

    $zona_opts = zona_opts();

    $nonce = $_POST['ajax_nonce'];
    $obj = $_POST['obj'];
    $output = '';


    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
        die( 'Busted!' );
    }
    if ( ! isset( $obj ) ) {
        die();
    }

    // Thumb Size
    $thumb_size = $obj['thumb_size'];

    // Show featured
    $show_featured = $obj['show_featured'];

    // Date format
    $date_format = get_option( 'date_format' );

    // Pagenum
    $obj['pagenum'] = isset( $obj['pagenum'] ) ? absint( $obj['pagenum'] ) : 1;

    // Begin Loop
    $args = array(
        'post_type' => $obj['cpt'],
        'post_status'     => 'publish'
    );

    if ( $obj[ 'filterby' ] == 'taxonomy' && $obj[ 'filter_name' ] != 'all' ) {
         $args['tax_query'] = array(
            array(
                'taxonomy' => $obj[ 'tax'],
                'field' => 'term_id',
                'terms' => $obj[ 'filter_name' ],
            )
        );
    }

    // Posts count
    $temp_args = $args;
    $temp_args['showposts'] = -1;
    $temp_query_count = new WP_Query();
    $temp_query_count->query( $temp_args );
    if ( $temp_query_count->post_count <= ( $obj['limit'] * $obj['pagenum'] ) ) {
        $posts_nr = 'end-posts';
    } else {
        $posts_nr = '';
    }

    // Args
    $args[ 'offset' ] = $obj[ 'pagenum' ] > 1 ? $obj['limit'] * ( $obj['pagenum'] - 1 ) : 0;
    $args[ 'showposts' ] = $obj['limit'];
    
    $ajax_query = new WP_Query();
    $ajax_query->query( $args );

    // Begin Loop
    if ( $ajax_query->have_posts() ) {
        
        while ( $ajax_query->have_posts() ) {
            $ajax_query->the_post();


            $output .= '<div class="grid--item item-anim anim-fadeup ' . esc_attr( $obj['cols_layout'] ) . ' grid-tablet-12 grid-mobile-12 ' . esc_attr( $posts_nr ) . '">';
            $output .= '<article class="' . esc_attr( implode( ' ', get_post_class( 'article-is-ajaxed', $ajax_query->post->ID ) ) ) . '">';

            $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $ajax_query->post->ID ), $thumb_size );
            if ( $show_featured && $show_featured == 'on' ) {
                $output .= '<img class="featured--image" src="' . esc_url( $img_src[0] ) . '" alt="' . esc_attr__( 'Post image', 'zona' ) .'">';
            }
            $output .= '<div class="article--preview">';
            $output .= '<figure style="background-image: url( '. esc_url( $img_src[0] ) . ')">></figure>';
            $output .= '</div>';
                  
            $output .= '<h2 class="article--title"><a href="' . esc_url( get_permalink() ) . '" >' . get_the_title() . '</a></h2>';
            $output .= '<div class="article--excerpt">';
            if (  has_excerpt() ) {
                $output .=  wp_trim_words( get_the_excerpt(), 30, ' [...]' );
            } else {
                $output .= wp_trim_words( strip_shortcodes( get_the_content() ), 30, ' [...]' ); 
            }
            $output .= '</div>';
            $output .= '<footer class="article--footer meta--cols">';
            $output .= '<div class="meta--col">';
            $output .= '<span class="meta--author-image">' . get_avatar( get_the_author_meta( 'email' ), '50' ) .'</span>';
            $output .= '<div class="meta--author">';
            $output .= esc_html__( 'by', 'zona' ) . ' <a href="' . get_author_posts_url( $ajax_query->post->post_author ) . '" class="author-name">' . esc_html( get_the_author_meta( 'display_name', $ajax_query->post->post_author ) ) . '</a><br>';
            $output .= '<span class="meta--date">' . get_the_time( $date_format ) .'</span>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '<div class="meta--col meta--col-link">';
            $output .= '<a href="' . esc_url( get_permalink() ) . '" class="btn--read-more meta--link">' . esc_html__( 'Read more', 'zona' ) . '</a>';
            $output .= '</div>';
            $output .= '</footer>';
            $output .= '</article>';
            $output .= '</div>';

           
        } 
       
        $zona_opts->e_esc( $output );

        die();
        return;
    } // end have_posts

    echo 'no_results';

    die();
    return;
    
}
add_action('wp_ajax_nopriv_zona_blog_filter', 'zona_blog_filter');
add_action('wp_ajax_zona_blog_filter', 'zona_blog_filter');


// Music
function zona_music_filter() {

    $zona_opts = zona_opts();

    $nonce = $_POST['ajax_nonce'];
    $obj = $_POST['obj'];
    $output = '';

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
        die( 'Busted!' );
    }
    if ( ! isset( $obj ) ) {
        die();
    }

    // Date format
    $date_format = get_option( 'date_format' );

    // Thumb Size
    $thumb_size = $obj['thumb_size'];

    // Pagenum
    $obj['pagenum'] = isset( $obj['pagenum'] ) ? absint( $obj['pagenum'] ) : 1;

    // Begin Loop
    $args = array(
        'post_type'   => $obj['cpt'],
        'orderby'     => 'menu_order',
        'order'       => 'ASC',
        'post_status' => 'publish'
    );

    if ( $obj[ 'filterby' ] == 'taxonomy' && $obj[ 'filter_name' ] != 'all' ) {
         $args['tax_query'] = array(
            array(
                'taxonomy' => $obj[ 'tax'],
                'field' => 'term_id',
                'terms' => $obj[ 'filter_name' ],
            )
        );
    }

    // Posts count
    $temp_args = $args;
    $temp_args['showposts'] = -1;
    $temp_query_count = new WP_Query();
    $temp_query_count->query( $temp_args );
    if ( $temp_query_count->post_count <= ( $obj['limit'] * $obj['pagenum'] ) ) {
        $posts_nr = 'end-posts';
    } else {
        $posts_nr = '';
    }

    // Args
    $args[ 'offset' ] = $obj[ 'pagenum' ] > 1 ? $obj['limit'] * ( $obj['pagenum'] - 1 ) : 0;
    $args[ 'showposts' ] = $obj['limit'];
    
    $ajax_query = new WP_Query();
    $ajax_query->query( $args );

    // Begin Loop
    if ( $ajax_query->have_posts() ) {
        
        while ( $ajax_query->have_posts() ) {
            $ajax_query->the_post();

            if ( has_post_thumbnail() ) {

                // Tracks ID 
                $track_id = get_post_meta( $ajax_query->post->ID, '_thumb_tracks', true );

                $output .= '<div class="grid--item item-anim anim-fadeup ' . esc_attr( $obj['cols_layout'] ) . ' grid-tablet-12 grid-mobile-12 ' . esc_attr( $posts_nr ) . '">';

                // Advanced style
                if ( $obj['thumb_style'] == 'advanced' ) {
                    $output .= '<article class="' . esc_attr( implode( ' ', get_post_class( 'article-is-ajaxed anim--reveal', $ajax_query->post->ID ) ) ) . '">';

                    $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $ajax_query->post->ID ), $thumb_size );
                    $output .= '<img class="music--image" src="'. esc_url( $img_src[0] ) . '" alt="'. esc_attr__( 'Post image', 'zona' ) .'">';
                    $output .= '<div class="music--buttons">';
                    if ( $track_id && $track_id != 'none' ) {

                        $tracklist_id = 'simple_tracklist_' . $ajax_query->post->ID;

                        $output .= '<div class="music--button">';
                        $output .= '<a href="#" class="btn--icon-square anim--reveal music--btn-play sp-play-list" data-id="' . esc_attr( $tracklist_id ) . '" ><span class="icon icon-play2"></span></a>';
                        $output .= '<div class="music--tracks">';
                        if ( function_exists( 'zona_simple_tracklist' ) ) {
                            $output .= zona_simple_tracklist( array( 'id' =>  $track_id, 'tracklist_id' =>  $tracklist_id ) );
                        }
                        $output .= '</div>';
                        $output .= '</div>';
                    }
                    $output .= '<div class="music--button">';
                    $output .= '<a href="'. esc_url( get_permalink() ) .'" class="btn--icon-square anim--reveal music--btn-link"><span class="icon icon-link"></span></a>';   
                    $output .= '</div>';             
                    $output .= '</div>';                
                    $output .= '<h2 class="music--title"><span>'. get_the_title() . '</span></h2>';                   
                    $output .= '<span class="music--date">' . get_the_time( $date_format ) .'</span>';                   
                    $output .= '</article>';

                // Simple style
                } else {
                    $output .= '<article class="' . esc_attr( implode( ' ', get_post_class( 'article-is-ajaxed anim--disabled', $ajax_query->post->ID ) ) ) . '">';
                    $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $ajax_query->post->ID ), $thumb_size );
                    $output .= '<img class="music--image" src="' . esc_url( $img_src[0] ).'" alt="'. esc_attr__( 'Post image', 'zona' ) .'">';
                    $output .= '<a href="' . esc_url( get_permalink() ) . '" class="music--click-layer"></a>';
                    $output .= '</article>';

                }
                $output .= '</div>';
            }
        } 
       
        $zona_opts->e_esc( $output );

        die();
        return;
    } // end have_posts

    echo 'no_results';

    die();
    return;
    
}
add_action('wp_ajax_nopriv_zona_music_filter', 'zona_music_filter');
add_action('wp_ajax_zona_music_filter', 'zona_music_filter');


// EVENTS
function zona_events_filter() {

    $zona_opts = zona_opts();
    
    $nonce = $_POST['ajax_nonce'];
    $obj = $_POST['obj'];
    $output = '';

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
        die( 'Busted!' );
    }
    if ( ! isset( $obj ) ) {
        die();
    }

    // Date format
    $date_format = 'd-m';
    if ( $zona_opts->get_option( 'event_date' ) ) {
        $date_format = $zona_opts->get_option( 'event_date' );
    }

    // Pagenum
    $obj['pagenum'] = isset( $obj['pagenum'] ) ? absint( $obj['pagenum'] ) : 1;


    // ---------------------- All events
    if ( $obj['event_type'] == 'all-events' ) {

        $future_tax = array(
            'relation' => 'AND',
            array(
               'taxonomy' => 'zona_event_type',
               'field' => 'slug',
               'terms' => 'future-events'
              )
        );

        $past_tax = array(
            'relation' => 'AND',
            array(
               'taxonomy' => 'zona_event_type',
               'field' => 'slug',
               'terms' => 'past-events'
              )
        );

        if ( $obj[ 'filterby' ] == 'taxonomy' && $obj[ 'filter_name' ] != 'all' ) {

            array_push( $future_tax,
                array(
                    'taxonomy' => $obj[ 'tax'],
                    'field' => 'term_id',
                    'terms' => $obj[ 'filter_name' ]
                )
            );
            array_push( $past_tax, 
                array(
                    'taxonomy' => $obj[ 'tax'],
                    'field' => 'term_id',
                    'terms' => $obj[ 'filter_name' ]
                )
            );
        }

        $future_events = get_posts( array(
            'post_type' => 'zona_events',
            'showposts' => -1,
            'tax_query' => $future_tax,
            'orderby' => 'meta_value',
            'meta_key' => '_event_date_start',
            'order' => 'ASC'
        ));

        // Past Events
        $past_events = get_posts(array(
            'post_type' => 'zona_events',
            'showposts' => -1,
            'tax_query' => $past_tax,
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
            'post_type' => $obj['cpt'],
            'post__in'  => $uniqueposts,
            'orderby' => 'post__in'
        );

    // ---------------------- Future or past events
    } else {

        /* Set order */
        $order = $obj['event_type'] == 'future-events' ? $order = 'ASC' : $order = 'DSC';

        // Event type taxonomy
        $taxonomies = array(
            array(
               'taxonomy' => 'zona_event_type',
               'field' => 'slug',
               'terms' => $obj['event_type']
              )
        );

        if ( $obj[ 'filterby' ] == 'taxonomy' && $obj[ 'filter_name' ] != 'all' ) {

            array_push( $taxonomies, 
                array(
                    'taxonomy' => $obj[ 'tax'],
                    'field' => 'term_id',
                    'terms' => $obj[ 'filter_name' ]
                )
            );
        }

        // Begin Loop
        $args = array(
            'post_type'        => $obj['cpt'],
            'tax_query'        => $taxonomies,
            'orderby'          => 'meta_value',
            'meta_key'         => '_event_date_start',
            'order'            => $order,
            'post_status'     => 'publish',
            'suppress_filters' => 0 // WPML FIX
        );
    }

    // Posts count
    $temp_args = $args;
    $temp_args['showposts'] = -1;
    $temp_query_count = new WP_Query();
    $temp_query_count->query( $temp_args );
    if ( $temp_query_count->post_count <= ( $obj['limit'] * $obj['pagenum'] ) ) {
        $posts_nr = 'end-posts';
    } else {
        $posts_nr = '';
    }

    // Args
    $args[ 'offset' ] = $obj[ 'pagenum' ] > 1 ? $obj['limit'] * ( $obj['pagenum'] - 1 ) : 0;
    $args[ 'showposts' ] = $obj['limit'];
    
    $ajax_query = new WP_Query();
    $ajax_query->query( $args );

    // Begin Loop
    if ( $ajax_query->have_posts() ) {
        
        while ( $ajax_query->have_posts() ) {
            $ajax_query->the_post();
   
            /* Event Date */
            $event_time_start = get_post_meta( $ajax_query->post->ID, '_event_time_start', true );
            $event_date_start = get_post_meta( $ajax_query->post->ID, '_event_date_start', true );
            $event_date_start = strtotime( $event_date_start );
            $event_date_end = strtotime( get_post_meta( $ajax_query->post->ID, '_event_date_end', true ) );

            /* Event data */
            $event_place = get_post_meta( $ajax_query->post->ID, '_event_place', true );
            $event_city = get_post_meta( $ajax_query->post->ID, '_event_city', true );
            $event_tickets_url = get_post_meta( $ajax_query->post->ID, '_event_tickets_url', true );
            $event_tickets_target = get_post_meta( $ajax_query->post->ID, '_event_tickets_new_window', true );
   
            $output .= '<li class="' . esc_attr( implode( ' ', get_post_class( 'grid--item item-anim anim-fadeup ' . $posts_nr, $ajax_query->post->ID ) ) ) . '">';
                
                $output .= '<div class="event--col event--col-date">';
                $output .= date_i18n( $date_format, $event_date_start );
                $output .= '</div>';

            $output .= '<div class="event--col event--col-title">';
                $output .= '<div class="event--show-on-mobile event--date">';
                $output .= date_i18n( $date_format, $event_date_start );
                $output .= '</div>';
                 if ( has_term( 'past-events', 'zona_event_type' ) ) {
                    $output .= '<span class="past-event-label">' . esc_html__( 'Past Event', 'zona' ) . '</span>';
                }   
                $output .= '<a href="' . esc_url( get_the_permalink() ) .'" class="event--title">' . get_the_title() . '</a>';
                $output .= '<div class="event--show-on-mobile event--city">';
                $output .= esc_html( $event_city );
                $output .= '</div>';
            $output .= '</div>';

            $output .= '<div class="event--col event--col-city">';
            $output .= esc_html( $event_city );
            $output .= '</div>';

            $output .= '<div class="event--col event--col-tickets">';
            if ( $event_tickets_url != '' ) {
        
                if ( $event_tickets_target == 'yes' ) {
                    $event_tickets_target = '_blank';
                } else {
                    $event_tickets_target = '_self';
                }

                $output .= '<a class="event--button anim--reveal" href="'. esc_url( $event_tickets_url ) . '" target="' . esc_attr( $event_tickets_target ) . '"><span>' . esc_html__( 'Tickets', 'zona' ) . '</span></a>';
            }
            $output .= '</div>';

            $output .= '</li>';
            
        } 
       
        $zona_opts->e_esc( $output );

        die();
        return;
    } // end have_posts

    echo 'no_results';

    die();
    return;
    
}
add_action('wp_ajax_nopriv_zona_events_filter', 'zona_events_filter');
add_action('wp_ajax_zona_events_filter', 'zona_events_filter');


// Gallery
function zona_gallery_filter() {

    $zona_opts = zona_opts();

    $nonce = $_POST['ajax_nonce'];
    $obj = $_POST['obj'];
    $output = '';

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
        die( 'Busted!' );
    }
    if ( ! isset( $obj ) ) {
        die();
    }

    // Date format
    $date_format = get_option( 'date_format' );

    // Thumb Size
    $thumb_size = $obj['thumb_size'];

    // Pagenum
    $obj['pagenum'] = isset( $obj['pagenum'] ) ? absint( $obj['pagenum'] ) : 1;

    // Begin Loop
    $args = array(
        'post_type'   => $obj['cpt'],
        'post_status' => 'publish'
    );

    if ( $obj[ 'filterby' ] == 'taxonomy' && $obj[ 'filter_name' ] != 'all' ) {
         $args['tax_query'] = array(
            array(
                'taxonomy' => $obj[ 'tax'],
                'field' => 'term_id',
                'terms' => $obj[ 'filter_name' ],
            )
        );
    }

    // Posts count
    $temp_args = $args;
    $temp_args['showposts'] = -1;
    $temp_query_count = new WP_Query();
    $temp_query_count->query( $temp_args );
    if ( $temp_query_count->post_count <= ( $obj['limit'] * $obj['pagenum'] ) ) {
        $posts_nr = 'end-posts';
    } else {
        $posts_nr = '';
    }

    // Args
    $args[ 'offset' ] = $obj[ 'pagenum' ] > 1 ? $obj['limit'] * ( $obj['pagenum'] - 1 ) : 0;
    $args[ 'showposts' ] = $obj['limit'];
    
    $ajax_query = new WP_Query();
    $ajax_query->query( $args );

    // Begin Loop
    if ( $ajax_query->have_posts() ) {
        
        while ( $ajax_query->have_posts() ) {
            $ajax_query->the_post();

            if ( has_post_thumbnail() ) {

                $output .= '<div class="grid--item item-anim anim-fadeup ' . esc_attr( $obj['cols_layout'] ) . ' grid-tablet-12 grid-mobile-12 ' . esc_attr( $posts_nr ) . '">';

                    $output .= '<article class="' . esc_attr( implode( ' ', get_post_class( 'article-is-ajaxed', $ajax_query->post->ID ) ) ) . '">';
                    $output .= '<a href="' . esc_url( get_permalink() ) . '" class="anim--reveal">';
                    $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $ajax_query->post->ID ), $thumb_size );
                    $output .= '<img class="gallery--image" src="'.esc_url( $img_src[0] ).'" alt="'. esc_attr__( 'Post image', 'zona' ) .'">';
                    $output .= '<h2 class="gallery--title">'. get_the_title() . '</h2>';   
                    $output .= '<span class="gallery--date"><span>' . get_the_time( $date_format ) .'</span></span>';  
                    $output .= '</a>';
                    $output .= '</article>';

           
                $output .= '</div>';
            }
        } 
       
        $zona_opts->e_esc( $output );

        die();
        return;
    } // end have_posts

    echo 'no_results';

    die();
    return;
    
}
add_action('wp_ajax_nopriv_zona_music_filter', 'zona_gallery_filter');
add_action('wp_ajax_zona_gallery_filter', 'zona_gallery_filter');


// GALLERY IMAGES
function zona_gallery_images_filter() {

    $zona_opts = zona_opts();

    $nonce = $_POST['ajax_nonce'];
    $obj = $_POST['obj'];
    $output = '';
    $obj;
    
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
        die( 'Busted!' );
    }

    if ( ! isset( $obj ) ) {
        die();
    }

    // Thumb Size
    $thumb_size = $obj['thumb_size'];
    
    // ID
    $obj['id'] = (int)$obj['id'];

    // Pagenum
    $obj['pagenum'] = isset( $obj['pagenum'] ) ? absint( $obj['pagenum'] ) : 1;

    // IDS
    $images_ids = get_post_meta( $obj['id'], '_gallery_ids', true ); 

    if ( ! $images_ids || $images_ids == '' ) {
        die();
    }

    $ids = explode( '|', $images_ids ); 
    
    // Begin Loop
    $args = array(
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        'post__in' => $ids,
        'orderby' => 'post__in',
        'post_status' => 'any',
    );
    

    // Posts count
    $temp_args = $args;
    $temp_args['showposts'] = -1;
    $temp_query_count = new WP_Query();
    $temp_query_count->query( $temp_args );
    if ( $temp_query_count->post_count <= ( $obj['limit'] * $obj['pagenum'] ) ) {
        $posts_nr = 'end-posts';
    } else {
        $posts_nr = '';
    }

    // Args
    $args[ 'offset' ] = $obj[ 'pagenum' ] > 1 ? $obj['limit'] * ( $obj['pagenum'] - 1 ) : 0;
    $args[ 'showposts' ] = $obj['limit'];
    
    $ajax_query = new WP_Query();
    $ajax_query->query( $args );

    // Begin Loop
    if ( $ajax_query->have_posts() ) {
        
        while ( $ajax_query->have_posts() ) {
            $ajax_query->the_post();

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
            $image = get_post_meta( $obj['id'], '_gallery_ids_' . get_the_id(), true );

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
                $link_class = 'iframe-link';
            } else {
                $link = wp_get_attachment_image_src( get_the_id(), 'full' );
                $link = $link[0];
                $link_class = '';
            }


            $output .= '<div class="grid--item item-anim anim-fadeup grid-3 grid-tablet-6 grid-mobile-6 ' . esc_attr( $posts_nr ) . '">';
            $output .= '<article class="' . esc_attr( implode( ' ', get_post_class( 'image-is-ajaxed', $ajax_query->post->ID ) ) ) . '">';
            $output .= '<a href="' . esc_url( $link ) .'" class="' . esc_attr( $link_class  ) . ' g-item" title="' . esc_attr( $image['title'] ) . '" data-group="gallery">';
            $output .= '<img src="' . esc_url( $image['src'] ) . '" alt="' . esc_attr__( 'Gallery thumbnail', 'zona' ) . '" title="' . esc_attr( $image['title'] ) . '">';
           
            $output .= '</a>'; 
            $output .= '</article>';
            $output .= '</div>';
        } 
       
        $zona_opts->e_esc( $output );

        die();
        return;
    } // end have_posts

    echo 'no_results';

    die();
    return;
    
}
add_action('wp_ajax_nopriv_zona_gallery_images', 'zona_gallery_images_filter');
add_action('wp_ajax_zona_gallery_images', 'zona_gallery_images_filter');