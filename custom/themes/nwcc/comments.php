<?php 
/***
 * Comments Template
 *
 * This template displays the current comments of a post and the comment form
 *
 */

if ( post_password_required()) : ?>
	<p><?php esc_html_e( 'Enter password to view comments.', 'smartline-lite' ); ?></p>
<?php return; endif; ?>


<?php if (( have_comments() or comments_open()) && (!is_page() || !is_buddypress())) : ?>

	<div id="comments">
	
		<?php if ( have_comments() ) : ?>

			<h3 class="comments-title"><span><?php comments_number( '', esc_html__( 'One comment', 'smartline-lite' ), esc_html__( '% comments', 'smartline-lite' ) );?></span></h3>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<div class="comment-pagination clearfix">
				<div class="alignleft"><?php previous_comments_link(); ?></div>
				<div class="alignright"><?php next_comments_link() ?></div>
			</div>
			<?php endif; ?>
			
			<ul class="commentlist">
				<?php wp_list_comments( array('callback' => 'smartline_list_comments')); ?>
			</ul>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<div class="comment-pagination clearfix">
				<div class="alignleft"><?php previous_comments_link() ?></div>
				<div class="alignright"><?php next_comments_link() ?></div>
			</div>
			<?php endif; ?>
			
		<?php endif; ?>

		<?php if ( comments_open() ) : ?>
			<?php comment_form(array('comment_notes_after' => '')); ?>
		<?php endif; ?>

	</div>

<?php endif; ?>