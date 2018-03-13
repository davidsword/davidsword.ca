<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div class='date nomargin'>
        <h2><a href='<?= get_permalink() ?>'><?= get_the_date(); ?></a></h2>
    </div>
    <div class='ramble'>
        <?php get_template_part( 'partials/inline', 'ftrimg' ); ?>
        <div class='entry'>
            <?php the_content() ?>
        </div>
    </div>
<?php endwhile; endif; ?>
