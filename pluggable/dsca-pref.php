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