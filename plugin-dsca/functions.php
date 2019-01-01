<?php
/**
 * Functions for davidsword.ca plugin.
 *
 * @package dsca
 */

/**
 * Add excerpts into PAGE post types.
 */
add_post_type_support( 'page', 'excerpt' );

/**
 * Remove tags from POST post type.
 *
 * I never use them, it's overkill with categories already being used so well.
 */
add_action('init', function () {
	unregister_taxonomy_for_object_type( 'post_tag', 'post' );
});

/**
 * Convert a GIST link the the_content into an embed for `assets/gist.js`
 *
 * This works for singual gists, as well as gists that have multiple file.
 * Pasting a specific file will work.
 *
 * @param $content string the_content of a page/post
 */
add_filter('the_content', function ( $content ) {

	$pattern = '/https:\/\/gist\.github\.com\/davidsword\/([a-zA-Z0-9#-\.]{24,99})[\n|<\/p]/';
	preg_match_all( $pattern, $content, $matches );

	foreach ( $matches[0] as $gist_url ) {
		$pos = strpos( $gist_url, '#' );
		if ( false === $pos ) {
			$content = preg_replace(
				"/https:\/\/gist\.github\.com\/davidsword\/([a-zA-Z0-9#-\.]{24,99})([\n|<\/p>])/",
				"<code class='oembed-gist' data-gist-id=$1 data-gist-hide-footer=true data-gist-show-loading=false gist-enable-cache=true></code>$2",
				$content
			);
		} else {
			$content = preg_replace(
				"/https:\/\/gist\.github\.com\/davidsword\/([a-zA-Z0-9-]{24,36})\#([a-zA-Z0-9#-\.]{1,99})([\n|<\/p>])/",
				"<code class='oembed-gist' data-gist-id=$1 data-gist-file=$2 data-gist-hide-footer=true data-gist-show-loading=false gist-enable-cache=true></code>$3",
				$content
			);
		}
	}
	return $content;
});

/**
 * Add in scripts.
 */
add_action( 'wp_enqueue_scripts', function () {

	$ver = ( WP_DEBUG ) ? time() : wp_get_theme()->get( 'Version' );

	/*  ---------------------------------- */
	wp_enqueue_script(
		'dsca',
		get_template_directory_uri() . '/plugin-dsca/assets/index.js',
		[ 'jquery', 'featherlight', 'dsca_gist', 'featherlight_swipe' ],
		$ver,
		true
	);

	/* GIST ---------------------------------- */
	wp_enqueue_script(
		'dsca_gist',
		get_template_directory_uri() . '/plugin-dsca/assets/gist.js',
		[ 'jquery' ],
		$ver,
		true
	);

	/* LIGHTBOX ---------------------------------- */
	wp_enqueue_script(
		'featherlight',
		get_template_directory_uri() . '/plugin-dsca/assets/featherlight.js',
		[ 'jquery', 'featherlight_swipe' ],
		$ver,
		true
	);
	add_action( 'wp_footer', function() use ( $ver ) {
		wp_enqueue_style(
			'featherlight',
			get_template_directory_uri() . '/plugin-dsca/assets/featherlight.css',
			[],
			$ver
		);
	});

	/* SWIPE ---------------------------------- */
	wp_enqueue_script(
		'featherlight_swipe',
		get_template_directory_uri() . '/plugin-dsca/assets/swipe.js',
		[ 'jquery' ],
		$ver,
		true
	);
});

/**
 * Sword Toolkit
 *
 * Toggle off features of WordPress
 *
 * @see https://github.com/davidsword/sword-toolkit
 */
add_filter('sword_toolkit', function() {
	return [
		'remove_menu_pages'      => [ 'widgets.php' ],
		'remove_menu_sub_pages'  => [
			'themes.php' => 'widgets.php',
		],
		'remove_jquery_migrate'  => true,
		'remove_wp_head_junk'    => true,
		'redirect_if_attachment' => true,
		'remove_post_tags'       => true,
		'remove_emojis'          => false,
	];
});
