<?php
/**
 * Theme Name: 		Zona - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/zona
 * Author URI: 		http://rascals.eu
 * File:			comments.php
 * =========================================================================================================================================
 *
 * @package zona
 * @since 1.0.0
 */

?>

<!-- ############################# Comment section ############################# -->
<section id="comments" class="comments-section">
    
        <?php
        // protect password protected comments
        if ( post_password_required() ) : ?>

        	<p class="comment-message"><?php esc_html_e( 'This post is password protected. Enter the password to view any comments.', 'zona' ); ?></p>
        	</div></section>
        <?php return; endif; ?>

        <?php if ( have_comments() ) : ?>
            <h4 class="comments-title"><?php printf( _n( '1 comment', '%1$s comments', get_comments_number(), 'zona' ), number_format_i18n( get_comments_number() ), 'zona' );
            ?></h4>
        	<div class="comments-container clearfix">	
        		<ul class="comment-list">
        			<?php 
                        wp_list_comments( array(
                            'type' => 'all',
                            'short_ping' => true,
                            'callback'=> 'zona_comments'
                        ) );
                    ?>
        		</ul>		
        		<nav class="comments-navigation" role="navigation">
        		    <div class="nav-prev"><?php previous_comments_link(); ?></div>
        		    <div class="nav-next"><?php next_comments_link(); ?></div>
        		</nav>
        	</div>

        <?php else : // there are no comments so far ?>
            
             <h4 class="comments-title"><?php esc_html_e( 'Comments', 'zona' ) ?></h4>

        	<?php if ( comments_open() ) : ?>
        		<!-- If comments are open, but there are no comments. -->
        		<p class="comment-message"><?php esc_html_e( 'Currently there are no comments related to this article. You have a special honor to be the first commenter. Thanks!', 'zona' ); ?></p>
        	 <?php else : // comments are closed ?>
        		<!-- If comments are closed. -->
        		<p class="comment-message"><?php esc_html_e( 'Comments are closed.', 'zona' ); ?></p>
        	<?php endif; ?>

        <?php endif; ?>


        <?php
        $fields = array();
        function custom_fields( $fields ) {
            global $comment_author, $comment_author_email, $comment_author_url;

            $fields['author'] = '<div class="flex-col-1-3 first">
                    <input type="text" name="author" id="author" value="' . esc_attr( $comment_author ) . '" size="22" tabindex="1" required placeholder="' . esc_html__('Name*', 'zona' ) . '" />
                    </div>';
            $fields['email'] = '<div class="flex-col-1-3">
                    <input type="text" name="email" id="email" value="' . esc_attr( $comment_author_email ) . '" size="22" tabindex="2" required placeholder="' . esc_html__('Email*', 'zona' ) . '"/>
                    </div>';
            $fields['url'] = '<div class="flex-col-1-3 last">
                    <input type="text" name="url" id="url" value="' . esc_attr( $comment_author_url ) . '" size="22" tabindex="3" placeholder="' . esc_html__('Website URL', 'zona' ) . '" />
                    </div>';
            return $fields;
        }

        add_filter('comment_form_default_fields', 'custom_fields');

        $form_fields = array(
            'fields' => apply_filters( 'comment_form_default_fields', $fields ),
            'title_reply' => esc_html__('Leave a Reply or Comment', 'zona'),
            'title_reply_to' =>  esc_html__('Leave a Reply', 'zona'),
            'cancel_reply_link' => esc_html__('(Cancel reply)', 'zona'),
            'comment_notes_before' => '',
            'label_submit' => esc_html__('Submit', 'zona'),
            'comment_notes_after' => '<p class="form-allowed-tags">' . esc_html__('* Your email address will not be published.', 'zona') . '<br/>' . sprintf( esc_html__('You may use these HTML tags and attributes: %s', 'zona'), ' <span>' . esc_html( allowed_tags() ) . '</span>' ) . '</p>',
            'comment_field' => '<div class="comment-field">
                    <textarea tabindex="4" rows="9" id="comment" name="comment" class="textarea" required placeholder="' . esc_html__('Your Comment*', 'zona') . '"></textarea>
                    </div>'
        );
        ?>
        <?php comment_form( $form_fields ); ?>
</section>
<!-- /comments -->