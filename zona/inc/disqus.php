<?php
/**
 * Theme Name:      Zona - Music WordPress Theme
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/zona
 * Author URI: 		http://rascals.eu
 * File:			disqus.php
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


// Get DISQUS shortname
$disqus_shortname = $zona_opts->get_option( 'disqus_shortname' );

?>
<!-- ############################# DISQUS Comment section ############################# -->
<section id="comments" class="comments-section">
    <!-- container -->
    <div class="comments-container clearfix">
		<h3 id="reply-title"><?php echo '<strong>' . esc_html__('Leave', 'zona') .' </strong>' . esc_html__(' a Reply', 'zona'); ?></h3>
		<div id="disqus_title" class="hidden"><?php echo get_the_title( $wp_query->post->ID )  ?></div>
		<div id="disqus_thread" data-post_id="<?php echo esc_attr( $wp_query->post->ID ) ?>" data-disqus_shortname="<?php echo esc_attr( $disqus_shortname ) ?>"></div>
    </div>
</section>