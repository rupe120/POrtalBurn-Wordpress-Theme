<?php
/**
 * Theme Name:      Zona - Music WordPress Theme
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascals.eu/zona
 * Author URI:      http://rascals.eu
 * File:            content-category.php
 * =========================================================================================================================================
 *
 * @package zona
 * @since 1.0.0
 */
?>

<?php 

    $zona_opts = zona_opts();

    // Thumb Size
    $thumb_size = 'zona-main-thumb';
    
    // Date format
    $date_format = get_option( 'date_format' );
?>
    
<div class="grid--item item-anim anim-fadeup grid-4 grid-tablet-12 grid-mobile-12">
    <article <?php post_class( 'article' ); ?>>
            <?php $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $thumb_size ); ?>
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
    </article>
</div>