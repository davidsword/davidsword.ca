<?php
/**
 * Default content output.
 *
 * The template hiarchy is not being used for this site. Everything
 * is output in a very simple mannor so most of the changes in content
 * reside in loading the correct `partials/*.php` files.
 *
 * @package davidsword-ca
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

	<!-- generated by index.php -->

	<main>
		<section>

			<?php
			global  $wp_query;
			if ( ! $wp_query->query['error'] && have_posts() ) :

				while ( have_posts() ) :
					the_post();
					get_template_part( 'partials/article', get_post_type() );
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

	<!-- /generated by index.php -->

<?php
get_footer();
