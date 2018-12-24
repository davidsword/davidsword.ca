<?php
/**
 * Functions, filters, and actions used by most or all CPTs
 *
 * @package dsca
 */

/**
 * Return all custom post types for this DSCA davidsword.ca plugin
 *
 * @return array of cpts
 */
function dsca_get_all_post_types() {
	return [ 'post', 'images', 'projects', 'status' ];
}

/**
 * Add all post types to main RSS feed.
 *
 * @param $qv array
 * @return array
 */
add_filter('request', function ( $qv ) {
	if ( isset( $qv['feed'] ) ) {
		$qv['post_type'] = dsca_get_all_post_types();
	}
	return $qv;
} );

/**
 * Set IMAGES PROJECTS and STATUS to use post-thumbnails
 */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'post-thumbnails', [ 'images', 'projects', 'status' ] );
});

/**
 * Display the post thumbnail in the edit page table for eaiser management
 *
 * @param array $columns from wp api.
 * @return array
 */
function ds_makethumbnailcol( $columns ) {
	unset( $columns['date'] );
	unset( $columns['comments'] );
	unset( $columns['author'] );
	$columns['img_thumbnail'] = '';
	return $columns;
}
add_filter( 'manage_art_posts_columns', 'ds_makethumbnailcol' );
add_filter( 'manage_images_posts_columns', 'ds_makethumbnailcol' );
add_filter( 'manage_projects_posts_columns', 'ds_makethumbnailcol' );

/**
 * Display the post thumbnail in the edit page table for eaiser management
 */
add_action('manage_posts_custom_column', function ( $column_name, $id ) {
	if ( 'img_thumbnail' === $column_name ) {
		echo "<a href='" . get_edit_post_link() . "'>";
		echo the_post_thumbnail( 'thumbnail', [ 'style' => 'max-width: 40px;height:auto' ] );
		echo '</a>';
	}
}, 999, 2);

/**
 * Dynamically Generate Labels for cpts admin interface.
 *
 * I'm really not sure why core doesn't do this.
 *
 * @param string $cpt name of the CPT, singular.
 * @return array of labels
 */
function dsca_make_labels( $cpt ) {
	return [
		'name'               => $cpt,
		'singular_name'      => $cpt,
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New ' . $cpt,
		'edit_item'          => 'Edit ' . $cpt,
		'new_item'           => 'New ' . $cpt,
		'all_items'          => 'All ' . $cpt,
		'view_item'          => 'View ' . $cpt,
		'search_items'       => 'Search ' . $cpt,
		'not_found'          => 'No ' . $cpt . ' found',
		'not_found_in_trash' => 'No ' . $cpt . ' found in Trash',
		'parent_item_colon'  => '',
		'menu_name'          => $cpt,
	];
}
