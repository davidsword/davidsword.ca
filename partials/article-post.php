<?php
/**
 * Content for Loop of POST post type.
 *
 * @package davidsword-2018
 */
?>
<article <?php post_class(); ?>>
	<header class='post_meta'>
		<time class='post_meta__date'>
			<a href='<?php echo get_permalink(); ?>'>
				<?php echo get_the_date(); ?>
			</a>
		</time>
		<span class='post_meta__tags'>
			<?php
			$terms = wp_get_post_terms( get_the_ID(), 'category' );
			foreach ( $terms as $term ) {
				$link = get_term_link( $term->term_id, 'category' );
				?>
				<a href='<?php echo $link; ?>'>#<?php echo $term->name; ?></a>
				<?php
			}
			?>
		</span>
	</header>
	<div class='entry'>
		<?php
			$format = get_post_format() ? : 'standard';
			if ( 'image' !== $format ) {
				get_template_part( 'partials/post-format', $format );
			} else {
				dsca_featured_image();
			}
		?>
	</div>
	<?php
	if ( is_singular() && comments_open() ) {
		comments_template();
	}
	?>
</article>