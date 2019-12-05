<?php
/**
 * Article template for posts not found.
 *
 * Commonly used in Search or an empty category/term.
 *
 * @package davidsword-ca
 */
?>
<article <?php post_class(); ?>>
	<div class='entry'>
		<h2>Uh oh.</h2>
		<?php if ( is_search() ) : ?>
			<p>No posts found, please refine your search.</p>
		<?php else : ?>
			<p>It seems like the post(s) you tried to reach have either been removed, renamed, or didn’t exist in the first place. You can return to the home page of the website by clicking <a href='<?php home_url(); ?>'>here</a>.</p>
		<?php endif ?>
	</div>
</article>
