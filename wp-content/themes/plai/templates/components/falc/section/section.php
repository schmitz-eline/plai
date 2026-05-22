<?php
$title = get_sub_field('falc_title');
$image = get_sub_field('falc_image');
$paragraphs = get_sub_field('falc_paragraphs');
$items = get_sub_field('falc_items') ?: [];
?>

<section class="falc__section">
    <?php if ($title) : ?>
        <h2 class="falc__title falc-title"><?= esc_html($title) ?></h2>
    <?php endif; ?>

    <div class="falc__text-media">
        <?php if ($image) : ?>
            <?php get_template_part('templates/components/falc/section/parts/image') ?>
        <?php endif; ?>

        <div class="falc__texts">
            <?php if ($paragraphs) : ?>
                <?php get_template_part('templates/components/falc/section/parts/paragraphs') ?>
            <?php endif; ?>

            <?php if (!empty($items)) : ?>
                <?php if (in_array('simple_list', $items)) : ?>
                    <?php get_template_part('templates/components/falc/section/parts/simple-list') ?>
                <?php endif; ?>

                <?php if (in_array('detailed_list', $items)) : ?>
                    <?php get_template_part('templates/components/falc/section/parts/detailed-list') ?>
                <?php endif; ?>

                <?php if (in_array('more_paragraphs', $items)) : ?>
                    <?php get_template_part('templates/components/falc/section/parts/more-paragraphs') ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

</section>