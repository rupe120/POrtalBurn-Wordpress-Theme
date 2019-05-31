<?php
/**
 * woocommerce.php
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

    // Shop id
    $shop_id = get_option( 'woocommerce_shop_page_id' );


   // Get layout
   $zona_layout = 'wide';

  if ( is_product() ) {
    $zona_layout = 'narrow';
  }
?>

<?php 
    // Get Custom Intro Section
    if ( is_shop() ) {
      get_template_part( 'inc/custom-intro' );
    }

?>

<?php
   
   /* Hooks and functions
   ------------------------------------------------------------------------*/

   /* Remove default page title */
   add_filter('woocommerce_show_page_title', 'override_page_title');
   function override_page_title() {
      return false;
   }

?>


<!-- ############ CONTENT ############ -->
<div class="content clearfix">
  
  <div class="container <?php echo esc_attr( $zona_layout ) ?>">
         <?php woocommerce_content(); ?>
   </div>
    <!-- /container -->
</div>
<!-- /content -->

<?php
   // Get orginal query
   $post = $temp_post;
   $wp_query = $query_temp;
?>
<?php get_footer(); ?>