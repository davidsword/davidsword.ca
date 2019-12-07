<?php
/**
 * Functions for this theme.
 *
 * @package davidsword-ca
 */

defined( 'ABSPATH' ) || exit;

// Load custom plugins.
require get_stylesheet_directory() . '/pluggable/projects.php';
require get_stylesheet_directory() . '/pluggable/dsca-pref.php';
require get_stylesheet_directory() . '/pluggable/security.php';
require get_stylesheet_directory() . '/pluggable/shortcodes.php';
require get_stylesheet_directory() . '/pluggable/gists/gists.php';
require get_stylesheet_directory() . '/pluggable/auto-post-format.php';

/**
 * Add various features for theme
 */
add_action( 'after_setup_theme', function () {

	add_theme_support( 'post-thumbnails', [ 'post', 'page' ] );
	add_theme_support( 'html5', [ 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ] );

	// gutenberg.
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );

	// Create colour palette for gutenberg.
	$my_colours = [ '#333', '#fff', '#999', '#4d77e2', '#fc6f56', '#ffe454', '#e279d0', '#6ba9df', '#d27070', '#6dbdac', '#7b82bd', '#B98EFF', '#8aa2ff' ];
	$palette    = [];
	foreach ( $my_colours as $colour ) {
		$palette[] = [
			'color' => $colour
		];
	}
	add_theme_support( 'editor-color-palette', $palette );

});

// Navigation.
register_nav_menu( 'main-nav', 'Main Navigation' );
register_nav_menu( 'sec-nav',  'Secondary Navigation' );
register_nav_menu( 'toe-nav',  'Footer Navigation' );

/**
 * Enqueue scripts into WordPress.
 *
 * Load in various styles and scripts into WordPress. Run conditionals to reduce unneeded scripts.
 *
 * @since 1.0.0
 *
 * @see `add_action( 'wp_enqueue_scripts'...`
 */
add_action( 'wp_enqueue_scripts', function() {

	$ver = SCRIPT_DEBUG ? time() : wp_get_theme()->get( 'Version' );

	wp_enqueue_style(
		'main',
		get_template_directory_uri() . '/style.css',
		[],
		$ver
	);

	wp_enqueue_script(
		'main',
		get_template_directory_uri() . '/assets/js/dist/index.js',
		[],
		$ver,
		true
	);

	if ( is_singular() ) {
		wp_enqueue_script( 'comment-reply' );
	}

});

/**
 * Change Excerpt cut off dots to a link.
 */
add_filter( 'excerpt_more', function ( $more ) {
    return ' ... '."<a href='".get_permalink()."'>continue reading »</a>";
} );

/**
 * Get the featured image
 */
function get_dsca_featured_image( $id = null, $size = 'large' ) {
	$id = ! $id ? get_the_ID() : intval( $id );
	$img = esc_url( wp_get_attachment_image_src( get_post_thumbnail_id( $id ), $size ) );
	if ( isset( $img[1] ) ) {
		$alt = esc_attr( get_the_title( $id ) );
		$img = "<img src='{$img[0]}' alt=\"{$alt}\" class='dsca_featured_image' />";
		if ( ! is_single() ) {
			$img = "<a href='".get_permalink( $id )."' class='noborder'>".$img."</a>";
		}
		return $img;
	}
}

/**
 * Get and print the featured image.
 */
function dsca_featured_image( $id = null, $size = 'full' ) {
	echo wp_kses_post( get_dsca_featured_image( $id, $size ) );
}

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
 * Add Gravitar to footer.
 */
add_action( 'wp_footer', function() {
	?>
	<style>
		header#head h1::before {
			background-image: url('https://www.gravatar.com/avatar/<?php echo md5( get_option( 'admin_email' ) ); ?>?s=200');
		}
	</style>
	<?php
} );
