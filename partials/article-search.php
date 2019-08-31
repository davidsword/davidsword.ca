<?php
/**
 * Article template for posts with the Status format.
 *
 * Supporting both single and archive type pages
 *
 * @package davidsword-ca
 */

$text = get_the_excerpt();
if ( empty( $text ) ) {
	$text = strip_shortcodes( wp_strip_all_tags( get_the_content() ) );
}

if ( empty( $text ) ) {
	$text = '';
}
?>
<article <?php post_class(); ?>>
	<?php if ( ! empty( get_the_title() ) ) : ?>
		<h2>
			<a class='title title--search' href='<?php echo esc_attr( the_permalink() ); ?>'><?php
				echo esc_html( get_the_title() );
			?></a>
		</h2>
	<?php endif; ?>
	<a href='<?php echo esc_attr( the_permalink() ); ?>' class='search_result_link'>
		<?php echo esc_html( the_permalink() ); ?> &raquo;
	</a>
	<div class='content'>
		<p>
			<?php echo esc_html( dsca_return_chopstring( $text, 150 ) ); ?>
		</p>
	</div>
</article>