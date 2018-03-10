<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'enqueue_block_assets', function () {
	wp_enqueue_style(
		'ds_cpts_gutenberg-cgb-style-css',
		get_template_directory_uri().'/inc/ds-cpts-gutenberg/dist/blocks.style.build.css',
		array( 'wp-blocks' ),
		time()
	);
});

// Hook: Editor assets.
add_action( 'enqueue_block_editor_assets', function () {
	wp_enqueue_script(
		'ds_cpts_gutenberg-cgb-block-js', // Handle.
		get_template_directory_uri().'/inc/ds-cpts-gutenberg/dist/blocks.build.js',
		array( 'wp-blocks', 'wp-i18n', 'wp-element' ), // Dependencies, defined above.
		time()
	);

	wp_enqueue_style(
		'ds_cpts_gutenberg-cgb-block-editor-css', // Handle.
		get_template_directory_uri().'/inc/ds-cpts-gutenberg/dist/blocks.editor.build.css',
		array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
		time()
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
			<?php get_template_part( 'partials/loop', 'projects' ); ?>
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

			<?php get_template_part( 'partials/loop', 'post' ); ?>
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
			<?php get_template_part( 'partials/loop', 'images' ); ?>
			<a href="<?php echo get_post_type_archive_link('images') ?>" class="fromGutenbergViewAll">View More »</a>
		</div>
		<?php
		wp_reset_query();
		return ob_get_clean();
	},
] );



// Hook server side rendering into render callback
register_block_type( 'cgb/block-ds-cpts-gutenberg-art', [
	'render_callback' => function () {
		ob_start();
		query_posts( ['post_type' => 'art', 'posts_per_page' => 4] );
		?>
		<div class='grid images images__art fromGutenberg'>
			<h2 class='fromGutenberg--title'>Recent Artwork</h2>
			<?php get_template_part( 'partials/loop', 'images' ); ?>
			<a href="<?php echo get_post_type_archive_link('art') ?>" class="fromGutenbergViewAll">View More »</a>
		</div>
		<?php
		wp_reset_query();
		return ob_get_clean();
	},
] );



// Hook server side rendering into render callback
register_block_type( 'cgb/block-ds-cpts-gutenberg-ramblings', [
	'render_callback' => function () {
		ob_start();
		query_posts( ['post_type' => 'ramblings', 'posts_per_page' => 3] );
		?>
		<div class='grid ramblings fromGutenberg'>
			<h2 class='fromGutenberg--title'>Recent Ramblings</h2>
			<?php get_template_part( 'partials/loop', 'ramblings' ); ?>
		</div><!-- /fromGutenberg -->
		<?php
		wp_reset_query();
		return ob_get_clean();
	},
] );
