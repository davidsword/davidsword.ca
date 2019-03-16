<h2 class='title title--page'><?php the_title(); ?></h2>
<div class='content'>
    <?php
        // Featured image.
        dsca_featured_image();

        the_content();
    ?>
</div>