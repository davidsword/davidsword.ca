<?php
/**
 * Single page for STATUS post types.
 *
 * This differs from normal single.php as its just smaller and simpler.
 * No comments, nothing fancy, just the content and some pagination.
 *
 * @package davidsword-2018
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<!-- generated by single-status.php -->

<main>
	<section>

		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				?>

			<article>
				<h2>
					<a href="<?php echo get_post_type_archive_link( 'status' ); ?>">status</a> &raquo; <span><?php echo get_the_date(); ?></span>
				</h2>

				<?php get_template_part( 'partials/inline', 'ftrimg' ); ?>

				<div class='entry'>
					<?php the_content(); ?>
				</div>

			</article>

			<div class='clear navigation'>
				<?php
				next_post_link( '%link', '&laquo; Next' );
				previous_post_link( '%link', 'Prev &raquo;' );
				?>
			</div><!--/navigation-->

				<?php
				endwhile;
			endif;
		?>
	</section>

</main>

<!-- /generated by single-status.php -->

<?php
get_footer();
