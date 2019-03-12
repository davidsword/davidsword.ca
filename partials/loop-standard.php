<?php
/**
 * Content for Loop of POST post type.
 *
 * @package davidsword-2018
 */

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
		<article <?php post_class(); ?>>
			<time class='date list list--left date--nomargin'>
				<?php the_date(); ?>
			</time>
			<div class='entry list list--right'>
				<?php
					// every post may have a featured image, including `image` post formats
					ftr_img();

					// we don't need to show anything else for `image` post formats. Img only.
					$format = get_post_format() ? : 'standard';
					if ( 'image' !== $format ) {
						get_template_part( 'partials/format', 'standard' );
					}
				?>
			</div>
		</article>
		<?php
	endwhile;
endif;
