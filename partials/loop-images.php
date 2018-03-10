<?php
if ( have_posts() ) : while ( have_posts() ) : the_post();
    $full = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), "full" );
    $img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), "medium" );
    ?>
    <a href='<?= $full[0] ?>' data-lightbox>
        <img src='<?= $img[0] ?>' alt="<?php echo get_the_title() ?>" />
    </a>
<?php
endwhile; endif;
?>
