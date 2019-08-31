<?php
/**
 * Security Tweaks to WordPress.
 *
 * @package davidsword-ca
 */

/**
 * remove login error
 *
 * hiding that a username is correct against brute force attacks
 */
add_filter('login_errors', function() { return '💩'; });

/**
 * make sure if comprimised, url_fopen won't work
 */
ini_set('allow_url_fopen',0); // phpcs:ignore WordPress.PHP.IniSet.Risky

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

	if (isset($_SERVER['REQUEST_URI'])) $request_uri_string = $_SERVER['REQUEST_URI']; // phpcs:ignore
	if (isset($_SERVER['QUERY_STRING'])) $query_string_string = $_SERVER['QUERY_STRING']; // phpcs:ignore
	if (isset($_SERVER['HTTP_USER_AGENT'])) $user_agent_string = $_SERVER['HTTP_USER_AGENT']; // phpcs:ignore

	if (
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
