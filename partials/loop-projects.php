<?php
/**
 * Content for PROJECTS loop.
 *
 * @package davidsword-2018
 */

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();

		$img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
		?>
		<a href='<?php echo get_permalink(); ?>'>
			<img src='<?php echo $img[0]; ?>' />
		</a>
		<article class="<?php echo is_singular() ? 'article_single' : 'article_list'; ?>">
			<strong><a href='<?php echo get_permalink(); ?>'><?php the_title(); ?></a></strong>
			<div class='entry'>
				<?php the_excerpt(); ?>
			</div>
		</article>
		<?php
	endwhile;
endif;
