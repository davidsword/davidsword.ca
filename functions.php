<?php
/**
 * Functions for this theme.
 *
 * @package davidsword-ca
 */

defined( 'ABSPATH' ) || exit;

require 'inc/post-format-image.php';
require 'inc/post-format-status.php';
require 'inc/cpt-project.php';
require 'inc/helpers.php';
require 'inc/template-functions.php';
require 'inc/shortcodes.php';

/**
 * Add various features for theme
 */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'custom-logo', [
		'height'      => 100,
		'width'       => 400,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => [ 'site-title', 'site-description' ],
	]);
	add_theme_support( 'post-thumbnails', [ 'post', 'page' ] );
	add_theme_support( 'html5', [ 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ] );

	// gutenberg.
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );

	// Create colour palette for gutenberg.
	$my_colours = [ '#333', '#fff', '#999', '#4d77e2', '#fc6f56', '#ffe454', '#e279d0', '#6ba9df', '#d27070', '#6dbdac', '#7b82bd', '#B98EFF', '#8aa2ff' ];
	$palette    = [];
	foreach ( $my_colours as $colour ) {
		$palette[] = [ 'color' => $colour ];
	}
	add_theme_support( 'editor-color-palette', $palette );

});

// Navigation.
register_nav_menu( 'main-nav', 'Main Navigation' );
register_nav_menu( 'sec-nav',  'Secondary Navigation' );

/**
 * Enqueue scripts into WordPress.
 *
 * Load in various styles and scripts into WordPress. Run conditionals to reduce unneeded scripts.
 *
 * @since 1.0.0
 *
 * @see `add_action( 'wp_enqueue_scripts'...`
 */
add_action( 'wp_enqueue_scripts', function () {

	$is_localhost = ( 'vvv.davidswor' === $_SERVER['HTTP_HOST'] );
	$ver = ( WP_DEBUG || $is_localhost ) ? time() : wp_get_theme()->get( 'Version' );

	// wp_enqueue_script(
		// 'swrdbs_js',
		// get_template_directory_uri() . '/assets/js/dist/assets',
		// [ 'jquery' ],
		// $ver,
		// true
	// );

	wp_enqueue_style(
		'main',
		get_template_directory_uri() . '/style.css',
		[],
		$ver
	);
});

/**
 * Enquque Editor Script
 *
 * Just for gutenberg. Compiled with Grunt.
 *
 * @see assets/css/style-editor.less
 */
// add_action( 'enqueue_block_editor_assets', function () {
// 	wp_enqueue_style(
// 		'dsca-editor-css',
// 		get_template_directory_uri() . '/assets/css/dist/style-editor.css',
// 		[ 'wp-edit-blocks' ],
// 		time()
// 	);
// }, 99 );


/**
 * Adjust posts. Add formats and excerpts.
 */
add_action( 'init', function() {
	add_post_type_support( 'page', 'excerpt' );
	/**
	 * Status has no title, just a blurb.
	 * Image is just an image, not title or blurb.
	 *
	 * These formats typically stay in their own categories, but this is more future-friendly
	 * to specify how the post should look via a post_format instead of a category.
	 */
	add_theme_support( 'post-formats', array( 'status', 'image' ) );
} );

/**
 * Remove tags from POST post type.
 *
 * I never use them, it's overkill with categories already being used so well.
 */
add_action('init', function () {
	unregister_taxonomy_for_object_type( 'post_tag', 'post' );
});

/**
 * Allow featured image.
 */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'post-thumbnails', [ 'post' ] );
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
	$columns['url_name'] = '';
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
	if ( 'url_name' === $column_name ) {
		echo urldecode( get_post( $id )->post_name );
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

/**
 * Convert a GIST link the the_content into an embed for `assets/gist.js`
 *
 * This works for singual gists, as well as gists that have multiple file.
 * Pasting a specific file will work.
 *
 * @param $content string the_content of a page/post
 */
add_filter('the_content', function ( $content ) {

	$pattern = '/https:\/\/gist\.github\.com\/davidsword\/([a-zA-Z0-9#-\.]{24,99})[\n|<\/p]/';
	preg_match_all( $pattern, $content, $matches );

	foreach ( $matches[0] as $gist_url ) {
		$pos = strpos( $gist_url, '#' );
		if ( false === $pos ) {
			$content = preg_replace(
				"/https:\/\/gist\.github\.com\/davidsword\/([a-zA-Z0-9#-\.]{24,99})([\n|<\/p>])/",
				"<code class='oembed-gist' data-gist-id=$1 data-gist-hide-footer=true data-gist-show-loading=false gist-enable-cache=true></code>$2",
				$content
			);
		} else {
			$content = preg_replace(
				"/https:\/\/gist\.github\.com\/davidsword\/([a-zA-Z0-9-]{24,36})\#([a-zA-Z0-9#-\.]{1,99})([\n|<\/p>])/",
				"<code class='oembed-gist' data-gist-id=$1 data-gist-file=$2 data-gist-hide-footer=true data-gist-show-loading=false gist-enable-cache=true></code>$3",
				$content
			);
		}
	}
	return $content;
});

/**
 * Add in scripts.
 */
add_action( 'wp_enqueue_scripts', function () {

	$ver = ( WP_DEBUG ) ? time() : wp_get_theme()->get( 'Version' );

	/*  ---------------------------------- */
	wp_enqueue_script(
		'dsca',
		get_template_directory_uri() . '/assets/js/index.js',
		[ 'jquery', 'featherlight', 'dsca_gist', 'featherlight_swipe' ],
		$ver,
		true
	);

	/* GIST ---------------------------------- */
	wp_enqueue_script(
		'dsca_gist',
		get_template_directory_uri() . '/assets/js/vendor/gist.js',
		[ 'jquery' ],
		$ver,
		true
	);

	/* LIGHTBOX ---------------------------------- */
	wp_enqueue_script(
		'featherlight',
		get_template_directory_uri() . '/assets/js/vendor/featherlight.js',
		[ 'jquery', 'featherlight_swipe' ],
		$ver,
		true
	);
	add_action( 'wp_footer', function() use ( $ver ) {
		wp_enqueue_style(
			'featherlight',
			get_template_directory_uri() . '/assets/vendor/featherlight.css',
			[],
			$ver
		);
	});

	/* SWIPE ---------------------------------- */
	wp_enqueue_script(
		'featherlight_swipe',
		get_template_directory_uri() . '/assets/js/vendor/swipe.js',
		[ 'jquery' ],
		$ver,
		true
	);
});

/**
 * Redirect if Attachment
 *
 * No page for files - we'll just redirect straight to media
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
 * Max out at 42 revisions
 */
add_filter('wp_revisions_to_keep', function() { return 42; });

/**
 * remove login error
 *
 * hiding that a username is correct against brute force attacks
 */
add_filter('login_errors', function() { return '💩'; });

/**
 * make sure if comprimised, url_fopen won't work
 */
ini_set('allow_url_fopen',0);

/**
 * PLUGIN: Yoast remove nag
 */
add_action('admin_head',function () {
	echo "<style>li#toplevel_page_wpseo_dashboard span.update-plugins { display:none; }</style>";
});

/**
 * PLUGIN: header and footer, prevent PHP exc
 */
add_filter( 'hefo_php_exec', '__return_false' );

/**
 * Block Bad Queries
 */
dsca_bbq_badrequests();
function dsca_bbq_badrequests() {
	$request_uri_array  = apply_filters( 'request_uri_items',  array( 'eval\(', 'UNION\+SELECT', '\(null\)', 'base64_', '\/localhost', '\%2Flocalhost', '\/pingserver', '\/config\.', '\/wwwroot', '\/makefile', 'crossdomain\.', 'proc\/self\/environ', 'etc\/passwd', '\/https\:', '\/http\:', '\/ftp\:', '\/cgi\/', '\.cgi', '\.exe', '\.sql', '\.ini', '\.dll', '\.asp', '\.jsp', '\/\.bash', '\/\.git', '\/\.svn', '\/\.tar', ' ', '\<', '\>', '\/\=', '\.\.\.', '\+\+\+', '\:\/\/', '\/&&', '\/Nt\.', '\;Nt\.', '\=Nt\.', '\,Nt\.', '\.exec\(', '\)\.html\(', '\{x\.html\(', '\(function\(' ) );
	$query_string_array = apply_filters( 'query_string_items', array( '\.\.\/', '127\.0\.0\.1', 'localhost', 'loopback', '\%0A', '\%0D', '\%00', '\%2e\%2e', 'input_file', 'execute', 'mosconfig', 'path\=\.', 'mod\=\.' ) );
	$user_agent_array   = apply_filters( 'user_agent_items',   array( 'binlar', 'casper', 'cmswor', 'diavol', 'dotbot', 'finder', 'flicky', 'nutch', 'planet', 'purebot', 'pycurl', 'skygrid', 'sucker', 'turnit', 'vikspi', 'zmeu' ) );

	if (isset($_SERVER['REQUEST_URI'])) $request_uri_string = $_SERVER['REQUEST_URI'];
	if (isset($_SERVER['QUERY_STRING'])) $query_string_string = $_SERVER['QUERY_STRING'];
	if (isset($_SERVER['HTTP_USER_AGENT'])) $user_agent_string = $_SERVER['HTTP_USER_AGENT'];

	if (
		// strlen( $_SERVER['REQUEST_URI'] ) > 255 || // optional
		(isset($request_uri_string) && isset($request_uri_array) && preg_match( '/' . implode( '|', $request_uri_array )  . '/i', $request_uri_string )) ||
		(isset($query_string_array) && isset($query_string_string) && preg_match( '/' . implode( '|', $query_string_array ) . '/i', $query_string_string )) ||
		(
			isset($user_agent_string) && !empty($user_agent_string) &&
			preg_match( '/' . implode( '|', $user_agent_array )   . '/i', $user_agent_string )
		)
	) {
		header('HTTP/1.1 403 Forbidden');
		header('Status: 403 Forbidden');
		header('Connection: Close');
		exit;
	}
}

/**
 * No PRIVATE posts on front end.
 */
add_filter('posts_where', function ($where) {
    if( is_admin() ) return $where;

    global $wpdb;
    return " $where AND {$wpdb->posts}.post_status != 'private' ";
});