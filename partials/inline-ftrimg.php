<?php
$img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), "full" );
if (isset($img[1])) {
    $alt = get_the_title();
    echo "<img src='{$img[0]}' alt=\"{$alt}\" class='inlineFeaturedImage' />";
}
