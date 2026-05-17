<?php if (have_posts()) : while (have_posts()): the_post(); ?>
    <?= get_the_title(); ?>
    <?= get_the_content(); ?>
<?php endwhile; else: ?>
    <p><?php esc_html('Désolé, aucune page ne correspond à vos critères.') ?></p>
<?php endif; ?>