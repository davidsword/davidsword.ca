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