<?php
/**
 * Custom preferences for WordPress.
 *
 * These are opinionated changes in how WordPress functions.
 * These changes are a personal preference.
 *
 * @package davidsword-ca
 */

/**
 * Max out at 42 revisions.
 *
 * Anything beyond that is ridiculous.
 */
add_filter('wp_revisions_to_keep', function() { return 42; });

/**
 * Redirect to media file itself if Attachment.
 *
 * The Attachment page is confusing and adds bloat to the site.
 * "Why am I here and how did I get here"
 */
add_action( 'init' ,function () {
	global $post;
	if ( isset( $post ) && is_object( $post ) ) {
		$media = wp_get_attachment_url( $post->ID);
		if ( !is_admin() && is_attachment() ) {
			wp_safe_redirect( $media );
			wp_die();
		}
	}
});

/**
 * Display the post thumbnail in the edit page table for eaiser management
 *
 * @param array  $columns from wp api.
 * @return array $columns for wp api.
 */
function ds_makethumbnailcol( $columns ) {
	unset( $columns['date'] );
	unset( $columns['comments'] );
	unset( $columns['author'] );
	$columns['img_thumbnail'] = '';
	return $columns;
}
add_filter( 'manage_post_posts_columns', 'ds_makethumbnailcol' );

/**
 * Display the post thumbnail in the edit page table for eaiser management
 */
add_action( 'manage_posts_custom_column', function( $column_name, $id ) {
	if ( 'img_thumbnail' === $column_name ) {
		echo "<a href='" . esc_url( get_edit_post_link() ) . "'>";
		echo wp_kses_post( the_post_thumbnail( 'thumbnail', [ 'style' => 'max-width: 40px;height:auto' ] ) );
		echo '</a>';
	}
}, 999, 2);

/**
 * Remove WordPress emojicon, rely on users systems instead.
 *
 * It's 2019 & my audience is of the technical-up-to-date crowd.
 */
add_action( 'init', function() {
	remove_action( 'admin_print_styles',  'print_emoji_styles' );
	remove_action( 'wp_head',             'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles',     'print_emoji_styles' );
	remove_filter( 'wp_mail',             'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed',    'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss',    'wp_staticize_emoji' );

	add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
	add_filter( 'emoji_svg_url',    '__return_false' );
} );

/**
 * If no site icon - use the gravatar instead.
 *
 * @TODO use function instead.
 */
add_filter( 'get_site_icon_url', function( $url ) {
	return empty( $url ) ? 'https://www.gravatar.com/avatar/'. md5( get_option( 'admin_email' ) ) . '?s=512' : $url;
}, 99, 1 );

/**
 * Ensure blank searches (`/?s=`) return no results.
 *
 * For whatever reason WP wants to return default WP_Query on a blank search.
 * Using `found_posts` hook is irelevant, it's just an avaliable hook after the query.
 *
 * @return string number of found posts.
 */
add_filter( 'found_posts', function ( $found, $query ) {
	$empty_search = empty( $query->query_vars['s'] );
	if ( ! is_admin() && is_search() && $empty_search ) {
		$query->posts = [];
		$query->found_posts = 0;
	}
	return $found;
}, 10, 3 );
