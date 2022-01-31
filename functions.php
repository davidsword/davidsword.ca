<?php
/**
 * Functions for this theme.
 *
 * @package davidsword-ca-custom-theme
 */

defined( 'ABSPATH' ) || exit;

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

	$ver = ( SCRIPT_DEBUG || WP_DEBUG || dsca_is_develop() ) ? time() : wp_get_theme()->get( 'Version' );

	wp_enqueue_style(
		'main',
		get_template_directory_uri() . '/assets/css/dist/style.css',
		[],
		$ver
	);

	wp_enqueue_script(
		'main',
		get_template_directory_uri() . '/assets/js/dist/index.js',
		[],
		$ver,
		false //footer
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
function get_dsca_featured_image( $id = null, $size = 'full' ) {
	$id = ! $id ? get_the_ID() : intval( $id );
	$feature_img = get_post_thumbnail_id( $id );
	$img = wp_get_attachment_image_src( $feature_img, $size );
	if ( isset( $img[1] ) ) {
		$alt = get_the_title( $id );
		$img = "<img src='".esc_url( $img[0] )."' alt='".esc_attr( $alt )."' class='dsca_featured_image' />";
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
 * Add Gravitar to footer.
 */
add_action( 'wp_footer', function() {
	?>

	<!-- set in themes/davidsword.ca/functions.php -->
	<style>
		header#head .head__inner h1:before {
			background-image: url('<?php echo esc_url( dsca_get_gravatar_from_admin_email( 200 ) ); ?>');
		}
	</style>
	<?php
} );
