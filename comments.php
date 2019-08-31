<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package davidsword-ca
 */

// maybe bail..
if ( ! comments_open() || post_password_required() ) {
	return;
}
?>

<div id="comments">

	<hr />

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			Comments
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments([
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 60,
				'format'      => 'html5',
				'reply_text'  => 'Reply to this.'
			]);
			?>
		</ol><!-- .comment-list -->

	<?php endif; ?>

	<?php comment_form(); ?>

</div><!-- #comments -->
