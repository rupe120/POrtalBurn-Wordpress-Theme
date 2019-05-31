<?php
/**
 * Theme Name: 		Zona - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/zona
 * Author URI: 		http://rascals.eu
 * File:			footer.php
 * =========================================================================================================================================
 *
 * @package zona
 * @since 1.0.0
 */
?>
<?php 
    $zona_opts = zona_opts();
?>
        </div>
        <!-- /ajax content -->
    </div>
    <!-- /ajax container -->
    
    <!-- Footer container -->
    <footer id="footer-widgets" class="footer-container">
        <div class="container">
            <?php if ( get_theme_mod( 'zona_footer_widgets', true ) ) : ?>
            <div class="grid-row grid-row-pad footer-widgets">
                <div class="grid-4 grid-mobile-12 grid-tablet-4">
                    <?php get_sidebar( 'footer-col1' ); ?>
                </div>
                <div class="grid-3 grid-offset-2 grid-mobile-12 grid-mobile-offset-0 grid-tablet-offset-0 grid-tablet-4">
                   <?php get_sidebar( 'footer-col2' ); ?>
                </div>
                <div class="grid-3 grid-mobile-12 grid-tablet-4">
                   <?php get_sidebar( 'footer-col3' ); ?>
                </div>
            </div>
            <?php endif; ?>
            <div class="grid-row grid-row-pad">
                <div class="grid-3 grid-mobile-12 footer-social dark-bg">
                   <?php 
                    if ( function_exists( 'zona_social_buttons' ) ) {
                            $footer_social_defaults = array(
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
                            echo zona_social_buttons( get_theme_mod( 'zona_footer_social_buttons_a', $footer_social_defaults ) );
                        }
                        ?>
                </div>
                <div class="grid-6 grid-offset-3 grid-mobile-12 grid-mobile-offset-0 footer-copyright">
                    <?php zona_copyright_note() ?>
                    <?php if ( get_theme_mod( 'zona_footer_wpml' ) ) : ?>
                        <?php zona_languages_list('footer-lang-selector', get_theme_mod( 'zona_footer_wpml_display', 'language_codes' ) ) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </footer>
    <!-- /footer container -->

</div>
<!-- /site -->



<?php wp_footer(); ?>
</body>
</html>