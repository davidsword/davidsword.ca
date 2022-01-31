<?php
/**
 * @package davidsword-ca-custom-theme
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

	<!-- generated by category-art.php -->

	<main>
		<section>

			<?php
			if ( $cat_description = get_the_archive_description() ) {
				?>
				<p><?= wp_kses_post( get_the_archive_description() ) ?></p>
				<?php
				}
			?>

			<?php
			global  $wp_query;
			if ( ! ( isset( $wp_query->query['error'] ) && $wp_query->query['error'] ) && have_posts() ) :

				while ( have_posts() ) :
					the_post();
					get_template_part( 'partials/article', 'art-post' );
					if ( ! is_page() ) {
						get_template_part( 'partials/post', 'nav' );
					}
				endwhile;

			else :

				get_template_part( 'partials/article', 'not-found' );

			endif;

			if ( ! is_page() && ! is_404() ) { ?>

				<div class='clear navigation'>
					<?php
					echo paginate_links( [ // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						'prev_text' => '« Prev',
						'next_text' => 'Next »',
					] );
					?>
				</div><!--/navigation-->

			<?php } ?>

		</section>
	</main>

	<!-- /generated by category-art.php -->

<?php
get_footer();
