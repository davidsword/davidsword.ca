<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'enqueue_block_assets', function () {
	wp_enqueue_style(
		'ds_cpts_gutenberg-cgb-style-css',
		get_template_directory_uri().'/inc/ds-cpts-gutenberg/dist/blocks.style.build.css',
		array( 'wp-blocks' )
	);
});

// Hook: Editor assets.
add_action( 'enqueue_block_editor_assets', function () {
	wp_enqueue_script(
		'ds_cpts_gutenberg-cgb-block-js', // Handle.
		get_template_directory_uri().'/inc/ds-cpts-gutenberg/dist/blocks.build.js',
		array( 'wp-blocks', 'wp-i18n', 'wp-element' ) // Dependencies, defined above.
	);

	wp_enqueue_style(
		'ds_cpts_gutenberg-cgb-block-editor-css', // Handle.
		get_template_directory_uri().'/inc/ds-cpts-gutenberg/dist/blocks.editor.build.css',
		array( 'wp-edit-blocks' ) // Dependency to include the CSS after it.
	);
});



// Hook server side rendering into render callback
register_block_type( 'cgb/block-ds-cpts-gutenberg', [
	'render_callback' => function () {
		ob_start();
		query_posts( ['post_type' => 'projects', 'posts_per_page' => 3] );
		?>
		<div class='grid projects fromGutenberg'>
			<h2 class='fromGutenberg--title'>Recent Projects</h2>
			<?php
			// @TODO this should be `get template part`
			if ( have_posts() ) : while ( have_posts() ) : the_post();
			$img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), "medium" );
			?>
			<a href='<?= get_permalink() ?>'>
				<img src='<?= $img[0] ?>' />
			</a>
			<article class="<?= is_singular() ? "article_single" : "article_list" ?>">
				<strong><a href='<?= get_permalink() ?>'><?php the_title() ?></a></strong>
				<div class='entry'>
					<?php the_excerpt() ?>
				</div>
			</article>
			<?php endwhile; endif;?>
			<!-- <a href="<?php echo get_post_type_archive_link('projects') ?>" class="fromGutenbergViewAll">View More »</a> -->
		</div><!-- /grid projects -->
		<?php
		wp_reset_query();
		return ob_get_clean();
	},
] );

// Hook server side rendering into render callback
register_block_type( 'cgb/block-ds-cpts-gutenberg-code', [
	'render_callback' => function () {
		ob_start();
		query_posts( ['post_type' => 'post', 'posts_per_page' => 5] );
		?>
		<div class='grid code fromGutenberg'>
			<h2 class='fromGutenberg--title'>Recent Code</h2>

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div class='date nomargin'>
					<?= get_the_date(); ?>
				</div>
				<h2 class='blog_title'><a href='<?= get_permalink() ?>'><?php the_title() ?> &raquo;</a></h2>
			<?php endwhile; endif; ?>
			<!-- <a href="<?php echo get_post_type_archive_link('post') ?>" class="fromGutenbergViewAll">View More »</a> -->
		</div><!-- /fromGutenberg -->
		<?php
		wp_reset_query();
		return ob_get_clean();
	},
] );


// Hook server side rendering into render callback
register_block_type( 'cgb/block-ds-cpts-gutenberg-images', [
	'render_callback' => function () {
		ob_start();
		query_posts( ['post_type' => 'images', 'posts_per_page' => 4] );
		?>
		<div class='grid images fromGutenberg'>
			<h2 class='fromGutenberg--title'>Recent Images</h2>
		<?php
		$c = 1;
		if ( have_posts() ) : while ( have_posts() ) : the_post();
		if ($c > 4) continue;
		$full = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), "full" );
		$img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), "medium" );
		?>
		<a href='<?= $full[0] ?>' data-lightbox>
			<img src='<?= $img[0] ?>' alt="<?php echo get_the_title() ?>" />
		</a>
		<?php
		$c++;
		endwhile; endif; ?>
		<a href="<?php echo get_post_type_archive_link('images') ?>" class="fromGutenbergViewAll">View More »</a>
		</div>
		<?php
		wp_reset_query();
		return ob_get_clean();
	},
] );
