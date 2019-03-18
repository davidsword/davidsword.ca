<?php
/**
 * Content template for posts with no post format (deafult).
 *
 * @package davidsword-ca
 */
?>
<h2>
	<?php
	if ( ! is_single() ) {
		?>
		<a href='<?php echo esc_attr( get_permalink() ); ?>'><?php the_title(); ?> &raquo;</a>
	<?php
	} else {
		the_title();
	}
	?>
</h2>
<div class='content'>
	<?php
		// Featured image.
		dsca_featured_image();

		if ( ! is_single() ) {
			the_excerpt();
		} else {
			the_content();
		}
	?>
</div>