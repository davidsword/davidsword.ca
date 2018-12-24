<?php
/**
 * Shortcodes for davidsword.ca
 *
 * See blockdocs for details.
 *
 * @package dsca
 */

/**
 * [YEARS] shortcode
 *
 * "It's been [year since=2010] years since I did this"
 * will turn into:
 * "It's been 9 years since I did this"
 *
 * @param $atts array from Shortcode API
 * @return string number of years since value passed in shortcode param
 */
add_shortcode('years', function ( $atts ) {
	$a = shortcode_atts( [
		'since' => date( 'r' ),
	], $atts );

	$then = new DateTime( $a['since'] );
	$now  = new DateTime();

	$interval = date_diff( $then, $now );
	return $interval->y;
});

/**
 * [skilltags] Takes a string of text and csv it while wrapping in tags
 *
 * @param $atts array from Shortcode API
 * @param $content string of content between tags `[skilltags]..[/skilltags]`
 *
 * @return string of html, entire thing wraped in div, individual words wraped in spans
 */
add_shortcode('skilltags', function ( $args, $content ) {
	$return = '';
	$tags   = explode( ',', $content );

	foreach ( $tags as $tag ) {
		$return .= "<span class='skilltag'>" . ltrim( rtrim( ltrim( $tag ) ) ) . '</span> ';
	}
	return "<div class='skilltags'>" . $return . '</div>';
});
