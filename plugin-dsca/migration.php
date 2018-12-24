<?php
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

add_action('admin_notices!', function () {
    $posts = get_posts('numberposts=999&post_type=attachment&order_by=ID');
    foreach ($posts as $apost) {

        $img = wp_get_attachment_image_src($apost->ID, "thumbnail");

        if (($apost->ID < 4190 && $apost->ID > 3993) || ($apost->ID < 2936 && $apost->ID > 2901) || ($apost->ID < 729 && $apost->ID > 692) ||
            in_array($apost->ID, [820, 818, 664])) {
            if (isset($img[1])) {
                echo "{$apost->ID} <img src='{$img[0]}' width=40 height=40 /><hr />";
				// create our new post
                $myp = array();
                $myp['post_type'] = 'art';
                $myp['post_title'] = $apost->post_name;
				//$myp['post_date'] 		= $post_date;
				//$myp['post_date_gmt'] 	= $post_date_gmt;
                $myp['post_status'] = 'publish';
                $myp['comment_status'] = 'closed';
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
