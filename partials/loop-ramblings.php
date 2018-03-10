<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div class='date nomargin'>
        <h2 class='underline'><?= get_the_date(); ?></h2>
    </div>
    <div>
        <?php the_content() ?>
    </div>
<?php endwhile; endif; ?>
