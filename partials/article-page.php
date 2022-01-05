<?php
/**
 * Article template for Pages.
 *
 * @package davidsword-ca-custom-theme
 */
?>
<article <?php post_class(); ?>>
	<div class='entry'>
	<h2 class='title title--page'><?php the_title(); ?></h2>
	<div class='content'>
		<?php
			dsca_featured_image();
			the_content();
		?>
	</div>
	</div>
</article>
