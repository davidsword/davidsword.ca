<?php
/**
 * Search template.
 *
 * @TODO redesign the page to work off of index using `get_template_part()`
 * and `partials/*` logic.
 *
 * @package davidsword-ca
 */

defined( 'ABSPATH' ) || exit;

get_header();

// escaped on output.
$s_value = ( is_search() ) ? 'value="' . get_search_query() . '"' : '';
?>

	<!-- generated by search.php -->

	<main>
		<section>

			<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
				<input type="text" name="s" id="s" <?php echo esc_attr( $s_value ); ?> placeholder='Search Site...' />
				<input type="submit" id="searchsubmit" value="Search" class='notext' />
			</form>

			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();

					$text = get_the_excerpt();
					if ( empty( $text ) ) {
						$text = strip_shortcodes( wp_strip_all_tags( get_the_content() ) );
					}

					if ( empty( $text ) ) {
						$text = '';
					}
					?>
					<div class='search_result'>
						<?php if ( ! empty( get_the_title() ) ) : ?>
							<h2><a class='search_result_title' href='<?php echo the_permalink(); ?>'>
								<?php the_title(); ?>
							</a>
							</h2>
						<?php endif; ?>
						<a href='<?php echo the_permalink(); ?>' class='search_result_link'>
							<?php echo the_permalink(); ?>
						</a>
						<p>
							<?php echo dsca_return_chopstring( $text, 150 ); ?>
						</p>
					</div>

			<?php endwhile; else :
				// @TODO: this should be CSS, not inline.
				?>
				<p style='text-align:center;padding-bottom:100px;'>No posts found. Try another keyword instead.</p>
			<?php endif; ?>

		</section>
	</main>

	<!-- /generated by search.php -->

<?php
get_footer();
