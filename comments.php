<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @TODO this was ripped from Twenty-x theme with little care, needs attention.
 *
 * @package davidsword-ca
 */

// Go away, VIP only.
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<hr />

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			Comments
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments(array(
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 60,
				'format'      => 'html5',
				'reply_text'  => 'Reply to this.'
			));
			?>
		</ol><!-- .comment-list -->

	<?php endif; ?>

	<?php
	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'twentyfifteen' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>

</div><!-- .comments-area -->
