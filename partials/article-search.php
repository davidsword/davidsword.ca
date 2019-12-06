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
		<p>
			<?php
				$excerpt = get_the_excerpt();
				$text = empty( $excerpt ) ? strip_shortcodes( wp_strip_all_tags( get_the_content() ) ) : $excerpt;
				echo esc_html( dsca_return_chopstring( $text, 150 ) ); ?>
		</p>
	</div>
</article>
