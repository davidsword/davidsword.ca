<?php
/**
 * Article template for Projects custom post type.
 *
 * Supporting both single and archive type pages.
 *
 * @package davidsword-ca
 */
?>
<article <?php post_class(); ?>>
	<header class='post_meta'>
		<span class='post_meta__tags'>
			<?php
			$terms = wp_get_post_terms( get_the_ID(), 'flag' );
			foreach ( $terms as $term ) {
				$link = get_term_link( $term->term_id, 'flag' );
				?>
				#<?php echo esc_html( $term->slug ); ?>
				<?php
			}
			?>
		</span>
	</header>
	<div class='entry'>
		<h2><a href='<?php echo esc_attr( get_permalink() ); ?>'><?php the_title(); ?> &raquo;</a></h2>
		<div class='content'>
			<?php
				dsca_featured_image();

				if ( is_single() ) {
					?>
					<div class='has-medium-font-size center'>
						<?php the_excerpt(); ?>
					</div>
					<hr />
					<?php
					the_content();
				} else {
					the_excerpt();
				}
			?>
		</div>
	</div>
</article>