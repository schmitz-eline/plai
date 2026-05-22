<?php if (have_rows('falc_more_paragraphs')) : ?>
    <div class="falc__paragraphs">
        <?php while (have_rows('falc_more_paragraphs')) : the_row() ?>
            <?php $paragraph = get_sub_field('falc_more_paragraph') ?>
            <p class="falc__paragraph falc-text"><?= esc_html($paragraph) ?></p>
        <?php endwhile; ?>
    </div>
<?php endif; ?>