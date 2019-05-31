<?php
/**
 * Theme Name:      Zona - Music WordPress Theme
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascals.eu/zona
 * Author URI:      http://rascals.eu
 * File:            content.php
 * =========================================================================================================================================
 *
 * @package zona
 * @since 1.0.0
 */
?>

<?php 

   $zona_opts = zona_opts();
   
   // Post header
   $post_header = get_post_meta( $wp_query->post->ID, '_post_header_type', true ); // post_featured_image, post_custom_image, post_disabled, post_audio_sc, post_yt, post_vimeo, post_vimeo

   // Date format
    $date_format = get_option( 'date_format' );

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'single--post-article' ); ?>>

    <!-- ############ POST HEADER ############ -->
    <header class="single--post-header content--extended">
        <div class="single--post-header-meta">
            <div class="single--post-header-date"><?php the_time( $date_format ); ?></div>
            <div class="single--post-header-cats"><?php the_category( ' / ' ) ?></div>
        </div>
        <h1><?php the_title(); ?></h1>
        <?php if ( ! $post_header || $post_header != 'post_disabled' ) : ?>
            
        <div class="single--media">

            <?php 
            // ------------------ POST CUSTOM IMAGE
            if ( $post_header == 'post_custom_image' &&  get_post_format() === 'image' ) : ?>

                <?php $custom_image = get_post_meta( $wp_query->post->ID, '_post_image', true ); ?>
                <?php if ( $custom_image && $custom_image != '' ) : ?>
                <div class="single--image">
                    <img src="<?php echo esc_url( $zona_opts->get_image( $custom_image ) ); ?>" alt="<?php esc_attr_e( 'Post Image', 'zona' ); ?>">
                </div>
                <?php endif ?>
                
                <?php
                // ------------------ SOUNDCLOUD
            elseif ( $post_header == 'post_audio_sc' ) : 
                $sc_embed = get_post_meta( $wp_query->post->ID, '_sc_embed', true );
                if ( $sc_embed && $sc_embed !== '' && strpos( $sc_embed, 'iframe' ) !== false ) : ?>     
                <div class="single--sc">
                    <?php echo str_replace( '&', '&amp;', $sc_embed ); ?>
                </div>
                <?php endif; ?>
                <?php 
                // ------------------ YOUTUBE
            elseif ( $post_header == 'post_yt' ) : 
                $yt = get_post_meta( $wp_query->post->ID, '_post_yt', true );
                if ( $yt && $yt !== '' && strpos( $yt, 'youtu' ) !== false ) : ?>     
                <div class="video">
                    <?php 
                    $yt_embed = preg_replace(
                        "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
                        "<iframe width=\"100%\" height=\"600\" src=\"//www.youtube.com/embed/$2\" allowfullscreen></iframe>",
                        $yt
                    );
                    $zona_opts->e_esc( $yt_embed );
                    ?>
                </div>
                <?php endif; ?>
                <?php 
                // ------------------ VIMEO
            elseif ( $post_header == 'post_vimeo' ) : 
                $vimeo = get_post_meta( $wp_query->post->ID, '_post_vimeo', true );
                if ( $vimeo && $vimeo !== '' && strpos( $vimeo, 'vimeo' ) !== false ) : ?>     
                <div class="video">
                    <?php 
                    $vimeo_embed = preg_replace(
                        '#https?://(www\.)?vimeo\.com/(\d+)#',
                        '<iframe class="videoFrame" src="//player.vimeo.com/video/$2" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>',
                        $vimeo
                    );
                    $zona_opts->e_esc( $vimeo_embed );
                    ?>
                </div>
                <?php endif; ?>
                <?php 
                // ------------------ FEATURED IMAGE 
            else :
                if ( has_post_thumbnail() ) : ?>
                <div class="single--image">
                    <img src="<?php echo esc_url( wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ) ); ?>" alt="<?php esc_attr_e( 'Post Image', 'zona' ); ?>">
                </div>
                <?php endif; ?>
            <?php endif ?>
        </div>

        <?php endif ?>
    </header>

    <?php the_content( esc_html__( '...View the rest of this post', 'zona' ) ); ?>

    <?php
        wp_link_pages( array(
            'before'    => '<div class="page-links">' . esc_html__( 'Jump to Page', 'zona' ),
            'after'     => '</div>',
        ) );
    ?>

    <footer class="single--post-footer">

        <!-- Meta -->
        <div class="single--post-meta meta--cols">
            <div class="meta--col">
                <?php the_tags( '<span class="meta-tags">', ' ', '</span>' ); ?>

            </div>
            <div class="meta--col">
                <?php if ( function_exists( 'zona_meta_share_buttons' ) ) { echo zona_meta_share_buttons( $post->ID ); } ?>

            </div>
        </div>
       
    </footer>

</article><!-- #post-## -->