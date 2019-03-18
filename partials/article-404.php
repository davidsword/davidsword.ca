<?php
/**
 * Article template for a 404 error.
 *
 * @package davidsword-ca
 */
?>
<article <?php post_class(); ?>>
	<div class='entry'>
		<h2>Uh oh.</h2>
		<p>It seems like the page you tried to reach has either been removed, renamed, or didn’t exist in the first place. You can return to the home page of the website by clicking <a href='<?php home_url(); ?>'>here</a>.</p>
	</div>
</article>