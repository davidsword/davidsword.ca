<?php
/**
 * Chop the length of a string without breaking word.
 *
 * Only chops if string is > chop length.
 *
 * Used only in search,php
 *
 * @param  string  $string of content to possibly chop.
 * @param  integer $choplen the point at which we want to chop.
 * @param  string  $cut what we replaced the chopped off value with.
 * @return string  possibly chopped content
 */
function dsca_return_chopstring( $string, $choplen = 20, $cut = '...' ) {
	if ( strlen( $string ) > $choplen ) {
		$ashortertitle = wp_strip_all_tags( $string );

		$first     = substr_replace( $ashortertitle, '', ( floor( $choplen / 2 ) ), strlen( $ashortertitle ) );
		$second    = substr_replace( $ashortertitle, '', 0, ( strlen( $ashortertitle ) - ( floor( $choplen / 2 ) ) ) );
		$newstring = $first . $cut . $second;

		// if the cut only cut 1 letter.. we don't want to bother. at least 4 had to be cut.
		return ( strlen( $newstring ) > ( strlen( $string ) ) ) ? $string : $newstring;
	} else {
		return $string;
	}
}

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
