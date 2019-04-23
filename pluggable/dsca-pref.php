<?php
/**
 * Custom preferences for WordPress.
 *
 * @package davidsword-ca
 */

/**
 * Max out at 42 revisions
 */
add_filter('wp_revisions_to_keep', function() { return 42; });

/**
 * No PRIVATE posts on front end.
 */
add_filter('posts_where', function ($where) {
	if( is_admin() ) return $where;
	global $wpdb;
	return " $where AND {$wpdb->posts}.post_status != 'private' ";
});

/**
 * Redirect to media file itself if Attachment.
 */
add_action( 'init' ,function () {
	global $post;
	if (isset($post) && is_object($post)) {
		$media = wp_get_attachment_url( $post->ID);
		if ( !is_admin() && is_attachment() ) {
			header('Location: '.$media);
			wp_die( 'No attachments page.' );
		}
	}
});


/**
 * Remove tags from POST post type.
 */
add_action('init', function () {
	unregister_taxonomy_for_object_type( 'post_tag', 'post' );
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
add_filter( 'manage_projects_posts_columns', 'ds_makethumbnailcol' );

/**
 * Display the post thumbnail in the edit page table for eaiser management
 */
add_action( 'manage_posts_custom_column', function( $column_name, $id ) {
	if ( 'img_thumbnail' === $column_name ) {
		echo "<a href='" . get_edit_post_link() . "'>";
		echo the_post_thumbnail( 'thumbnail', [ 'style' => 'max-width: 40px;height:auto' ] );
		echo '</a>';
	}
}, 999, 2);

/**
 * Remove WordPress emojicon, rely on users systems instead.
 *
 * It's 2019 & my audience is of the technical-up-to-date crowd.
 */
add_action( 'init', function() {

	return; // disable this, yes use emojicon.

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