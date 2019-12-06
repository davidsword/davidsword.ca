<?php
/**
 * Article template for Pages.
 *
 * @package davidsword-ca
 */
?>
<article <?php post_class(); ?>>
	<div class='entry'>
		<?php
			get_template_part( 'partials/content' );
		?>
	</div>
</article>
