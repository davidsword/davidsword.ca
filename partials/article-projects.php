<?php
/**
 *
 *
 * @package davidsword-2018
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
				#<?php echo $term->slug; ?>
				<?php
			}
			?>
		</span>
	</header>
	<div class='entry'>
		<h2><a href='<?php echo get_permalink(); ?>'><?php the_title(); ?> &raquo;</a></h2>
		<div class='content'>
			<?php
				dsca_featured_image();

				if ( is_single() ) {
					the_excerpt();
					?>
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