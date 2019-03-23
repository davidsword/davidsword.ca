<?php
/**
 * Functions for this theme.
 *
 * @package davidsword-ca
 */

defined( 'ABSPATH' ) || exit;

require 'inc/pseduo-post-format.php';
require 'inc/cpt-project.php';
require 'inc/helpers.php';
require 'inc/template-functions.php';
require 'inc/shortcodes.php';

/**
 * Add various features for theme
 */
add_action( 'after_setup_theme', function () {

	add_theme_support( 'post-thumbnails', [ 'post', 'page' ] );
	add_theme_support( 'html5', [ 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ] );

	/**
	 * Status has no title, just a blurb.
	 * Image is just an image, not title or blurb.
	 *
	 * These formats typically stay in their own categories, but this is more future-friendly
	 * to specify how the post should look via a post_format instead of a category.
	 */
	add_theme_support( 'post-formats', array( 'status', 'image' ) );

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
add_action( 'wp_enqueue_scripts', function () {

	$is_localhost = ( 'vvv.davidswor' === $_SERVER['HTTP_HOST'] );
	$ver = ( SCRIPT_DEBUG || $is_localhost ) ? time() : wp_get_theme()->get( 'Version' );

	wp_enqueue_style(
		'main',
		get_template_directory_uri() . '/style.css',
		[],
		$ver
	);

	/*  ---------------------------------- */
	wp_enqueue_script(
		'dsca',
		get_template_directory_uri() . '/assets/js/dist/index.js',
		[ 'jquery', 'dsca_gist' ],
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

	if ( is_singular() ) {
		wp_enqueue_script( 'comment-reply' );
	}

});


/**
 * Adjust posts. Add formats and excerpts.
 */
add_action( 'init', function() {
	add_post_type_support( 'page', 'excerpt' );
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

/**
 * Change Excerpt cut off dots to a link.
 */
add_filter( 'excerpt_more', function ( $more ) {
    return ' ... '."<a href='".get_permalink()."'>continue reading »</a>";
} );