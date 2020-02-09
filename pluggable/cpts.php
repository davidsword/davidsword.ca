<?php
/**
 * Helpers for custom post types
 */

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
