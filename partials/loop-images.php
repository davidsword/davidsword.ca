<?php
if ( have_posts() ) : while ( have_posts() ) : the_post();
    $full = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), "full" );
    $img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), "thumbnail" );
    ?>
    <a href='<?php echo $full[0] ?>' style='background-image:url(<?php echo $img[0] ?>)' data-lightbox>
        <!-- <img src='' alt="<?php echo get_the_title() ?>" /> -->
    </a>
<?php
endwhile; endif;
?>
