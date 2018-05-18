<?php
if ( have_posts() ) : while ( have_posts() ) : the_post();
    $full = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), "full" );
    $img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), "thumbnail" );
    ?>
    <a href='<?= $full[0] ?>' style='background-image:url(<?= $img[0] ?>)' data-lightbox>
    </a>
<?php
endwhile; endif;
?>
