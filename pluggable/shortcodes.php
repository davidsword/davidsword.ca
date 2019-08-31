<?php
/**
 * Shortcodes for the theme.
 *
 * @TODO these extend the functionality of WordPress and should likely be a plugin.
 *
 * @package davidsword-ca
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
	$return = ''; // phpcs:ignore
	$tags   = explode( ',', $content );

	foreach ( $tags as $tag ) {
		$return .= "<span class='skilltag'>" . ltrim( rtrim( ltrim( esc_html( $tag ) ) ) ) . '</span> ';
	}
	return "<div class='skilltags'>" . $return . '</div>';
});

/**
 * For the "Uses" or "About" page, list off all plugins used on site_admin_notice(  )
 *
 * Note that this includes inactive plugins, so keep the plugins tidy.
 *
 * @return string of html, list of plufins and links to their site.
 */
add_shortcode('list_plugins', function(){
	$list_plugins = [];
	$plugins = get_plugins();
	foreach ( $plugins as $plugin ) {
		if ( in_array( $plugin['Name'], [ 'Gutenberg', 'Classic Editor' ], true ) ) {
			continue;
		}
		$list_plugins[] = "<a href='" . esc_url( $plugin['PluginURI'] ) . "'>" . esc_html( $plugin['Name'] ) . "</a>";
	}
	return implode( ', ', $list_plugins );
});
