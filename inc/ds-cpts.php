<?php

add_action( 'after_setup_theme', function () {
	add_theme_support( 'post-thumbnails' , ['images' , 'projects', 'ramblings'] );
});

add_action('the_excerpt_rss',function($content){
	if (isset($_GET['post_type']) && $_GET['post_type'] == 'images') {
		$img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), "large" );
		$content .= "<img src='{$img[0]}' />";
	}
	if (is_feed()) {
		$content .= "<br /><br /><a href='".get_permalink()."'>".get_permalink()."</a>";
	}
	return $content;
});

// our migrator
// add_action('admin_notice',function(){
// 	$posts = get_posts('numberposts=-1&post_type=post');
// 	foreach ($posts as $apost) {
// 		$terms = wp_get_post_terms( $apost->ID , 'category' );
//
// 		echo "<strong>{$apost->post_title}</strong><br />";
// 		foreach ($terms as $term) {
//             echo $term->name.", ";
//             if ($term->name == 'Design') {
//                 wp_update_post( [
//                     'ID' => $apost->ID,
//                     'post_type' => 'projects'
//                 ] );
//             }
//         }
// 		echo "<hr />";
// 	}
// });

add_action('admin_notices!',function(){
	$posts = get_posts('numberposts=999&post_type=attachment&order_by=ID');
	foreach ($posts as $apost) {

		$img = wp_get_attachment_image_src( $apost->ID , "thumbnail" );


		if (
			($apost->ID < 4190 && $apost->ID > 3993) ||
			($apost->ID <  2936 && $apost->ID > 2901) ||
			($apost->ID <  729 && $apost->ID > 692) ||
			in_array($apost->ID,[820,818,664])
		) {
			if (isset($img[1])) {
				echo "{$apost->ID} <img src='{$img[0]}' width=40 height=40 /><hr />";
				// create our new post
			    $myp = array();
			    $myp['post_type']  = 'art';
			    $myp['post_title'] 		= $apost->post_name;
			    //$myp['post_date'] 		= $post_date;
			    //$myp['post_date_gmt'] 	= $post_date_gmt;
				$myp['post_status']     = 'publish';
				$myp['comment_status']  = 'closed';
				// $newid = wp_insert_post($myp);
				// if ($newid)
				// 	set_post_thumbnail( $newid, $apost->ID );
			}
		}



		 //echo "<pre style=background:black;color:white> {$apost->ID}👋 ".print_r( htmlspecialchars($newcontent) ,true)."</pre>";
        // wp_update_post( [
             // 'ID' => $apost->ID,
             // 'post_content' => $newcontent
         // ] );
	}
});




add_action( 'init', function () {
    $cptName = 'Images';
    $cptSlug = 'images';
    $args = [
        'labels' => ds_make_labels($cptName),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-format-gallery',
        'supports' => [ 'title', 'editor', 'thumbnail' ],
		'show_in_rest' => true,
		'rest_base' => $cptSlug,
  		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'exclude_from_search' => true
    ];
    register_post_type($cptSlug,$args);
});

add_action( 'init', function () {
    $cptName = 'art';
    $cptSlug = 'art';
    $args = [
        'labels' => ds_make_labels($cptName),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-format-gallery',
        'supports' => [ 'title', 'editor', 'thumbnail' ],
		'show_in_rest'       => true,
		'rest_base' => $cptSlug,
  		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'exclude_from_search' => true
    ];
    register_post_type($cptSlug,$args);
});




add_action( 'init', function () {
    $cptName = 'Ramblings';
    $cptSlug = 'ramblings';
    $args = [
        'labels' => ds_make_labels($cptName),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-megaphone',
        'supports' => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ],
		'show_in_rest'       => true,
		'rest_base' => $cptSlug,
  		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'exclude_from_search' => true
    ];
    register_post_type($cptSlug,$args);
});



add_action( 'init', function () {
    $cptName = 'Projects';
    $cptSlug = 'projects';
    $args = [
        'labels' => ds_make_labels($cptName),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-book',
        'supports' => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ],
		'show_in_rest'       => true,
  		'rest_base'          => 'projects',
  		'rest_controller_class' => 'WP_REST_Posts_Controller',
    ];
    register_post_type($cptSlug,$args);
});


function ds_make_labels($cptName) {
    return [
        'name' => _x($cptName, 'post type general name'),
        'singular_name' => _x($cptName, 'post type singular name'),
        'add_new' => _x('Add New', $cptName),
        'add_new_item' => __('Add New '.$cptName),
        'edit_item' => __('Edit '.$cptName),
        'new_item' => __('New '.$cptName),
        'all_items' => __('All '.$cptName),
        'view_item' => __('View '.$cptName),
        'search_items' => __('Search '.$cptName),
        'not_found' =>  __('No '.$cptName.' found'),
        'not_found_in_trash' => __('No '.$cptName.' found in Trash'),
        'parent_item_colon' => '',
        'menu_name' => $cptName
    ];
}


add_filter('manage_art_posts_columns', 'ds_makethumbnailcol');
add_filter('manage_images_posts_columns', 'ds_makethumbnailcol');
add_filter('manage_projects_posts_columns', 'ds_makethumbnailcol');
function ds_makethumbnailcol($columns){
	unset($columns['date']);
	unset($columns['comments']);
	unset($columns['author']);
    $columns['img_thumbnail'] = '';
    return $columns;
}

add_action('manage_posts_custom_column',function ($column_name,$id){
	 if ($column_name == 'img_thumbnail') {
		  echo "<a href='".get_edit_post_link()."'>";
		  echo the_post_thumbnail( 'thumbnail' , array('style' => 'max-width: 40px;height:auto') );
		  echo "</a>";
	}
},999,2);


// if it's an image for the image section,
// create post and assign category and date from file name
// when we upload a media item
add_filter( 'add_attachment', function ($attachment_id) {
	$attachment = get_post($attachment_id);
	$att_title = $attachment->post_title;
	if( !preg_match("/^([0-9-]{8}|[0-9-]{10,11})$/i", $att_title) ) return;
	// get the attachments filename, build date
	$post_date = date('Y-m-d H:i:s',strtotime($att_title." 00:00:01"));
	$gmt_offset = get_option( 'gmt_offset' ) * 3600;
	$post_date_gmt = date('Y-m-d H:i:s',(strtotime($att_title." 00:00:01") + $gmt_offset ));
	// create our new post
    $myp = array();
    $myp['post_type']  = 'images';
    $myp['post_title'] 		= $att_title;
    $myp['post_date'] 		= $post_date;
    $myp['post_date_gmt'] 	= $post_date_gmt;
	$myp['post_status']     = 'publish';
	$myp['comment_status']  = 'closed';
	$newid = wp_insert_post($myp);
	// set upload media as thumbnail to new post
	if ($newid)
		set_post_thumbnail( $newid, $attachment->ID );
}, 10, 2 );




// RAMBLINGS - change title to excerpt of post_content
add_action( 'save_post', function ( $post_id = '') {
	if (get_post_type($post_id) == 'ramblings') {
    	$ramble = get_post($post_id);
		$newTitle = trim(substr(strip_tags(nl2br($ramble->post_content)),0,50));
		if (strlen($ramble->post_content) > 50)
			$newTitle .= "...";
		if ($newTitle != $ramble->post_title) {
			$newSlug = sanitize_title(substr(strip_tags($ramble->post_content),0,50));
            $myp 				= array();
            $myp['ID'] 			= $ramble->ID;
			$myp['post_title'] 	= $newTitle;
			$myp['post_name'] 	= $newSlug;
			$myp['guid'] 		= str_replace($ramble->name, $newSlug, $ramble->guid);
            wp_update_post($myp);
        }
    }
});





// set limit on front end main archive page
add_filter('pre_get_posts', function ($query) {
    global $mycats;

//	echo "<pre style=background:black;color:white>👋 ".print_r($query,true)."</pre>";

	// ONLY ON FRONT END ARCHIVES PAGE
	if (
		!is_admin() &&
		isset($query->query['post_type']) &&
		($query->query['post_type'] == 'images' || $query->query['post_type'] == 'art') &&
		$query->is_archive == 1 &&
		!isset($query->query['posts_per_page'])
	)
		$query->set( 'posts_per_page', '24' );

		// ONLY ON FRONT END ARCHIVES PAGE
		if (
			!is_admin() &&
			isset($query->query['post_type']) &&
			($query->query['post_type'] == 'projects') &&
			$query->is_archive == 1 &&
			!isset($query->query['posts_per_page'])
		)
			$query->set( 'posts_per_page', '6' );

	return $query;
});


// prevent SINGLE for ramblings and images
add_action('wp',function(){
	if (!is_admin() && is_singular( ['images','art'] )) //'ramblings',
		wp_redirect( get_post_type_archive_link( get_post_type() ) );
});
