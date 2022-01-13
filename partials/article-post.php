<?php
/**
 * Article template for posts with the Aside format.
 *
 * Supporting both single and archive type pages
 *
 * @package davidsword-ca-custom-theme
 */
?>
<article <?php post_class(); ?>>
	<?php if ( get_the_title() ) :  ?>
		<h2 class='title title--<?php echo esc_attr( get_post_type() ); ?>'>
			<?php if ( ! is_single() ) { ?>
				<a href='<?php echo esc_url( get_permalink() ); ?>'><?php the_title(); ?> &raquo;</a>
			<?php } else {
				the_title();
			} ?>
		</h2>
	<?php endif; ?>

	<div class='content'>
		<?php
			if ( ! has_post_format( 'aside', get_the_ID() ) )
				dsca_featured_image();

			if ( is_home() && ! has_post_format( 'aside', get_the_ID() ) )
				the_excerpt();
			else
				the_content();

			if ( has_post_format( 'aside', get_the_ID() ) )
				dsca_featured_image();
		?>
	</div>

	<header class='post_meta'>
		<time class='post_meta__date'>
			<a href='<?php echo esc_url( get_permalink() ); ?>'>
				<?php echo get_the_date(); ?>
			</a>
		</time>
		<span class='post_meta__tags'>
			<?php
			$terms = wp_get_post_terms( get_the_ID(), 'category' );
			foreach ( $terms as $aterm ) {
				$alink = get_term_link( $aterm->term_id, 'category' );
				?>
				<a href='<?php echo $alink ? esc_url( $alink ) : ''; ?>'>#<?php echo esc_html( $aterm->slug ); ?></a>
				<?php
			}
			if ( is_sticky() ) {
				echo "<a href='#'>#sticky</a>";
			}
			?>
		</span>
		<?php edit_post_link('#edit-this') ?>

	</header>

	<?php
	if ( is_singular() && comments_open() ) {
		comments_template();
	}
	?>
</article>
