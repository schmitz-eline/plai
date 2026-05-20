<?php
$title = get_sub_field('card_title');
$items = get_sub_field('card_items') ?: [];
$color = get_sub_field('card_color');
$title_icon = get_sub_field('card_title_icon');

$color_class = 'card--' . $color;
$icon_class = ($title_icon && $title_icon !== 'none') ? 'card__title--' . $title_icon : '';
?>

<article class="card <?= esc_attr($color_class) ?>">
    <?php if ($title) : ?>
        <h3 class="card__title <?= esc_attr($icon_class) ?> card-title"><?= esc_html($title) ?></h3>
    <?php endif; ?>

    <?php if (!empty($items)) : ?>
        <?php if (in_array('text', $items)) : ?>
            <?php get_template_part('templates/components/card/parts/text'); ?>
        <?php endif; ?>

        <?php if (in_array('image', $items)) : ?>
            <?php get_template_part('templates/components/card/parts/image'); ?>
        <?php endif; ?>

        <?php if (in_array('secondary_text', $items)) : ?>
            <?php get_template_part('templates/components/card/parts/secondary-text'); ?>
        <?php endif; ?>

        <?php if (in_array('simple_list', $items)) : ?>
            <?php get_template_part('templates/components/card/parts/simple-list'); ?>
        <?php endif; ?>

        <?php if (in_array('detailed_list', $items)) : ?>
            <?php get_template_part('templates/components/card/parts/detailed-list'); ?>
        <?php endif; ?>

        <?php if (in_array('link', $items)) : ?>
            <?php get_template_part('templates/components/card/parts/link'); ?>
        <?php endif; ?>
    <?php endif; ?>
</article>