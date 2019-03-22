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
	<header class='post_meta'>
		<time class='post_meta__date'>
			<a href='<?php echo esc_attr( get_permalink() ); ?>'>
				<?php echo get_the_date(); ?>
			</a>
		</time>
		<span class='post_meta__tags'>
			<?php
			$terms = wp_get_post_terms( get_the_ID(), 'category' );
			foreach ( $terms as $term ) {
				$link = get_term_link( $term->term_id, 'category' );
				?>
				<a href='<?php echo esc_attr( $link ); ?>'>#<?php echo esc_html( $term->slug ); ?></a>
				<?php
			}
			if ( is_sticky() ) {
				echo "#sticky";
			}
			?>
		</span>
		<?php edit_post_link('#edit-this', ' &nbsp; ') ?>
	</header>
	<div class='content'>
		<?php
			$format = dsca_get_pseduo_post_format();
			get_template_part( 'partials/content', $format );
		?>
	</div>
	<?php
	if ( is_singular() && comments_open() ) {
		comments_template();
	}
	?>
</article>