<?php

// I'll never use tags
add_action('init', function () {
	unregister_taxonomy_for_object_type('post_tag', 'post');
});

// GISTS
add_filter('the_content', function ($content) {
	global $mycats, $post;
	$pattern = '/https:\/\/gist\.github\.com\/davidsword\/([a-zA-Z0-9#-\.]{24,99})[\n|<\/p]/';
	preg_match_all($pattern, $content, $matches);
	foreach ($matches[0] as $gistURL) {
		$pos = strpos($gistURL, '#');
		if ($pos === false) {
			$content = preg_replace(
			"/https:\/\/gist\.github\.com\/davidsword\/([a-zA-Z0-9#-\.]{24,99})([\n|<\/p>])/",
			"<code class='oembed-gist' data-gist-id=$1 data-gist-hide-footer=true data-gist-show-loading=false gist-enable-cache=true></code>$2",
			$content);
		} else {
			$content = preg_replace(
			"/https:\/\/gist\.github\.com\/davidsword\/([a-zA-Z0-9-]{24,36})\#([a-zA-Z0-9#-\.]{1,99})([\n|<\/p>])/",
			"<code class='oembed-gist' data-gist-id=$1 data-gist-file=$2 data-gist-hide-footer=true data-gist-show-loading=false gist-enable-cache=true></code>$3",
			$content);
		}
	}
	return $content;
});
