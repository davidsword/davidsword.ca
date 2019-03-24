<?php
/**
 * Gists integration.
 *
 * Converts a inline gist URL to an embed.
 *
 * @package davidsword-ca
 */

add_action( 'wp_enqueue_scripts', function () {

	$ver  = SCRIPT_DEBUG ? time() : wp_get_theme()->get( 'Version' );
	$path = str_replace( get_stylesheet_directory(), '', __DIR__ );

	wp_enqueue_script(
		'dsca_gist_integration',
		get_template_directory_uri() . $path . '/integration.js',
		[ 'jquery', 'dsca_gist' ],
		$ver,
		true
	);

	wp_enqueue_script(
		'dsca_gist',
		get_template_directory_uri() . $path . '/gist.js',
		[ 'jquery' ],
		$ver,
		true
	);

	wp_enqueue_style(
		'gist',
		get_template_directory_uri() . $path . '/gist.css',
		[],
		$ver
	);
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
