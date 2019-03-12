<?php
/**
 * Functions for davidsword.ca plugin.
 *
 * @package dsca
 */

defined('ABSPATH') || die();

/**
 * Adjust posts. Add formats and excerpts.
 */
add_action( 'init', function() {
	add_post_type_support( 'page', 'excerpt' );
	add_theme_support( 'post-formats', array( 'link', 'status', 'image', 'quote', 'aside' ) );
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
		get_template_directory_uri() . '/plugin-dsca/assets/index.js',
		[ 'jquery', 'featherlight', 'dsca_gist', 'featherlight_swipe' ],
		$ver,
		true
	);

	/* GIST ---------------------------------- */
	wp_enqueue_script(
		'dsca_gist',
		get_template_directory_uri() . '/plugin-dsca/assets/gist.js',
		[ 'jquery' ],
		$ver,
		true
	);

	/* LIGHTBOX ---------------------------------- */
	wp_enqueue_script(
		'featherlight',
		get_template_directory_uri() . '/plugin-dsca/assets/featherlight.js',
		[ 'jquery', 'featherlight_swipe' ],
		$ver,
		true
	);
	add_action( 'wp_footer', function() use ( $ver ) {
		wp_enqueue_style(
			'featherlight',
			get_template_directory_uri() . '/plugin-dsca/assets/featherlight.css',
			[],
			$ver
		);
	});

	/* SWIPE ---------------------------------- */
	wp_enqueue_script(
		'featherlight_swipe',
		get_template_directory_uri() . '/plugin-dsca/assets/swipe.js',
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
 * Notify admin if FTP password is in code
 */
add_action( 'init', function() {
	if (defined('FTP_PASS')) {
		if ( false === ( $value = get_transient( 'ds_nag' ) ) ) {
			wp_mail(get_option('admin_email'), 'URGRENT ISSUE', 'FTP_PASS is defined for '.$_SERVER['HTTP_HOST']);
			set_transient( 'ds_nag', 'yes', 60*60*4 );
		}
	}
} );

/**
 * Max out at 42 revisions
 */
add_filter('wp_revisions_to_keep', function() { return 42; });

/**
 * extra protocalls, remove
 */
add_filter( 'xmlrpc_methods', 'ds_block_xmlrpc_attacks' );

/**
 * remove login error
 *
 * hiding that a username is correct against brute force attacks
 */
add_filter('login_errors', function() { return 'Uh oh:'; });

/**
 * make sure if comprimised, url_fopen won't work
 */
ini_set('allow_url_fopen',0);

/**
 * remove wordpress generator
 */
remove_action('wp_head', 'wp_generator');
add_filter('the_generator', function() { return ''; });

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
