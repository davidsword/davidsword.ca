<?php
/**
 * Default content output.
 *
 * @package davidsword-2018
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

	<!-- generated by index.php (which is basically: archive-post.php) -->

	<main>
		<section>

			<?php if ( is_archive() && is_category() ) : ?>
				<div class='termTitle gray'>
					<a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">Blog</a> &raquo;
					#<?php echo single_cat_title( '', false ); ?>
				</div>
			<?php endif ?>

			<div class='articles'>
				<?php get_template_part( 'partials/loop', 'standard' ); ?>
			</div>

			<div class='clear navigation'>
				<?php echo paginate_links(); ?>
			</div><!--/navigation-->

		</section>
	</main>

	<!-- /generated by index.php -->

<?php
get_footer();
