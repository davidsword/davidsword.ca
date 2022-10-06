<?php

// custom TwentyFifteen Theme Edits

// Add search link to footer.
add_action(
	'twentyfifteen_credits',
	function() {
		// @TODO make this a dynamic nav instead.
		echo "<a href='/search'>Search</a> &nbsp; <span style='opacity:0.25'>|</span> &nbsp; ";
	}
);

// microblog "aside" posts don't have post_titles, 2015 relies on them for next/prev links.
// the post_tile filter cant pinpoint this one use area its needed. so refactor html output with new post_titles.
// @see `the_post_navigation()` in `/themes/twentyfifteen/single.php`
add_filter( 'next_post_link', 'fix_2015_nav_links', 10, 5);
add_filter( 'previous_post_link', 'fix_2015_nav_links', 10, 5);
function fix_2015_nav_links( $output, $format, $link, $post, $adjacent ) {
	$title = has_post_format( 'aside', $post ) ? wp_trim_words( wp_strip_all_tags( $post->post_content ), 3 )."" : apply_filters('post_title',$post->post_title);

	// veryify string as its not being escaped.
	if ( ! in_array( $adjacent, ['next','previous'] ) )
		die('something has gone terribly wrong');

	return sprintf('
		<div class="nav-'.$adjacent.'">
			<a href="%s" rel="'.$adjacent.'">
				<span class="meta-nav" aria-hidden="true">'.$adjacent.'</span>
				<span class="screen-reader-text">'.$adjacent.' post:</span>
				<span class="post-title">%s</span>
			</a>
		</div>',
		get_permalink( $post ),
		$title
	);
}

// for whatever reason, NewsNetWire doesn't render this themes favicon so well.. shimming this in:
add_action('wp_head', function(){
	if ( function_exists('dsca_get_gravatar_from_admin_email') )
	echo '
	<link rel="apple-touch-icon-precomposed" href="'.esc_url( dsca_get_gravatar_from_admin_email( 256 ) ).'">
	<link rel="shortcut icon" href="'.esc_url( dsca_get_gravatar_from_admin_email( 256 ) ).'">
	';
}, 999);
