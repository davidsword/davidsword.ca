<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div class='date nomargin'>
        <?php echo get_the_date(); ?>
    </div>
    <h2 class='blog_title'><a href='<?php echo get_permalink() ?>'><?php the_title() ?> &raquo;</a></h2>
<?php endwhile; endif; ?>
