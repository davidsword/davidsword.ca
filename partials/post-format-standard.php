<h2><a href='<?php echo get_permalink(); ?>'><?php the_title(); ?> &raquo;</a></h2>
<div class='content'>
    <?php
        // Featured image.
        dsca_featured_image();

        if ( is_home() || 'projects' === get_post_type() ) {
            the_excerpt();
        } else {
            the_content();
        }
    ?>
</div>