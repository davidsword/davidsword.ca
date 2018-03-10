<?php

//global $wp_rewrite;
//$wp_rewrite->flush_rules();

// [YEARS] shortcode
add_shortcode('years', function ($atts) {
    $a = shortcode_atts( array(
        'since' => date('r')
    ), $atts );
	$then = new DateTime($a['since']);
	$now = new DateTime();
	$interval = date_diff($then, $now);
    return $interval->y;
});



// GISTS
add_filter('the_content', function ($content) {
	// global $mycats, $post;
	// $pattern = '/https:\/\/gist\.github\.com\/davidsword\/(.+?|(.+?)\#(.+?))<\/p>\n/';
	// $replacement = "/https:\/\/gist\.github\.com\/davidsword\/(.+?|(.+?)\#(.+?))<\/p>\n/";
	// preg_match_all($pattern, $content, $matches);
	// foreach ($matches[0] as $gistURL) {
	// 	$pos = strpos($gistURL, '#');
	// 	if ($pos === false) {
	// 	    $content = preg_replace(
	// 	    "/https:\/\/gist\.github\.com\/davidsword\/(.+?)<\/p>\n/",
	// 	    "<code class='oembed-gist' data-gist-id=$1 data-gist-hide-footer=true data-gist-show-loading=false gist-enable-cache=true></code>",
	// 	    $content);
	// 	} else {
	// 	    $content = preg_replace(
	// 	    "/https:\/\/gist\.github\.com\/davidsword\/(.+?)\#(.+?)<\/p>\n/",
	// 	    "<code class='oembed-gist' data-gist-id=$1 data-gist-file=$2 data-gist-hide-footer=true data-gist-show-loading=false gist-enable-cache=true></code>",
	// 	    $content);
	// 	}
	// }
	return $content;
});



// STicky "good reads" to top //@TODO fix
// add_filter( 'the_posts', function ( $posts, $query ) {
//  	// We only care to do this for the first page of the archives
//  	if( $query->is_main_query() && is_archive() && 0 == get_query_var( 'paged' ) && '' != get_query_var( 'cat' ) ) {
// 	 	$category 	= get_category( get_query_var( 'cat' ) );
// 		$sticky 	= get_option( 'sticky_posts' );
// 		$sticky_query = new WP_Query( 'p=' . $sticky[0]);
// 	 	$post_id = ( ! isset ( $sticky_query->posts[0] ) ) ? false : $sticky_query->posts[0];
// 	 	wp_reset_postdata();
// 	 	if ( $post_id ) {
// 		 	$new_posts = array(  );
// 		 	$thispost = get_post( $post_id );
// 		 	if ( in_category( $category->cat_ID, $thispost )  ) {
// 			 	$new_posts[] = $thispost;
// 		 	}
// 		 	foreach( $posts as $post_index => $apost ) {
// 		 		if( $apost->ID == $post_id->ID )
// 			 		unset( $posts[ $post_index ] );
//
// 		 	}
// 		 	$posts = array_merge( $new_posts, $posts );
// 	 	}
//  	}
//  	return $posts;
//  }, 10, 2 );




add_shortcode('skilltags', function ($args, $content) {
	$return = '';
	$tags = explode(',', $content);
	foreach ($tags as $tag)
		$return .= "<span class='skilltag'>".ltrim(rtrim(ltrim($tag)))."</span> ";
	return "<div class='skilltags'>".$return."</div>";
});




add_action('init', function () {
    unregister_taxonomy_for_object_type('post_tag', 'post');
});
