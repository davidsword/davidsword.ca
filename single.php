<?php defined('ABSPATH') || exit; get_header() ?>

<!-- generated by single.php -->

<main>
	<section>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<article>
				<h2>
					<!--
					<?php if (is_singular( 'post' )) : ?>
						<a href="<?= get_post_type_archive_link('post') ?>">Code</a> &raquo;
					<?php endif ?>
					-->
					<span><?php the_title() ?></span>
				</h2>

				<?php if (is_singular( 'projects' )) : ?>
					<div class='excerpt'>
						<?php echo the_excerpt() ?>
					</div>
				<?php endif ?>

				<?php if (is_singular( 'post' )) : ?>
					<div class='date single_date'>
						<?= get_the_date(); ?>
					</div>
				<?php endif ?>

				<?php get_template_part( 'partials/inline', 'ftrimg' ); ?>

				<div class='entry'>
					<?php the_content() ?>
				</div>

			</article>


			<div class='clear navigation'>
				<?php
				next_post_link('%link','&laquo; Next');
				previous_post_link('%link','Prev &raquo;');
				?>
			</div><!--/navigation-->

		<?php endwhile; endif; ?>
	</section>

</main>

<!-- /generated by single.php -->

<?php get_footer() ?>
