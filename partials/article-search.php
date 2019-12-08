<?php
/**
 * Article template for posts with the Status format.
 *
 * Supporting both single and archive type pages
 *
 * @package davidsword-ca
 */
?>
<article <?php post_class(); ?>>
	<?php if ( ! empty( get_the_title() ) ) : ?>
		<h2>
			<a class='title title--search' href='<?php echo esc_url( the_permalink() ); ?>'><?php
				echo esc_html( get_the_title() );
			?></a>
		</h2>
	<?php endif; ?>
	<a href='<?php echo esc_url( the_permalink() ); ?>' class='search_result_link'>
		<?php echo esc_html( the_permalink() ); ?> &raquo;
	</a>
	<div class='content'>
		<?php echo the_excerpt() ?>
	</div>
</article>
